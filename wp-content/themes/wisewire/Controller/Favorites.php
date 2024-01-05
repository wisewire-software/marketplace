<?php

class Controller_Favorites
{

    private $wpdb;
    private $wp_query;

    public $recommendations = array();
    public $favorites = array();
    public $favorites_loaded = false;
    public $pio;

    public function __construct()
    {

        global $wpdb, $wp_query;

        $this->wpdb = $wpdb;
        $this->wp_query = $wp_query;

        //$this->pio = new PredictionIOController();

        //$this->load_data();
    }

    public function load_data()
    {

        // $this->load_recommendations();
    }

    private function load_recommendations()
    {

        $recommendations = $this->pio->get_recommendations(4);

        $recommended = array();

        if ($recommendations->itemScores) {

            foreach ($recommendations->itemScores as $item) {
                $recommended [] = $item->item;
            }
        }

        $sql = "SELECT p.* FROM `wp_posts` p INNER JOIN `wp_postmeta` pm ON pm.`meta_key` = 'item_object_id' AND pm.`post_id` = p.`ID` "
            . "AND pm.`meta_value` IN ('" . implode('\',\'', $recommended) . "') "
            . "WHERE p.`post_status` = 'publish';";

        $this->recommendations = $this->wpdb->get_results($sql);
    }

    public function is_favorite($item_object_id, $item_type)
    {
        $favorites = $this->get_favorites();
        foreach ($favorites as $v) {
            if ($v->type == $item_type && $v->item_object_id == $item_object_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $user_id
     */
    public function get_favorites()
    {

        if ($this->favorites_loaded === true) {
            return $this->favorites;
        }

        $user_id = get_current_user_id();
	$user_favorites = wp_cache_get('ww_favorites_user_'.$user_id);
	if ($user_favorites === false) {
        $sql1 = "SELECT p.`id`, "
            . "p.`author`, "
            . "p.`date`, "
            . "p.`title`, "
            . "p.`name`, "
            . "p.`type`, "
            . "p.`publish_date`, "
            . "p.`content_type_icon`, "
            . "p.`object_type`, "
            . "p.`ratings`, "
            . "p.`preview`, "
            . "p.`dok`, "
            . "p.`grade`, "
            . "p.`grade_id`, "
            . "p.`subdiscipline`, "
            . "p.`preview_url`, "
            . "p.`source`, "
            . "p.`description`, "
            . "p.`level1_label`, "
            . "p.`level2_label`, "
            . "p.`level3_label`, "
            . "p.`description_label`, "
            . "p.`code_label`, "
            . "p.`tags`, "
            . "p.`image_id`, "
            . "f.`fav_created`, "
            . "f.`item_id`  AS `item_object_id` "
            . "FROM `wp_favorites` f "
            . "INNER JOIN `summarized_item_metadata` p ON p.`id` =  CAST(f.`item_id` as CHAR(42)) "
            . "WHERE f.`user_id` = " . (int)$user_id . " ";


        $sql2 = "SELECT p.`id`, "
            . "p.`author`, "
            . "p.`date`, "
            . "p.`title`, "
            . "p.`name`, "
            . "p.`type`, "
            . "p.`publish_date`, "
            . "p.`content_type_icon`, "
            . "p.`object_type`, "
            . "p.`ratings`, "
            . "p.`preview`, "
            . "p.`dok`, "
            . "p.`grade`, "
            . "p.`grade_id`, "
            . "p.`subdiscipline`, "
            . "p.`preview_url`, "
            . "p.`source`, "
            . "p.`description`, "
            . "p.`level1_label`, "
            . "p.`level2_label`, "
            . "p.`level3_label`, "
            . "p.`description_label`, "
            . "p.`code_label`, "
            . "p.`tags`, "
            . "p.`image_id`, "
            . "f.`fav_created`, "
            . "f.`item_id`  AS `item_object_id` "
            . "FROM `wp_favorites` f "
            . "LEFT JOIN {$this->wpdb->postmeta} pm ON pm.`meta_key` = 'item_object_id' AND pm.`meta_value` = f.`item_id` "
            . "INNER JOIN `summarized_item_metadata` p ON p.`id` = CAST(pm.`post_id` as CHAR(42)) "
            . "WHERE f.`user_id` = " . (int)$user_id . " ";


        $sql = "SELECT * FROM ($sql1 UNION $sql2) AS x ORDER BY fav_created ASC;";


        $this->favorites_loaded = true;
        $user_favorites = $this->wpdb->get_results($sql);
	wp_cache_set('ww_favorites_user_'.$user_id, $user_favorites);
	}
	$this->favorites = $user_favorites;

        return $this->favorites;
    }

    /**
     *
     * @param int $user_id
     * @param mixed $item_id
     * @param int $item_type
     */
    public function action_add()
    {

        $user_id = get_current_user_id();
        $item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
        $item_type = isset($_REQUEST['item_type']) ? $_REQUEST['item_type'] : '';
        $item_source = isset($_REQUEST['item_source']) ? $_REQUEST['item_source'] : '';

      // clear favorites cache
      wp_cache_delete('ww_favorites_user_'.$user_id);  

      if (is_numeric($item_id) && $item_source != 'merlot') {
            $item_type = 'wp';
        }

        $a = array(
            'fav_created' => date('Y-m-d H:i:s'),
            'user_id' => $user_id,
            'item_id' => $item_id,
            'item_type' => $item_type
        );

        $this->wpdb->insert('wp_favorites', $a);

        $pio = new PredictionIOController();
        $pio->send_event('buy', $item_id);

    }

    /**
     * Require all field to make sure it is secured
     * @param int $user_id
     * @param mixed $item_id
     * @param int $item_type
     */
    public function action_remove()
    {

        $user_id = get_current_user_id();
        $item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
        $item_type = isset($_REQUEST['item_type']) ? $_REQUEST['item_type'] : '';

        if (is_numeric($item_id) && $item_type != "question") {
            $item_type = 'wp';
        }
      // clear cache  
      wp_cache_delete('ww_favorites_user_'.$user_id);

        $a = array(
            'user_id' => $user_id,
            'item_id' => $item_id,
            'item_type' => $item_type
        );


        $this->wpdb->delete('wp_favorites', $a, array('%d', '%s', '%s'));
    }
}
