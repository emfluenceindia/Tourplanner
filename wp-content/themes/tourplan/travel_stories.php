<?php
/* Template Name: Travel Story List */
get_header();

$currentPage = get_query_var('paged');

/*
'publish' - a published post or page
'pending' - post is pending review
'draft' - a post in draft status
'auto-draft' - a newly created post, with no content
'future' - a post to publish in the future
'private' - not visible to users who are not logged in
'inherit' - a revision. see get_children.
'trash' - post is in trashbin. added with Version 2.9.
*/

$q = new WP_Query(array(
    'post_type' => 'travelog',
    'paged' => $currentPage,
    'posts_per_page' => 5,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => array('publish')
));

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php
            //Activate Sidebars here...
            if(is_active_sidebar('sidebar-1')) {
                dynamic_sidebar('sidebar-1');
            }?>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="text-large roboto-c module-head">Recent Stories</h3>
                    <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                        <?php if(function_exists('bcn_display'))
                        {
                            //bcn_display();
                        }?>
                    </div>
                    <hr />
                    <?php
                    if($q->have_posts()) {
                        while($q->have_posts()) {
                            $q->the_post(); ?>
                            <div class="package-tour-list bg-gray-lighter border-gray pad-10 margin-bottom-10">
                                <!-- Single data row -->
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                            <?php the_post_thumbnail(); ?>
                                        </a>
                                        <p class="text-small margin-top-10">
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php echo get_the_author_meta('display_name'); ?></a><br />
                                        </p>
                                        <p class="text-small gray-text">
                                            <!-- Help: http://wordpress.stackexchange.com/questions/29339/how-can-i-get-the-month-name-from-archive -->
                                            <?php echo get_the_date( 'd M' ); ?>, <?php the_time(); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-10">
                                        <h3 class="text-large roboto">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <hr class="hr-white-base" />
                                        <p class="text-small text-gray"><?php the_excerpt(); ?></p>
                                        <p class="text-small text-gray">
                                            Published under: <?php the_category(', '); ?>
                                            <?php
                                            //Help: https://css-tricks.com/forums/topic/display-custom-taxonomy-like-the_category-for-custom-post-type/
                                            $post_id = get_the_ID();
                                            $terms = get_the_terms($post_id, 'story-type');
                                            foreach($terms as $term) {
                                                $term_url = get_term_link($term, 'story-type');?>
                                                , <a href="<?php echo $term_url ?>"><?php echo $term->name ?></a>
                                            <?php } ?>.
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                    <div class="margin-top-20">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <!-- Pagination block goes here -->
                                <?php
                                echo paginate_links(array(
                                    'total' => $q->max_num_pages
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php
                    if(is_active_sidebar('upcoming-stories-sidebar')){
                        dynamic_sidebar('upcoming-stories-sidebar');
                    }

                    if (is_active_sidebar('site-user-login')) { ?>
                        <div class="bg-white border-gray pad-10">
                            <?php dynamic_sidebar('site-user-login'); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>