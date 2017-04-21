<?php
/*
Plugin Name: Forum or Topic overview
Description: Shows an overview (in sidebar) for current Forum or Topic
Version: 1.0
Author: Subrata Sarkar
Author URI: http://emfluence.com
*/

class tp_forum_or_topic_overview extends WP_Widget {
    function __construct()
    {
        parent::__construct(false, $name = __("Forum or Topic Overview", "tourplan"));
    }

    function form()
    {

    }

    function update() {

    }

    function widget($args, $instance)
    {
        $topic_id = bbp_get_topic_id();

        if($topic_id > 0){ ?>
            <div class="bg-white pad-10 border-gray margin-top-10">
                <h3 class='roboto-c module-head text-medium'>Topic Overview</h3><hr class='hr-whitebase'/>
                <div class="text-small">
                    <div class="row">
                        <div class="col-md-3">
                            Creator:
                        </div>
                        <div class="col-md-9">
                            <a href="<?php bbp_topic_author_url(); ?>"><?php bbp_topic_author_display_name($topic_id); ?></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            Tags:
                        </div>
                        <div class="col-md-9">
                            <?php bbp_topic_tag_list_tp(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            Voices:
                        </div>
                        <div class="col-md-9">
                            <?php echo bbp_get_topic_voice_count ($topic_id); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            Replies:
                        </div>
                        <div class="col-md-9">
                            <?php echo bbp_get_topic_replies_link($topic_id); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            Latest:
                        </div>
                        <div class="col-md-9">
                            <?php echo bbp_get_topic_freshness_link($topic_id); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row margin-top-10">
                        <div class="col-md-3">
                            By:
                        </div>
                        <div class="col-md-9">
                            <?php
                                $last_reply_id = bbp_get_topic_last_reply_id();
                                $last_reply_author_display_name = bbp_get_reply_author_display_name($last_reply_id);
                            ?>
                            <a href="<?php echo bbp_get_reply_author_url($last_reply_id); ?>"><?php echo $last_reply_author_display_name ?></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}

add_action("widgets_init", function() {
    register_widget("tp_forum_or_topic_overview");
});

?>