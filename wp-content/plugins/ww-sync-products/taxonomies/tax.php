<?php
// REGISTER TAXONOMIES
add_action( 'init', 'register_taxonomy_format' );

function register_taxonomy_format() {

    $labels = array( 
        'name' => _x( 'Formats', 'format' ),
        'singular_name' => _x( 'Format', 'format' ),
        'search_items' => _x( 'Search Formats', 'format' ),
        'popular_items' => _x( 'Popular Formats', 'format' ),
        'all_items' => _x( 'All Format', 'formats' ),
        'parent_item' => _x( 'Parent Format', 'format' ),
        'parent_item_colon' => _x( 'Parent Format:', 'format' ),
        'edit_item' => _x( 'Edit Format', 'format' ),
        'update_item' => _x( 'Update Format', 'format' ),
        'add_new_item' => _x( 'Add New Format', 'format' ),
        'new_item_name' => _x( 'New Format', 'format' ),
        'separate_items_with_commas' => _x( 'Separate formats with commas', 'format' ),
        'add_or_remove_items' => _x( 'Add or remove formats', 'format' ),
        'choose_from_most_used' => _x( 'Choose from the most used formats', 'format' ),
        'menu_name' => _x( 'Formats', 'format' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
		'has_archive' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'format', array('school'), $args );
}

add_action( 'init', 'register_taxonomy_format' );

function register_taxonomy_association() {

    $labels = array( 
        'name' => _x( 'Association', 'association' ),
        'singular_name' => _x( 'Associations', 'association' ),
        'search_items' => _x( 'Search Association', 'association' ),
        'popular_items' => _x( 'Popular Association', 'association' ),
        'all_items' => _x( 'All Associations', 'association' ),
        'parent_item' => _x( 'Parent Association', 'association' ),
        'parent_item_colon' => _x( 'Parent Association:', 'association' ),
        'edit_item' => _x( 'Edit Association', 'association' ),
        'update_item' => _x( 'Update Association', 'association' ),
        'add_new_item' => _x( 'Add New Association', 'association' ),
        'new_item_name' => _x( 'New Association', 'association' ),
        'separate_items_with_commas' => _x( 'Separate Associations with commas', 'association' ),
        'add_or_remove_items' => _x( 'Add or remove Association', 'association' ),
        'choose_from_most_used' => _x( 'Choose from the most used Association', 'association' ),
        'menu_name' => _x( 'Association', 'association' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
		'has_archive' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'association', array('school'), $args );
}

add_action( 'init', 'register_taxonomy_association' );

function register_taxonomy_focus() {

    $labels = array( 
        'name' => _x( 'Focus', 'focus' ),
        'singular_name' => _x( 'Focuses', 'focus' ),
        'search_items' => _x( 'Search Focus', 'focus' ),
        'popular_items' => _x( 'Popular Focus', 'focus' ),
        'all_items' => _x( 'All Focuses', 'focus' ),
        'parent_item' => _x( 'Parent Focus', 'focus' ),
        'parent_item_colon' => _x( 'Parent Focus:', 'focus' ),
        'edit_item' => _x( 'Edit Focus', 'focus' ),
        'update_item' => _x( 'Update Focus', 'focus' ),
        'add_new_item' => _x( 'Add New Focus', 'focus' ),
        'new_item_name' => _x( 'New Focus', 'focus' ),
        'separate_items_with_commas' => _x( 'Separate Focuses with commas', 'focus' ),
        'add_or_remove_items' => _x( 'Add or remove Focus', 'focus' ),
        'choose_from_most_used' => _x( 'Choose from the most used Focus', 'focus' ),
        'menu_name' => _x( 'Focus', 'focus' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
		'has_archive' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'focus', array('school'), $args );
}

add_action( 'init', 'register_taxonomy_focus' );


function register_taxonomy_region() {

    $labels = array( 
        'name' => _x( 'Region', 'region' ),
        'singular_name' => _x( 'Regions', 'region' ),
        'search_items' => _x( 'Search Region', 'region' ),
        'popular_items' => _x( 'Popular Region', 'region' ),
        'all_items' => _x( 'All Regions', 'region' ),
        'parent_item' => _x( 'Parent Region', 'region' ),
        'parent_item_colon' => _x( 'Parent Region:', 'region' ),
        'edit_item' => _x( 'Edit Region', 'region' ),
        'update_item' => _x( 'Update Region', 'region' ),
        'add_new_item' => _x( 'Add New Region', 'region' ),
        'new_item_name' => _x( 'New Region', 'region' ),
        'separate_items_with_commas' => _x( 'Separate Regions with commas', 'region' ),
        'add_or_remove_items' => _x( 'Add or remove Region', 'region' ),
        'choose_from_most_used' => _x( 'Choose from the most used Region', 'region' ),
        'menu_name' => _x( 'Region', 'region' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
		 'has_archive' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'region', array('school','post', 'hellofeeds','page','tribe_events'), $args );
}

add_action( 'init', 'register_taxonomy_region' );

// Added by Pupung Purnama

function register_taxonomy_requirements() {

    $labels = array( 
        'name' => _x( 'Requirements', 'region' ),
        'singular_name' => _x( 'Requirements', 'region' ),
        'search_items' => _x( 'Search Requirements', 'region' ),
        'popular_items' => _x( 'Popular Requirements', 'region' ),
        'all_items' => _x( 'All Requirements', 'region' ),
        'parent_item' => _x( 'Parent Requirements', 'region' ),
        'parent_item_colon' => _x( 'Parent Requirements:', 'region' ),
        'edit_item' => _x( 'Edit Requirements', 'region' ),
        'update_item' => _x( 'Update Requirements', 'region' ),
        'add_new_item' => _x( 'Add New Requirements', 'region' ),
        'new_item_name' => _x( 'New Requirements', 'region' ),
        'separate_items_with_commas' => _x( 'Separate Requirements with commas', 'region' ),
        'add_or_remove_items' => _x( 'Add or remove Requirements', 'region' ),
        'choose_from_most_used' => _x( 'Choose from the most used Requirements', 'region' ),
        'menu_name' => _x( 'Requirements', 'region' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
         'has_archive' => true,
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'requirements', array('school'), $args );
}

add_action( 'init', 'register_taxonomy_requirements' );


?>