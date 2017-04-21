<?php
/*
 * Template Name: Create New Travelog
 */
get_header();?>

<?php

/* Routine server side form validation and Save task */
if($_POST['travelog_submit'] == 'Submit') {

    $title = $_POST['txt_travelog_title'];
    $story = $_POST['txt_travelog_story'];
    $category = $_POST['travelog_category'];
    $story_type = $_POST['travelog_story_type'];
    $year_visited = $_POST['travelog_year_visited'];
    $adult_count = $_POST['travelog_adult_count'];
    $child_count = $_POST['travelog_child_count'];
    $trip_cost = $_POST['travelog_trip_cost'];
    $places_covered = $_POST['travelog_places_covered'];
    $addl_info = $_POST['travelog_addl_info'];
    $post_type = $_POST['post_type'];

    //echo $title . '<br />' . $story . '<br />' . $category . '<br />' . $story_type . '<br />' . $year_visited . '<br />' . $adult_count . '<br />' . $child_count . '<br />' . $trip_cost . '<br />' . $places_covered . '<br />' . $addl_info . '<br />' . $post_type;
    //return;

    //Routine check starts

    /*if(!isset($_POST['new_travelog_nonce'])) { //Check in nonce is set
        return;
    }

    if(!wp_verify_nonce('new_travelog_nonce')) { //Verify nonce source
        return;
    }

    if(!current_user_can('contributor') && !current_user_can('editor')) { //Check if current user is Contributor or Editor
        return;
    }*/

    if(!isset($_POST['txt_travelog_title']) || !isset($_POST['txt_travelog_story']) || !isset($_POST['travelog_category'])) {
        return;
    }

    //Routine check ends

    $post_args = array(
        'post_title' => $title,
        'post_content' => $story,
        'tax_input' => array($story_type),
        'post_type' => 'travelog',
        'post_status' => 'pending',
        'comment_status' => 'open',
        'ping_status' => 'closed'
    );

    //Save main post and grab last inserted post_id
    $post_id = wp_insert_post($post_args);

    //Save meta information against last inserted post_id
    add_post_meta($post_id, '_travelog_year_visited', $year_visited);
    add_post_meta($post_id, '_travelog_adults_count', $adult_count);
    add_post_meta($post_id, '_travelog_children_count', $child_count);
    add_post_meta($post_id, '_travelog_trip_cost', $trip_cost);
    add_post_meta($post_id, '_travelog_additional_info', $addl_info);
    add_post_meta($post_id, '_travelog_places_covered', $places_covered);

    //Save term relationships against last inserted post_id
    wp_set_object_terms($post_id, array((int)$category), 'category');
    wp_set_object_terms($post_id, array((int)$story_type), 'story-type');

    //Upload featured image / attachment
    //Help:http://www.wordpresscircle.com/how-to-add-featured-image-for-frontend-post/

    $uploaddir = wp_upload_dir();
    $file = $_FILES['travelog_thumbnail' ];
    $uploadfile = $uploaddir['path'] . '/' . basename( $file['name'] );
    move_uploaded_file( $file['tmp_name'] , $uploadfile );
    $filename = basename( $uploadfile );
    $wp_filetype = wp_check_filetype(basename($filename), null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
        'post_content' => '',
        'post_status' => 'inherit',
        'menu_order' => $_i + 1000
    );
    $attach_id = wp_insert_attachment( $attachment, $uploadfile );

    add_post_meta($post_id, '_thumbnail_id', $attach_id);
    set_post_thumbnail($post_id, $thumbnail_id);

    //Multiple file upload routine starts.................
    $gallery_images = $_FILES['travelog_gallery_images'];
    foreach($gallery_images['name'] as $key => $value) {
        if($gallery_images['name'][$key]) {
            $image = array(
                'name' => $gallery_images['name'][$key],
                'type' => $gallery_images['type'][$key],
                'tmp_name' => $gallery_images['tmp_name'][$key],
                'error' => $gallery_images['error'][$key],
                'size' => $gallery_images['size'][$key]
            );

            $_FILES = array('travelog_gallery_images' => $image);
            //var_dump($_FILES);

            foreach($_FILES as $image => $array) {
                $attach_id = media_handle_upload($image, $post_id);
                //var_dump($attach_id);
            }
        }
    }
    //Ends: Multiple file upload

    //wp_redirect(home_url('/about/'));
    //exit;
}
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
            <?php
                if(content_restricted('You are not logged in')) {
                    return;
                }
            ?>
            <form id="travelog-form" name="travelog-form" method="post" action="<?php echo get_page_link("424"); ?>" enctype="multipart/form-data">

                <input type="hidden" name="post_type" id="post_type" value="post_type" />
                <input type="hidden" id="post_action" name="post_action" value="post_action" />

                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="roboto-c module-head text-large">Create a New Story</h3>
                                <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                                    <?php if(function_exists('bcn_display'))
                                    {
                                        //bcn_display();
                                    }?>
                                </div>
                            </div>
                            <div class="col-md-4 text-right  text-small">
                                <a href="/stories" class="btn btn-primary text-small">List of Travelog</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <hr />
                        <div class="margin-top-20"></div>
                        <div class="row text-small">
                            <div class="col-md-12">
                                Title <i class="text-red">*</i>
                                <input type="text" id="txt_travelog_title" name="txt_travelog_title" placeholder="Title of your travelog" required maxlength="75" class="form-control" />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row text-small margin-top-10">
                            <div class="col-md-12">
                                Story <i class="text-red">*</i>
                                <!--<textarea id="txt_travelog_story" name="txt_travelog_story" rows="10" cols="80" required class="form-control" placeholder="Add your story"></textarea>-->
                                <?php
                                    $content = '';
                                    $editor_id = 'txt_travelog_story';
                                    $settings = array(
                                        'textarea_name'=> 'txt_travelog_story',
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
                            <div class="clearfix"></div>
                        </div>
                        <div class="row text-small margin-top-10">
                            <?php $args_category = array(
                                'show_option_all'    => '',
                                'show_option_none'   => ' ',
                                'option_none_value'  => '',
                                'orderby'            => 'Name',
                                'order'              => 'ASC',
                                'show_count'         => 0,
                                'hide_empty'         => 1,
                                'child_of'           => 0,
                                'exclude'            => '1',
                                'include'            => '',
                                'echo'               => 1,
                                'selected'           => 0,
                                'hierarchical'       => 0,
                                'name'               => 'travelog_category',
                                'id'                 => 'travelog_category',
                                'class'              => 'form-control',
                                'depth'              => 0,
                                'tab_index'          => 0,
                                'taxonomy'           => 'category',
                                'hide_if_empty'      => false,
                                'value_field'	     => 'term_id',
                                'exclude'            => 1,
                                'required'           => true
                            ); ?>

                            <?php $terms = get_terms('story-type', array(
                                'orderby' => 'name',
                                'hide_empty' => 0
                            )); ?>

                            <div class="col-md-6">
                                Travel Category <i class="text-red">*</i>
                                <?php wp_dropdown_categories($args_category); ?>
                            </div>
                            <div class="col-md-6">
                                Story Type <i class="text-red">*</i>
                                <select name="travelog_story_type" id="travelog_story_type" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    foreach($terms as $term) {
                                        printf("<option value='%s'>%s</option>", $term->term_id, $term->name);
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row text-small margin-top-10">
                            <div class="col-md-3">
                                Year visited <i class="text-red">*</i>
                                <input id="travelog_year_visited" name="travelog_year_visited" type="number" maxlength="4" class="form-control" placeholder="2015" required />
                            </div>
                            <div class="col-md-3">
                                No. of Adults <i class="text-red">*</i>
                                <input id="travelog_adult_count" name="travelog_adult_count" type="number" maxlength="2" class="form-control" placeholder="4" required />
                            </div>
                            <div class="col-md-3">
                                No. of Children <i class="text-red">*</i>
                                <input id="travelog_child_count" name="travelog_child_count" type="number" maxlength="2" class="form-control" placeholder="2" required />
                            </div>
                            <div class="col-md-3">
                                Total Trip Cost <i class="text-red">*</i>
                                <input id="travelog_trip_cost" name="travelog_trip_cost" type="number" maxlength="6" class="form-control" placeholder="50000" required />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row text-small margin-top-10">
                            <div class="col-md-6">
                                Places Covered <i class="text-red">*</i>
                                <textarea id="travelog_places_covered" name="travelog_places_covered" rows="5" cols="80" required class="form-control" placeholder="Places you covered during this trip."></textarea>
                            </div>
                            <div class="col-md-6">
                                Additional information (optional)
                                <textarea id="travelog_addl_info" name="travelog_addl_info" rows="5" cols="80" class="form-control" placeholder="You may add hotels you stayed, contact number of your cab driver etc."></textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="row text-small margin-top-10">
                            <div class="col-md-6">
                                Upload Cover Photo  <i class="text-red">*</i>
                                <input type="file" id="travelog_thumbnail" name="travelog_thumbnail" class="form-control" accept="image/jpg, image/jpeg" required />
                            </div>
                            <div class="col-md-6">
                                Upload Gallery Photos (optional)
                                <input type="file" id="travelog_gallery_images[]" name="travelog_gallery_images[]" multiple="multiple" accept="image/jpg, image/jpeg" class="form-control" />
                            </div>
                        </div>
                        <div class="row text-small margin-top-20">
                            <div class="col-md-12">
                                <input type="submit" value="Submit" id="travelog_submit" name="travelog_submit" class="btn btn-primary text-medium-small" />
                            </div>
                            <div class="clearfix"></div>
                            <?php wp_nonce_field('new_travelog_nonce'); ?>
                        </div>
                    </div>
                    <div class="col-md-3 text-medium-small">
                        <?php if (is_active_sidebar('site-user-login')) { ?>
                            <div class="bg-white border-gray pad-10">
                                <?php dynamic_sidebar('site-user-login'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>