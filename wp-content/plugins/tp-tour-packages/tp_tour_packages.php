<?php
/*
Plugin Name: Tour Package
Description: Tour Package
Version: 1.0
Author: Subrata Sarkar
*/

class tp_tour_package extends WP_Widget{
    function __construct()
    {
        parent::__construct(false, $name = __('Packaged Tours'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        get_template_part( 'template-parts/post/package', get_post_format() );
    }
}

add_action('widgets_init', function() {
    register_widget('tp_tour_package');
})

?>