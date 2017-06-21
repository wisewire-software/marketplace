<?php
/*
Plugin Name: Wisewire List Lo Items Custom
*/

if (!class_exists('WP_List_Item_Custom')) {

    class WW_List_LO_Items_Custom
    {

        public function __construct()
        {
            if (is_admin()) {
                add_action('admin_footer-edit.php', array(&$this, 'custom_bulk_admin_footer'));
                add_action('load-edit.php', array(&$this, 'custom_bulk_action'));
                add_filter('manage_posts_columns', array(&$this, 'add_hide_item_post_columns'));
                add_action('manage_posts_custom_column', array(&$this, 'posts_custom_columns'), 10, 2);
                add_action('admin_enqueue_scripts', array(&$this, 'add_admin_scripts'));
                add_action('admin_print_footer_scripts', array(&$this, 'admin_add_script_post_list'));

                add_filter('bulk_actions-edit', array(&$this, 'add_bulk_action_post'));
                add_action('wp_ajax_post_item_hide_page', array(&$this, 'ajax_hide_post_item'));
                add_action('wp_ajax_nopriv_post_item_hide_page', array(&$this, 'ajax_hide_post_item'));
                add_action('wp_ajax_post_item_rel_nofollow', array(&$this, 'ajax_item_rel_nofollow'));
                add_action('wp_ajax_nopriv_post_item_rel_nofollow', array(&$this, 'ajax_item_rel_nofollow'));
            }
        }


        function add_hide_item_post_columns($columns)
        {
            return array_merge($columns, array('hide_item_post' => 'Hide Item', 'is_rel_nofollow' => 'Rel NoFollow'));
        }

        function posts_custom_columns($column, $post_id)
        {
            switch ($column) {
                case 'hide_item_post' :
                    $hide_item = get_post_meta($post_id, 'is_hide_item', true);
                    $checked = isset($hide_item) && $hide_item == 1 ? true : false;

                    echo sprintf(
                        '<input type="checkbox" class="switch_hide_item" name="hide_item_%s" value="%s" %s />',
                        $post_id, $post_id, $checked ? 'checked="checked"' : ''
                    );
                    break;

                case 'is_rel_nofollow':
                    global $wpdb;

                    $table_name = $wpdb->prefix . 'item_rel_nofollow';
                    $data_item_meta = $wpdb->get_row($wpdb->prepare("SELECT is_rel_nofollow FROM $table_name WHERE  item_id= '%s'", $post_id), ARRAY_A);
                    $checked = is_array($data_item_meta) && isset($data_item_meta['is_rel_nofollow']) && $data_item_meta['is_rel_nofollow'] == 1 ? true : false;

                    echo sprintf(
                        '<input type="checkbox" class="switch_is_rel_nofollow" name="rel_nofollow_%s" value="%s" %s />',
                        $post_id, $post_id, $checked ? 'checked="checked"' : ''
                    );

                    break;
            }
        }

        function ajax_hide_post_item()
        {
            $data = $_REQUEST;
            $response['success'] = false;
            $response['message'] = 'Failed update Hide Item';
            if (isset($data['action']) && isset($data['item_id'])) {
                $is_hide_item = isset($data['status']) && $data['status'] == 1 ? 1 : 0;
                $updated = update_post_meta($data['item_id'], 'is_hide_item', $is_hide_item);
                do_action('ww_items_update_summarized', $data['item_id'], boolval($is_hide_item), 'C');
                if ($updated) {
                    $response['success'] = true;
                    $response['message'] = 'Successfully updated';
                }
            }

            echo json_encode($response);
            wp_die();
        }


        function ajax_item_rel_nofollow(){
            global $wpdb;
            $data = $_REQUEST;
            $response['success'] = false;
            $response['message'] = 'Failed update Item Rel NoFollow';
            if (isset($data['action'])) {
                if ($data['action'] == 'post_item_rel_nofollow' && isset($data['item_id'])) {
                    $is_rel_nofollow = isset($data['rel_nofollow']) && $data['rel_nofollow'] == 1 ? 1 : 0;
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

        function add_bulk_action_post($actions)
        {
            return array_merge($actions, array(
                'hide_item_platform' => 'Hide Item Platform',
                'show_item_platform' => 'Show Item Platform',
            ));

        }

        function add_admin_scripts($hook)
        {
            global $post;
            if ($hook == 'edit.php') {
                if ('item' === $post->post_type) {
                    wp_enqueue_style('lc_switch_styles', get_stylesheet_directory_uri() . '/css/lc_switch.css');
                    wp_enqueue_script('lc_switch_script', get_stylesheet_directory_uri() . '/js/lc_switch.js');
                }
            }
        }

        function admin_add_script_post_list()
        {
            global $post;
            if ('item' === $post->post_type) {
                echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/admin_post_items_list.js"></script>';
            }
        }

        function custom_bulk_admin_footer()
        {
            global $post_type;

            if ($post_type == 'item') {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('<option>').val('hide_post_item').text('<?php _e('Hide Item')?>').appendTo("select[name='action']");
                        jQuery('<option>').val('show_post_item').text('<?php _e('Show Item')?>').appendTo("select[name='action']");
                        jQuery('<option>').val('hide_post_item').text('<?php _e('Hide Item')?>').appendTo("select[name='action2']");
                        jQuery('<option>').val('show_post_item').text('<?php _e('Show Item')?>').appendTo("select[name='action2']");
                    });
                </script>
                <?php
            }
        }


        /**
         * Step 2: handle the custom Bulk Action
         *
         * Based on the post http://wordpress.stackexchange.com/questions/29822/custom-bulk-action
         */
        function custom_bulk_action()
        {
            global $typenow;
            $post_type = $typenow;

            if ($post_type == 'item') {

                // get the action
                $wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
                $action = $wp_list_table->current_action();

                $allowed_actions = array("hide_post_item", "show_post_item");
                if (!in_array($action, $allowed_actions)) return;

                // security check
                check_admin_referer('bulk-posts');

                // make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
                if (isset($_REQUEST['post'])) {
                    $post_ids = array_map('intval', $_REQUEST['post']);
                }

                if (empty($post_ids)) return;

                // this is based on wp-admin/edit.php
                $sendback = remove_query_arg(array('hided_item', 'showed_item', 'untrashed', 'deleted', 'ids'), wp_get_referer());
                if (!$sendback)
                    $sendback = admin_url("edit.php?post_type=$post_type");

                $pagenum = $wp_list_table->get_pagenum();
                $sendback = add_query_arg('paged', $pagenum, $sendback);
                $is_hide_item = $action == 'show_post_item' ? 0 : 1;

                switch ($action) {
                    case 'hide_post_item':
                    case 'show_post_item':
                        $total_item = 0;
                        foreach ($post_ids as $post_id) {
                            if (!$this->perform_hide_show_item($post_id, $is_hide_item))
                                wp_die(__('Error exporting post.'));

                            $total_item++;
                        }
                        do_action('ww_items_update_summarized', $post_ids, boolval($is_hide_item), 'C');
                        $sendback = add_query_arg(array(($action == 'show_post_item' ? 'showed_item' : 'hided_item') => $total_item, 'ids' => join(',', $post_ids)), $sendback);
                        break;

                    default:
                        return;
                }



                $sendback = remove_query_arg(array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view'), $sendback);

                wp_redirect($sendback);
                exit();
            }
        }

        function perform_hide_show_item($post_id, $is_hide_item)
        {
            $updated = update_post_meta($post_id, 'is_hide_item', $is_hide_item);
            return $updated;
        }
    }
}

new WW_List_LO_Items_Custom();