<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="row margin-top-10">
    <div class="bg-hay pad-10">
        <div class="col-md-8 text-small text-white">
            <?php bbp_reply_post_date(); ?>
        </div>
        <div class="col-md-4 text-right">
            <?php echo bbp_reply_admin_url_tp(); ?>
            <a title="Permalink" class="inline-link btn btn-default text-small-button" href="<?php bbp_reply_permalink(); ?>#post-<?php bbp_reply_id(); ?>">#<?php bbp_reply_id(); ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row margin-bottom-5">
    <div class="pad-10 bg-white border-hay border-notop">
        <div class="col-md-2 text-center text-small">
            <a class="bare-link thumbnail-wrapper" href="<?php bbp_reply_author_url(); ?>" title="<?php bbp_reply_author_display_name() ?>"><?php bbp_reply_author_avatar(); ?></a>
            <a class="bare-link" href="<?php bbp_reply_author_url(); ?>"><?php bbp_reply_author_display_name(); ?></a>
            <?php echo bbp_reply_author_role_name(); ?>
            <?php if ( bbp_is_user_keymaster() ) : ?>
                <div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>
            <?php endif; ?>
        </div>
        <div class="col-md-10 text-small">
            <?php bbp_reply_content(); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div id="post-<?php bbp_reply_id(); ?>" class="bbp-reply-header hidden">

    <div class="bbp-meta">

        <span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>

        <?php if ( bbp_is_single_user_replies() ) : ?>

            <span class="bbp-header">
				<?php _e( 'in reply to: ', 'bbpress' ); ?>
                <a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a>
			</span>

        <?php endif; ?>

        <a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>

        <?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

        <?php bbp_reply_admin_links(); ?>

        <?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>

    </div><!-- .bbp-meta -->

</div><!-- #post-<?php bbp_reply_id(); ?> -->

<div <?php bbp_reply_class(); ?> style="display: none;">

    <div class="bbp-reply-author">

        <?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

        <?php bbp_reply_author_link( array( 'sep' => '<br />', 'show_role' => true ) ); ?>

        <?php if ( bbp_is_user_keymaster() ) : ?>

            <?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

            <div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id() ); ?></div>

            <?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

        <?php endif; ?>

        <?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

    </div><!-- .bbp-reply-author -->

    <div class="bbp-reply-content">

        <?php do_action( 'bbp_theme_before_reply_content' ); ?>

        <?php bbp_reply_content(); ?>

        <?php do_action( 'bbp_theme_after_reply_content' ); ?>

    </div><!-- .bbp-reply-content -->

</div><!-- .reply -->
