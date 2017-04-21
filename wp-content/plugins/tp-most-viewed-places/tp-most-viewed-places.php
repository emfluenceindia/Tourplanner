<?php
/*
Plugin Name: Popular Destinations
Description: Most viewed places based on view count
Author: Subrata Sarkar
Version: 1.0
Author URI: http://emfluence.com
Plugin URI: http://emfluence.com
*/

class tp_most_viewed_places extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Popular Destinations'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance)
    {
        echo "<div class='margin-top-30'></div>";
        echo '<div class="pad-10 bg-white border-gray">';
        echo "<h3 class='text-medium roboto-c module-head'>Popular Destinations</h3>";
        echo "<div class='margin-bottom-10'></div>";
        //Dynamic Output is handled here.
        //meta_value_num is used to order posts by a field holding numeric values
        $args = array(
            'post_type' => 'trips',
            'meta_key' => 'view_count',
            'orderby' => 'meta_value_num',
            'meta_type' => 'NUMERIC',
            'order' => 'DESC'
        );
        $q = new WP_Query($args);
        //echo $q->request . '<br />';
        if($q->have_posts()){ ?>
            <div>
                <ul class="related-posts">
                    <?php while ($q->have_posts()){
                        $q->the_post();?>
                        <li><a class="text-small" href="<?php the_permalink(); ?>" tit="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            </div>
        <?php
        }
    }
}

add_action('widgets_init', function() {
   register_widget('tp_most_viewed_places');
});

?>