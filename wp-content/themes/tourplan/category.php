<?php get_header(); ?>
    <?php
        //false -> stops displaying title on screen.
        $cat_name = single_cat_title('', false);

        //Function reference: functions.php
        $this_cat = get_category_object($cat_name);
        $cat_id = $this_cat->term_id;

        //Definition: functions.php
        $posts = get_posts_by_category_id($cat_id, 'trips', 24);
        /*foreach($posts as $post) : setup_postdata($post); ?>
            <h1><?php the_title(); ?></h1>
            <?php echo get_post_meta($post->ID, 'introduction', true) ?>
        <?php endforeach;*/
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <h3 class="roboto-c text-larger module-head"><?php echo $cat_name; ?>s</h3>
                <div class="row">
                    <?php foreach($posts as $post) : setup_postdata($post); ?>
                        <div class="col-md-4 margin-top-10">
                            <div class="bg-white pad-10 border-gray grid-box">
                                <p class="grid-featured-image-container"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?></a></p>
                                <h3 class="grid-title"><a class="text-gray text-small lh-50" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h3>
                                <div class="grid-excerpt"><?php echo excerpt(32); ?></div>
                                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                            </div>
                        </div>
                    <?php endforeach;?>
                    <div class="clearfix"></div>
                    <!-- Pagination -->
                    <div class="margin-top-20">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <!-- Pagination block goes here -->
                                <?php
                                echo paginate_links(array(
                                    'total' => $posts->max_num_pages
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <?php if(is_active_sidebar('sidebar-package-tour-list')){dynamic_sidebar('sidebar-package-tour-list');} ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

<?php get_footer(); ?>