<?php

class acf_field_wisewire_post_item_v5 extends acf_field_wisewire_post_item
{

    function __construct()
    {
        parent::__construct();
    }

    function input_admin_enqueue_scripts()
    {
        wp_enqueue_script($this->settings['script-handle'], $this->settings['url'] . '/js/input.js', array($this->settings['acf-script-handle']), $this->settings['version']);
    }


    function get_choices($options = array())
    {
        $options = acf_parse_args($options, array(
            'post_id' => 0,
            's' => '',
            'paged' => 1
        ));

        $args = array();
        $args['numberposts'] = 20;
        $args['paged'] = $options['paged'];
        // search
        if ($options['s']) {
            $args['s'] = $options['s'];
        }

        $post_item = acf_wwpi_get_post($args);

        $data = array();
        foreach ($post_item as $item) {
            $data[] = array(
                'id' => $item->id,
                'text' => $item->title . ' - ' . $item->source
            );
        }

        return $data;
    }

    function ajax_query()
    {

        if (!acf_verify_ajax()) {
            die();
        }

        // get posts
        $posts = $this->get_choices($_POST);

        // validate
        if (!$posts) {
            die();
        }

        echo json_encode($posts);
        die();
    }

    function render_field_settings($field)
    {

        $field['min'] = empty($field['min']) ? '' : $field['min'];
        $field['max'] = empty($field['max']) ? '' : $field['max'];

        // filters
        acf_render_field_setting($field, array(
            'label' => __('Filters', 'acf'),
            'instructions' => '',
            'type' => 'checkbox',
            'name' => 'filters',
            'choices' => array(
                'search' => __("Search", 'acf'),
            ),
        ));

        // filters
        acf_render_field_setting($field, array(
            'label' => __('Elements', 'acf'),
            'instructions' => __('Selected elements will be displayed in each result', 'acf'),
            'type' => 'checkbox',
            'name' => 'elements',
            'choices' => array(
                'featured_image' => __("Featured Image", 'acf'),
            ),
        ));

        // min
        acf_render_field_setting($field, array(
            'label' => __('Minimum posts', 'acf'),
            'instructions' => '',
            'type' => 'number',
            'name' => 'min',
        ));

        // max
        acf_render_field_setting($field, array(
            'label' => __('Maximum posts', 'acf'),
            'instructions' => '',
            'type' => 'number',
            'name' => 'max',
        ));

        // return_format
        acf_render_field_setting($field, array(
            'label' => __('Return Format', 'acf'),
            'instructions' => '',
            'type' => 'radio',
            'name' => 'return_format',
            'choices' => array(
                'object' => __("Post Object", 'acf')
            ),
            'layout' => 'horizontal',
        ));

    }

    function render_field($field)
    {
        $atts = array(
            'id' => $field['id'],
            'class' => "acf-relationship {$field['class']}",
            'data-min' => $field['min'],
            'data-max' => $field['max'],
            'data-s' => '',
            'data-paged' => 1,
        );

        // width for select filters
        $width = array(
            'search' => 0,
        );

        if (!empty($field['filters'])) {
            $width = array(
                'search' => 50,
            );

            foreach (array_keys($width) as $k) {
                if (!in_array($k, $field['filters'])) {
                    $width[$k] = 0;
                }
            }

            $width['search'] = ($width['search'] == 0) ? 0 : 100;
        }
        ?>
        <div <?php acf_esc_attr_e($atts); ?>>

            <div class="acf-hidden">
                <input type="hidden" name="<?php echo $field['name']; ?>" value=""/>
            </div>

            <?php if ($width['search'] || $width['post_type'] || $width['taxonomy']): ?>
                <div class="filters">
                    <ul class="acf-hl">
                        <?php if ($width['search']): ?>
                            <li style="width:<?php echo $width['search']; ?>%;">
                                <div class="inner">
                                    <input class="filter" data-filter="s" placeholder="<?php _e("Search...", 'acf'); ?>"
                                           type="text"/>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                </div>
            <?php endif; ?>

            <div class="selection acf-cf">
                <div class="choices">
                    <ul class="acf-bl list"></ul>
                </div>
                <div class="values">
                    <ul class="acf-bl list">
                        <?php if (!empty($field['value'])):
                            $posts = acf_wwpi_get_post(array(
                                'post__in' => $field['value']
                            ));

                            // set choices
                            if (!empty($posts)):
                                foreach (array_keys($posts) as $i):
                                    $post = acf_extract_var($posts, $i);
                                    ?>
                                    <li>
                                        <input type="hidden" name="<?php echo $field['name']; ?>[]"
                                               value="<?php echo $post->id; ?>"/>
                                        <span data-id="<?php echo $post->id; ?>" class="acf-rel-item">
                                            <?php echo $post->title . ' - ' . $post->source; ?>
                                            <a href="#" class="acf-icon -minus small dark" data-name="remove_item"></a>
                                        </span>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }


    function format_value($value, $post_id, $field)
    {
        if (!empty($value)) {
            $value = acf_wwpi_get_post(array('post__in' => $value));
        }
        return $value;
    }

}

new acf_field_wisewire_post_item_v5();

?>