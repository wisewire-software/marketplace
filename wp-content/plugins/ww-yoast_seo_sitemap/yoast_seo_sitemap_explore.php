<?php

class WW_Yoast_Seo_Sitemap_Explore extends WW_Yoast_Seo_Sitemap_Base
{

    private $post = array();
    private $post_last_modified;

    function __construct()
    {
        parent::__construct();

        $this->page_custom_type = 'explore';
        $this->post = $this->get_post_explore();
        $this->post_last_modified = $this->get_post_last_modified();
        $this->set_last_modified($this->post_last_modified);

        add_action('init', array($this, 'init_wpseo_do_sitemap_actions'));
        add_action('init', array($this, 'register_sitemap_explore'), 99);
        //add_action('init', 'init_do_sitemap_actions');
    }

    public function init_wpseo_do_sitemap_actions()
    {
        add_action("wpseo_do_sitemap_" . $this->page_custom_type, array($this, 'generate_sitemap_explore'));
    }

    private function get_post_explore()
    {
        $the_slug = 'explore';
        $args = array(
            'name' => $the_slug,
            'post_type' => 'page',
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $post = get_posts($args);

        if (is_array($post)) {
            $post = $post[0];
        }

        return $post;
    }

    private function get_post_last_modified()
    {
        if (isset($this->post->post_modified_gmt) && $this->post->post_modified_gmt != '0000-00-00 00:00:00' && $this->post->post_modified_gmt > $this->post->post_date_gmt) {
            $last_modified = $this->post->post_modified_gmt;
        } else {
            if ('0000-00-00 00:00:00' != $this->post->post_date_gmt) {
                $last_modified = $this->post->post_date_gmt;
            } else {
                $last_modified = $this->post->post_date;
            }
        }

        return $last_modified;
    }

    public function generate_sitemap_explore()
    {

        global $wpseo_sitemaps;

        $chf = 'weekly';
        $pri = 1.0;

        $grades = array(
            'elementary' => 'Elementary',
            'middle' => 'Middle',
            'high-school' => 'High School',
            'higher-education' => 'Higher Education'
        );

        $output = '';
        foreach ($grades as $grade_key => $grade) {
            $url['mod'] = $this->post_last_modified;
            $url['loc'] = site_url() . '/explore/' . $grade_key;
            $url['chf'] = $chf;
            $url['pri'] = $pri;

            $output .= $wpseo_sitemaps->sitemap_url($url);

            if (have_rows('grade_repeater', $this->post->ID)) {
                while (have_rows('grade_repeater', $this->post->ID)) {
                    the_row();
                    $grade_cms = get_sub_field('grade');
                    if ($grade_key === $grade_cms) {
                        if (have_rows('carousel_repeater', $this->post->ID)) {

                            while (have_rows('carousel_repeater', $this->post->ID)) {
                                the_row();
                                $category = get_sub_field('section_category');

                                $url['mod'] = $this->post_last_modified;
                                $url['loc'] = site_url() . '/explore/' . $grade_key . '/' . $category->slug;
                                $url['chf'] = $chf;
                                $url['pri'] = $pri;
                                $output .= $wpseo_sitemaps->sitemap_url($url);
                            }
                        }
                    }
                }
            }
        }

        if (empty($output)) {
            $wpseo_sitemaps->bad_sitemap = true;
            return;
        }

        //Build the full sitemap
        $sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
        $sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sitemap .= $output . '</urlset>';
        $wpseo_sitemaps->set_sitemap($sitemap);

    }

    public function register_sitemap_explore()
    {
        global $wpseo_sitemaps;
        $wpseo_sitemaps->register_sitemap($this->page_custom_type, array($this, 'generate_sitemap_explore'));
    }

//    private function init_do_sitemap_actions()
//    {
//        add_action('wp_seo_do_sitemap_our-page-explore', 'ex_generate_origin_combo_sitemap');
//    }

}

new WW_Yoast_Seo_Sitemap_Explore();