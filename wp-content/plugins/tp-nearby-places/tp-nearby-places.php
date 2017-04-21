<?php
/*
Plugin Name: Nearby Places
Description: Places of attraction nearby
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_nearby_places extends  WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Places of attractions'));
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
            $nearby_places = get_post_meta($post_id, 'nearby_places', true);
            ?>
            <div class="margin-top-30"></div>
            <div class="pad-10 bg-white border-gray">
                <h3 class='text-medium roboto-c module-head'>Places of Attraction</h3>
                <div class="text-small margin-top-10 li-container"><?php echo $nearby_places ?></div>
            </div>
        <?php }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_nearby_places');
});

?>