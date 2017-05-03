<?php get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <?php

                //Create a term dynamically and add into database using wp_insert_term
                //Syntax: wp_insert_term($term, $taxonomy, $args = array()) {}
                $arr_term = array(
                    'description' => 'Cabin for honeymoon couple',
                    'slug' => 'honeymoon-cabin'
                );

                $new_term = wp_insert_term('Honeymoon Cabin', 'amenities', $arr_term);
                $new_term_id = $new_term['term_id'];

                //Dynamic hook used: create_{$taxonomy}
                do_action('create_amenities', $new_term_id);

                wp_delete_term($new_term_id, 'amenities');

                //Pagination with custom query: https://www.youtube.com/watch?v=HMscydyViZw&list=PLofGaVT53aP8OCWq_aqrtIowZ7vkqzbo5
                $currentPage = get_query_var('paged');
                $query = new WP_Query(array(
                    'post_type' => array('trips'),
                    'meta_key' => 'display_on_hompage',
                    'meta_value' => 'Yes',
                    //'s' => 'dharam',
                    'posts_per_page' => 9,
                    'paged' => $currentPage));

                //echo $query->request;
                if($query->have_posts()):
                    while($query->have_posts()) : $query->the_post();?>
                        <div class="col-md-4 margin-top-10">
                            <div class="bg-white pad-10 border-gray grid-box">
                                <p class="grid-featured-image-container"><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?></a></p>
                                <h3 class="grid-title"><a class="text-gray text-small lh-50" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h3>
                                <div class="grid-excerpt">
                                    <?php
                                        //echo excerpt(25);
                                        do_action('tourplan_trip_intro', $post->ID);
                                    ?>
                                </div>
                                <div class="cat-links"><?php //the_category(', '); ?></div>
                                <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <div class="clearfix"></div>
                    <div class="margin-top-20">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <!-- Pagination block goes here -->
                                <?php
                                    echo paginate_links(array(
                                        'total' => $query->max_num_pages,
                                        'format' => 'page/%#%',
                                        'add_args' => array( 'place' => 1, 'type' => 4 /* or whatever the project number is*/ ),
                                    ));
                                /*echo paginate_links(
                                    array(
                                        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'current' => max( 1, get_query_var( 'paged' ) ),
                                        'total'   => $query->max_num_pages,
                                        'format' => 'page/%#%',
                                        'add_args' => array( 'project' => 1 ),
                                    ) );*/
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3">
            <?php if(is_active_sidebar('sidebar-1')){dynamic_sidebar('sidebar-1');} ?>
        </div>
        <div class="clearfix"></div>
    </div>

</div>

<?php get_footer(); ?>