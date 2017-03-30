<?php


if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class List_Custom_SEO extends WP_List_Table
{

    function __construct()
    {
        parent::__construct(array(
            'singular' => 'List Custom SEO',
            'plural' => 'List Custom SEO',
        ));
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function get_columns()
    {
        $columns = array(
            'title' => 'Title',
            'url' => 'URL',
            'meta_description' => 'Meta Description'
        );
        return $columns;
    }

    function column_title($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&id=%s">Edit</a>', 'wp_wan_custom_seo_update', $item['id']),
        );

        return sprintf('<a href="?page=%1$s&id=%3$s">%2$s</a> <span style="color:silver ; display : none;">(id:%3$s)</span>%4$s',
            'wp_wan_custom_seo_update',
            $item['title'],
            $item['id'],
            $this->row_actions($actions)
        );
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'url' => array('url', false),
            'title' => array('title', false)
        );
        return $sortable_columns;
    }

    function get_data_seo()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "wan_custom_seo";

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'title';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $query = "SELECT id, url, title, meta_description from $table_name ORDER BY $orderby $order";

        return $wpdb->get_results($query, ARRAY_A);
    }


    function prepare_items()
    {
        $per_page = 10; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->get_data_seo();

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

}


function wp_wan_custom_seo_list()
{
    $post_item_platform = new List_Custom_SEO();
    $post_item_platform->prepare_items();

    ?>

    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>Custom SEO</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=wp_wan_custom_seo_create'); ?>"
                   class="button button-primary">Add New Custom SEO</a><br><br>
            </div>
            <br class="clear">
        </div>

        <?php $post_item_platform->display() ?>
    </div>
    <?php
}