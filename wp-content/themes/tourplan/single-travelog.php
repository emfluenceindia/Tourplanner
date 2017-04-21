<?php get_header(); ?>

<div class="container-fluid">
    <div class="col-md-3">
        <?php
        //Activate Sidebars here...
        if(is_active_sidebar('sidebar-1')) {
            dynamic_sidebar('sidebar-1');
        }
        ?>
    </div>
    <div class="col-md-7">
        <?php while(have_posts()) : the_post(); ?>
            <h1 class="entry-title module-head roboto-c bold"><?php echo the_title(); ?></h1>
            <?php
                //$post = NULL;
                //echo get_the_content();
                $author_id = $post->post_author;
                $author_page = get_author_link(false, $author_id);
            ?>
            <p class="margin-top-10 text-gray text-small">By <a href="<?php echo $author_page ?>"><?php the_author_meta('display_name', $author_id); ?></a>. Published on: <?php echo get_post_time('M d') ?></p>
            <hr />
            <div class="excerpt_container"><?php echo the_excerpt(); ?></div>
            <hr />
            <div class="excerpt_container main-post-image">
                <?php echo the_post_thumbnail(); ?>
            </div>
            <div class="margin-top-20"></div>
            <div>
                <!-- Get attachment images -->
                <?php
                if($post->post_type == 'travelog') {
                    //echo $post->ID;

                    $images = get_posts(array(
                        'post_type' => 'attachment',
                        'posts_per_page' => -1,
                        'post_parent' => $post->ID,
                        'exclude' => get_post_thumbnail_id()
                    ));

                    if($images) { ?>
                        <div class="row">
                            <?php
                                foreach($images as $image) {
                                    $thumb = wp_get_attachment_image($image->ID, 'thumbnail');
                                    $image_title = get_the_title($image->ID);
                                    ?>
                                    <div class="col-md-3 margin-bottom-10 text-center">
                                        <a title="Click to enlarge" onclick="enlargeImage(this)" class="load-large-image"><?php echo $thumb; ?><span><?php echo $image_title ?></span></a>
                                    </div>
                                <?php }
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    <?php }
                }
                ?>
                <!-- //Ends -->
            </div>
            <div class="margin-top-20"></div>
            <h3 class="text-medium-small text-beige bold">The Story: <?php echo the_title(); ?></h3>
            <hr />
            <?php
                $content = apply_filters('the_content', get_the_content());
            ?>
            <div class="li-container itinerary text-medium-small margin-top-10 line-height-dedh"><?php echo $content; ?></div>
        <?php endwhile; ?>
    </div>
    <div class="col-md-2">
        <?php
            //Develop plugin to display latest 10 travel stories other than this
            if(is_active_sidebar('upcoming-stories-sidebar')){
                dynamic_sidebar('upcoming-stories-sidebar');
            }
        ?>
    </div>
    <div class="clearfix"></div>
</div>

<?php get_footer(); ?>
