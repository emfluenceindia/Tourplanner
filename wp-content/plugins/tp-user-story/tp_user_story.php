<?php
/*
 * Plugin Name: Travelog and Travel Story
 * Description: Create new travel story
 * Version: 1.0
 */

add_action('init', 'register_travelog');

function register_travelog() {
    $labels = array(
        'name' => 'Travelog',
        'singular_name' => 'Travelog',
        'admin_menu' => 'Travelog',
        'name_admin_bar' => 'Travelog'
    );

    $supports = array(
        'title',
        'editor'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'capability_type' => 'post',
        'taxonomies' => array('category', 'story-type'),
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 27,
        'hierarchical' => false,
        'rewrite' => array('slug', 'travelog'),
        'supports' => $supports,
        //REST API support
        'show_in_rest' => true,
        'rest_base' => 'api/travelog',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type('travelog', $args);
}

/* Metaboxes */
add_action('add_meta_boxes', 'add_metaboxes');
function add_metaboxes() {
    add_meta_box('travelog_meta', 'Related Information About the Travelog', 'create_travelog_meta_boxes_callback', 'travelog', 'normal');
    add_meta_box('travelog_image_meta', 'Attached Images', function ($post) {
        if($post->post_type == 'travelog') {
            $images = get_posts(array(
                'post_type' => 'attachment',
                'posts_per_page' => -1,
                'post_parent' => $post->ID,
                'exclude' => get_post_thumbnail_id()
            ));

            if($images) {
                foreach($images as $image) {
                    //$thumb = wp_get_attachment_image($image->ID, 'thumbnail-size');
                    $thumb = wp_get_attachment_image($image->ID, 'thumbnail');
                    echo "<div style='text-align:center;margin-top:10px;float:left;width:25%;'>" . $thumb . "<br />" . get_the_title($image->ID) . "</div>";
                }
                echo '<div style="clear:both;"></div>';
            }
        }
    });
}

function create_travelog_meta_boxes_callback($post) {
    wp_nonce_field('save_travelog_meta', 'travelog_nonce'); //save_travelog_meta is the function name

    //Get meta value against post ID and store in local variables....................
    //Syntax: get_post_meta(int postId, string metaKey, bool single [default: true]);
    $year_visited    = get_post_meta($post->ID, '_travelog_year_visited', true);
    $no_of_adults    = get_post_meta($post->ID, '_travelog_adults_count', true);
    $no_of_children  = get_post_meta($post->ID, '_travelog_children_count', true);
    $places_covered  = get_post_meta($post->ID, '_travelog_places_covered', true);
    $trip_cost       = get_post_meta($post->ID, '_travelog_trip_cost', true);
    $additional_info = get_post_meta($post->ID, '_travelog_additional_info', true);

    //Create layouts for each metabox...............................................
    echo create_metabox_layout('Year Visited', false, 'txt_year_visited', 4, false, 'Year of visit', true, $year_visited);
    echo create_metabox_layout('Number of Adults', false, 'txt_adults_count', 3, true, 'Number of Adults', true, $no_of_adults);
    echo create_metabox_layout('Number of Children', false, 'txt_children_count', 3, true, 'Number of Children', true, $no_of_children);
    echo create_metabox_layout('Places Covered', true, 'txt_places_covered', 150, false, 'Name of the places you covered during your trip', true, $places_covered);
    echo create_metabox_layout('Trip Cost', false, 'txt_trip_cost', 5, true, 'Total cost for the entire trip', true, $trip_cost);
    echo create_metabox_layout('Helpful Information', true, 'txt_additional_info', 300, false, 'Information like name and contact number of your tour guide etc.', false, $additional_info);
}

function create_metabox_layout($metabox_title, $is_text_area, $id_name, $maxlength, $is_number, $placeholder_text, $is_required, $input_value) {
    $layout = ''; ?>

    <div style="border:1px solid #dddddd;padding: 10px;margin-top:10px;">
        <h3 style="margin: 0 auto;font-size: 90%;"><?php echo $metabox_title; ?></h3>
        <hr />
        <?php if($is_text_area){  ?>
            <textarea id="<?php echo $id_name; ?>" name="<?php echo $id_name; ?>" rows="7" cols="80"
                      style="width:100%" maxlength="<?php echo $maxlength; ?>"
                      placeholder="<?php echo $placeholder_text; ?>" <?php if($is_required){ ?>required<?php } ?>><?php echo esc_attr($input_value); ?></textarea>
        <?php } else { ?>
            <input type="<?php if(!$is_number){ ?>text<?php } else { ?>number<?php } ?>" id="<?php echo $id_name; ?>" name="<?php echo $id_name; ?>" style="width:100%" maxlength="<?php echo $maxlength; ?>"
                   placeholder="<?php echo $placeholder_text; ?>" <?php if($is_required){ ?>required<?php } ?> value="<?php echo esc_attr($input_value); ?>" />
        <?php } ?>
    </div>

    <?php return $layout;
}

//Now save travelog with meta information and taxonomies
add_action('save_post', 'save_travelog_meta'); //save_travelog_meta is the actual function name
function save_travelog_meta($post_id) {
    //Let's do some routine checks before we actually save our data to database!

    //Check whether nonce is at all present. If not, we shall terminate execution immediately.
    if(!isset($_POST['travelog_nonce'])) {
        return;
    }

    //Verify whether the nonce value comes from save_travelog function call. If not we shall terminate execution immediately.
    if(!wp_verify_nonce($_POST['travelog_nonce'], 'save_travelog_meta')) { //save_travelog_meta is the function name
        return;
    }

    //We don't want WordPress to AutoSave this custom post type data during filling up the form.
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    //Check whether current user can create / edit this custom post type post (post_id). If not terminate
    if(!current_user_can('edit_post', $post_id)) {
        return;
    }

    //Finally we check whether all required fields are passed with values. If not, terminate.
    if(!isset($_POST['txt_year_visited']) || !isset($_POST['txt_adults_count']) || !isset($_POST['txt_children_count'])
        || !isset($_POST['txt_places_covered']) || !isset($_POST['txt_trip_cost']) ) {

        return;
    }

    //Now it is safe to save the record along with meta information

    $year_visited = sanitize_text_field($_POST['txt_year_visited']);
    $no_of_adults = sanitize_text_field($_POST['txt_adults_count']);
    $no_of_children = sanitize_text_field($_POST['txt_children_count']);
    $places_covered = sanitize_text_field($_POST['txt_places_covered']);
    $trip_cost = sanitize_text_field($_POST['txt_trip_cost']);
    $additional_info = sanitize_text_field($_POST['txt_additional_info']);

    update_post_meta($post_id, '_travelog_year_visited', $year_visited);
    update_post_meta($post_id, '_travelog_adults_count', $no_of_adults);
    update_post_meta($post_id, '_travelog_children_count', $no_of_children);
    update_post_meta($post_id, '_travelog_places_covered', $places_covered);
    update_post_meta($post_id, '_travelog_trip_cost', $trip_cost);
    update_post_meta($post_id, '_travelog_additional_info', $additional_info);

    //How to remove all existing associated custom taxonomies and add new to a custom post type.
}

?>