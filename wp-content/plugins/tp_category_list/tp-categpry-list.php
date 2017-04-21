<?php
/*
Plugin Name: Customized Category List
Description: Displays a customizable category list using Category API
Author: Subrata Sarkar
Version: 1.0
Plugin URI: http://local.tourplanner.com
Author URI: http://emfluence.com
*/

class tp_category_list extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Customised Category List'));
    }

    function form () {

    }

    function update() {

    }

    function widget() {
        echo '<div class="pad-10 bg-white border-gray">';
        echo "<h3 class='text-medium roboto-c module-head'>Browse Categories</h3><div class='margin-bottom-10'></div>";
        $args = array(
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 1,
            'exclude' => 1, //Uncategorized is excluded from display
            'title_li' => ''

        );
        echo '<ul class="related-posts">';
        echo wp_list_categories($args);
        echo '</ul>';
        echo '</div>';
    }
}

/* Initialize and register widget using widgets_init HOOK */
add_action('widgets_init', function() {
    register_widget('tp_category_list');
})
?>