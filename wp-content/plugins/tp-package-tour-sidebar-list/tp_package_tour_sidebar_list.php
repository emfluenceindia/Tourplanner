<?php
/*
Plugin Name: Package Tour List
Description: Creates a list of Packaged tours
Version: 1.0
Author: Subrata Sarkar
*/

class tp_package_tour_sidebar_list extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Package tour list'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        echo '<div class="pad-10 bg-white border-gray">';
            echo "<h3 class='text-medium roboto-c module-head'>Tour Packages</h3><div class='margin-bottom-10'></div>";
            $args = array(
                'post_type' => "package_tour",
                'orderby' => 'name',
                'order' => 'ASC',
                'title_li' => '',
                'posts_per_page' => 20
    
            );
            $q = new WP_Query($args);
            if($q->have_posts()){
                echo "<ul>";
                while($q->have_posts()){
                    $q->the_post();?>
                    <li><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                <?php }
                echo "</ul>";
            }
        echo '</div>';
        echo "<div class=margin-bottom-20></div>";
    }
}

add_action('widgets_init', function() {
    register_widget("tp_package_tour_sidebar_list");
})

?>