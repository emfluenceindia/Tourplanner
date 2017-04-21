<?php
/*
Plugin Name: Create New User Story
Description: Creates a new story and stores into database
Version: 1.0
*/

function story_custom_post_type() {
    $labels = array(
        'name'               => __( 'Stories', 'tourplan' ),
        'singular_name'      => __( 'Story', 'tourplan' ),
        'add_new'            => _x( 'Add New Story', '${4:Name}', 'tourplan' ),
        'add_new_item'       => __( 'Add New Story', 'tourplan' ),
        'edit_item'          => __( 'Edit Story', 'tourplan' ),
        'new_item'           => __( 'New Story', 'tourplan' ),
        'view_item'          => __( 'View Story', 'tourplan' ),
        'search_items'       => __( 'Search Stories', 'tourplan' ),
        'not_found'          => __( 'No Stories found', 'tourplan' ),
        'not_found_in_trash' => __( 'No Stories found in Trash', 'tourplan' ),
        'parent_item_colon'  => __( 'Parent Story:', 'tourplan' ),
        'menu_name'          => __( 'User Story', 'tourplan' ),
    );

    $rewrite = array(
        'with_front' => false,
        'slug' => 'stories');

    $supports = array(
        'title',
        'editor',
        //'author',
        'thumbnail',
        //'custom-fields',
        //'trackbacks',
        //'comments',
        //'revisions',
        //'page-attributes',
        'post-formats'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'description',
        'taxonomies' => array('category', 'story-type', 'genre'),
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'http://webmaster.webmastersuccess.netdna-cdn.com/wp-content/uploads/2015/03/pencil.png',
        'public' => true,
        'has_archive' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'supports' => $supports,
        'rewrite' => $rewrite,
        'register_meta_box_cb' => 'add_story_metaboxes'
    );

    register_post_type('user_story', $args);
}

//Function to create and add meta boxes to custom post type
function add_story_metaboxes() {
    //Syntax: add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args );
    /* Meaning of each parameter
    $id is “wpt_events_location”- or the html id that will be applied to this metabox.
    $title is “Event Location”. This appears at the top of the new metabox when displayed.
    $callback is the function “wpt_events_location” which will load the html into the metabox.
    $page is “events”, the name of our custom post type.
    $context is “side”. If you wanted it to load below the content area, you could put “normal”.
    $priority controls where the metabox will display in relation to the other metaboxes. You can put “high”, “low” or “default”.
     */
    //Reference: https://wptheming.com/2010/08/custom-metabox-for-post-type/
    add_meta_box('_visiting_year', 'Year visited', 'mb_visiting_year', 'user_story', 'normal', 'default');
    add_meta_box('_visiting_month', 'Month visited', 'mb_visiting_month', 'user_story', 'normal', 'default');
    add_meta_box('_no_of_heads', 'No. of Heads', 'mb_heads', 'user_story', 'normal', 'default');
    add_meta_box('_places_visited', 'Places Covered', 'mb_places_visited', 'user_story', 'normal', 'default');
    add_meta_box('_trip_cost', 'Trip Cost', 'mb_trip_cost', 'user_story', 'normal', 'default');
    add_meta_box('_addl_info', 'Additional Info', 'mb_addl_info', 'user_story', 'normal', 'default');
}

//Function to generate HTML for meta box Visting Year (cmb_visiting_year)
function mb_visiting_year() {
    global $post;

    //Noncename needs to verify where the data originated
    echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
    // Get the location data if its already been entered
    $visiting_year = get_post_meta($post->ID, '_visiting_year', true);
    // Echo out the field
    echo '<input type="text" name="_visiting_year" id="_visiting_year" value="' . $visiting_year  . '" class="form-control" maxlength="4" required />';
}

//Generate Month dropdown
function mb_visiting_month() {
    global $post;
    $visiting_month = get_post_meta($post->ID, '_visiting_month', true);

    $dd='<select id="_visiting_month" name="_visiting_month" class="form-control" required>';
    $dd .= '<option value="">-</option>';
    $dd .= '<option value="January">January</option>';
    $dd .= '<option value="February">February</option>';
    $dd .= '<option value="March">March</option>';
    $dd .= '<option value="April">April</option>';
    $dd .= '<option value="May">May</option>';
    $dd .= '<option value="June">June</option>';
    $dd .= '<option value="July">July</option>';
    $dd .= '<option value="August">August</option>';
    $dd .= '<option value="September">September</option>';
    $dd .= '<option value="October">October</option>';
    $dd .= '<option value="November">November</option>';
    $dd .= '<option value="December">December</option>';
    $dd .= '</select>';

    echo $dd;
}

//Generate No-of-Heads
function mb_heads() {
    global $post;
    $no_of_heads = get_post_meta($post->ID, '_no_of_heads', true);

    echo '<input type="number" id="_no_of_heads" name="_no_of_heads" value="' . $no_of_heads . '" class="form-control" maxlength="3" required />';
}

//Places covered / visited
function mb_places_visited() {
    global $post;
    $places_visited = get_post_meta($post->ID, '_places_visited', true);

    echo '<input type="text" id="_places_visited" name="_places_visited" value="'  . $places_visited . '" class="form-control" maxlength="100" required />';
}

//Trip cost
function mb_trip_cost() {
    global $post;
    $trip_cost = get_post_meta($post->ID, '_trip_cost', true);

    echo '<input type="number" id="_trip_cost" name="_trip_cost" value="' . $trip_cost . '" class="form-control" required />';
}

//Additional information about the trip
function mb_addl_info() {
    global $post;
    $addl_info = get_post_meta($post->ID, '_addl_info', true);

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
    echo wp_editor($content, $editor_id, $settings);
}

//Function to build the form for front end and used by a short code...
function render_user_story_form() {

    $form='<form id="user_story_form" name="user_story_form" action="" method="post">';
    $form .= '<div><input type="text" class="form-control" id="_title" name="_title" maxlength="75" required placeholder="Story title" /></div>';
    $form .= '<div><textarea id="_description" name="_description" rows="5" cols="80" class="form-control" maxlength="500" required placeholder="Your story here"></textarea></div>';
    $form .= '<div><input type="text" class="form-control" id="_places_visited" name="_places_visited" maxlength="100" required placeholder="Places visited during the trip" /></div>';
    $form .= '<div><input type="number" class="form-control" id="_trip_cost" name="_trip_cost" maxlength="6" required placeholder="Trip cost" /></div>';
    $form .= '<input type="submit" value="Submit" class="btn btn-primary" />';
    $form .= '</form>';

    echo $form;
}

function save_user_story() {
    $title = $_POST['_title'];
    $description = $_POST['_description'];
    $places = $_POST['_places_visited'];
    $cost = $_POST['_trip_cost'];

    $post = array(
        'post_title' => $title,
        'post_content' => $description,
        'post_type' => 'user_story',
        'post_status' => 'publish'
    );

    $new_post_id = wp_insert_post($post, 10, 1);

    add_post_meta($new_post_id, '_places_visited', $places);
    add_post_meta($new_post_id, '_trip_cost', $cost);
}

add_action ('init', 'story_custom_post_type');

add_shortcode('new-user-story', 'render_user_story_form');

add_action('save_post_user_story', 'save_user_story', 1, 2);

?>