<?php
$tours = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'trip_packages WHERE trip_id = '.get_the_ID());

if($tours){?>
    <div class="margin-top-20"></div>
    <h1 class="roboto-c text-large module-head">Packaged Tours</h1>
    <hr />
<?php
    foreach($tours as $tour) {
        $pid = $tour->package_id;
        $args = array('p' => $pid, 'post_type' => 'package_tour');
        $q = new WP_Query($args);
        if($q->have_posts()) {
            while($q->have_posts()) {
                $q->the_post();
                global $post;?>
                <h3 class="text-medium"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                <?php $cost = get_post_meta($post->ID, 'cost_per_adult', true); ?>
                <div class="text-red text-small margin-top-10">Cost: INR <?php echo $cost ?>/pax</div>
                <div class="margin-top-5"></div>
                <div class="package-tour-list"><?php the_excerpt(); ?></div>
                <p class="text-small">

                    <?php $tour_starts = get_post_meta($post->ID, 'tour_starts_on', true)?>
                    <b>Tour starts:</b> <?php echo date('j F, Y', strtotime(get_post_meta($post->ID, 'tour_starts_on', true))); ?> |
                    <b>Status:</b> <?php echo get_post_meta($post->ID, 'booking_status', true); ?> |
                    <b>Booking closes:</b> <?php echo date('j F, Y', strtotime(get_post_meta($post->ID, 'booking_ends_on', true))); ?></p>
                    <div class="row margin-top-10">
                        <div class="col-md-12 text-right"><a class="btn btn-primary text-small" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">more &raquo;</a></div>
                        <div class="clearfix"></div>
                    </div>

                <hr />
            <?php }
        }
    }
}

?>
