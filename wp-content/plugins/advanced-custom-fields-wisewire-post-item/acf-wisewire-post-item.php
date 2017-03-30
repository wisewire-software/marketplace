<?php
/*
Plugin Name: ACF: Wisewire Post Item and Item Platform
Text Domain: acf-wwpi
Domain Path: /lang
*/


class ACF_Wisewire_Post_Item {

    const version = '1.0';

    function __construct() {
        add_action('plugins_loaded', array($this, 'plugins_loaded') );
        add_action('acf/include_field_types', array($this, 'include_field_types'));
    }

    function plugins_loaded() {
        load_plugin_textdomain('acf-wwpi', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
    }

    function include_field_types($version) {// $version = 5 and can be ignored until ACF6 exists
        include_once('functions.php');
        include_once('acf-wisewire-post-item-base.php');
        include_once('acf-wisewire-post-item-v5.php');
    }
}

new ACF_Wisewire_Post_Item();