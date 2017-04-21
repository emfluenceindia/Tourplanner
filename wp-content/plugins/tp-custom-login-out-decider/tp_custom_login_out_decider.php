<?php
/*
Plugin name: User login status checker
Description: Determines user's current logged-in status and displays relevant custom designed contents
Version: 1.0
Author: Subrara Sarkar
Plugin URI: http://emfluence.com
*/

class tp_custom_login_out_decider extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __('User Login Status Checker'));
    }

    function form() {

    }

    function update() {

    }

    function widget($args, $instance) {
        if(is_user_logged_in()){
            global $current_user; ?>
            <div class="row">
                <div class="col-md-4">
                    <?php
                        //echo get_currentuserinfo(); - depricated
                        echo get_avatar( $current_user->ID );
                    ?>
                </div>
                <div class="col-md-8 text-small">
                    <b class="module-head"><?php echo bbp_get_current_user_name(); ?></b>
                    <ul class="user-action-links">
                        <li><a href="/create-travelog/" title="Publish a trip report">Create a Travelog</a></li>
                        <li><a href="/create-travelog/" title="My Travelogs">My Travelogs</a></li>
                        <li>
                            <?php $forum_id = bbp_get_forum_id();
                            if($forum_id == 0) { ?>
                                <a href="/new-topic/" title="Create New Topic">Create New Topic</a>
                            <?php } else { ?>
                                <a href="/new-topic/?f=<?php echo bbp_get_forum_id(); ?>" title="Create New Topic">Create New Topic</a>
                            <?php } ?>
                        </li>
                        <li><a href="<?php echo bbp_user_profile_url($current_user->ID); ?>">Profile</a></li>
                        <li><a href="<?php echo bbp_user_profile_edit_url($current_user->ID); ?>">Edit Profile</a></li>
                        <li><a href="<?php echo wp_logout_url(); ?>">Log Out</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        <?php
        }
        else{
            //echo "No user is logged in yet!";
            echo "<h3 class='roboto-c module-head text-medium'>Login</h3><div class='margin-top-10'></div>";
            wp_login_form();
        }
    }
}

add_action("widgets_init", function(){
    register_widget('tp_custom_login_out_decider');
});

?>