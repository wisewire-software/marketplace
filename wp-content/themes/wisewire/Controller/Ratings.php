<?php

class Controller_Ratings
{

    private $wpdb;
    private $wp_query;

    public function __construct()
    {

        global $wpdb, $wp_query;

        $this->wpdb = $wpdb;
        $this->wp_query = $wp_query;
    }

    /**
     *
     * @param int $user_id
     * @param mixed $item_id
     * @param int $item_type
     * @param float $rate
     */
    public function action_add()
    {

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : '1';
        $user_id = get_current_user_id();
        $item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
        $item_type = isset($_REQUEST['item_type']) ? $_REQUEST['item_type'] : '1';
        $item_source = isset($_REQUEST['item_source']) ? $_REQUEST['item_source'] : '';

        if (is_numeric($item_id) && $item_source != 'merlot') {
            $item_type = 'wp';
        }

        // check it is unique
        $sql = "SELECT * FROM `wp_ranks` WHERE `user_id` = " . (int)$user_id . " AND `item_id` = '" . esc_sql($item_id) . "' AND `item_type` = '" . esc_sql($item_type) . "';";
        $existing = $this->wpdb->get_row($sql);

        if ($existing) {

            $a = array(
                'rank_created' => date('Y-m-d H:i:s'),
                'value' => $rate
            );

            $this->wpdb->update('wp_ranks', $a, array(
                'user_id' => $user_id,
                'item_id' => $item_id,
                'item_type' => $item_type
            ));

        } else {

            $a = array(
                'rank_created' => date('Y-m-d H:i:s'),
                'user_id' => $user_id,
                'value' => $rate,
                'item_id' => $item_id,
                'item_type' => $item_type
            );

            $this->wpdb->insert('wp_ranks', $a);
        }

        $pio = new PredictionIOController();
        $pio->send_event('rate', $item_id, array(
            'rating' => (int)$rate
        ));

        $average_rate = $this->wpdb->get_row("SELECT AVG(`value`) AS `value` FROM `wp_ranks` WHERE `item_id` = '" . esc_sql($item_id) . "' AND `item_type` = '" . esc_sql($item_type) . "';", ARRAY_A);

        // get item
        if ($item_type == 'question') {

            $item_meta = $this->wpdb->get_row("SELECT * FROM `wp_apicache_meta` WHERE `itemId` = '" . esc_sql($item_id) . "' AND `meta_key` = 'item_ratings' LIMIT 1;", ARRAY_A);

            if (!$item_meta) {
                $this->wpdb->insert('wp_apicache_meta', array(
                    'itemId' => $item_id,
                    'meta_key' => 'item_ratings',
                    'meta_value' => $rate
                ));
            } else {
                $this->wpdb->update('wp_apicache_meta', array(
                    'meta_value' => round($average_rate['value'], 1)
                ), array(
                    'itemId' => $item_id,
                    'meta_key' => 'item_ratings'
                ));
            }

            do_action('ww_items_update_summarized', array($id), false, 'P');
        } else {

            $item_by_meta = $this->wpdb->get_row("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_id' AND `meta_value` = '" . esc_sql($item_id) . "' LIMIT 1;", ARRAY_A);

            if ($item_by_meta) {

                $item_meta = $this->wpdb->get_row("SELECT * FROM `wp_postmeta` WHERE `post_id` = '" . esc_sql($item_by_meta['post_id']) . "' AND `meta_key` = 'item_ratings' LIMIT 1;", ARRAY_A);

                if (!$item_meta) {
                    $this->wpdb->insert('wp_postmeta', array(
                        'post_id' => $item_id,
                        'meta_key' => 'item_ratings',
                        'meta_value' => $rate
                    ));
                } else {
                    $this->wpdb->update('wp_postmeta', array(
                        'meta_value' => round($average_rate['value'], 1)
                    ), array(
                        'meta_id' => $item_meta['meta_id']
                    ));
                }
                do_action('ww_items_update_summarized', array($id), false, 'C');
            }

        }

        $_REQUEST['item_avg_rate'] = $average_rate['value'];
    }


    public function action_remove()
    {

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $item_id = isset($_REQUEST['itemId']) ? $_REQUEST['itemId'] : '';
        $item_type = isset($_REQUEST['itemType']) ? $_REQUEST['itemType'] : '1';
        $item_source = isset($_REQUEST['itemSource']) ? $_REQUEST['itemSource'] : '';
        $rate = 0;

        if (is_numeric($item_id) && $item_source != 'merlot') {
            $item_type = 'wp';
        }

        $data_remove_rank = array(
            'item_id' => $item_id,
            'item_type' => $item_type
        );

        $delete_rate = $this->wpdb->delete('wp_ranks', $data_remove_rank, array('%s', '%s'));

        if ($delete_rate) {
            if ($item_type == 'question') {
                $this->wpdb->update('wp_apicache_meta', array(
                    'meta_value' => $rate
                ), array(
                    'itemId' => $item_id,
                    'meta_key' => 'item_ratings'
                ));
                do_action('ww_items_update_summarized', array($id), false, 'P');
            } else {
                $item_by_meta = $this->wpdb->get_row("SELECT post_id FROM wp_postmeta WHERE meta_key = 'item_object_id' AND meta_value = '" . esc_sql($item_id) . "' LIMIT 1;", ARRAY_A);

                if ($item_by_meta) {
                    $item_meta = $this->wpdb->get_row("SELECT * FROM `wp_postmeta` WHERE post_id = '" . esc_sql($item_by_meta['post_id']) . "' AND `meta_key` = 'item_ratings' LIMIT 1;", ARRAY_A);

                    if ($item_meta) {
                        $this->wpdb->update('wp_postmeta', array(
                            'meta_value' => $rate
                        ), array(
                            'meta_id' => $item_meta['meta_id']
                        ));
                    }
                }
                do_action('ww_items_update_summarized', array($id), false, 'C');
            }
        }

        $_REQUEST['item_avg_rate'] = $rate;
    }
}