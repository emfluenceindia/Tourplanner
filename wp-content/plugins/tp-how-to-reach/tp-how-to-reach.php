<?php
/*
Plugin Name: How to reach
Description: How to access a place
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_how_to_reach extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('How to Access the place'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        //Get Post Id
        $queried_object = get_queried_object();
        if($queried_object) {
            $post_id = $queried_object->ID;
            $how_to_reach = get_post_meta($post_id, 'how_to_reach', true);
            $railhead = get_post_meta($post_id, 'nearest_railhead', true);
            $airport = get_post_meta($post_id, 'nearest_airport', true);
            $busterminus = get_post_meta($post_id, 'nearest_bus_stop', true);
            ?>
            <div class="pad-10 bg-white border-gray">
                <h3 class='text-medium roboto-c module-head'>How to reach there</h3>
                <p class="text-small margin-top-10"><?php echo $how_to_reach ?></p>
                <div class="margin-top-10"></div>
                <p class="text-small text-gray-dark"><b>Airport:</b> <?php echo $airport ?></p>
                <div class="margin-top-5"></div>
                <p class="text-small text-gray-dark"><b>Railway station:</b> <?php echo $railhead ?></p>
                <div class="margin-top-5"></div>
                <p class="text-small text-gray-dark"><b>Bus stop:</b> <?php echo $busterminus ?></p>
            </div>
        <?php }
    }
}

add_action('widgets_init', function() {
   register_widget('tp_how_to_reach');
});

?>
