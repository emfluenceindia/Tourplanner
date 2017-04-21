<?php
/*
Plugin Name: Weather Info
Description: Weather information of the place
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_place_weather extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name=__('Weather Information'));
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
            $weather_summer=get_post_meta($post_id, 'weather_condition_summer', true);
            $weather_autumn=get_post_meta($post_id, 'weather_condition_autumn', true);
            $weather_monsoon=get_post_meta($post_id, 'weather_condition_monsoon', true);
            $weather_winter=get_post_meta($post_id, 'weather_condition_winter', true); ?>
            <?php echo "<div class='margin-top-30'></div>" ?>
            <div class="pad-10 bg-white border-gray">
                <h3 class='text-medium roboto-c module-head'>Seasonal Weather</h3>
                <p class="text-small margin-top-10"><?php echo "<b>Summer</b>: " . $weather_summer ?></p>
                <p class="text-small margin-top-10"><?php echo "<b>Autumn</b>: " . $weather_autumn ?></p>
                <p class="text-small margin-top-10"><?php echo "<b>Monsson</b>: " . $weather_monsoon ?></p>
                <p class="text-small margin-top-10"><?php echo "<b>Winter</b>: " .  $weather_winter ?></p>
            </div>
        <?php }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_place_weather');
});
?>