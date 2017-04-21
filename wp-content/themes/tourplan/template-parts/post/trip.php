<?php $trips = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'trip_packages WHERE package_id = '.get_the_ID()); ?>
<?php if($trips){ ?>

    <div class="margin-top-20"></div>
    <h1 class="roboto-c text-large module-head">Related Places</h1>
    <hr />

    <?php foreach($trips as $trip){
        $trip_id = $trip->trip_id;
        $args = array('p' => $trip_id, 'post_type' => 'trips');
        $q = new WP_Query($args);

        if($q->have_posts()) {
            while($q->have_posts()){
                $q->the_post();
                global $post; ?>
                <div class="col-md-4 image-container">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="col-md-8 package-tour-list">
                    <h3 class="text-medium"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                    <div class="margin-top-5"></div>
                    <?php the_excerpt(); ?>
                </div>
                <div class="clearfix"></div>
                <hr />
            <?php }
        }
    }
} ?>
