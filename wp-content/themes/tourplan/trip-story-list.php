<?php
/* Template Name: Trip Story List */
get_header();
$currentPage = get_query_var('paged');
$q = new WP_Query(array(
    'post_type' => 'travelog',
    'paged' => $currentPage,
    'posts_per_page' => 3
)); ?>

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
                <div class="col-md-8">
                    <h3 class="roboto-c module-head text-large">Stories</h3>
                </div>
                <div class="col-md-4 text-right  text-small">
                    <a href="/publish-trip-report" class="btn btn-primary text-small">Create New Story</a>
                </div>
                <div class="clearfix"></div>
            </div>
            <hr />
            <div class="margin-top-20"></div>
            <?php if($q->have_posts()) {
                while($q->have_posts()) {
                    $q->the_post(); ?>
                    <div class="package-tour-list bg-gray-lighter border-gray pad-10 margin-bottom-10">
                        <h3 class="text-larger"><a class="text-small" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                        <span class="text-small text-gray-light">Published by: <?php echo get_the_author_meta('display_name'); ?> on <?php echo get_the_date( 'Y-m-d' ); ?> at <?php the_time(); ?></span>
                        <div class="margin-top-5"></div>
                        <?php the_excerpt(); ?>
                        <?php $id = get_the_ID(); ?>
                        <p class="text-red text-large"><?php echo "<b>Cost: INR " . get_post_meta($id, '_visiting_cost', true) . " total</b>"; ?></p>
                        <p class="text-small">Read full story at <a class="module-head" href="<?php the_permalink(); ?>"><?php echo the_permalink(); ?></a></p>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row margin-top-20">
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
        <div class="clearfix"></div>
    </div>
</div>

<?php
get_footer();
?>