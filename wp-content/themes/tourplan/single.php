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
                    <?php
                        global $wp;
                        $request_url=$_SERVER['REQUEST_URI'];
                        $current_url = home_url(add_query_arg(array(),$wp->request));
                        //echo $request_url;
                    ?>
                    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                        <?php if(function_exists('bcn_display'))
                        {
                            bcn_display();
                        }?>
                    </div>
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

            the_post_navigation( array(
                'prev_text' => __( 'Previous Post'),
                'next_text' => __( 'Next Post'),
                'in_same_term' => true,
                'excluded_term' => '23',
                'taxonomy' => 'category'
            ));
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
<?php wp_link_pages(); ?>
<?php get_footer(); ?>
