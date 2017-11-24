<?php

// PHP Excel 1.8
require_once ABSPATH . 'wp-includes/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require_once(ABSPATH . 'wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php'); // helloAri

class WiseWireImportItems
{

    private $wpdb;
    private $xlsx_path = array();
    private $images_dir;

    private $categories;
    private $disciplines;

    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;
        $this->syncproducts = new WiseWireSyncProducts();    // helloAri

        $upload_dir = ABSPATH . 'tmp/162.242.245.131/Batch Upload Sheets to Celery/';

        $this->xlsx_path [] = $upload_dir . 'Sample Batch/WW_Bulk_Upload_sample set.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 01/WW_Bulk_Upload_Batch 1.xlsx';
        //$this->xlsx_path []= $upload_dir . 'Batch 02/WW_Bulk_Upload_Batch 02.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 03/WW_Bulk_Upload_Batch_03.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 04/WW_Bulk_Upload_Batch04_OER.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 07/WW_Bulk_Upload_HE_Batch_07.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 08/WW_Bulk_Upload_Batch_08_.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 09/WW_Bulk_Upload_Batch09.xlsx';
        $this->xlsx_path [] = $upload_dir . 'Batch 10/WW__Bulk_Upload_Batch_10.xlsx';

        $this->images_dir = $upload_dir . 'Sample Batch/Images for sample set 1/';
        $this->images_dir = $upload_dir . 'Batch 08/Images for Batch 08/Images/';

        $results = $this->wpdb->get_results("SELECT t.*, tt.`parent` FROM {$this->wpdb->terms} t "
            . "LEFT JOIN `wp_term_taxonomy` tt ON tt.`term_id` = t.`term_id` "
            . "WHERE t.`api_id` > 0 AND t.`api_type` IN ('Student Level','Grades And Disciplines')");

        if ($results) {
            foreach ($results as $v) {
                $parent = in_array($v->parent, $this->get_parent_categories()) ? 0 : $v->parent;
                $this->categories[$parent] [$v->name] = array('name' => $v->name, 'parent' => $v->parent, 'slug' => $v->slug, 'term_id' => $v->term_id);
            }
        }

        // load all main categories / Disciplines
        $sql = "SELECT t.`name`, t.`term_id`, t.`slug`, tt.`parent` FROM {$this->wpdb->terms} t "
            . "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_id` = t.`term_id` "
            . "WHERE t.`api_type` = 'Discipline' "
            . "ORDER BY t.`name` ASC;";
        $disciplines = $this->wpdb->get_results($sql, ARRAY_A);

        if ($disciplines) {
            foreach ($disciplines as $v) {
                $this->disciplines[$v['parent']] [$v['name']] = $v;
            }
        }
    }

    private function get_parent_categories()
    {
        $sql = "SELECT term_id FROM wp_terms WHERE api_type = 'Student Level' AND slug NOT LIKE '%;%'";
        $categories_parent = $this->wpdb->get_results($sql, ARRAY_A);
        $data_categories = array();
        foreach ($categories_parent as $c) {
            $data_categories[] = $c['term_id'];
        }
        return $data_categories;
    }

    public function download_remote_files()
    {

        $ftp_host = '162.242.245.131';
        $ftp_user = 'WRDNUM150031';
        $ftp_password = 'Rockrose2050!';
        $ftp_path = '/Batch Upload Sheets to Celery/';

        $local_path = '/var/www/html/tmp';

        $cmd = "wget -P $local_path -m 'ftp://$ftp_user:$ftp_password@$ftp_host$ftp_path'";

        exec($cmd, $output);

        //f_print_r($output);

        return $output;
    }

    public function hide_imported($file)
    {

        $path = ABSPATH . 'tmp/162.242.245.131/Batch Upload Sheets to Celery/' . $file;

        //  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($path);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($path, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
        }

        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0); // first sheet (0..N-1)
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // which row is first
        $startRow = 3;

        //  Loop through rows
        for ($row = $startRow; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                null, true, false);

            $post = array();

            foreach ($rowData[0] as $k => $v) {
                $post[$this->get_col_letter($k + 1)] = $v;
            }

            $object_id = $post['B'];
            if ($object_id) {
                $post = $this->wpdb->get_row("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_id' AND `meta_value` = '" . esc_sql($object_id) . "'");
                if ($post) {
                    $sql = "UPDATE `wp_posts` SET `post_status` = 'private' WHERE `ID` = " . (int)$post->post_id . ";";
                    echo $sql . '<br />';
                }
            }
        }
    }

    public function validate_file($path)
    {

    }

    public function import_ziped_images($path)
    {

        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {

                if (is_dir($path . $entry)) {

                    // object_id is the directory name
                    $object_id = $entry;
                    $post_result = $this->wpdb->get_results("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_id' AND `meta_value` = '" . $object_id . "';");

                    if (!$post_result) {
                        continue;
                    }

                    $post_id = $post_result[0]->post_id;

                    $handle2 = opendir($path . $entry);

                    // list of carousel gallery images
                    $carousel_attach_id = array();

                    while (false !== ($file = readdir($handle2))) {

                        // identify file
                        if (is_dir($path . $entry . '/' . $file)) {
                            continue;
                        }
                        echo 'is file' . "\n";

                        if (preg_match("/^pdf_cta/i", $file, $matches)) {

                            // pdf to CTA
                            $attach_id = $this->import_image($path . $entry . '/' . $file, $post_id);

                            update_post_meta($post_id, '_item_cta_button_pdf', 'field_5628d9e379348');
                            update_post_meta($post_id, 'item_cta_button_pdf', $attach_id);

                        } else if (preg_match("/^demo_pdf_/i", $file, $matches)) {

                            // pdf to CTA
                            $attach_id = $this->import_image($path . $entry . '/' . $file, $post_id);

                            update_post_meta($post_id, '_item_preview_pdf', 'field_5643b74bfa982');
                            update_post_meta($post_id, 'item_preview_pdf', $attach_id);

                        } elseif (preg_match("/^main_/i", $file, $matches)) {

                            // main image
                            $attach_id = $this->import_image($path . $entry . '/' . $file, $post_id, 'main');

                            update_post_meta($post_id, '_item_main_image', 'field_5628d98c79346');
                            update_post_meta($post_id, 'item_main_image', $attach_id);

                        } else if (preg_match("/^demo_carousel_/i", $file, $matches)
                            || preg_match("/^demo_pdf_[0-9]{3}\.jpg$/i", $file, $matches)) {
                            // carousel images
                            $carousel_attach_id [] = $this->import_image($path . $entry . '/' . $file, $post_id);
                        }
                    }

                    closedir($handle2);

                    update_post_meta($post_id, '_item_carousel_images', 'field_5628d9b079347');
                    update_post_meta($post_id, 'item_carousel_images', serialize($carousel_attach_id));
                }
            }

            closedir($handle);
        }
    }

    public function import_single_file($path)
    {

        //  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($path);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path);
        } catch (Exception $e) {
            @unlink($path);
            die('Error loading file "' . pathinfo($path, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
        }

        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0); // first sheet (0..N-1)
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $firstRowData = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, false);

        if ($firstRowData[0][37] != 'Level of Rigor') {
            @unlink($path);
            die('Error, columns count doesnt match!');
        }

        // which row is first
        $startRow = 3;

        //  Loop through rows
        for ($row = $startRow; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                null, true, false);

            $post = array();

            foreach ($rowData[0] as $k => $v) {
                $post[$this->get_col_letter($k + 1)] = $v;
            }

            $this->import_post($post);
        }

        @unlink($path);

    }

    public function import()
    {

        foreach ($this->xlsx_path as $path) {

            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($path);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($path);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($path, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0); // first sheet (0..N-1)
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            // which row is first
            $startRow = 3;

            //  Loop through rows
            for ($row = $startRow; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    null, true, false);

                $post = array();

                foreach ($rowData[0] as $k => $v) {
                    $post[$this->get_col_letter($k + 1)] = $v;
                }

                $this->import_post($post);
            }
        }
    }

    private function decode_grades($grades)
    {

        $map = array(
            1 => 'First grade',
            2 => 'Second grade',
            3 => 'Third grade',
            4 => 'Fourth grade',
            5 => 'Fifth grade',
            6 => 'Sixth grade',
            7 => 'Seventh grade',
            8 => 'Eighth grade',
            9 => 'Ninth grade',
            10 => 'Tenth grade',
            11 => 'Eleventh grade',
            12 => 'Twelfth grade'
        );

        if (preg_match('/^Grade ([0-9\-]+)/', $grades, $matches)) {

            $g = explode('-', $matches[1]);

            if ($g) {
                $grades = array();
                foreach ($g as $grade) {
                    $grades [] = $map[$grade];
                }
                $grades = implode(';', $grades);
            }
        }

        return $grades;
    }

    private function map_categories($grade, $discipline, $subdiscipline1, $subdiscipline2)
    {

        $categories = array();

        $grade = trim($grade);
        $discipline_list = explode(';', $discipline);
        $discipline = trim($discipline_list[0]);
        $subdiscipline1 = trim($subdiscipline1);
        $subdiscipline2 = trim($subdiscipline2);

        // add disciplines
        if (isset($this->disciplines[0][$discipline])) {
            //echo $discipline.'<br />';
            $d = $this->disciplines[0][$discipline];
            $categories[] = $d['term_id'];

            //echo $subdiscipline1.'<br />';
            if (isset($this->disciplines[$d['term_id']][$subdiscipline1])) {
                $categories[] = $this->disciplines[$d['term_id']][$subdiscipline1]['term_id'];
            }
            //echo $subdiscipline2.'<br />';
            if (isset($this->disciplines[$d['term_id']][$subdiscipline2])) {

                $categories[] = $this->disciplines[$d['term_id']][$subdiscipline2]['term_id'];
            }
        }

        $grade = $this->decode_grades($grade);

        // split grades
        $grades = array_map('trim', explode(';', $grade));
        if ($grades) {
            foreach ($grades as $grade) {

                $grade = str_replace('Kindergarten', 'Kindergarden', $grade);

                $d = $sd1 = $sd2 = '';

                if (isset($this->categories[0][$grade])) {
                    //echo $grade.'<br />';
                    $grade = $this->categories[0][$grade];

                    $categories[] = $grade['parent'];
                    $categories[] = $grade['term_id'];

                    if (isset($this->categories[$grade['term_id']][$discipline])) {
                        //echo $discipline.'<br />';
                        $d = $this->categories[$grade['term_id']][$discipline];
                        $categories[] = $d['term_id'];

                        if (isset($this->categories[$d['term_id']][$subdiscipline1])) {
                            //echo $subdiscipline1.'<br />';
                            $sd1 = $this->categories[$d['term_id']][$subdiscipline1];
                            $categories[] = $sd1['term_id'];
                        }

                        if (isset($this->categories[$d['term_id']][$subdiscipline2])) {
                            //echo $subdiscipline2.'<br />';
                            $sd2 = $this->categories[$d['term_id']][$subdiscipline2];
                            $categories[] = $sd2['term_id'];
                        }
                    }
                }
            }
        }

        return $categories;
    }

    public function import_post($post)
    {

        if (!$post['B']) {
            return true;
        }

        $categories = $this->map_categories($post['M'], $post['I'], $post['J'], $post['K']);

        $this->wpdb->query("SET autocommit=0;");

        // Create post object
        $my_post = array(
            'post_title' => $post['A'],
            'post_name' => '',
            //'post_content'  => 'This is my post.',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type' => 'item',
            'post_category' => $categories
        );

        $metaData = array(
            'item_object_id' => $post['B'],
            '_item_object_id' => 'field_55ebffd81397a',
            'item_publish_date' => PHPExcel_Style_NumberFormat::toFormattedString($post['N'], 'yyyymmdd'),
            '_item_publish_date' => 'field_55ec00c713983',
            //'item_home_page_feature' => $post['C'],
            //'_item_home_page_feature' => 'field_55ebffee1397b',
            //'item_explore_page_feature' => $post['D'],
            //'_item_explore_page_feature' => 'field_55ec00211397c',
            'item_price' => $post['E'],
            //'_item_price' => 'field_55ec00611397f',
            'item_cta_button' => $post['F'],
            '_item_cta_button' => 'field_55ec007313980',
            'item_cta_button_url' => $post['G'],
            '_item_cta_button_url' => 'field_5638d3e955698',
            'item_preview' => $post['H'],
            '_item_preview' => 'field_55ec0380b4143',
            //'item_sample_demo_template' => $post['H'],
            //'_item_sample_demo_template' => 'field_55ec00501397e',
            //'item_cta_button_url' => $post['F'],
            //'_item_cta_button_url' => 'field_560ec6cbeeb06',
            'item_content_type_icon' => $post['L'],
            '_item_content_type_icon' => 'field_55ec008f13981',
            'item_grade_level' => $post['M'],
            '_item_grade_level' => 'field_55ec00ae13982',
            'item_object_type' => $post['O'],
            '_item_object_type' => 'field_55ec010813984',
            'item_contributor' => $post['P'],
            '_item_contributor' => 'field_55ec012113986',
            //'item_contributor_link' => $post['U'],
            //'_item_contributor_link' => 'field_55ec012a13987',
            //'item_contributor_email' => $post['V'],
            //'_item_contributor_email' => 'field_55ec013913988',
            //'item_contributor_description' => $post['W'],
            //'_item_contributor_description' => 'field_55ec014b13989',
            //'item_contributor_image' => $post['X'],
            //'_item_contributor_image' => 'field_55ec015e1398a',
            'item_ratings' => '',
            '_item_ratings' => 'field_55ec018421be4',
            'item_standards' => array_map('trim', explode(';', $post['Q'])),
            '_item_standards' => 'field_55ec01a121be5',
            'item_standards_subtag' => $post['R'], //array_map('trim',explode(';',$post['R'])),
            '_item_standards_subtag' => 'field_55ec01ca21be6',
            'item_dok' => $post['S'],
            '_item_dok' => 'field_55ec01d721be7',
            'item_keywords' => $post['T'],
            '_item_keywords' => 'field_55ec01e621be8',
            //'item_pdf_download_terms_button' => $post['T'],
            //'_item_pdf_download_terms_button' => 'field_55ec01f121be9',
            //'item_pdf_download_terms_button_url' => $post['AE'],
            //'_item_pdf_download_terms_button_url' => 'field_55ec020521bea',
            'item_for_sale' => $post['V'],
            '_item_for_sale' => 'field_55ec021521beb',
            'item_license_type' => $post['W'],
            '_item_license_type' => 'field_55ec024621bec',
            'item_license_url' => $post['X'],
            '_item_license_url' => 'field_56331c25e4854',
            'item_language' => $post['Y'],
            '_item_language' => 'field_55ec025321bed',
            'item_long_description' => $post['Z'],
            '_item_long_description' => 'field_55ec025f21bee',
            'item_read_more' => $post['AA'],
            '_item_read_more' => 'field_56063fa2955da',
            'item_parent_object' => $post['AB'],
            '_item_parent_object' => 'field_55ec028121bef',
            'item_parent_object_child_objects' => $post['AC'],
            '_item_parent_object_child_objects' => 'field_55ec029221bf0',
            'item_parent_object_next_in_sequence' => $post['AD'],
            '_item_parent_object_next_in_sequence' => 'field_55ec029f21bf1',
            'item_parent_object_previous_in_sequence' => $post['AE'],
            '_item_parent_object_previous_in_sequence' => 'field_55ec02ab21bf2',
            'item_related_content' => array_map('trim', explode(';', $post['AF'])),
            '_item_related_content' => 'field_55ec02b821bf3',
            'item_demo_viewer_template' => $post['AG'],
            '_item_demo_viewer_template' => 'field_55ec02c421bf4',
            //'item_demo_viewer_pdf_viewer_preview_pages' => $post['AP'],
            //'_item_demo_viewer_pdf_viewer_preview_pages' => 'field_55ec02d221bf5',
            //'item_object_type_tei_type' => $post['AF'],
            //'_item_object_type_tei_type' => 'field_55ec011613985',
            'item_object_url' => $post['AI'],
            '_item_object_url' => 'field_5606400d955dd',
            'item_demo_subhead' => $post['AJ'],
            '_item_demo_subhead' => 'field_55ec02de21bf6',
            'item_instructional_time' => PHPExcel_Style_NumberFormat::toFormattedString($post['AK'], 'hh:mm'),
            '_item_instructional_time' => 'field_56063fd7955db',
            'item_level_of_rigor' => $post['AL'],
            '_item_level_of_rigor' => 'field_56063fe2955dc'
        );

        // search form post
        $results = $this->wpdb->get_results("SELECT post_id FROM {$this->wpdb->postmeta} WHERE `meta_key` = 'item_object_id' "
            . "AND `meta_value` = '" . $post['B'] . "'");

        // skip if exists
        if ($results && $results[0]->post_id) {

            $post_id = (int)$results[0]->post_id;

            //echo 'Update '.$post_id.'<br />';

            $my_post['ID'] = $post_id;

            wp_update_post($my_post);

            foreach ($metaData as $meta_key => $meta_value) {
                update_post_meta($post_id, $meta_key, $meta_value);
            }

        } else {

            // Insert the post into the database
            $post_id = wp_insert_post($my_post);

            //echo 'Insert '.$post_id.'<br />';

            foreach ($metaData as $meta_key => $meta_value) {
                add_post_meta($post_id, $meta_key, $meta_value);
            }

            add_post_meta($post_id, 'is_hide_item', 0);
        }


        /* ----------------------------------------------------------  BEGIN HELLOARI  ------------------ */


        $objid = $post['B'];
        if ($post['B']) {

            $prod_id = $this->syncproducts->get_product_by_sku($objid);

            if ($prod_id) {
                $this->syncproducts->update_lo_upload_product($post, $prod_id);
            } else {
                $this->syncproducts->add_lo_upload_product($post);
            }

        }

        $this->update_grades_post($post_id, $post['M']);

        /* -----------------------------------------------------------------  END HELLOARI  ------------------ */

        // set keywords
        wp_set_post_terms($post_id, array_map('trim', explode(';', $post['T'])), 'post_tag');

        // set standards
        wp_set_post_terms($post_id, array_map('trim', explode(';', $post['Q'])), 'Standards');

        // set languages
        wp_set_post_terms($post_id, array_map('trim', explode(';', $post['Y'])), 'Languages');

        // set relations
        wp_set_post_terms($post_id, array_map('trim', explode(';', $post['AF'])), 'Related');

        //set object types
        wp_set_post_terms($post_id, array_map('trim', explode(';', $post['O'])), 'ObjectType');

        $this->wpdb->query("COMMIT;");
    }


    private function gradesLabel()
    {
        return array(
            15319 => 'Pre-K',
            15320 => 'Kindergarten',
            15321 => 'First grade',
            15322 => 'Second grade',
            15323 => 'Third grade',
            15324 => 'Fourth grade',
            15325 => 'Fifth grade',
            15326 => 'Sixth grade',
            15327 => 'Seventh grade',
            15328 => 'Eighth grade',
            15330 => 'Ninth grade',
            15331 => 'Tenth grade',
            15332 => 'Eleventh grade',
            15333 => 'Twelfth grade',
            15335 => 'Undergraduate',
            15336 => 'Graduate'
        );

    }

    private function update_grades_post($post_id, $grades)
    {
        if ($grades) {
            $data_grades = explode(';', $grades);

            if (count($data_grades)) {
                $grade_keys = implode(', ', array_keys($this->gradesLabel()) );

                $sql = $this->wpdb->prepare("DELETE FROM wp_term_relationships WHERE object_id = %d AND term_taxonomy_id IN(".$grade_keys.")",$post_id );
                $this->wpdb->query($sql);

                foreach ($data_grades as $key => $grade){
                    $grade = trim($grade);

                    $key_grade = array_search(trim($grade), $this->gradesLabel());
                    if($key_grade){
                        $sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (%d, %d, %d)", $post_id, $key_grade, $key);
                        $this->wpdb->query($sql);
                    }


                }
            }
        }

    }

    public function sync_post_grades(){

        $query = "SELECT p.post_id, p.meta_value  FROM  wp_postmeta p INNER JOIN summarized_item_metadata s ON p.post_id = s.id AND s.source = 'CMS' and grade IS NULL WHERE p.meta_key='item_grade_level'";

        $data_post = $this->wpdb->get_results($query, ARRAY_A);

        foreach ($data_post as $post){
            $this->update_grades_post($post['post_id'], $post['meta_value']);
            echo "Update Post ". $post['post_id']."<br>";
        }
    }

    private function import_image($filepath, $parent_post_id = 0, $type = '')
    {

        $sql = "SELECT pm.`post_id` FROM `wp_postmeta` pm "
            . "INNER JOIN `wp_posts` p ON p.`ID` = pm.`post_id` AND p.`post_parent` = " . $parent_post_id . " "
            . "WHERE pm.`meta_key` = '_wp_attached_file' AND pm.`meta_value` LIKE '%/" . esc_sql(basename($filepath)) . "';";

        $old_attachment = $this->wpdb->get_row($sql);
        if ($old_attachment) {
            wp_delete_attachment($old_attachment->post_id, true);
        }

        $this->wpdb->query("SET autocommit=0;");

        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();

        //$wp_upload_path = $wp_upload_dir['path'].'/'.date('d').'/'.$parent_post_id.'/';
        $wp_upload_path = $wp_upload_dir['basedir'] . '/items/' . $parent_post_id . '/';

        if (!file_exists($wp_upload_path)) {
            mkdir($wp_upload_path, 0777, true);
        }

        $filename = $wp_upload_path . basename($filepath);

        // copy file to destination
        copy($filepath, $filename);

        unlink($filepath);

        // Check the type of file. We'll use this as the 'post_mime_type'.
        $filetype = wp_check_filetype(basename($filename), null);

        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Insert the attachment.
        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
        wp_update_attachment_metadata($attach_id, $attach_data);

        if ($type == 'main') {
            set_post_thumbnail($parent_post_id, $attach_id);
        }

        $this->wpdb->query("COMMIT;");

        $this->wpdb->query("SET autocommit=1;");

        return $attach_id;
    }

    public function import_images()
    {

        // Demo_carousel_%.jpg
        // pdf_cta.pdf
        // main.jpg

        if ($handle = opendir($this->images_dir)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {

                if (is_dir($this->images_dir . $entry)) {

                    // object_id is the directory name
                    $object_id = $entry;
                    echo $object_id . '<br />';
                    $post_result = $this->wpdb->get_results("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_id' AND `meta_value` = '" . $object_id . "';");

                    if (!$post_result) {
                        continue;
                    }

                    $post_id = $post_result[0]->post_id;

                    $handle2 = opendir($this->images_dir . $entry);

                    // list of carousel gallery images
                    $carousel_attach_id = array();

                    while (false !== ($file = readdir($handle2))) {

                        // identify file
                        if (is_dir($this->images_dir . $entry . '/' . $file)) {
                            continue;
                        }

                        if ($file == 'pdf_cta.pdf') {

                            // pdf to CTA
                            $attach_id = $this->import_image($this->images_dir . $entry . '/' . $file, $post_id);

                            update_post_meta($post_id, '_item_cta_button_pdf', 'field_5628d9e379348');
                            update_post_meta($post_id, 'item_cta_button_pdf', $attach_id);

                        } else if (preg_match("/^demo_pdf_/i", $file, $matches)) {

                            // pdf to CTA
                            $attach_id = $this->import_image($this->images_dir . $entry . '/' . $file, $post_id);

                            update_post_meta($post_id, '_item_preview_pdf', 'field_5643b74bfa982');
                            update_post_meta($post_id, 'item_preview_pdf', $attach_id);

                        } else if ($file === 'pdf_download_terms.pdf') {

                            // terms
                            $this->import_image($this->images_dir . $entry . '/' . $file, $post_id);

                        } else if ($file === 'main.jpg') {

                            // main image
                            $attach_id = $this->import_image($this->images_dir . $entry . '/' . $file, $post_id, 'main');

                            update_post_meta($post_id, '_item_main_image', 'field_5628d98c79346');
                            update_post_meta($post_id, 'item_main_image', $attach_id);

                        } else if (preg_match("/^demo_carousel_[0-9]{1,3}\.jpg$/i", $file, $matches)
                            || preg_match("/^demo_pdf_[0-9]{3}\.jpg$/i", $file, $matches)) {
                            // carousel images
                            $carousel_attach_id [] = $this->import_image($this->images_dir . $entry . '/' . $file, $post_id);
                        }


                    }

                    update_post_meta($post_id, '_item_carousel_images', 'field_5628d9b079347');
                    update_post_meta($post_id, 'item_carousel_images', serialize($carousel_attach_id));

                    closedir($handle2);
                }
            }

            closedir($handle);
        }
    }


    public function fix_thumbnails_relations()
    {
        $sql = "SELECT * FROM `wp_posts` WHERE `post_type` LIKE 'attachment' ORDER BY `ID` DESC";
        $results = $this->wpdb->get_results($sql);

        if ($results) {
            foreach ($results as $post) {
                add_post_meta($post->post_parent, '_thumbnail_id', $post->ID);
            }
        }
    }


    private function get_col_list($from, $to)
    {
        $from_i = get_col_index($from);
        $to_i = get_col_index($to);

        $list = array();
        for ($i = $from_i; $i <= $to_i; $i++) {
            $list [] = get_col_letter($i);
        }
        return $list;
    }

    private function get_col_index($cell)
    {
        $index = 1;
        for ($i = 0; $i < strlen($cell); $i++) {
            if ($i > 0) {

                $index *= 26;
                if ($i == 1) {
                    $index++;
                }
            }
            $index += (ord($cell{$i}) - 65);
        }
        return $index;
    }

    private function get_col_letter($index)
    {
        if ($index / 26 > 1) {
            return chr(65 + intval(($index - 1) / 26) - 1) . chr(65 + (($index - 1) % 26));
        } else {
            return chr(65 + (($index - 1) % 26));
        }
    }

    private function get_col_sum($col, $from, $to, $data)
    {
        $sum = 0;
        for ($i = $from; $i <= $to; $i++) {
            $sum += $data[$col . $i];
        }
        return $sum;
    }
}