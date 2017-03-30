<?php

// REGISTER POST TYPE

add_action( 'init', 'register_cpt_school' );

function register_cpt_school() {

    $labels = array( 
        'name' => _x( 'Schools', 'school' ),
        'singular_name' => _x( 'School', 'school' ),
        'add_new' => _x( 'Add New', 'school' ),
        'add_new_item' => _x( 'Add New School', 'school' ),
        'edit_item' => _x( 'Edit School', 'school' ),
        'new_item' => _x( 'New School', 'school' ),
        'view_item' => _x( 'View School', 'school' ),
        'search_items' => _x( 'Search Schools', 'school' ),
        'not_found' => _x( 'No schools found', 'school' ),
        'not_found_in_trash' => _x( 'No schools found in Trash', 'school' ),
        'parent_item_colon' => _x( 'Parent School:', 'school' ),
        'menu_name' => _x( 'Schools', 'school' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes','custom-fields' ),
        'taxonomies' => array( 'format', 'association', 'focus','region' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'school', $args );
}
?>