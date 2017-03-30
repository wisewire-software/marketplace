<?php

// load WiseWire API
require_once(ABSPATH . 'wp-includes/WiseWireApi.php');

class WiseWireApiCache
{

    private $wpdb;
    private $api;
    private $destination;
    private $destination_pod;
    private $url;
    private $url_pod;
    private $page_size = 1000;
    private $page_num = 0;
    private $num_found = 0;
    private $start = 0;

    public function __construct()
    {

        global $wpdb;

        $this->wpdb = $wpdb;
        $this->api = new WiseWireApi();

        $this->url = WW_API_URL . "/content/mkt/search?keyword=&pageSize={pageSize}&pageNum={pageNum}&filter=itemType:question&mediaType=json";
        $this->url_pod = WW_API_URL . "/pod/mkt/search?keyword=&pageSize={pageSize}&pageNum={pageNum}&filter=&mediaType=json";

        $this->destination = ABSPATH . 'tmp/listing.csv';
        $this->destination_pod = ABSPATH . 'tmp/listing_pod.csv';

    }

    private function cleanup()
    {

        // BEGIN
        // Updated because we have now two types of sources 1: platform and 2: merlot
        // and this should only delete platform item
        $this->wpdb->query("DELETE
							FROM `wp_apicache_items` 
							WHERE `source` = 1;");

        $this->wpdb->query("DELETE
							FROM `wp_apicache_categories` 
							WHERE `source` = 1;");
        //END


        $this->wpdb->query("TRUNCATE `wp_apicache_tags`;");

        $this->revelance = 0;
    }

    public function cache_pod($initial = false)
    {

        if ($initial) {
            // start timer and clean up last cache data
            $this->start = microtime(true);
            $this->cleanup();
        }

        $url_pod = str_replace('{pageSize}', $this->page_size, $this->url_pod);
        $url_pod = str_replace('{pageNum}', $this->page_num, $url_pod);

        $this->api->download($url_pod, $this->destination_pod);

        //echo 'Downloaded<br />';

        if ($this->parse_pod() && $this->num_found > 0 && $this->page_size * ($this->page_num + 1) < $this->num_found) {
            $this->page_num++;
            $this->cache_pod();
        }

        //WiseWireApi::set_option( 'cache_lasttime', date('Y-m-d H:i:s') );
        //WiseWireApi::set_option( 'caching_duration', microtime(true)-$this->start );
    }

    public function cache($initial = false)
    {

        if ($initial) {
            // start timer and clean up last cache data
            //$this->start = microtime(true);
            //$this->cleanup();
        }

        $url = str_replace('{pageSize}', $this->page_size, $this->url);
        $url = str_replace('{pageNum}', $this->page_num, $url);

        //echo $url.'<br />';

        $this->api->download($url, $this->destination);

        $url_pod = str_replace('{pageSize}', $this->page_size, $this->url_pod);
        $url_pod = str_replace('{pageNum}', $this->page_num, $url_pod);

        $this->api->download($url_pod, $this->destination_pod);

        //echo 'Downloaded<br />';

        if ($this->parse() && $this->num_found > 0 && $this->page_size * ($this->page_num + 1) < $this->num_found) {

            $this->page_num++;
            $this->cache();

        } else {

            // end
            $this->wpdb->query("UPDATE `wp_apicache_categories` c SET c.`term_id` = (SELECT t.`term_id` FROM `wp_terms` t WHERE t.`api_id` = c.`categoryId` LIMIT 1) WHERE source=1;");
            $this->wpdb->query("UPDATE `wp_apicache_categories` SET `categoryId` = `term_id` WHERE source=1;");
            $this->wpdb->query("INSERT INTO `wp_apicache_categories` (SELECT ac.`itemId`, tt.`parent`, 0 FROM `wp_terms` t
       	  	LEFT JOIN `wp_term_taxonomy` tt ON tt.`term_id` = t.`term_id`
        	LEFT JOIN `wp_apicache_categories` ac ON ac.`categoryId` = t.`term_id`
        	WHERE t.`api_branch` = 2 AND t.`api_type` = 'Discipline' AND ac.`source`=1 AND ac.`categoryId` IS NOT NULL)");

            WiseWireApi::set_option('cache_lasttime', date('Y-m-d H:i:s'));
            WiseWireApi::set_option('caching_duration', microtime(true) - $this->start);
        }

        /* Call store procedure */
        $this->wpdb->query("CALL `prc_populate_platform_tile_info`();");
        $this->wpdb->query("CALL `prc_populate_summarized_item_metadata`();");

        /* Call the API SOLR */
        $URL = "http://localhost:8983/solr/summarizeditemmetadata/dataimport?command=full-import";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $URL));
        curl_exec($curl);
        curl_close($curl);

        /* Call the API SOLR */
        $URL_spellcheck = "http://localhost:8983/solr/summarizeditemmetadata/spell?spellcheck.build=true";
        //$data = file_get_contents($URL_spellcheck);
        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $URL_spellcheck));
        curl_exec($curl2);
        curl_close($curl2);

        WiseWireApi::set_option('SOLR_lasttime', date('Y-m-d H:i:s'));

    }


    public function parse_pod()
    {

        $this->data = json_decode(file_get_contents($this->destination_pod));

        //echo 'Parsed<br />';

        if ($this->data) {

            //echo $this->data->numFound.' '.$this->data->start.'<br />';

            $this->num_found = (int)$this->data->numFound;

            $this->wpdb->query("SET autocommit=0;");

            foreach ($this->data->pods->pod as $item) {

                $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_items` SET "
                    . "`itemId` = %s, `title` = %s, "
                    . "`itemType` = %s, `userId` = %s, `userFullName` = %s, "
                    . "`created` = %s, `updated` = %s, `repoId` = %s, "
                    . "`previewURL` = %s, `description` = %s, `questions` = %s, "
                    . "`instructionalTime` = %s, `price` = %s, `license_type` = %s, `type` = 'pod', "
                    . "`userEmail` = %s",
                    $item->podId,
                    $item->title,
                    $item->podType,
                    $item->userId,
                    $item->userFullName,
                    $item->created,
                    $item->updated,
                    $item->repoId,
                    $item->externalPreviewUrl,
                    $item->description,
                    $item->questions,
                    $item->instructionalTime,
                    $item->price,
                    $item->licenseType,
                    $item->userEmail
                );

                $this->wpdb->query($sql);

                if ($item->categories && sizeof($item->categories->category)) {
                    if (is_array($item->categories->category)) {
                        foreach ($item->categories->category as $category_id) {
                            $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
                                . "`itemId` = %s, `categoryId` = %s;", $item->podId, $category_id);
                            $this->wpdb->query($sql);
                        }
                    } else {
                        $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
                            . "`itemId` = %s, `categoryId` = %s;", $item->podId, $item->categories->category);
                        $this->wpdb->query($sql);
                    }
                }

                if ($item->tags && sizeof($item->tags->tag)) {
                    if (is_array($item->tags->tag)) {
                        foreach ($item->tags->tag as $tag) {
                            $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_tags` SET "
                                . "`itemId` = %s, `tag` = %s;", $item->podId, $tag);
                            $this->wpdb->query($sql);
                        }
                    } else {
                        $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_tags` SET "
                            . "`itemId` = %s, `tag` = %s;", $item->podId, $item->tags->tag);
                        $this->wpdb->query($sql);
                    }
                }

                $this->wpdb->update('wp_apicache_meta',array(
                    'meta_value' => 0
                ),array(
                    'itemId' => $item->podId,
                    'meta_key' => 'is_hide_item'
                ));
            }

            $this->wpdb->query("COMMIT;");

            $this->wpdb->query("SET autocommit=1;");

            return true;
        }

        echo '<span style="color: red;">No Data to Import!</span><br />';

        return false;
    }

    public function parse()
    {

        $this->data = json_decode(file_get_contents($this->destination));

        //echo 'Parsed<br />';

        if ($this->data) {

            //echo $this->data->numFound.' '.$this->data->start.'<br />';

            $this->num_found = (int)$this->data->numFound;

            $this->wpdb->query("SET autocommit=0;");

            foreach ($this->data->items->item as $item) {

                $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_items` SET "
                    . "`itemId` = %s, `contentType` = %s, `title` = %s, "
                    . "`itemType` = %s, `subType` = %s, `userId` = %s, `userFullName` = %s, "
                    . "`versionNumber` = %s, `created` = %s, `updated` = %s, `repoId` = %s, "
                    . "`dok` = %s, `previewURL` = %s, `description` = %s, `price` = %s, "
                    . "`license_type` = %s, `type` = 'item', "
                    . "`userEmail` = %s",
                    $item->itemId,
                    $item->contentType,
                    $item->title,
                    $item->objectType,
                    $item->subType,
                    $item->userId,
                    $item->userFullName,
                    $item->versionNumber,
                    $item->created,
                    $item->updated,
                    $item->repoId,
                    $item->dok,
                    $item->previewURL,
                    $item->description,
                    $item->price,
                    $item->licenseType,
                    $item->userEmail
                );

                $this->wpdb->query($sql);

                if ($item->categories && sizeof($item->categories->category)) {
                    if (is_array($item->categories->category)) {
                        foreach ($item->categories->category as $category_id) {
                            $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
                                . "`itemId` = %s, `categoryId` = %s;", $item->itemId, $category_id);
                            $this->wpdb->query($sql);
                        }
                    } else {
                        $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
                            . "`itemId` = %s, `categoryId` = %s;", $item->itemId, $item->categories->category);
                        $this->wpdb->query($sql);
                    }
                }

                if ($item->tags && sizeof($item->tags->tag)) {
                    if (is_array($item->tags->tag)) {
                        foreach ($item->tags->tag as $tag) {
                            $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_tags` SET "
                                . "`itemId` = %s, `tag` = %s;", $item->itemId, $tag);
                            $this->wpdb->query($sql);
                        }
                    } else {
                        $sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_tags` SET "
                            . "`itemId` = %s, `tag` = %s;", $item->itemId, $item->tags->tag);
                        $this->wpdb->query($sql);
                    }
                }
            }

            $this->wpdb->query("COMMIT;");

            $this->wpdb->query("SET autocommit=1;");

            return true;
        }

        //echo '<span style="color: red;">No Data to Import!</span><br />';

        return false;
    }
}