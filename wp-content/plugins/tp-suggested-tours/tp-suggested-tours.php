<?php
/*
Plugin Name: Suggested Tours
Description: Tour suggestions based on tour being viewed
Author: Subrata Sarkar
Version: 1.0
Author URI: http://emfluence.com
*/

class tp_suggested_tours extends WP_Widget
{
    function __construct()
    {
        parent:: __construct(false, $name = __('Suggested Tours'));
    }

    function form()
    {

    }

    function update()
    {

    }

    function widget($args, $instance)
    {
        echo "<div class='margin-top-30'></div>";
        echo '<div class="pad-10 bg-white border-gray">';
        echo "<h3 class='text-medium roboto-c module-head'>Suggested Tours</h3>";
        echo "<div class='margin-bottom-10'></div>";
        //Dynamic Output is handled here.
        $queried_object = get_queried_object();
        if ($queried_object) {
            $post_id = $queried_object->ID;
            $post_cats = wp_get_post_categories($post_id);
            $q = new WP_Query(array('post_type' => 'trips', 'orderby' => 'name', 'order' => 'ASC', 'posts_per_page' => 10, 'category__in' => $post_cats, 'post__not_in' => array($post_id)));
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
       <?php }
        }
    }
}
/* widgets_init is a HOOK */
add_action('widgets_init', function() {
    register_widget('tp_suggested_tours');
});
?>