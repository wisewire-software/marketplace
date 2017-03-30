<?php
/**
 * Base class defining same constructor for both ver 4 and 5 of the field
 */

class acf_field_wisewire_post_item extends acf_field
{
    var $settings;

    function __construct()
    {

        $this->name = 'wisewire_post_item';
        $this->label = __("Wisewire Post Item", 'acf-wwpi');
        $this->category = 'relational';

        $this->defaults = array(
            'min' => 0,
            'max' => 0,
            'filters' => array('search'),
            'elements' => array(),
            'return_format' => 'object'
        );
        $this->l10n = array(
            'min' => __("Minimum values reached ( {min} values )", 'acf-wwpi'),
            'max' => __("Maximum values reached ( {max} values )", 'acf-wwpi'),
            'loading' => __('Loading', 'acf-wwpi'),
            'empty' => __('No matches found', 'acf-wwpi'),
        );

        add_action('wp_ajax_acf/field/wisewire_get_post_item/query',			array($this, 'ajax_query'));
        add_action('wp_ajax_nopriv_acf/field/wisewire_get_post_item/query',	array($this, 'ajax_query'));

        parent::__construct();

        $this->settings = array(
            'path' => plugin_dir_path(__FILE__),
            'url' => plugins_url('',__FILE__),
            'version' => ACF_Wisewire_Post_Item::version,
            'script-handle' => 'acf-input-wisewire-post-item',
            'acf-script-handle' => 'acf-input'
        );

    }
}

?>