<?php
/*
Plugin Name: Best time to travel
Description: Best time to visit a place
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_best_time_to_travel extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Best time to travel'));
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
            $travel_times = get_post_meta($post_id, 'best_time_to_travel', true); //Returns array ?>
            <div class="margin-top-30"></div>
            <div class="pad-10 bg-white border-gray">
                <h3 class='text-medium roboto-c module-head'>Best Time to Travel</h3>
                <div class="margin-top-10"></div>
                <ul class="related-posts">
                    <?php foreach($travel_times as $travel_time) { ?>
                        <li class="text-small lh-150"><?php echo $travel_time; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_best_time_to_travel');
});

?>