<?php
/*
Plugin Name: Wisewire Post Item Platform
Version: 1.0
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class List_Post_Item_Platform extends WP_List_Table
{

    function __construct()
    {
        parent::__construct(array(
            'singular' => 'item platform',
            'plural' => 'items platform',
        ));
    }

    function column_default($item, $column_name)
    {

        switch ($column_name) {
            case 'created':
                return get_gmt_from_date($item[$column_name], 'Y/m/d');
                break;
            default:
                return $item[$column_name];
        }

    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'post_item_platform'),
            'tags' => __('Tags', 'post_item_platform'),
            'object_type' => __('Object Types', 'post_item_platform'),
            'created' => __('Date', 'post_item_platform'),
            'itemId' => __('Hide Item', 'post_item_platform'),
            'is_rel_nofollow' => __('Rel NoFollow', 'post_item_platform')
        );
        return $columns;
    }

    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['itemId']);
    }

    function column_itemId($item)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'apicache_meta';
        $data_item_meta = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE meta_key = 'is_hide_item' AND itemId = '%s'", $item['itemId']), ARRAY_A);
        $checked = is_array($data_item_meta) && isset($data_item_meta['meta_value']) && $data_item_meta['meta_value'] == 1 ? true : false;

        return sprintf(
            '<input type="checkbox" class="switch_hide_item" name="hide_item_%s" value="%s" %s />',
            $item['itemId'], $item['itemId'], $checked ? 'checked="checked"' : ''
        );
    }

    function column_is_rel_nofollow($item)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'item_rel_nofollow';
        $data_item_meta = $wpdb->get_row($wpdb->prepare("SELECT is_rel_nofollow FROM  $table_name WHERE  item_id= '%s'", $item['itemId']), ARRAY_A);
        $checked = is_array($data_item_meta) && isset($data_item_meta['is_rel_nofollow']) && $data_item_meta['is_rel_nofollow'] == 1 ? true : false;

        return sprintf(
            '<input type="checkbox" class="switch_is_rel_nofollow" name="rel_nofollow_%s" value="%s" %s />',
            $item['itemId'], $item['itemId'], $checked ? 'checked="checked"' : ''
        );
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'title' => array('title', true)
        );
        return $sortable_columns;
    }

    function get_data_post_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apicache_items';

        $search = (isset($_REQUEST['s'])) ? $_REQUEST['s'] : false;
        $do_search = ($search) ? $wpdb->prepare("WHERE title LIKE '%%%s%%' ", $search) : '';

        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'title';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $query = "SELECT id as cb, title, itemType as object_type, created, (SELECT GROUP_CONCAT(DISTINCT UPPER(tag)) "
            . "FROM  wp_apicache_tags "
            . "WHERE itemId = wpi.itemId) AS tags, itemId  FROM $table_name as wpi $do_search ORDER BY $orderby $order";

        return $wpdb->get_results($query, ARRAY_A);
    }

    function get_bulk_actions()
    {
        $actions = array(
            'hide_item_platform' => 'Hide Item Platform',
            'show_item_platform' => 'Show Item Platform',
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'apicache_meta';

        if ('hide_item_platform' === $this->current_action() || 'show_item_platform' === $this->current_action()) {
            $ids_items_platform = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            $is_hidden_item = ('hide_item_platform' === $this->current_action() ? true : false);

            if (is_array($ids_items_platform) && count($ids_items_platform)) {
                foreach ($ids_items_platform as $id) {
                    $wpdb->update(
                        $table_name, array('meta_value' => ($is_hidden_item === true ? 1 : 0)),
                        array(
                            'itemId' => $id,
                            'meta_key' => 'is_hide_item'
                        )
                    );
                }

                do_action('ww_items_update_summarized', $ids_items_platform, $is_hidden_item);
            }
        }
    }


    function prepare_items()
    {
        $per_page = 20; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $data = $this->get_data_post_items();

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

if (!class_exists('Post_Item_Platform')) :

    class Post_Item_Platform
    {
        private $post_item_platform;

        function __construct()
        {
        }

        function initialize()
        {
            add_action('admin_menu', array($this, 'admin_menu_post_item_platform'));
            add_action('wp_ajax_post_item_platform_hide_page', array($this, 'ajax_hide_item_platform'));
            add_action('wp_ajax_nopriv_post_item_platform_hide_page', array($this, 'ajax_hide_item_platform'));
            add_action('wp_ajax_post_item_platform_rel_nofollow', array($this, 'ajax_update_item_rel_nofollow'));
            add_action('wp_ajax_nopriv_post_item_platform_rel_nofollow', array($this, 'ajax_update_item_rel_nofollow'));
            add_action('ww_items_update_summarized', array($this, 'update_batch_summarized_metadata'), 10, 3);
        }


        function post_item_platform_enqueue_script()
        {
            wp_register_script(
                'post_item_platform_js',
                plugins_url('post-item-platform.js', __FILE__),
                array(),
                FALSE,
                TRUE
            );

            wp_enqueue_style('post_item_platform_css', get_stylesheet_directory_uri() . '/css/lc_switch.css');
            wp_enqueue_script('post_item_platform_switch_js', get_stylesheet_directory_uri() . '/js/lc_switch.js');
            wp_enqueue_script('post_item_platform_js');
        }

        function post_item_platform_page_handler()
        {
            $this->post_item_platform = new List_Post_Item_Platform();
            $this->post_item_platform->prepare_items();
            ?>
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                <h2><?php _e('Items Platform', 'post_item_platform') ?></h2>
                <form id="wrapper_list_post_item_platform" method="GET"
                      data-total-columns="<?php echo count($this->post_item_platform->get_columns()); ?>">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                    <?php $this->post_item_platform->search_box('search', 'search_id'); ?>
                    <?php $this->post_item_platform->display() ?>
                </form>
            </div>
            <?php
        }


        function admin_menu_post_item_platform()
        {
            $main = add_menu_page(__('Post Item Platform', 'post_item_platform'), __('Items Platform', 'post_item_platform'), 'activate_plugins', 'items_platform', array($this, 'post_item_platform_page_handler'), null, 5);

            add_action("admin_print_scripts-$main", array($this, 'post_item_platform_enqueue_script'));
        }


        function ajax_hide_item_platform()
        {
            global $wpdb;
            $data = $_REQUEST;
            $response['success'] = false;
            $response['message'] = 'Failed update Hide Item';
            if (isset($data['action']) && $data['action'] == 'post_item_platform_hide_page' && isset($data['item_id'])) {
                $is_hide_item = isset($data['status']) && $data['status'] == 1 ? 1 : 0;
                $table_name = $wpdb->prefix . 'apicache_meta';

                $updated = $wpdb->update($table_name, array('meta_value' => $is_hide_item), array('itemId' => $data['item_id'], 'meta_key' => 'is_hide_item'));

                if ($updated) {
                    $response['success'] = true;
                    $response['message'] = 'Successfully updated';
                    $this->update_batch_summarized_metadata($data['item_id'], boolval($is_hide_item), 'P');
                }
            }

            echo json_encode($response);
            wp_die();
        }

        function ajax_update_item_rel_nofollow()
        {
            global $wpdb;
            $data = $_REQUEST;
            $response['success'] = false;
            $response['message'] = 'Failed update Item Rel NoFollow';
            if (isset($data['action'])) {
                if ($data['action'] == 'post_item_platform_rel_nofollow' && isset($data['item_id'])) {
                    $is_rel_nofollow = isset($data['is_rel_nofollow']) && $data['is_rel_nofollow'] == 1 ? 1 : 0;
                    $table_name = $wpdb->prefix . 'item_rel_nofollow';

                    $count_rel_nofollow = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE item_id=%s", $data['item_id']));

                    if($count_rel_nofollow){
                        $wpdb->update($table_name, array('is_rel_nofollow' => $is_rel_nofollow), array('item_id' => $data['item_id']));
                    }else{
                        $wpdb->insert('table',
                            array(
                                'item_id' => $data['item_id'],
                                'is_rel_nofollow' => $is_rel_nofollow
                            ),
                            array(
                                '%s',
                                '%d'
                            )
                        );
                    }

                    $response['success'] = true;
                    $response['message'] = 'Successfully updated';
                }
            }


            echo json_encode($response);
            wp_die();
        }


        function update_batch_summarized_metadata($item_ids, $is_hidden_item = false, $source_item = 'P')
        {

            try {
                if (!is_array($item_ids)) {
                    $item_ids = array($item_ids);
                }

                if (count($item_ids)) {
                    foreach ($item_ids as $item_id) {
                        $this->update_summarized_metadata($item_id, $is_hidden_item, $source_item);
                    }

                    if ($is_hidden_item === false) {
                        $url = URL_API_SEARCH_SOLR . 'dataimport?command=delta-import&clean=false';
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec($curl);

                        if ($result === false) {
                            throw new Exception('Error calling API Search Solr' . curl_error($curl));
                        }
                    } elseif ($is_hidden_item === true) {

                        foreach ($item_ids as $item_id) {
                            $params = array('delete' => array('query' => 'id:' . $item_id));
                            $url = URL_API_SEARCH_SOLR . 'update?commit=true';
                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($curl, CURLOPT_POST, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
                            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                                'Content-Type: application/json'
                            ));

                            $result = curl_exec($curl);
                            if ($result === false) {
                                throw new Exception('Error calling API Search Solr' . curl_error($curl));
                            }
                        }
                    }

                    return true;
                }
            } catch (Exception $e) {
                error_log("\n" . date("Y-m-d h:i:s") . " Error Update Batch Summarized Metadata: Failed:" . $e->getMessage());
            }

            return false;
        }

        function update_summarized_metadata($item_id, $is_hidden_item = false, $source_item = 'P')
        {
            global $wpdb;

            try {
                if ($is_hidden_item === false) {
                    if ($source_item == 'P') {
                        $wpdb->query("CALL prc_populate_summarized_of_platform('" . $item_id . "')");
                    } elseif ($source_item == 'C') {
                        $wpdb->query("CALL prc_populate_summarized_of_cms('" . $item_id . "')");
                    }
                    return true;
                } elseif ($is_hidden_item === true) {
                    $wpdb->delete('summarized_item_metadata', array('id' => $item_id));
                    return true;
                }
            } catch (Exception $e) {
                error_log("\n" . date("Y-m-d h:i:s") . " Error Update Summarized Metadata: Failed:" . $e->getMessage());
            }

            return false;
        }
    }

    $post_item_platform = new Post_Item_Platform();
    $post_item_platform->initialize();


endif;
