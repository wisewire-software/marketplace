<?php


function acf_wwpi_get_post($args = array())
{
    global $wpdb;

    $defaults = array(
        'numberposts' => -1,
        'orderby' => 'publish_date',
        'order' => 'DESC',
        'post__in' => array(),
        'paged' => 1,
        's' => ''
    );

    $r = wp_parse_args($args, $defaults);

    $query = "SELECT * FROM summarized_item_metadata WHERE source IN ('CMS', 'PLATFORM', 'MERLOT')";

    $post_item_count = count($r['post__in']);
    if ($post_item_count > 0) {
        $string_placeholders = array_fill(0, $post_item_count, '%s');
        $placeholders_for_post_items = implode(',', $string_placeholders);
        $query .= " AND id IN ($placeholders_for_post_items)";
        $query = $wpdb->prepare($query, $r['post__in']);
    }

    if (!empty($r['s']) && $r['s']) {
        $query .= $wpdb->prepare(" AND (title LIKE '%%%s%%' OR name LIKE '%%%s%%')", $r['s'], $r['s']);
    }

    $query .= $wpdb->prepare(" ORDER BY %s %s", $r['orderby'], $r['order']);

    $limit_query = '';
    if ($r['numberposts'] > 0){
        $paged = $r['paged'] ? $r['paged'] : 1;
        $post_per_page = $r['numberposts'];
        $offset = ($paged - 1) * $post_per_page;
        $limit_query = " LIMIT " . $post_per_page . " OFFSET " . $offset;
    }

    $rows = $wpdb->get_results($query . $limit_query, OBJECT);

    return $rows;// return OBJECT
}