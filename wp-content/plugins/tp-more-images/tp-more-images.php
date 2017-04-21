<?php
/*
Plugin Name: Additional Place Images
Description: Displays Non-featured custom field images
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_more_images extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Additional Images'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance)
    {
        //Retrieve images from custom fields place_photo_1, place_photo_2, place_photo_3 and place_photo_4
        echo "<div class='margin-top-30'></div>";
        echo "<h3 class='text-large roboto-c module-head'>More Photos</h3>";
        echo "<hr />";
        $images = array();
        $queried_object = get_queried_object();
        if($queried_object) {
            $post_id = $queried_object->ID;
            for($counter=1; $counter<=4; $counter++){
                $photo_field_name = 'place_photo_' . $counter;
                $attached_image = get_post_meta($post_id, $photo_field_name, true);
                $images[] = $attached_image;
            }

            echo "<div class='row'>";
                foreach($images as $image){
                    echo "<div class='col-md-6 margin-top-10 image-container'>";
                        echo wp_get_attachment_image($image);
                    echo "</div>";
                }

                echo "<div class='clearfix'></div>";
            echo "</div>";
        }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_more_images');
});

?>