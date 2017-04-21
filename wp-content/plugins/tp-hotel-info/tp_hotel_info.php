<?php
/*
 * Plugin Name: Hotel Information
 * Description: Add a Hotel - name, description, address, phone number, email address and other information relevant to a hotel
 * Version: 1.0
 * Author: Subrata Sarkar
 */

//Register new CPT for Hotel
add_action('init', 'register_hotel_info');

/*
 * Registers new CPT: Hotel
 */
function register_hotel_info() {

    $labels = array(
        'name' => 'Hotel',
        'singular_name' => 'Hotel',
        'admin_menu' => 'Hotel',
        'name_admin_bar' => 'Hotel'
    );

    $supports = array(
        'title',
        'editor',
        'thumbnail'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'capability_type' => 'post',
        'taxonomies' => array ('hotel_type', 'room_type', 'amenities'),
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 28,
        'hierarchical' => false,
        'rewrite' => array('slug', 'hotels'),
        'supports' => $supports,
        'exclude_from_search' => false
    );


    register_post_type('hotel-info', $args);
}

/*
 * Metaboxes
 */

add_action('add_meta_boxes', 'add_hotel_metaboxes');

function add_hotel_metaboxes() {
    add_meta_box('hotel_meta', 'Hotel Information', 'create_hotel_meta_boxes_callback', 'hotel-info', 'normal');
}

function create_hotel_meta_boxes_callback($post) {
    wp_nonce_field('save_hotel_meta', 'hotel_nonce'); //save_hotel_meta is the function name

    //Get meta value against post ID and store in local variables....................
    //Syntax: get_post_meta(int postId, string metaKey, bool single [default: true]);

    $location = get_post_meta($post->ID, '_hotel_location', true);
    $address = get_post_meta($post->ID, '_hotel_address', true);
    $phone_primary = get_post_meta($post->ID, '_hotel_primary_phone', true);
    $phone_alternate = get_post_meta($post->ID, '_hotel_phone_alternate', true);
    $email = get_post_meta($post->ID, '_hotel_contact_email', true);
    $website = get_post_meta($post->ID, '_hotel_website', true);
    $no_of_rooms = get_post_meta($post->ID, '_hotel_no_of_rooms', true);
    $rly_station_distance = get_post_meta($post->ID, '_hotel_nearest_railhead', true);
    $airport_distance = get_post_meta($post->ID, '_hotel_nearest_airport', true);
    $bus_stand_distance = get_post_meta($post->ID, '_hotel_nearest_bus_stand', true);
    $complementary_service = get_post_meta($post->ID, '_hotel_complementary_service', true);
    $booking_procedure = get_post_meta($post->ID, '_hotel_booking_process', true);
    $cancellation_procedure = get_post_meta($post->ID, '_hotel_cancel_phone', true);
    $bank_name = get_post_meta($post->ID, '_hotel_bank_name', true);
    $bank_address = get_post_meta($post->ID, '_hotel_bank_address', true);
    $branch_name = get_post_meta($post->ID, '_hotel_branch_name', true);
    $branch_code = get_post_meta($post->ID, '_hotel_branch_code', true);
    $ac_holder_name = get_post_meta($post->ID, '_hotel_ac_holder_name', true);
    $ac_number = get_post_meta($post->ID, '_hotel_ac_number', true);
    $bank_ifsc = get_post_meta($post->ID, '_hotel_ifsc_code', true);


    //Create Layout for each metabox!
    echo create_hotel_metabox_layout($post, 'Location', false, 'cbo_location', 0, 'select', '', true, $location);
    echo create_hotel_metabox_layout($post, 'Address', true, 'txt_hotel_address', 250, 'text', 'Enter hotel address', true, $address);
    echo create_hotel_metabox_layout($post, 'Primary Phone', false, 'txt_primary_phone', 15, 'text', 'Primary Phone Number', true, $phone_primary);
    echo create_hotel_metabox_layout($post, 'Alternate Phone', false, 'txt_alternate_phone', 15, 'text', 'Alternate Phone Number', false, $phone_alternate);
    echo create_hotel_metabox_layout($post, 'Contact Email', false, 'txt_contact_email', 75, 'email', 'Email address', true, $email);
    echo create_hotel_metabox_layout($post, 'Website', false, 'txt_website', 100, 'url', 'Website Address', false, $website);
    echo create_hotel_metabox_layout($post, 'Number of Rooms', false, 'txt_rooms', 3, 'number', 'No of rooms', true, $no_of_rooms);
    echo create_hotel_metabox_layout($post, 'Nearest Rly. Station and Distance. Leave blank if not applicable', false, 'txt_rly', 75, 'text', 'Nearest Rly. Station', false, $rly_station_distance);
    echo create_hotel_metabox_layout($post, 'Nearest Airport and Distance. Leave blank if not applicable', false, 'txt_airport', 75, 'text', 'Nearest Airport', false, $airport_distance);
    echo create_hotel_metabox_layout($post, 'Nearest Bus stop and Distance. Leave blank if not applicable', false, 'txt_bus', 75, 'text', 'Nearest Bus stop', false, $bus_stand_distance);
    echo create_hotel_metabox_layout($post, 'Complementary Services. Leave blank if not applicable', true, 'txt_complementary', 250, '', 'Complementary Services', false, $complementary_service);
    echo create_hotel_metabox_layout($post, 'Booking Procedure', true, 'txt_booking_procedure', 500, '', 'Booking Procedure', true, $booking_procedure);
    echo create_hotel_metabox_layout($post, 'Cancellation Procedure', true, 'txt_cancellation_procedure', 500, '', 'Cancellation Procedure', true, $cancellation_procedure);
    echo create_hotel_metabox_layout($post, 'Name of Bank', false, 'txt_bank_name', 75, 'text', 'Name of bank', true, $bank_name);
    echo create_hotel_metabox_layout($post, 'Bank Address', true, 'txt_bank_address', 500, '', 'Bank address', true, $bank_address);
    echo create_hotel_metabox_layout($post, 'Branch Name', false, 'txt_branch_name', 100, 'text', 'Branch name', true, $branch_name);
    echo create_hotel_metabox_layout($post, 'Branch Code', false, 'txt_branch_code', 8, 'text', 'Branch Code', true, $branch_code);
    echo create_hotel_metabox_layout($post, 'Name of Account Holder', false, 'txt_ac_holder', 75, 'text', 'Name of Account Holder', true, $ac_holder_name);
    echo create_hotel_metabox_layout($post, 'Account Number', false, 'txt_ac_number', 20, 'text', 'Name of bank', true, $ac_number);
    echo create_hotel_metabox_layout($post, 'IFSC', false, 'txt_ifsc', 20, 'text', 'Branch IFSC code', true, $bank_ifsc);
    echo create_hotel_metabox_layout($post, 'Additional Images', false, 'txt_multi_image', '', 'file', 'Upload Images', false, '');
}

function create_hotel_metabox_layout($post, $metabox_title, $is_text_area, $id_name, $maxlength, $input_type, $placeholder_text, $is_required, $input_value) {
    /*----------Fields----------*/

    $location_id = get_post_meta($post->ID, '_hotel_location', true);
    $args_hotel_location = array(
        'show_option_all'    => '',
        'show_option_none'   => '-- Select --',
        'option_none_value'   => '',
        //'orderby'            => 'ID',
        //'order'              => 'ASC',
        'show_count'         => 1,
        'hide_empty'         => 0,
        //'child_of'           => 0,
        //'exclude'            => '',
        'echo'               => 1,
        'selected'           => $location_id,
        'hierarchical'       => 0,
        'name'               => 'cbo_location',
        'id'                 => 'cbo_location',
        //'class'              => '',
        'required'           => 'required',
        'depth'              => 0,
        'tab_index'          => 0,
        'taxonomy'           => 'hotel_location',
        'hide_if_empty'      => false,
        //'walker'             => ''
    );

    /*
    * Address
    * Primary Phone
    * Alternate Phone
    * Email
    * Website
    * No. of Rooms
    * Nearest Rly. Station and Distance
    * Nearest Airport and Distance
    * Nearest Bus stand and Distance
    * Nearest Market place and Distance
    * No. of Rooms
    * Complementary Services
    * Booking Procedure
    * Cancellation Procedure
    * Bank Account Information
    * Name and Descriptions will go as Title and Content Editor content
    */
    $layout = ''; ?>



    <div style="border:0px solid #dddddd;padding: 10px;margin-top:3px;">
        <h3 style="margin: 0 auto;font-size: 98%;"><?php echo $metabox_title; ?></h3>
        <?php if($is_text_area) { ?>
              <textarea id="<?php echo $id_name; ?>"
                        name="<?php echo $id_name; ?>"
                        rows="7" cols="80"
                        style="width:100%" maxlength="<?php echo $maxlength; ?>"
                        placeholder="<?php echo $placeholder_text; ?>"
                        <?php if($is_required){ ?>required<?php } ?>>
                  <?php echo esc_attr(trim(br2nl($input_value))); ?>
              </textarea>
        <?php
        } else {
            if($input_type == 'text') { ?>
                <input type="text"
                       id="<?php echo $id_name; ?>"
                       name="<?php echo $id_name; ?>"
                       style="width:100%"
                       maxlength="<?php echo $maxlength; ?>"
                       placeholder="<?php echo $placeholder_text; ?>"
                       <?php if($is_required){ ?>required<?php } ?>
                       value="<?php echo esc_attr(trim($input_value)); ?>" />
            <?php
            }
            elseif($input_type == 'email') { ?>
                <input type="email"
                       id="<?php echo $id_name; ?>"
                       name="<?php echo $id_name; ?>"
                       style="width:100%"
                       maxlength="<?php echo $maxlength; ?>"
                       placeholder="<?php echo $placeholder_text; ?>"
                       <?php if($is_required){ ?>required<?php } ?>
                       value="<?php echo esc_attr(trim($input_value)); ?>" />
            <?php
            }
            elseif($input_type == 'number') { ?>
                <input type="number"
                       id="<?php echo $id_name; ?>"
                       name="<?php echo $id_name; ?>"
                       style="width:100%"
                       maxlength="<?php echo $maxlength; ?>"
                       placeholder="<?php echo $placeholder_text; ?>"
                       <?php if($is_required){ ?>required<?php } ?>
                       value="<?php echo esc_attr(trim($input_value)); ?>" />
            <?php
            }
            elseif($input_type == 'url') { ?>
                <input type="url"
                       id="<?php echo $id_name; ?>"
                       name="<?php echo $id_name; ?>"
                       style="width:100%"
                       maxlength="<?php echo $maxlength; ?>"
                       placeholder="<?php echo $placeholder_text; ?>"
                       <?php if($is_required){ ?>required<?php } ?>
                       value="<?php echo esc_attr(trim($input_value)); ?>" />
            <?php }
            elseif($input_type == 'file') { ?>
                <input type="file" multiple
                       id="<?php echo $id_name; ?>"
                       name="<?php echo $id_name; ?>"
                       style="width:100%"
                       maxlength="<?php echo $maxlength; ?>"
                       placeholder="<?php echo $placeholder_text; ?>"
                       <?php if($is_required){ ?>required<?php } ?>
                       value="<?php echo esc_attr($input_value); ?>" />
            <?php
            }
            elseif($input_type =='select') {
                wp_dropdown_categories($args_hotel_location);
            }
        } ?>

    </div>

    <?php return $layout;
}

//Now save hotel with meta information and taxonomies
add_action('save_post', 'save_hotel_meta');

function save_hotel_meta($post_id) {

    //Check whether nonce is presenet
    if(!isset($_POST['hotel_nonce'])) {
        return;
    }

    //check whether it is a valid nonce, i.e. current nonce is coming from save_hotel_meta function call
    if(!wp_verify_nonce($_POST['hotel_nonce'], 'save_hotel_meta')) {
        return;
    }

    //We do not want an AUTOSAVE here
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    //check whether current user can create /edit HOTEL CPT data
    if(!current_user_can('edit_post', $post_id)) {
        return;
    }

    //Finally check whether all required fields are served with values.
    if(!isset($_POST['txt_hotel_address']) || !isset($_POST['txt_primary_phone']) || !isset($_POST['txt_contact_email'])  || !isset($_POST['txt_rooms'])) {
        return;
    }
    
    //Enough checking! Let's now SAVE the record and meta information :-)
    $hotel_location = $_POST['cbo_location'];
    $hotel_address = nl2br($_POST['txt_hotel_address']);
    $primary_phone = sanitize_text_field($_POST['txt_primary_phone']);
    $contact_email = sanitize_text_field($_POST['txt_contact_email']);
    $no_of_rooms = sanitize_text_field($_POST['txt_rooms']);

    $website = '';
    $rly_station = '';
    $airport = '';
    $bus_stand = '';
    $complementary_service = '';
    $booking_process = '';
    $cancel_process = '';
    $bank_name = '';
    $bank_address = '';
    $branch_name = '';
    $branch_code = '';
    $ac_holder = '';
    $ac_number = '';
    $ifsc = '';


    if(isset($_POST['txt_alternate_phone'])) {
        $alternate_phone = sanitize_text_field($_POST['txt_alternate_phone']);
    }

    if(isset($_POST['txt_website'])) {
        $website = sanitize_text_field($_POST['txt_website']);
    }

    if(isset($_POST['txt_rly'])) {
        $rly_station = sanitize_text_field($_POST['txt_rly']);
    }

    if(isset($_POST['txt_airport'])) {
        $airport = sanitize_text_field($_POST['txt_airport']);
    }

    if(isset($_POST['txt_bus'])) {
        $bus_stand = sanitize_text_field($_POST['txt_bus']);
    }

    if(isset($_POST['txt_complementary'])) {
        $complementary_service = nl2br($_POST['txt_complementary']);
    }

    if(isset($_POST['txt_booking_procedure'])) {
        $booking_process = nl2br($_POST['txt_booking_procedure']);
    }

    if(isset($_POST['txt_cancellation_procedure'])) {
        $cancel_process = nl2br($_POST['txt_cancellation_procedure']);
    }

    if(isset($_POST['txt_bank_name'])) {
        $bank_name = sanitize_text_field($_POST['txt_bank_name']);
    }

    if(isset($_POST['txt_bank_address'])) {
        $bank_address = nl2br($_POST['txt_bank_address']);
    }

    if(isset($_POST['txt_branch_name'])) {
        $branch_name = sanitize_text_field($_POST['txt_branch_name']);
    }

    if(isset($_POST['txt_branch_code'])) {
        $branch_code = sanitize_text_field($_POST['txt_branch_code']);
    }

    if(isset($_POST['txt_ac_holder'])) {
        $ac_holder = sanitize_text_field($_POST['txt_ac_holder']);
    }

    if(isset($_POST['txt_ac_number'])) {
        $ac_number = sanitize_text_field($_POST['txt_ac_number']);
    }

    if(isset($_POST['txt_ifsc'])) {
        $ifsc = sanitize_text_field($_POST['txt_ifsc']);
    }

    //Mandatory fields
    update_post_meta($post_id, '_hotel_location', $hotel_location);
    update_post_meta($post_id, '_hotel_address', $hotel_address);
    update_post_meta($post_id, '_hotel_primary_phone', $primary_phone);
    update_post_meta($post_id, '_hotel_contact_email', $contact_email);
    update_post_meta($post_id, '_hotel_no_of_rooms', $no_of_rooms);

    //Optional fields
    update_post_meta($post_id, '_hotel_alternate_phone', $alternate_phone);
    update_post_meta($post_id, '_hotel_website', $website);
    update_post_meta($post_id, '_hotel_nearest_railhead', $rly_station);
    update_post_meta($post_id, '_hotel_nearest_airport', $airport);
    update_post_meta($post_id, '_hotel_nearest_bus_stand', $bus_stand);
    update_post_meta($post_id, '_hotel_complementary_service', $complementary_service);
    update_post_meta($post_id, '_hotel_booking_process', $booking_process);
    update_post_meta($post_id, '_hotel_cancel_phone', $cancel_process);
    update_post_meta($post_id, '_hotel_bank_name', $bank_name);
    update_post_meta($post_id, '_hotel_bank_address', $bank_address);
    update_post_meta($post_id, '_hotel_branch_name', $branch_name);
    update_post_meta($post_id, '_hotel_branch_code', $branch_code);
    update_post_meta($post_id, '_hotel_ac_holder_name', $ac_holder);
    update_post_meta($post_id, '_hotel_ac_number', $ac_number);
    update_post_meta($post_id, '_hotel_ifsc_code', $ifsc);

    //Let's now upload media files (Additional images)
    //Multiple file upload routine starts.................
    $gallery_images = $_FILES['txt_multi_image'];
    foreach($gallery_images['name'] as $key => $value) {
        if($gallery_images['name'][$key]) {
            $image = array(
                'name' => $gallery_images['name'][$key],
                'type' => $gallery_images['type'][$key],
                'tmp_name' => $gallery_images['tmp_name'][$key],
                'error' => $gallery_images['error'][$key],
                'size' => $gallery_images['size'][$key]
            );

            $_FILES = array('txt_multi_image' => $image);
            //var_dump($_FILES);

            foreach($_FILES as $image => $array) {
                $attach_id = media_handle_upload($image, $post_id);
                //var_dump($attach_id);
            }
        }
    }
    //Ends: Multiple file upload
}

?>