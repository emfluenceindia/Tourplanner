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
        <div class="col-md-6">
            <?php
                if(have_posts()){
                    while (have_posts()) : the_post(); $post_id = get_the_ID(); ?>
                        <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                            <?php if(function_exists('bcn_display'))
                            {
                                bcn_display();
                            }?>
                        </div>
                        <h1 class="entry-title module-head roboto-c bold"><?php echo the_title(); ?></h1>
                        <div class="text-small margin-top-5"><i class="fa fa-map-marker text-blue"></i>&nbsp;<?php echo wp_strip_all_tags(get_post_meta(get_the_ID(), '_hotel_address', true), true); ?><br />
                            <i class="fa fa-phone-square text-blue"></i>&nbsp;<?php echo get_post_meta($post_id, '_hotel_primary_phone', true); ?>
                            &nbsp; <i class="fa fa-envelope text-blue"></i>&nbsp;<?php echo get_post_meta($post_id, '_hotel_contact_email', true); ?>
                            &nbsp; <i class="fa fa-globe text-blue"></i>&nbsp;<?php echo get_post_meta($post_id, '_hotel_website', true); ?>
                        </div>
                        <hr />
                        <div class="content-container"><?php the_content(); ?></div>
                        <div class="margin-top-10"></div>
                        <?php the_post_thumbnail(); ?>

                        <div class="row margin-top-20">
                            <div class="col-md-6" style="border-right: 1px solid #dddddd;">
                                <h4 class="cabin-c"><i class="fa fa-play-circle text-blue"></i>&nbsp;Complementary Services:</h4>
                                <p class="text-small gray-text margin-top-10">
                                    <?php echo get_post_meta($post_id, '_hotel_complementary_service', true); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="cabin-c"><i class="fa fa-play-circle text-blue"></i>&nbsp;Connectivity:</h4>
                                <p class="text-small gray-text margin-top-10">
                                    Railway station: <?php echo get_post_meta($post_id, '_hotel_nearest_railhead', true); ?>
                                </p>
                                <p class="text-small gray-text">
                                    Airport: <?php echo get_post_meta($post_id, '_hotel_nearest_airport', true); ?>
                                </p>
                                <p class="text-small gray-text">
                                    Bus stand: <?php echo get_post_meta($post_id, '_hotel_nearest_bus_stand', true); ?>
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <hr />
                        <div class="row margin-top-20">
                            <div class="col-md-6" style="border-right: 1px solid #dddddd;">
                                <h4 class="cabin-c"><i class="fa fa-play-circle text-blue"></i>&nbsp;Booking Procedure:</h4>
                                <p class="text-small gray-text margin-top-10">
                                    <?php echo get_post_meta($post_id, '_hotel_booking_process', true); ?>
                                </p>
                                <h4 class="cabin-c margin-top-30"><i class="fa fa-play-circle text-blue"></i>&nbsp;Cancellation Procedure:</h4>
                                <p class="text-small gray-text margin-top-10">
                                    <?php echo get_post_meta($post_id, '_hotel_cancel_phone', true); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h4 class="cabin-c"><i class="fa fa-play-circle text-blue"></i>&nbsp;Bank Information:</h4>
                                <p class="text-small gray-text margin-top-10">
                                    <?php echo get_post_meta($post_id, '_hotel_bank_name', true); ?><br />
                                    <?php echo get_post_meta($post_id, '_hotel_bank_address', true); ?>
                                </p>
                                <p class="text-small gray-text margin-top-10">
                                    Branch Name: <?php echo get_post_meta($post_id, '_hotel_branch_name', true); ?><br />
                                    Branch Code: <?php echo get_post_meta($post_id, '_hotel_branch_code', true); ?><br />
                                </p>
                                <p class="text-small gray-text margin-top-10">
                                    Name of Account: <?php echo get_post_meta($post_id, '_hotel_ac_holder_name', true); ?><br />
                                    Account No.: <?php echo get_post_meta($post_id, '_hotel_ac_number', true); ?><br />
                                    IFSC: <?php echo get_post_meta($post_id, '_hotel_ifsc_code', true); ?><br />
                                </p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php endwhile;
                }
            ?>
        </div>
        <div class="col-md-3">
            <div class="pad-10 bg-white border-gray">
                <h4 class="cabin-c bg-gray-light pad-5">Amenities</h4>
                <ul class="hotel-features">
                    <?php
                        $amenities = get_the_terms(get_the_ID(), 'amenities');
                        foreach($amenities as $amenity) { ?>
                            <li><i class="fa fa-caret-right text-gray-light"></i>&nbsp;<?php echo $amenity->name; ?></li>
                        <?php }
                    ?>
                </ul>
            </div>
            <div class="pad-10 bg-white border-gray margin-top-10">
                <h4 class="cabin-c bg-gray-light pad-5">Type of Hotel</h4>
                <ul class="hotel-features">
                    <?php
                    $hotel_types = get_the_terms(get_the_ID(), 'hotel_type');
                    foreach($hotel_types as $hotel_type) { ?>
                        <li><i class="fa fa-caret-right text-gray-light"></i>&nbsp;<?php echo $hotel_type->name; ?></li>
                    <?php }
                    ?>
                </ul>
            </div>
            <div class="pad-10 bg-white border-gray margin-top-10">
                <h4 class="cabin-c bg-gray-light pad-5">Available Rooms</h4>
                <ul class="hotel-features">
                    <?php
                    $room_types = get_the_terms(get_the_ID(), 'room_type');
                    foreach($room_types as $room_type) { ?>
                        <li><i class="fa fa-caret-right text-gray-light"></i>&nbsp;<?php echo $room_type->name; ?></li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
        <div class-="clearfix"></div>
    </div>

<?php get_footer(); ?>