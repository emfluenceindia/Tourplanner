<?php
/*
Plugin Name: Google Map locator
Description: Mark place on google map
Version: 1.0
Author: Subrata Sarkar
Plugin URI: http://emfluence.com
Author URI: hppt://emfluence.com
*/

class tp_google_map_location extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Locate a place on Google Map'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance){
        $queried_object = get_queried_object();
        if($queried_object) {
            $post_id = $queried_object->ID;
            $location = get_post_meta($post_id, 'location_map', true);
            //$location = get_field('location_map');
            if (!empty($location)) { ?>
                <div class="acf-map">
                    <div class="marker" data-lat="<?php echo $location['lat']; ?>"
                         data-lng="<?php echo $location['lng']; ?>"></div>
                </div>
            <?php }
        }
    }
}

add_action('widgets_init', function(){
   register_widget('tp_google_map_location');
});
?>