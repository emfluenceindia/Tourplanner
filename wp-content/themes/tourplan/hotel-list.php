<?php
/*
 * Template name: List of Hotels
 */
get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php
            //Activate Sidebars here...
            if(is_active_sidebar('sidebar-1')) {
                dynamic_sidebar('sidebar-1');
            }?>
        </div>
        <div class="col-md-9 margin-top-10">
            <h1 class="entry-title module-head roboto-c bold">Hotels</h1>
            <hr />
            <?php echo do_shortcode('[hotel-list]'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>