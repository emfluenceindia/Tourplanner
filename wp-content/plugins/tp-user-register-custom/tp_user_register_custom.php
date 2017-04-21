<?php
/*
 * Plugin Name: Custom User Registration From
 * Description: Custom User Registration form to grab additional values of a user
 * Version: 1.0
 * Author: Subrata Sarkar
 */

    function custom_user_registration_form() {
        //Render registration form only if user is not logged in already!
        if(!is_user_logged_in()) {
            $registration_enabled = get_option('users_can_register');
            if($registration_enabled) {
                $output = render_registration_form();
            } else {
                $output = __('User registration is not enabled');
            }

            return $output;
        } else {
            return _e('You are already logged in!');
        }
    }

    //Add a shortcode for the above function to check and render custom registration form
    add_shortcode('register-user', 'custom_user_registration_form');

    /*Function to create and render user registration. We would save user metadata into wp_usermeta table
     * after grabbing the new user_id using wp_insert core function.
     */

    function render_registration_form() {
        ob_start();?>

        <form id="user_registration" name="user_registration" method="post" action="" class="text-small" enctype="multipart/form-data">
            <div class="default-error-container">
                <div class="row">
                    <div class="col-md-12">
                        <?php show_registration_error(); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-5">
                    <?php _e('First Name&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_firstname" name="txt_firstname" class="form-control" placeholder="Enter your first name" required maxlength="30" />
                </div>
                <div class="col-md-5">
                    <?php _e('Last Name&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_lastname" name="txt_lastname" class="form-control" placeholder="Enter your last name" required maxlength="30" />
                </div>
                <div class="col-md-2">
                    <?php _e('Gender&nbsp;') ?><i class="text-red">*</i>
                    <select id="cbo_gender" name="cbo_gender" class="form-control" required>
                        <option value=""></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-6">
                    <?php _e('Email Address&nbsp;') ?><i class="text-red">*</i>
                    <input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="e.g. myname@domain.com" required maxlength="75" />
                </div>
                <div class="col-md-6">
                    <?php _e('Phone Number') ?>
                    <input type="text" id="txt_phone" name="txt_phone" class="form-control" placeholder="Enter your phone number" maxlength="20" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-3">
                    <?php _e('House / Flat Number') ?>
                    <input type="text" id="txt_flat_number" name="txt_flat_number" class="form-control" placeholder="e.g. D3" maxlength="4" />
                </div>
                <div class="col-md-5">
                <?php _e('Street Address&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_street" name="txt_street" class="form-control" placeholder="e.g. 100, Kings Street" required maxlength="70" />
                </div>
                <div class="col-md-2">
                    <?php _e('City&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_city" name="txt_city" class="form-control" required maxlength="15" />
                </div>
                <div class="col-md-2">
                    <?php _e('Postal Code&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_zip" name="txt_zip" class="form-control" required maxlength="9" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row margin-top-10">
                <div class="col-md-4">
                    <?php _e('Login Id / Username&nbsp;') ?><i class="text-red">*</i>
                    <input type="text" id="txt_username" name="txt_username" class="form-control" placeholder="This will be used for you to login" required maxlength="20" />
                </div>
                <div class="col-md-4">
                    <?php _e('Password&nbsp;') ?><i class="text-red">*</i>
                    <input type="password" id="txt_password" name="txt_password" class="form-control" placeholder="Enter your password" maxlength="20" />
                </div>
                <div class="col-md-4">
                    <?php _e('Password&nbsp;') ?><i class="text-red">*</i>
                    <input type="password" id="txt_password_retype" name="txt_password_retype" class="form-control" placeholder="Retype password" maxlength="20" />
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row margin-top-20">
                <div class="col-md-3">
                    <?php wp_nonce_field('register_nonce'); ?>
                    <!-- <input type="text" value="<?php //echo wp_create_nonce('register_nonce_custom') ?>"> -->
                    <input type="submit" id="btn_submit" name="btn_submit" value="Submit" class="btn btn-primary text-medium-small margin-top-20" />
                </div>
            </div>
        </form>

        <?php return ob_get_clean();
    }

    function show_registration_error() {
        if($codes = reg_errors()->get_error_codes()) {
            echo '<div class="text-red bg-gray-light pad-10">';
            // Loop error codes and display errors
            foreach($codes as $code){
                $message = reg_errors()->get_error_message($code);
                echo '<span class="error">' . $message . '</span>. ';
            }
            echo '</div>';
        }
    }

    function reg_errors(){
        static $wp_error; // Will hold global variable safely
        return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
    }

    function validate_and_create_user() {
        // && wp_verify_nonce($_POST['register_nonce'], 'register-nonce')
        if(isset($_POST['txt_username'])) {

            $retrieved_nonce = $_REQUEST['_wpnonce'];
            if(!wp_verify_nonce($retrieved_nonce, 'register_nonce' )) {
                die('Failed security check');
            }

            //wp_users
            $first_name = $_POST['txt_firstname'];
            $last_name = $_POST['txt_lastname'];
            $email = $_POST['txt_email'];
            $loginid = $_POST['txt_username'];
            $password = $_POST['txt_password'];
            $password_retype = $_POST['txt_password_retype'];

            //User meta (wp_usermeta)
            $gender = $_POST['cbo_gender'];
            $phone = $_POST['txt_phone'];
            $flatno = $_POST['txt_flat_number'];
            $street = $_POST['txt_street'];
            $city = $_POST['txt_city'];
            $zip = $_POST['txt_zip'];

            // this is required for username checks
            require_once(ABSPATH . WPINC . '/registration.php');

            if($first_name == '') {
                reg_errors()->add('firstname_empty', __('Please enter first name'));
            }
            if($last_name == '') {
                reg_errors()->add('lastname_empty', __('Please enter last name'));
            }
            if($gender == '') {
                reg_errors()->add('gender_empty', __('Please select gender'));
            }
            if($email == '') {
                reg_errors()->add('email_empty', __('Please enter email'));
            }
            if(!is_email($email)) {
                reg_errors()->add('email_invalid', __('Invalid email'));
            }
            if(email_exists($email)) {
                reg_errors()->add('email_unavailable', __('Email is already taken'));
            }
            if($street == '') {
                reg_errors()->add('street_empty', __('Please enter street'));
            }
            if($city == '') {
                reg_errors()->add('city_empty', __('Please enter your city'));
            }
            if($zip == '') {
                reg_errors()->add('zip_empty', __('Please enter postal code'));
            }
            if(username_exists($loginid)) {
                reg_errors()->add('username_unavailable', __('Username already taken'));
            }
            if(!validate_username($loginid)) {
                reg_error()->add('username_invalid', __('Invalid username'));
            }
            if($password == '') {
                reg_errors()->add('password_empty', __('Please enter password'));
            }
            if($password != $password_retype) {
                reg_errors()->add('passwords_mismatch', __('Passwords do not match'));
            }

            $errors = reg_errors()->get_error_message();

            //Only create user if there is no error reported
            if(empty($errors)) {
                $user_data = array(
                    'user_login' => $loginid,
                    'user_pass' => $password,
                    'user_nicename' => $first_name,
                    'display_name' => $first_name . ' ' . $last_name,
                    'user_email' => $email,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'user_registered' => date('Y-m-d H:i:s'),
                    'role' => 'subscriber'
                );
                $new_user_id = wp_insert_user($user_data);

                //echo $new_user_id;
                //echo $_POST['txt_firstname'];

                if($new_user_id) {
                    //Sends email to the admin altering new user registration
                    //wp_new_user_notification($new_user_id);

                    //Update user meta...
                    add_user_meta($new_user_id, '_user_gender', $gender);
                    if($phone != '') {
                        add_user_meta($new_user_id, '_user_phone', $phone);
                    }
                    if($flatno != '') {
                        add_user_meta($new_user_id, '_user_flat_no', $flatno);
                    }
                    add_user_meta($new_user_id, '_user_street', $street);
                    add_user_meta($new_user_id, '_user_city', $city);
                    add_user_meta($new_user_id, '_user_zip', $zip);



                    //Log user in
                    wp_set_auth_cookie($new_user_id, true);
                    wp_set_current_user($new_user_id, $loginid);
                    do_action('wp_login', $loginid);

                    //Send new user to create travelog page
                    wp_redirect(home_url().'/create-travelog/');
                    exit;
                }
            }
        }
    }

    add_action('init', 'validate_and_create_user');
?>