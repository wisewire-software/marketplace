<?php

class WW_Yoast_Seo_Sitemap_Base
{

    public $page_custom_type = '';
    private $last_modified = null;

    function __construct()
    {
        add_filter('wpseo_sitemap_index', array($this, 'add_seo_sitemap'));
        add_filter('wpseo_enable_xml_sitemap_transient_caching', '__return_false');
    }

    public function add_seo_sitemap()
    {
        $smp = '';
        $smp .= '<sitemap>' . "\n";
        $smp .= '<loc>' . site_url() . '/' . $this->page_custom_type . '-sitemap.xml</loc>' . "\n";
        $smp .= '<lastmod>' . htmlspecialchars($this->last_modified) . '</lastmod>' . "\n";
        $smp .= '</sitemap>' . "\n";

        return $smp;
    }

    public function set_last_modified($last_modified)
    {
        $this->last_modified = $last_modified;
    }
}

