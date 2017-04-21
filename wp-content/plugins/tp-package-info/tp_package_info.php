<?php

/*
Plugin Name: Package Info
Description: Tour Package information
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_package_info extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Information about Tour Package'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {

        $queried_object = get_queried_object();

        if($queried_object){
            $post_id = $queried_object->ID;
            echo "<div class='margin-top-30'></div>" ?>
            <div class="pad-10 bg-white border-gray text-small">
                <h3 class='text-large roboto-c module-head'>About Package</h3>
                <div class="margin-top-10"></div>

                <div class='text-medium roboto-c text-white bg-blue pad-5'>Cost</div>
                <div class="margin-top-5"></div>
                <div class="text-red text-large">INR <?php echo get_post_meta($post_id, 'cost_per_adult', true); ?> per adult</div>

                <div class="margin-top-10"></div>
                <div class='text-medium roboto-c text-white bg-blue pad-5'>How to Book</div>
                <div class="li-container"><?php echo get_post_meta($post_id, 'booking_procedure', true); ?></div>

                <div class="margin-top-10"></div>
                <div class='text-medium roboto-c text-white bg-blue pad-5'>Package Incudes</div>
                <div class="li-container"><?php echo get_post_meta($post_id, 'package_includes', true) ?></div>

                <div class="margin-top-10"></div>
                <div class='text-medium roboto-c text-white bg-blue pad-5'>Package Excludes</div>
                <div class="li-container"><?php echo get_post_meta($post_id, 'package_excludes', true) ?></div>

                <div class="margin-top-10"></div>
                <div class='text-medium roboto-c text-white bg-blue pad-5'>Cancellation Procedure</div>
                <div class="li-container"><?php echo get_post_meta($post_id, 'cancellation_procedure', true); ?></div>
            </div>
    <?php }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_package_info');
})

?>