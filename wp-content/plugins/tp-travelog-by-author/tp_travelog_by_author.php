<?php
/*
 * Plugin Name: Author Travelogs
 * Description: Travelogs posted by story author
 * Version: 1.0
 */

class tp_travelog_by_author extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('Stories By Author'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        //Learning Resource (Conditional Tag): https://codex.wordpress.org/Conditional_Tags
        if(is_singular('travelog')){
            $post_id = get_the_ID();
            $post = get_post($post_id);

            $author_id = $post->post_author;
            //$user = get_user_by("id", $author_id);
            //$username = $user->display_name;

            $author_first_name = get_the_author_meta("first_name", $author_id);

            $query = new WP_Query(array(
                'post_type' => 'travelog',
                'post_status' => array('publish'),
                'orderby' => 'post_date',
                'order' => 'DESC',
                'author' => $author_id,
                'post__not_in' => array($post_id)
            ));

            if($query->have_posts()) { ?>
                <div class="pad-10 bg-white border-gray">
                    <h3 class='text-medium roboto-c module-head'><?php echo $author_first_name ?>'s Stories</h3>
                    <hr class="hr-white-base" />
                    <?php while($query->have_posts()) {
                        $query->the_post(); ?>
                        <div class="text-small text-primary lato bottom-border-dotted">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo the_title(); ?></a>
                            <div class="margin-top-5"></div>
                            <div class="text-medium-small sidebar-excerpt text-gray"><?php echo excerpt(15) ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php }
        } else {
            return;
        }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_travelog_by_author');
})

?>