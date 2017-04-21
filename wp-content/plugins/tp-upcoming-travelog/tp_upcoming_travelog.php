<?php
/*
 * Plugin Name: Upcoming Travelogs
 * Description: Shows a list of Pending and Future Travelogs
 * Version:1.0
 * Author: Subrata Sarkar
 */

class tp_upcoming_travelog extends WP_Widget{function __construct()
    {
        parent::__construct(false, $name = __('Upcoming Travel Stories'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        $q = new WP_Query(array(
            'post_type' => 'travelog',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'post_status' => array('future')
        ));

        if($q->have_posts()) { ?>
            <div class="pad-10 bg-white border-gray">
                <h3 class='text-medium roboto-c module-head'>Upcoming Stories</h3>
                <hr class="hr-white-base" />
                <?php while($q->have_posts()) {
                    $q->the_post(); ?>
                    <div class="text-small module-head lato bottom-border-dotted">
                        <?php echo the_title(); ?>
                        <div class="margin-top-5"></div>
                        <div class="text-medium-small sidebar-excerpt text-gray"><?php echo the_excerpt(10) ?></div>
                    </div>
                <?php } ?>
            </div>
        <?php }
    }
}

add_action('widgets_init', function() {
    register_widget('tp_upcoming_travelog');
})

?>