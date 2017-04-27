<?php
/*
 * Plugin Name: Latest Travel Stories
 * Description: Displays 5 latest published stories (REST API based)
 * Version: 1.0
 * Author: Subrata Sarkar
 */

class tp_rest_latest_stories extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Display Latest Stories'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        $base_domain = get_site_url();
        $request = wp_remote_get( $base_domain . '/wp-json/wp/v2/api/trips?per_page=5');

        if(is_wp_error($request)) {
            return false;
        }

        $json_raw = wp_remote_retrieve_body($request);
        $data = json_decode($json_raw);

        echo "<div class='margin-top-10'></div>";
        echo '<div class="pad-10 bg-white border-gray">'; //Opened
        echo "<h3 class='text-medium roboto-c module-head'>Latest Stories</h3>";
        echo "<div class='margin-bottom-10'></div>";
            echo '<div>';
                foreach($data as $item) { ?>
                    <ul class="related-posts">
                        <li>
                            <a href="<?php echo $item->link; ?>" title="<?php echo $item->title->rendered; ?>"><?php echo $item->title->rendered ?></a>
                        </li>
                    </ul>
                <?php }
            echo '</div>';
        echo '</div>'; //Closed
        echo '<div class="margin-bottom-30"></div>';
    }
}

add_action('widgets_init', function() {
    register_widget('tp_rest_latest_stories');
});

?>