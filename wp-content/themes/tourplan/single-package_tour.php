<?php get_header(); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php
            //Activate Sidebars here...
            if(is_active_sidebar('sidebar-1')) {
                dynamic_sidebar('sidebar-1');
            }
            ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="margin-top-10"></div>
            <?php
            //Single post data
            while(have_posts()): the_post();
                //get_template_part( 'template-parts/post/content', get_post_format() );
                $intro = get_post_meta($post->ID, 'places_covered', true); ?>
                <h1 class="entry-title module-head roboto-c bold"><?php echo the_title(); ?></h1>
                <p class='text-medium-small margin-top-10 bg-gray-light pad-10 border-gray-dark'><b>Places Covered in the package:</b> <?php echo $intro ?></p>
                <div class="li-container itinerary"><?php echo the_content(); ?></div>

                <?php get_template_part( 'template-parts/post/trip', get_post_format() ); ?>
            <?php endwhile;
            ?>
        </div>
        <div class="col-md-3">
            <?php
                if(is_active_sidebar('package-info')){
                    dynamic_sidebar('package-info');
                }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>