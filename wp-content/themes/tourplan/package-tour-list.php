<?php
/* Template Name: Package Tour List */
get_header();

$currentPage = get_query_var('paged');
$q = new WP_Query(array(
    'post_type' => 'package_tour',
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
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="roboto-c module-head text-large">Package Tours</h3>
                            <hr />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php if($q->have_posts()){?>
                        <?php while ($q->have_posts()){
                            $q->the_post();?>
                            <div class="package-tour-list bg-gray-lighter border-gray pad-10 margin-bottom-10">
                                <h3 class="text-larger"><a class="text-small" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                <hr class="hr-white-base"/>
                                <?php the_excerpt(); ?>
                                <?php $id = get_the_ID(); ?>
                                <p class="text-red text-large"><?php echo "<b>Cost: INR " . get_post_meta($id, 'cost_per_adult', true) . " per head</b>"; ?></p>
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
                <div class="col-md-3">
                    <?php if (is_active_sidebar('site-user-login')) { ?>
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