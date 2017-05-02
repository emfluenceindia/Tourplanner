<?php
    /* Includes */
    include 'shortcodes.php';
    include 'custom_post_types.php';
    //include 'custom-taxonomy-genre.php';
    /* Ends Includes */

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    function get_category_object($cat_name){
        //Reference: https://codex.wordpress.org/Function_Reference/get_category
        $term = get_term_by('name', $cat_name, 'category');
        return $term;
    }

    function get_posts_by_category_id($cat_id, $post_type, $records_per_page){
        $currentPage = get_query_var('paged');
        $args = array(
            'category' => $cat_id,
            'post_type' => $post_type,
            'paged' => $currentPage,
            'posts_per_page' => $records_per_page
        );
        $posts = get_posts($args);

        return $posts;
    }

    function resource_includes(){
    /*Syntax: wp_enqueue_style( $handle, $src = string, $deps = array(), $ver = false, $media = 'all' ); */
        wp_enqueue_style('style', get_stylesheet_uri(), array(), mt_rand(), 'all');
        wp_enqueue_style('gfonts', get_stylesheet_directory_uri().'/styles/gfonts.css', array(), mt_rand(), 'all');
        wp_enqueue_style('margin', get_stylesheet_directory_uri().'/styles/margin.css', array(), mt_rand(), 'all');
        wp_enqueue_style('padding', get_stylesheet_directory_uri().'/styles/padding.css', array(), mt_rand(), 'all');
        wp_enqueue_style('text', get_stylesheet_directory_uri().'/styles/text.css', array(), mt_rand(), 'all');
        wp_enqueue_style('bg', get_stylesheet_directory_uri().'/styles/bg.css', array(), mt_rand(), 'all');
        wp_enqueue_style('border', get_stylesheet_directory_uri().'/styles/border.css', array(), mt_rand(), 'all');
        wp_enqueue_style('mq', get_stylesheet_directory_uri().'/styles/mq.css', array(), mt_rand(), 'all');
        wp_enqueue_style('font-awesome', get_stylesheet_directory_uri().'/styles/font-awesome.css', array(), mt_rand(), 'all');

        /* Bootstrap */
        wp_enqueue_style('bootstrap.min', get_stylesheet_directory_uri().'/styles/bootstrap/css/bootstrap.min.css', array(), mt_rand(), 'all');
        wp_enqueue_style('bootstrap.icon-large.min', get_stylesheet_directory_uri().'/styles/bootstrap/css/bootstrap.icon-large.min.css', array(), mt_rand(), 'all');
        wp_enqueue_style('bootstrap-theme.min', get_stylesheet_directory_uri().'/styles/bootstrap/css/bootstrap-theme.min.css', array(), mt_rand(), 'all');

        /* JS references */
        wp_enqueue_script('equal-height', get_template_directory_uri() . '/scripts/equal-height.js', array('jquery'), 1.1, true);
        wp_enqueue_script('gmap', get_template_directory_uri() . '/scripts/gmap.js', array(), '1.0.0', true);
    }

    /* Get Post view */
    function getPostViews($postID) {
        $count_key = 'view_count';
        $count = get_post_meta($postID, $count_key, true);

        if($count == ''){
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');

            return '0 Views';
        }

        return $count . 'Views';
    }

    /* Set Post View */
    function setPostViews($postID) {
        $count_key = 'view_count';
        $count = get_post_meta($postID, $count_key, true);

        if($count == ''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

    //Removes issues with prefetching adding extra views.
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

    add_action('wp_enqueue_scripts', 'resource_includes');

    // Remove default image width and height attributes from all images on the site
    add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
    add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
    // Removes attached image sizes as well
    add_filter( 'the_content', 'remove_width_attribute', 10 );

    function remove_width_attribute( $html ) {
        //$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
        $html = preg_replace( '/(width|height)="\d*"/', "", $html );
        return $html;
    }

    /* Create custom widgets and register them */
    function tp_widgets_init(){
        register_sidebar(array(
            'name' => __('Sidebar', 'tourplan'),
            'id' => 'sidebar-1',
            'description' => __('Add widgets to display on sidebar', 'tourplan'),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>'
        ));

        register_sidebar(array(
            'name' => __('Trip Related Info', 'tourplan'),
            'id' => 'trip-related-info',
            'description' => __('Important Information', 'tourplan'),
        ));

        register_sidebar(array(
            'name' => __('More Images', 'tourplan'),
            'id' => 'additional-images',
            'description' => __('Attached Images', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('Available Package Tours', 'tourplan'),
            'id' => 'packaged-tour',
            'description' => __('Associated Tour Packages', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('Tour Package Info', 'tourplan'),
            'id' => 'package-info',
            'description' => __('Package Information', 'tourplann')
        ));

        register_sidebar(array(
            'name' => __('Sidebar Packaged Tour list', 'tourplan'),
            'id' => 'sidebar-package-tour-list',
            'description' => __('Creates a list of available package tours', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('User Login Sidebar', 'tourplan'),
            'id' => 'site-user-login',
            'description' => __('Creates a user login box', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('Forum or Topic Sidebar', 'tourplan'),
            'id' => 'forum-topic-sidebar',
            'description' => __('Shows a sidebar with Form or Topic overview', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('Upcoming Stories', 'tourplan'),
            'id' => 'upcoming-stories-sidebar',
            'description' => __('Lists upcoming stores in a sidebar', 'tourplan')
        ));

        register_sidebar(array(
            'name' => __('Latest Stories', 'tourplan'),
            'id' => 'latest-stories-sidebar',
            'description' => __('Lists latest stories in a sidebar', 'tourplan')
        ));
    }

    /* Hook to register sidebars */
    add_action('widgets_init', 'tp_widgets_init');

    /*
        ==================================
        Theme support function
        ==================================
    */
    add_theme_support('html5', array('search-form'));

    function custom_excerpt_more_link($more){
        return '<a href="' . get_the_permalink() . '" rel="nofollow">&nbsp;[more]</a>';
        /*
        global $post;
        if ($post->post_type == 'travelog') {
            return '..';
        } else {
            return '<a href="' . get_the_permalink() . '" rel="nofollow">&nbsp;[more]</a>';
        }*/
    }

    add_filter('excerpt_more', 'custom_excerpt_more_link');

    function set_custom_excerpt_length($length){
        return 40;
    }

    add_filter('excerpt_length', 'set_custom_excerpt_length', 10);

    //Function to pass customized length of excerpt from outside and return the text with post link
    function excerpt($limit, $show_more = true) {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).'...';
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
        if($show_more)
            return $excerpt . '<a href="'.get_the_permalink().'" rel="nofollow">&nbsp;[more]</a>';
        else
            return $excerpt;
    }

    function content($limit) {
        $content = explode(' ', get_the_content(), $limit);
        if (count($content)>=$limit) {
            array_pop($content);
            $content = implode(" ",$content).'...';
        } else {
            $content = implode(" ",$content);
        }
        $content = preg_replace('/\[.+\]/','', $content);
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);
        return $content;
    }

    /* Google map api key */
    //AIzaSyB69TTtConBHxaqoFAPCrX1U3ysPBhlfio
    function acf_google_map_api( $api ){

        $api['key'] = 'AIzaSyB69TTtConBHxaqoFAPCrX1U3ysPBhlfio';
        return $api;
    }

    add_filter('acf/fields/google_map/api', 'acf_google_map_api');

    /* Register menu: https://codex.wordpress.org/Navigation_Menus */

    function register_tourplan_menus(){ //Registers multiple menus in single function.
        register_nav_menus(array(
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu')
        ));
    }

    add_action('init', 'register_tourplan_menus');

    add_filter('wp_nav_menu_items', 'add_login_logout_link', 10, 2);

    function add_login_logout_link($items, $args) {
        ob_start();
        wp_loginout('index.php');
        $loginoutlink = ob_get_contents();
        ob_end_clean();
        if(is_user_logged_in()){
            $user = wp_get_current_user();
            //$str = 'Welcome ' . $user->display_name . '. ' . $loginoutlink;
            //$str = sprintf("<span style='inline-block;'>Welcome %s</span>. %s", $user->display_name, $loginoutlink);
            $items .= '<li>' . $loginoutlink . '</li>';
        } else {
            $items .= '<li>' . $loginoutlink . '</li>';
        }

        return $items;
    }

    function save_trip_package_relationship($id, $post){
        //Code to insert mapping
        /*if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (isset($post->post_status) && 'auto-draft' == $post->post_status) {
            return;
        }*/

        /*global $wpdb;
        $table_name = $wpdb->prefix . "trip_packages";

        $wpdb->insert($table_name, array(
            'trip_id' => $post->ID,
            'package_id' => 20
        ));*/
    }

    //add_action('draft_to_publish', 'save_trip_package_relationship');

    function create_trip_package_map($post_id){
        //First get all available records in wp_trip_packages table against $post_id (current post)
        //Loop though the record set and remove each of them

        global $wpdb;
        //$query = 'SELECT * FROM ' . $wpdb->prefix . 'trip_packages WHERE trip_id = ' . $post_id;
        //$old_map = $wpdb->get_results($query, OBJECT);

        $selected_packages = get_field('available_tour_packages');
        if($selected_packages) {

            $wpdb->query('DELETE FROM ' . $wpdb->prefix . 'trip_packages WHERE trip_id = ' . $post_id);

            foreach($selected_packages as $package) {
                $table_name = $wpdb->prefix . "trip_packages";

                $wpdb->insert($table_name, array(
                    'trip_id' => $post_id,
                    'package_id' => $package->ID
                ));
            }
        }
    }

    add_action('acf/save_post', 'create_trip_package_map', 20);

    // Add Password recovery link to wp_login_form()
    function add_register_lost_password_links() {
        //return '<a href="/wp-login.php?action=lostpassword">Lost Password?</a>';
        return '<div class="recovery-action"><a href="/recover-password">Lost Password</a> | <a href="/register">Register</a></div>';
    }

    //Available HOOKS: login_form_bottom, login_form_top, login_form_middle
    add_action( 'login_form_bottom', 'add_register_lost_password_links' );



    /* Topic Dropdowns - Topic Type and Topic Status */
    /* Source file: /wp-content/plugins/bbpress/includes/forums/template/php */

    function bbp_form_topic_type_dropdown_tp( $args = '' ) {
        echo bbp_get_form_topic_type_dropdown_tp( $args );
    }
    /**
     * Returns topic type select box (normal/sticky/super sticky)
     *
     * @since bbPress (r5059)
     *
     * @param $args This function supports these arguments:
     *  - select_id: Select id. Defaults to bbp_stick_topic
     *  - tab: Tabindex
     *  - topic_id: Topic id
     *  - selected: Override the selected option
     * @uses bbp_get_topic_id() To get the topic id
     * @uses bbp_is_single_topic() To check if we're viewing a single topic
     * @uses bbp_is_topic_edit() To check if it is the topic edit page
     * @uses bbp_is_topic_super_sticky() To check if the topic is a super sticky
     * @uses bbp_is_topic_sticky() To check if the topic is a sticky
     */
    function bbp_get_form_topic_type_dropdown_tp( $args = '' ) {

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
            'select_id'    => 'bbp_stick_topic',
            'default_css_class' => 'form-control',
            'tab'          => bbp_get_tab_index(),
            'topic_id'     => 0,
            'selected'     => false
        ), 'topic_type_select' );

        // No specific selected value passed
        if ( empty( $r['selected'] ) ) {

            // Post value is passed
            if ( bbp_is_post_request() && isset( $_POST[ $r['select_id'] ] ) ) {
                $r['selected'] = $_POST[ $r['select_id'] ];

                // No Post value passed
            } else {

                // Edit topic
                if ( bbp_is_single_topic() || bbp_is_topic_edit() ) {

                    // Get current topic id
                    $topic_id = bbp_get_topic_id( $r['topic_id'] );

                    // Topic is super sticky
                    if ( bbp_is_topic_super_sticky( $topic_id ) ) {
                        $r['selected'] = 'super';

                        // Topic is sticky or normal
                    } else {
                        $r['selected'] = bbp_is_topic_sticky( $topic_id, false ) ? 'stick' : 'unstick';
                    }
                }
            }
        }

        // Used variables
        $tab = !empty( $r['tab'] ) ? ' tabindex="' . (int) $r['tab'] . '"' : '';

        // Start an output buffer, we'll finish it after the select loop
        ob_start(); ?>

        <select class="<?php echo esc_attr( $r['default_css_class'] ) ?>" name="<?php echo esc_attr( $r['select_id'] ); ?>" id="<?php echo esc_attr( $r['select_id'] ); ?>_select"<?php echo $tab; ?>>

            <?php foreach ( bbp_get_topic_types() as $key => $label ) : ?>

                <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $key, $r['selected'] ); ?>><?php echo esc_html( $label ); ?></option>

            <?php endforeach; ?>

        </select>

        <?php

        // Return the results
        return apply_filters( 'bbp_get_form_topic_type_dropdown_tp', ob_get_clean(), $r );
    }

    function bbp_form_topic_status_dropdown_tp( $args = '' ) {
        echo bbp_get_form_topic_status_dropdown_tp( $args );
    }
    /*
     * Returns topic status downdown
     *
     * This dropdown is only intended to be seen by users with the 'moderate'
     * capability. Because of this, no additional capablitiy checks are performed
     * within this function to check available topic statuses.
     *
     * @since bbPress (r5059)
     *
     * @param $args This function supports these arguments:
     *  - select_id: Select id. Defaults to bbp_open_close_topic
     *  - tab: Tabindex
     *  - topic_id: Topic id
     *  - selected: Override the selected option
     */
    function bbp_get_form_topic_status_dropdown_tp( $args = '' ) {

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
            'select_id' => 'bbp_topic_status',
            'default_css_class' => 'form-control',
            'tab'       => bbp_get_tab_index(),
            'topic_id'  => 0,
            'selected'  => false
        ), 'topic_open_close_select' );

        // No specific selected value passed
        if ( empty( $r['selected'] ) ) {

            // Post value is passed
            if ( bbp_is_post_request() && isset( $_POST[ $r['select_id'] ] ) ) {
                $r['selected'] = $_POST[ $r['select_id'] ];

                // No Post value was passed
            } else {

                // Edit topic
                if ( bbp_is_topic_edit() ) {
                    $r['topic_id'] = bbp_get_topic_id( $r['topic_id'] );
                    $r['selected'] = bbp_get_topic_status( $r['topic_id'] );

                    // New topic
                } else {
                    $r['selected'] = bbp_get_public_status_id();
                }
            }
        }

        // Used variables
        $tab = ! empty( $r['tab'] ) ? ' tabindex="' . (int) $r['tab'] . '"' : '';

        // Start an output buffer, we'll finish it after the select loop
        ob_start(); ?>

        <select class="<?php echo esc_attr( $r['default_css_class'] ) ?>" name="<?php echo esc_attr( $r['select_id'] ) ?>" id="<?php echo esc_attr( $r['select_id'] ); ?>_select"<?php echo $tab; ?>>

            <?php foreach ( bbp_get_topic_statuses( $r['topic_id'] ) as $key => $label ) : ?>

                <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $key, $r['selected'] ); ?>><?php echo esc_html( $label ); ?></option>

            <?php endforeach; ?>

        </select>

        <?php

        // Return the results
        return apply_filters( 'bbp_get_form_topic_status_dropdown_tp', ob_get_clean(), $r );
    }

    /* Single Topic page - Topic Description Generator */

    function bbp_single_topic_description_latest_activity($args = ''){
        echo bbp_get_single_topic_description_latest_activity($args);
    }

    function bbp_get_single_topic_description_latest_activity($args = ''){
        $outer_container_start = "<div class='clearfix'></div><div class='bg-white pad-10 border-gray text-small'><div class='row'>";

        $author_column_start = "<div class='col-md-2'>";
        $author_column_end = "</div>";

        $activity_column_start = "<div class='col-md-10'><h3 class='text-medium module-head'>Forum Activity</h3><hr class='hr-white-base' />";
        $activity_column_end = "</div>";

        $clearfix = "<div class='clearfix'></div>";
        $outer_container_end = "</div></div>";

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
            'topic_id'  => 0,
            'size'      => 0
        ), 'get_single_topic_description' );

        // Validate topic_id
        $topic_id = bbp_get_topic_id( $r['topic_id'] );

        // Unhook the 'view all' query var adder
        remove_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );

        // Build the topic description
        $vc_int      = bbp_get_topic_voice_count   ( $topic_id, true  );
        $voice_count = bbp_get_topic_voice_count   ( $topic_id, false );
        $reply_count = bbp_get_topic_replies_link  ( $topic_id        );
        $time_since  = bbp_get_topic_freshness_link( $topic_id        );
        $author_display_name = bbp_get_topic_author_display_name($topic_id);

        $last_reply_id = bbp_get_topic_last_reply_id();
        $last_reply_author_display_name = bbp_get_reply_author_display_name($last_reply_id);
        $last_reply_author_url = bbp_get_reply_author_url($last_reply_id);

        $author_avatar = bbp_get_topic_author_avatar();
        $author_url = bbp_get_topic_author_url($topic_id);

        $voice_count = sprintf( _n( '%s voice', '%s voices', $vc_int, 'bbpress' ), $voice_count );

        $last_reply = bbp_get_topic_last_reply_id( $topic_id );

        $retstr = $outer_container_start . $author_column_start;

        //Has replies
        if(!empty($last_reply)){
            //Author column
            $last_updated_by = bbp_get_author_link( array( 'post_id' => $last_reply, 'size' => $r['size'] ) );
            $retstr = $retstr . "<a title=" . $author_display_name ." href='" . $author_url . "'>" . $author_avatar . "</a>" . $author_column_end;

            //Activity column
            $retstr = $retstr . $activity_column_start;
            $activity_str = "Created by: <a title='" . $author_display_name . "' href='" . $author_url . "'>" .$author_display_name . "</a><br />";
            $activity_str = $activity_str . "Last activity: " . $time_since . " by " . "<a title='" . $last_reply_author_display_name . "' href='" . $last_reply_author_url . "'>"  . $last_reply_author_display_name . "</a>";
            $retstr = $retstr . $activity_str . $activity_column_end;

            $retstr = $retstr . $clearfix . $outer_container_end;

        } elseif (!empty($last_reply) && !empty($voice_count)) { //Both replies and voices are present

        } elseif (empty($last_reply) && empty($voice_count)) { //No voice or reply found

        }

        //$retstr = $retstr . $author_column_end . $activity_column_start . $activity_column_end . $clearfix . $outer_container_end;

        // Add the 'view all' filter back
        add_filter( 'bbp_get_topic_permalink', 'bbp_add_view_all' );
        return apply_filters( 'bbp_get_single_topic_description_latest_activity', $retstr, $r );

        //echo 'Customizing single topic latest activity description';
    }

    /* Topic Editor: get_the_content() */
    /* Original source at: /wp-admin/plugins/bbpress/includes/common/template.php */

    function bbp_the_content_tp( $args = array() ) {
	    echo bbp_get_the_content_tp( $args );
    }
	/**
	 * Return a textarea or TinyMCE if enabled
	 *
	 * @since bbPress (r3586)
	 *
	 * @param array $args
	 *
	 * @uses apply_filter() To filter args and output
	 * @uses wp_parse_pargs() To compare args
	 * @uses bbp_use_wp_editor() To see if WP editor is in use
	 * @uses bbp_is_edit() To see if we are editing something
	 * @uses wp_editor() To output the WordPress editor
	 *
	 * @return string HTML from output buffer
	 */
    function bbp_get_the_content_tp( $args = array() ) {

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
            'context'           => 'topic',
            'before'            => '<div class="bbp-the-content-wrapper">',
            'after'             => '</div>',
            'wpautop'           => true,
            'media_buttons'     => false,
            'textarea_rows'     => '12',
            'tabindex'          => bbp_get_tab_index(),
            'tabfocus_elements' => 'bbp_topic_title,bbp_topic_tags',
            'editor_class'      => 'form-control',
            'tinymce'           => true,
            'teeny'             => true,
            'quicktags'         => false,
            'dfw'               => false
        ), 'get_the_content' );

        // If using tinymce, remove our escaping and trust tinymce
        if ( bbp_use_wp_editor() && ( false !== $r['tinymce'] ) ) {
            remove_filter( 'bbp_get_form_forum_content', 'esc_textarea' );
            remove_filter( 'bbp_get_form_topic_content', 'esc_textarea' );
            remove_filter( 'bbp_get_form_reply_content', 'esc_textarea' );
        }

        // Assume we are not editing
        $post_content = call_user_func( 'bbp_get_form_' . $r['context'] . '_content' );

        // Start an output buffor
        ob_start();

        // Output something before the editor
        if ( !empty( $r['before'] ) ) {
            echo $r['before'];
        }

        // Use TinyMCE if available
        if ( bbp_use_wp_editor() ) :

            // Enable additional TinyMCE plugins before outputting the editor
            add_filter( 'tiny_mce_plugins',   'bbp_get_tiny_mce_plugins'   );
            add_filter( 'teeny_mce_plugins',  'bbp_get_tiny_mce_plugins'   );
            add_filter( 'teeny_mce_buttons',  'bbp_get_teeny_mce_buttons'  );
            add_filter( 'quicktags_settings', 'bbp_get_quicktags_settings' );

            // Output the editor
            wp_editor( $post_content, 'bbp_' . $r['context'] . '_content', array(
                'wpautop'           => $r['wpautop'],
                'media_buttons'     => $r['media_buttons'],
                'textarea_rows'     => $r['textarea_rows'],
                'tabindex'          => $r['tabindex'],
                'tabfocus_elements' => $r['tabfocus_elements'],
                'editor_class'      => $r['editor_class'],
                'tinymce'           => $r['tinymce'],
                'teeny'             => $r['teeny'],
                'quicktags'         => $r['quicktags'],
                'dfw'               => $r['dfw'],
            ) );

            // Remove additional TinyMCE plugins after outputting the editor
            remove_filter( 'tiny_mce_plugins',   'bbp_get_tiny_mce_plugins'   );
            remove_filter( 'teeny_mce_plugins',  'bbp_get_tiny_mce_plugins'   );
            remove_filter( 'teeny_mce_buttons',  'bbp_get_teeny_mce_buttons'  );
            remove_filter( 'quicktags_settings', 'bbp_get_quicktags_settings' );

        /**
         * Fallback to normal textarea.
         *
         * Note that we do not use esc_textarea() here to prevent double
         * escaping the editable output, mucking up existing content.
         */
        else : ?>

            <textarea id="bbp_<?php echo esc_attr( $r['context'] ); ?>_content" class="<?php echo esc_attr( $r['editor_class'] ); ?>" name="bbp_<?php echo esc_attr( $r['context'] ); ?>_content" cols="60" rows="<?php echo esc_attr( $r['textarea_rows'] ); ?>" tabindex="<?php echo esc_attr( $r['tabindex'] ); ?>"><?php echo $post_content; ?></textarea>

        <?php endif;

        // Output something after the editor
        if ( !empty( $r['after'] ) ) {
            echo $r['after'];
        }

        // Put the output into a usable variable
        $output = ob_get_clean();

    return apply_filters( 'bbp_get_the_content_tp', $output, $args, $post_content );
}

    //BBpress New Topic Button //
    function wpmu_bbp_create_new_topic(){

        if ( isset($_GET['f']) ){

            return do_shortcode("[bbp-topic-form forum_id=".$_GET['f']."]");

        }else{

            return do_shortcode("[bbp-topic-form]");

        }
    }
    add_shortcode('wpmu_bbp_topic', 'wpmu_bbp_create_new_topic', 10);
    //End BBpress New Topic Button //

    function bbp_reply_admin_url_tp(){
        return "<a class='inline-link btn btn-primary text-small-button' title='Reply' href='#new-post'>Reply</a>";
    }

    function bbp_reply_author_role_name($args = array()){
        return bbp_get_reply_author_role_name($args);
    }

    function bbp_get_reply_author_role_name($args = array()) {
        $r = bbp_parse_args( $args, array(
            'reply_id' => 0,
            'class'    => 'bbp-author-role',
            'before'   => '',
            'after'    => ''
        ), 'get_reply_author_role' );

        $reply_id    = bbp_get_reply_id( $r['reply_id'] );
        $author_role        = bbp_get_user_display_role( bbp_get_reply_author_id( $reply_id ) );

        return apply_filters( 'bbp_get_reply_author_role_name', $author_role, $r );
    }

    //Topic tags //
    function bbp_topic_tag_list_tp( $topic_id = 0, $args = '' ) {
        echo bbp_get_topic_tag_list_tp( $topic_id, $args );
    }
    /**
     * Return the tags of a topic
     *
     * @param int $topic_id Optional. Topic id
     * @param array $args This function supports these arguments:
     *  - before: Before the tag list
     *  - sep: Tag separator
     *  - after: After the tag list
     * @uses bbp_get_topic_id() To get the topic id
     * @uses get_the_term_list() To get the tags list
     * @return string Tag list of the topic
     */
    function bbp_get_topic_tag_list_tp( $topic_id = 0, $args = '' ) {

        // Bail if topic-tags are off
        if ( ! bbp_allow_topic_tags() )
            return;

        // Parse arguments against default values
        $r = bbp_parse_args( $args, array(
            'before' => '<div class="tag-list">',
            'sep'    => ', ',
            'after'  => '</div>'
        ), 'get_topic_tag_list' );

        $topic_id = bbp_get_topic_id( $topic_id );

        // Topic is spammed, so display pre-spam terms
        if ( bbp_is_topic_spam( $topic_id ) ) {

            // Get pre-spam terms
            $terms = get_post_meta( $topic_id, '_bbp_spam_topic_tags', true );

            // If terms exist, explode them and compile the return value
            if ( !empty( $terms ) ) {
                $terms  = implode( $r['sep'], $terms );
                $retval = $r['before'] . $terms . $r['after'];

                // No terms so return emty string
            } else {
                $retval = '';
            }

            // Topic is not spam so display a clickable term list
        } else {
            $retval = get_the_term_list( $topic_id, bbp_get_topic_tag_tax_id(), $r['before'], $r['sep'], $r['after'] );
        }

        return $retval;
    }

    function list_comment_filters()
    {
        global $wp_filter;

        $comment_filters = array ();
        $h1  = '<h1>Current Comment Filters</h1>';
        $out = '';
        $toc = '<ul>';

        foreach ( $wp_filter as $key => $val )
        {
            if ( FALSE !== strpos( $key, 'menu' ) )
            {
                $comment_filters[$key][] = var_export( $val, TRUE );
            }
        }

        foreach ( $comment_filters as $name => $arr_vals )
        {
            $out .= "<h2 id=$name>$name</h2><pre>" . implode( "\n\n", $arr_vals ) . '</pre>';
            $toc .= "<li><a href='#$name'>$name</a></li>";
        }

        print "$h1$toc</ul>$out";
    }

    //add_action( 'wp_head', 'list_comment_filters' );
    //add_action('init', 'save_song');

    /*function save_song()
    {
        if ('post' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action'])) {
            if (!isset($_POST['new_song_nonce'])) {
                return;
            }
            if (!isset($_POST['song_title'])) {
                echo "Enter a title";
                return;
            }
            if (!isset($_POST['song_desc'])) {
                return;
            }

            $post_array = array(
                'post_title' => $_POST['song_title'],
                'post_content' => $_POST['song_desc'],
                'post_type' => 'fav_songs'
            );

            $post_id = wp_insert_post($post_array);
            update_post_meta($post_id, '_song_artist_name', $_POST['song_artist']);

            $url = "/add-song";
            wp_redirect($url);
            exit();
        }
    }*/

    add_action( 'init', 'create_user_story_tax' );

    function create_user_story_tax() {

        /* Create Story Type Taxonomy */
        $args = array(
            'label' => __( 'Story Type' ),
            'rewrite' => array( 'slug' => 'story-type' ),
            'hierarchical' => true,
        );

        register_taxonomy( 'story-type', 'user_story', $args );
        register_taxonomy( 'story-type', 'travelog', $args );
    }

    add_action('init', 'travelog_thumbnail_support');

    function travelog_thumbnail_support() {
        add_post_type_support('travelog', 'thumbnail');
    }

    add_theme_support( 'post-thumbnails');

    //Restrict content


    /*add_action('init', 'restrict_page_shortcode');

    function restrict_page_shortcode() {
        add_shortcode('authorized', 'restrict_page_content');
    }*/

    function content_restricted ($msg = 'You must login to see this content.') {
        if(!is_user_logged_in()) {
            $defaults = array(
                // message show to non-logged in users
                'msg'    => __($msg, 'tourplan'),
                // Login page link
                'link'   => site_url('wp-login.php'),
                // login link anchor text
                'anchor' => __('Login.', 'tourplan')
            );
            $args = wp_parse_args($defaults);

            $msg = sprintf(
                '<aside class="login-warning">%s <a href="%s">%s</a></aside>',
                esc_html($args['msg']),
                esc_url($args['link']),
                esc_html($args['anchor'])
            );

            echo $defaults['msg'];
            //Create login form arguments
            $args = array(
                'echo' => true,
                'form_id' => 'loginform',
                'label_username' => __('Login Username'),
                'label_password' => __('Login Password'),
                'label_remember' => __('Remember me on this computer'),
                'label_log_in' => 'Log In',
                'id_username' => 'txt_login_username',
                'id_password' => 'txt_login_password',
                'id_remember' => 'chk_remember_me',
                'id_submit' => 'btn_login_submit',
                'remember' => true,
                'value_username' => NULL,
                'value_remember' => false,

                'username_required' => true,
                'username_maxlength' => '30',
                'username_css_class' => 'form-control',
                'username_placeholder_text' => __('Username'),

                'password_required' => true,
                'password_maxlength' => '30',
                'password_css_class' => 'form-control',
                'password_placeholder_text' => __('Password'),

                'render_input_size' => false,
                'input_size' => 40,

                'default_form_width' => '50'
            );

            //$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $login_args ) );

            wp_login_form($args);
            return true;
        }

        return false;
    }

    /*add_action('wp_loaded', 'redirect_after_travelog_add');

    function redirect_after_travelog_add() {
        if(isset($_POST['travelog_submit'])) {
            $redirect = '/about/';
            wp_redirect($redirect);
            exit;
        }
    }*/
    function get_breadcrumb() {
        echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
        if (is_category() || is_single()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
            the_category(' &bull; ');
            if (is_single()) {
                echo " &nbsp;&nbsp;&#187;&nbsp;&nbsp; ";
                the_title();
            }
        } elseif (is_page()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;";
            echo the_title();
        } elseif (is_search()) {
            echo "&nbsp;&nbsp;&#187;&nbsp;&nbsp;Search Results for... ";
            echo '"<em>';
            echo the_search_query();
            echo '</em>"';
        }
    }

    //We also set a custom size of 55 pixels that will be used to show the featured image's preview:
    add_image_size('featured_preview', 55, 55, true);

    // GET FEATURED IMAGE
    function _get_featured_image($post_ID) {
        $post_thumbnail_id = get_post_thumbnail_id($post_ID);
        if ($post_thumbnail_id) {
            $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
            return $post_thumbnail_img[0];
        }
    }

    // ADD NEW COLUMN
    function _columns_head($defaults) {
        $defaults['featured_image'] = 'Featured Image';
        //Add more columns with $default['column-name'] = 'Column Name';
        return $defaults;
    }

    // SHOW THE FEATURED IMAGE
    function _columns_content($column_name, $post_ID) {
        if ($column_name == 'featured_image') {
            $post_featured_image = _get_featured_image($post_ID);
            if ($post_featured_image) {
                //Has a featured image
                echo '<img style="width:30%;" src="' . $post_featured_image . '" />';
            } else {
                //No featured image present. Show default
                //echo '<img style="width:20%;" src="' . get_bloginfo( 'template_url' ) . '/images/default.png" />';
                echo 'No featured image';
            }
        }
    }

    add_filter('manage_posts_columns', '_columns_head');
    add_action('manage_posts_custom_column', '_columns_content', 10, 2);

    //Conditional logic for showing menu items based on whether user is logged in or not!
    function conditional_menu_item($args = '') {
        if(is_user_logged_in()) {
            $menu = wp_get_nav_menu_items('main-menu');
            if(!$menu) {
                //echo "No menu defined";
            }
        }
    }

    //add_filter('wp_nav_menu_args', 'conditional_menu_item');

    add_action('wp_head','hide_menu_item');

    function hide_menu_item() {
        if ( !is_user_logged_in() ) {
            //
        } else {
            $output="<style> .navbar-nav li:nth-child(9) { display: none; } </style>";
        }
        echo $output;
    }

    //PHP code enabled widget_text
    add_filter('widget_text','execute_php',100);
    function execute_php($html){
        if(strpos($html,"<"."?php")!==false){
            ob_start();
            eval("?".">".$html);
            $html=ob_get_contents();
            ob_end_clean();
        }
        return $html;
    }

    //Changing Featured Image box title by CPT
    //add_action( 'admin_head', 'update_hotel_featured_image_metabox_title', 100 );
    function update_hotel_featured_image_metabox_title() {
        remove_meta_box( 'postimagediv', 'hotel-info', 'side' );
        add_meta_box('postimagediv', __('Main Photo of the Hotel'), 'post_thumbnail_meta_box', 'hotel-info', 'side', 'high');
    }

    function br2nl($input) {
        return preg_replace('/<br(\s+)?\/?>/i', "\n", $input);
    }

    //Inclusion of CPT in search result
    add_filter( 'pre_get_posts', 'cpt_search' );

    /**
     * This function modifies the main WordPress query to include an array of
     * post types instead of the default 'post' post type.
     *
     * @param object $query The original query.
     * @return object $query The amended query.
     */
    function cpt_search( $query ) {
        if ( $query->is_search ) {
            $query->set( 'post_type', array( 'post', 'travelog', 'hotel-info', 'trips', 'package_tour' ) );
        }
        return $query;
    }

    /* Not working. Need to look into it more.. */
    if (!function_exists('get_archive_link')) {
        function get_archive_link( $post_type ) {
            global $wp_post_types;
            $archive_link = false;
            if (isset($wp_post_types[$post_type])) {
                $wp_post_type = $wp_post_types[$post_type];
                if ($wp_post_type->publicly_queryable) {
                    if ($wp_post_type->has_archive && $wp_post_type->has_archive !== true)
                        $slug = $wp_post_type->has_archive;
                    else if (isset($wp_post_type->rewrite['slug']))
                        $slug = $wp_post_type->rewrite['slug'];
                    else
                        $slug = $post_type;
                }
                $archive_link = get_option( 'siteurl' ) . "/{$slug}/";
            }
            
            return apply_filters( 'archive_link', $archive_link, $post_type );
        }
    }

    /* Sort search result by custom post types' order */
    add_filter( 'the_posts', function( $posts, $q )
    {
        if( $q->is_main_query() && $q->is_search() )
        {
            usort( $posts, function( $a, $b ){
                /**
                 * Sort by post type. If the post type between two posts are the same
                 * sort by post date. Make sure you change your post types according to
                 * your specific post types. This is my post types on my test site
                 */
                $post_types = [
                    'product' => 1,
                    'trips' => 2,
                    'package_tour' => 3,
                    'hotel-info' => 4,
                    'travelog' => 5,
                ];
                if ( $post_types[$a->post_type] != $post_types[$b->post_type] ) {
                    return $post_types[$a->post_type] - $post_types[$b->post_type];
                } else {
                    return $a->post_date < $b->post_date; // Change to > if you need oldest posts first
                }
            });
        }
        return $posts;
    }, 10, 2 );

    /* Declare Woocommerce Support */
    add_action( 'after_setup_theme', 'woocommerce_support' );
    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    /* Learn more about action_hooks, add_action, add_filter, apply_filter, do_action

    /* Modify woocommerce_before_main_content hook to match theme structure */

    add_action('woocommerce_before_main_content', 'tp_product_page_container_open', 5);

    function tp_product_page_container_open() {
        echo '<div class="container">';
    }

    /* Modify woocommerce_after_main_content hook to match theme structure */

    add_action('woocommerce_after_main_content', 'tp_product_page_container_close', 50);

    function tp_product_page_container_close() {
        echo '</div>';
    }


    /*
    add_action('init', 'include_product_in_search');

    function include_product_in_search() {
        global $wp_post_types;

        $wp_post_types['attachment']->exclude_from_search = false;
    }
    */

    //test: https://core.trac.wordpress.org/ticket/40474
    add_action('wp_ajax_save-attachment', function($array, $int) {
        var_dump('save-attachment');
    }, 10, 2);

    add_action('init', 'travelg_post_type_rest_support_add', 25);

    function travelg_post_type_rest_support_add() {
        global $wp_post_types;

        $post_type_name = 'trips';
        if(isset($wp_post_types[$post_type_name])) {
            $wp_post_types[$post_type_name]->show_in_rest = true;
            $wp_post_types[$post_type_name]->rest_base = 'api/trips';
            $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
        }
    }

    /* Learning about Hooks (Actions and Filters) */

    /* Creating own ACTION HOOK and tying multiple functions to it */

    //Syntax: add_action($tag, $function_to_add, 10, 1)
    // 10 = priority (default), 1 = number of paramters function would accept. If none is defined the function will either accept none
    // or the default number of parameters available

    add_action('tourplan_trip_intro', 'tourplan_get_trip_intro', 10, 1);

    function tourplan_get_trip_intro($post_id) {
        $post_type = get_post_type();
        $intro = get_post_meta($post_id, 'introduction', true);
        if(is_single()) { //If we are on a single-* page we print meta value of the post
            if($post_type == 'trips') {
                //echo "<p class='text-small margin-top-10 bg-gray-light pad-10 border-gray-dark'>" . $intro . "</p>";
                do_action('tourplan_custom_excerpt_page_anchor', 40, 'storyline');
            }
        } else { //print customized content excerpt
            echo excerpt(25);
        }
    }

    add_action('tourplan_custom_excerpt_page_anchor', 'custom_excerpt_page_anchor', 10, 2);

    function custom_excerpt_page_anchor($limit, $anchor) {
        $excerpt = explode(' ', get_the_excerpt(), $limit);
        if(count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(' ', $excerpt) . '...';
        } else {
            $excerpt = implode(' ', $excerpt);
        } ?>

        <div class="row">
            <div class="col-md-1"><div class="margin-top-20"></div><span class="fa fa-link text-larger text-gray"></span></div>
            <div class="col-md-11">
                <div class="text-small margin-top-10 margin-bottom-10">
                    <a class="text-gray storyline-anchor" href="#<?php echo $anchor ?>"><?php echo $excerpt ?></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php }

?>