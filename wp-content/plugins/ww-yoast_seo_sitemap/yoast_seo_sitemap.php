<?php

/*
Plugin Name: WW Yoast SEO Sitemap: Page Explore
*/


class WW_Yoast_Seo_Sitemap
{
    public function __construct()
    {
        $this->include_sitemaps();
    }

    function include_sitemaps()
    {
        include_once('yoast_seo_sitemap_base.php');
        include_once('yoast_seo_sitemap_explore.php');
    }

}

new WW_Yoast_Seo_Sitemap();