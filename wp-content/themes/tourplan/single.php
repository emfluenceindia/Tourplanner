<?php get_header(); ?>
<?php setPostViews(get_the_ID()); ?>
<?php
    //$id = get_the_ID();
    //echo $id;
    //$image_upload = get_post_meta($id, 'place_photo_2', true);
    //echo wp_get_attachment_image($image_upload);
?>
<?php //echo getPostViews(get_the_ID()); ?>
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
                    get_template_part( 'template-parts/post/content', get_post_format() );
                endwhile;

                if(is_active_sidebar('additional-images')) {
                    dynamic_sidebar('additional-images');
                }

                //Find relationship posts --------------------------------- //
                if(is_active_sidebar('packaged-tour')) {
                    dynamic_sidebar('packaged-tour');
                }
            ?>
        </div>
        <div class="col-md-3">
            <?php
                //Activate Sidebars here...
                if(is_active_sidebar('trip-related-info')) {
                    dynamic_sidebar('trip-related-info');
                }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<?php get_footer(); ?>
