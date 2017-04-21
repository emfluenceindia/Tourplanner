<?php
/*add_shortcode('trip-report', function() {
    echo "Trip report form rendered from anonymous function.";
});*/
add_shortcode( 'vacation', 'vacation_shortcode' );

function vacation_shortcode() {
    if($_POST['vacation']=="submit" && !empty( $_POST['action'] )) {
        echo "Thanks for submitting your vacation request!";
    }
    if (isset ($_POST['title'])) {
        $title =  $_POST['title'];
    } else {
        echo 'Please add a description of your request!';
    }?>

    <form method="post" name="vacation_form" action="" id="vacation_form" >
    <input type="text" name="title" value="Title of vacation request" />
    <input type="text" name="_simple_vacation_type" value="Reason for absence" />
    <input type="hidden" name="vacation" value="submit" />
    <input type="hidden" name="action" value="new_vacation" />
    <input type="submit" value="Submit">
    <?php wp_nonce_field( 'new_vacation' ); ?>
</form>
<?php }

function simple_vacation_add_post(){
    if($_POST['vacation']=="submit" && !empty( $_POST['action'] )) {
        $title     = $_POST['title'];
        $vacation_type = $_POST['_simple_vacation_type'];
        //the array of arguments to be inserted with wp_insert_post

        $new_post = array(
            'post_title'    => $title,
            'post_type'     =>'vacation',
            'post_status'   => 'publish'
        );

        //insert the the post into database by passing $new_post to wp_insert_post
        $pid = wp_insert_post($new_post);

        //we now use $pid (post id) to help add our post meta data
        add_post_meta($pid, '_simple_vacation_type', $vacation_type, true);
    }
}

add_action('init','simple_vacation_add_post');
?>

<?php
/* Post type: story */
add_shortcode('story', 'trip_story_form_builder_shortcode');

function trip_story_form_builder_shortcode(){
    if($_POST['story'] == 'submit' && !empty($_POST['action'])){
        //echo 'Ok';
    }
    if(isset($_POST['txtTitle'])){
        $title = $_POST['txtTitle'];
    } else {
        //echo 'Please add a description';
    } ?>
    <!-- form starts -->
    <form method="post" name="story_form" action="" id="story_form">
        <div class="text-small">
            <div class="row margin-top-10">
                <div class="col-md-12">
                    Story Title <i class="text-red">*</i>
                    <input type="text" class="form-control" id="txtTitle" name="txtTitle" maxlength="75" required />
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-12">
                    Story <i class="text-red">*</i>
                    <div class="margin-top-5"></div>
                    <?php
                        $content = '';
                        $editor_id = 'txtStory';
                        $settings = array(
                            'textarea_name'=> 'txtStory',
                            'quicktags' => false,
                            'media_buttons' => true,
                            'teeny' => false,
                            'tinymce' => array(
                                'toolbar1'=> 'bold,italic,underline,bullist,link,unlink,forecolor,undo,redo'
                            )
                        );
                        wp_editor($content, $editor_id, $settings);
                    ?>
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-8">
                    Time of visit:
                    <div class="row margin-top-5">
                        <div class="col-md-6">
                            Year<i class="text-red">*</i>
                            <input type="text" class="form-control" id="txtYear" name="txtYear" maxlength="4" required />
                        </div>
                        <div class="col-md-6">
                            Month<i class="text-red">*</i>
                            <select id="cboMonth" name="cboMonth" class="form-control" required>
                                <option value="">-</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row margin-top-25">
                        <div class="col-md-12">
                            No. of heads <i class="text-red">*</i>
                            <input id="txtHeads" name="txtHeads" type="number" maxlength="3" class="form-control" required />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-12">
                    Places visited <i class="text-red">*</i>
                    <input type="text" class="form-control" id="txtPlaces" name="txtPlaces" maxlength="300" required placeholder="Enter name of the places you visited. Separate places by comma(,)" />
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-6">
                    Category <i class="text-red">*</i>
                    <?php
                    $args = array(
                        'show_option_all'    => '',
                        'show_option_none'   => '',
                        'option_none_value'  => '',
                        'orderby'            => 'ID',
                        'order'              => 'ASC',
                        'show_count'         => 0,
                        'hide_empty'         => 1,
                        'child_of'           => 0,
                        'exclude'            => '',
                        'include'            => '',
                        'echo'               => 1,
                        'selected'           => 0,
                        'hierarchical'       => 0,
                        'name'               => 'cboCategory',
                        'id'                 => 'cboCategory',
                        'class'              => 'form-control',
                        'depth'              => 0,
                        'tab_index'          => 0,
                        'taxonomy'           => 'category',
                        'hide_if_empty'      => true,
                        'value_field'	     => 'term_id',
                    );
                    wp_dropdown_categories( $args );
                    ?>
                </div>
                <div class="col-md-6">
                    Total Trip cost <i class="text-red">*</i>
                    <input type="number" id="txtCost" name="txtCost" required maxlength="6" class="form-control" />
                </div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-12">
                    Additional information, if any (max. 600 characters)
                    <textarea id="txtInfo" name="txtInfo" rows="5" cols="80" maxlength="600" class="form-control" placeholder="For example, name of hotel you stayed, name and phone numebr of your cab driver etc."></textarea>
                </div>
            </div>
            <div class="row margin-top-20">
                <div class="col-md-12">
                    <input type="hidden" name="story" value="submit" />
                    <input type="hidden" name="action" value="new_story" />
                    <?php wp_nonce_field( 'new_story' ); ?>

                    <input type="submit" value="Submit Trip Report" class="btn btn-primary text-medium-small">
                </div>
            </div>
        </div>
    </form>
<?php
}

function add_trip_story() {
    if($_POST['story']=="submit" && !empty( $_POST['action'] )) {
        $title     = $_POST['txtTitle'];
        $description = $_POST['txtStory'];

        //meta data builder
        $visiting_year = $_POST['txtYear'];
        $visiting_month = $_POST['cboMonth'];
        $no_heads = $_POST['txtHeads'];
        $places = $_POST['txtPlaces'];
        $trip_cost = $_POST['txtCost'];
        $addl_info = $_POST['txtInfo'];

        $new_post = array(
            'post_title'    => $title,
            'post_content' => $description,
            'post_type'     =>'story',
            'post_status'   => 'publish'
        );

        //insert the the post into database by passing $new_post to wp_insert_post
        $pid = wp_insert_post($new_post);

        //We now use $pid (post id) to help add our post meta data
        add_post_meta($pid, '_visting_year', $visiting_year, true);
        add_post_meta($pid, '_visiting_month', $visiting_month, true);
        add_post_meta($pid, '_visiting_heads', $no_heads, true);
        add_post_meta($pid, '_visiting_places', $places, true);
        add_post_meta($pid, '_visiting_cost', $trip_cost, true);
        add_post_meta($pid, '_visting_addl_info', $addl_info, true);
    }
}

add_action('init','add_trip_story');

add_shortcode('hotel-list', 'hotel_list');
function hotel_list() {
    $currentPage = get_query_var('paged');

    $q = new WP_Query(array(
        'post_type' => 'hotel-info',
        'paged' => $currentPage,
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => array('publish')
    ));

    if($q->have_posts()) {
        while($q->have_posts()) {
            $q->the_post(); $post_id = get_the_ID(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                    <div class="col-md-9">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h4 class="text-medium"><?php the_title(); ?></h4></a>
                        <div class="excerpt_container margin-top-10"><?php the_excerpt(); ?></div>
                        <div class="text-small margin-top-5"><i class="fa fa-map-marker text-blue"></i>&nbsp;<?php echo wp_strip_all_tags(get_post_meta($post_id, '_hotel_address', true), true); ?><br />
                            <i class="fa fa-phone-square text-blue"></i>&nbsp;<?php echo get_post_meta($post_id, '_hotel_primary_phone', true); ?>
                            &nbsp; <i class="fa fa-envelope text-blue"></i>&nbsp;<?php echo get_post_meta($post_id, '_hotel_contact_email', true); ?>
                            <?php $url = get_post_meta($post_id, '_hotel_website', true); ?>
                            <br /> <i class="fa fa-globe text-blue"></i>&nbsp;<a href="<?php echo $url ?>" target="_blank" title="<?php echo $url ?>"><?php echo $url; ?></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <hr />
        <?php }
    }
}

?>