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
        <div class="col-md-9">
            <h1 class="text-larger cabin-c module-head">Search Result</h1>
            <div class="margin-top-10"></div>
            <?php
                $count = 0;
                if(have_posts()) :?>
                    <?php //global $wp_query; ?>
                    <p class="text-small">Your search for <b>'<?php echo get_search_query(); ?>'</b> has produced <?php echo $wp_query->found_posts ?> results.</p>
                    <hr />
                    <?php while(have_posts()) : the_post(); ?>
                        <?php
                            $postType = get_post_type(get_the_ID());
                            $obj_postType = get_post_type_object($postType);
                            $post_type_url = get_archive_link($postType);
                            //echo $postType;
                        ?>
                        <?php if($postType == 'trips'){ ?>
                            <div class="pad-10 bg-white border-gray margin-bottom-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if(has_post_thumbnail()): ?>
                                            <div><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h1 class="text-medium">
                                            <a href="/"><?php echo $obj_postType->labels->singular_name ?></a>  &raquo;
                                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <div class="text-small margin-top-10"><?php the_excerpt(); ?></div>
                                        <p class="text-small"><?php the_category(', ') ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } elseif($postType == 'package_tour') { ?>

                            <div class="pad-10 bg-white border-gray margin-bottom-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><img src="/wp-content/uploads/pt.jpg" alt="Packaged tour" class="img-responsive" /></a></div>
                                    </div>
                                    <div class="col-md-10">
                                        <h1 class="text-medium">
                                            <a href="/package-tours"><?php echo $obj_postType->labels->singular_name ?></a>  &raquo;
                                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <div class="text-small margin-top-10"><?php the_excerpt(); ?></div>
                                        <div class="text-small margin-top-10"><b>Places Covered:</b> <?php echo get_post_meta(get_the_ID(), 'places_covered', true) ?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        <?php } elseif($postType == 'travelog') { ?>
                            <div class="pad-10 bg-white border-gray margin-bottom-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if(has_post_thumbnail()): ?>
                                            <div><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h1 class="text-medium">
                                            <a href="/travelogs"><?php echo $obj_postType->labels->singular_name ?></a>  &raquo;
                                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <div class="text-small margin-top-10"><?php the_excerpt(); ?></div>
                                        <p class="text-small"><?php the_category(', ') ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } elseif($postType == 'hotel-info') { ?>
                            <div class="pad-10 bg-white border-gray margin-bottom-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if(has_post_thumbnail()): ?>
                                            <div><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h1 class="text-medium">
                                            <a href="/hotels"><?php echo $obj_postType->labels->singular_name ?></a>  &raquo;
                                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <div class="text-small margin-top-10"><?php the_excerpt(); ?></div>
                                        <p class="text-small"><?php the_category(', ') ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } elseif($postType == 'product') { ?>
                            <div class="pad-10 bg-white border-gray margin-bottom-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <?php if(has_post_thumbnail()): ?>
                                            <div><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-10">
                                        <h1 class="text-medium">
                                            <a href="/hotels"><?php echo $obj_postType->labels->singular_name ?></a>  &raquo;
                                            <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                                        <div class="text-small margin-top-10"><?php the_excerpt(); ?></div>
                                        <p class="text-small"><?php the_category(', ') ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php endwhile;
                    //echo $count;
                    echo paginate_links();
                    /*echo paginate_links(array(
                        'total' => wp_count_posts()->publish,
                        'format' => 'page/%#%',
                        'add_args' => array( 'place' => 1, 'type' => 4),
                    ));*/
                endif;
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php if ( have_posts() ) :
    /* Start the Loop */
    while ( have_posts() ) : the_post();

        /**
         * Run the loop for the search to output the results.
         * If you want to overload this in a child theme then include a file
         * called content-search.php and that will be used instead.
         */
        //get_template_part( 'template-parts/post/content', 'excerpt' );
        //echo "<h1>" . the_title() . "</h1>";
        //echo "<p>" . the_excerpt() . "</p>";

    endwhile; // End of the loop.

    /*the_posts_pagination( array(
        'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
    ) );*/

else : ?>

    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
    <?php
    get_search_form();

endif;
get_footer();
?>