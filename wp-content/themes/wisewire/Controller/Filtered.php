<?php

require get_template_directory() . "/Controller/ExploreAll.php";

class Controller_Filtered extends Controller_ExploreAll
{

    public function __construct()
    {

        // change page name
        $this->page = 'filtered';

        // pass filters key as param
        parent::__construct('filtered');

        //unset( $_SESSION['exploreall_filters'] );
    }

    public function get_permalink()
    {

        return get_site_url() . '/filtered/';
    }

    public function get_filters($base = false)
    {

        $conditions = parent::get_filters($base);

        /*$conditions ['join'] []= "INNER JOIN wp_postmeta ct ON ct.`post_id` = p.`ID` AND ct.`meta_key` = 'item_content_type_icon' AND ct.`meta_value` = 'Student Resource'";
        $conditions ['api']['where'] []= "'Assessment' = 'Student Resource'";*/

        return $conditions;
    }
}