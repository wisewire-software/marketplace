<?php

require get_template_directory() . "/Controller/ExploreAll.php";

class Controller_MostViewed extends Controller_ExploreAll
{

    public function __construct()
    {

        $this->page = 'mostviewed';

        parent::__construct('most-viewed');
    }

    public function get_permalink()
    {

        return get_site_url() . '/most-viewed/';
    }

    public function get_filters($base = false)
    {

        $conditions = parent::get_filters($base);
        $conditions['q'] = '*:*';
        $conditions['fq'][] = 'views:[1 TO *]';
        $conditions['sort'] = 'views DESC';

        return $conditions;
    }
}