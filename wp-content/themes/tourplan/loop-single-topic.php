<?php

/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="forum-topic-row box border-gray bg-gray-lighter">
    <div class="col-md-1 text-center">
        <div class="margin-top-5"></div>
        <a title="<?php bbp_topic_author_display_name(); ?>" href="<?php bbp_topic_author_url(); ?>">
            <?php echo bbp_topic_author_avatar(); ?><br>
            <?php //bbp_topic_author_display_name(); ?>
        </a>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-9">
        <a class="text-medium roboto-c" title="<?php bbp_topic_title(); ?>" href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
        <p class="text-small"><?php echo bbp_topic_excerpt(); ?></p>
        <div class="text-small">
            <b>Voices:</b> <?php bbp_topic_voice_count(); ?>.
            <b>Posts:</b> <?php bbp_show_lead_topic() ? bbp_topic_reply_count() : bbp_topic_post_count(); ?>.
            <b>Last activity:</b> <?php bbp_topic_last_active_time(); ?> by <a href="<?php bbp_topic_author_url(); ?>"><?php bbp_topic_author_display_name(); ?></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="col-md-2 text-right">
        <div class="margin-top-30"></div>
        <a href="<?php bbp_topic_permalink(); ?>" class="btn btn-primary text-small">Discuss &raquo;</a>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- End of single topic -->

<!-- DO NOT DELETE NOW -->

<ul id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>

    <li class="bbp-topic-title">

        <?php if ( bbp_is_user_home() ) : ?>

            <?php if ( bbp_is_favorites() ) : ?>

                <span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

                    <?php bbp_topic_favorite_link( array( 'before' => '', 'favorite' => '+', 'favorited' => '&times;' ) ); ?>

                    <?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

            <?php elseif ( bbp_is_subscriptions() ) : ?>

                <span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

                    <?php bbp_topic_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

                    <?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

            <?php endif; ?>

        <?php endif; ?>

        <?php do_action( 'bbp_theme_before_topic_title' ); ?>

        <!-- Topic link -->

        <?php do_action( 'bbp_theme_after_topic_title' ); ?>

        <?php bbp_topic_pagination(); ?>

        <?php do_action( 'bbp_theme_before_topic_meta' ); ?>

        <p class="bbp-topic-meta">

            <?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

            <span class="bbp-topic-started-by"><!-- Author link --></span>

            <?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

            <?php if ( !bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

                <?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

                <span class="bbp-topic-started-in"><?php printf( __( 'in: <a href="%1$s">%2$s</a>', 'bbpress' ), bbp_get_forum_permalink( bbp_get_topic_forum_id() ), bbp_get_forum_title( bbp_get_topic_forum_id() ) ); ?></span>

                <?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

            <?php endif; ?>

        </p>

        <?php do_action( 'bbp_theme_after_topic_meta' ); ?>

        <?php bbp_topic_row_actions(); ?>

    </li>

    <li class="bbp-topic-voice-count"><!-- Voice Count --></li>

    <li class="bbp-topic-reply-count"><!-- Lead Count --></li>

    <li class="bbp-topic-freshness">

        <?php do_action( 'bbp_theme_before_topic_freshness_link' ); ?>

        <!-- Freshness Link -->

        <?php do_action( 'bbp_theme_after_topic_freshness_link' ); ?>

        <p class="bbp-topic-meta">

            <?php do_action( 'bbp_theme_before_topic_freshness_author' ); ?>

            <span class="bbp-topic-freshness-author"><!-- Author Link --></span>

            <?php do_action( 'bbp_theme_after_topic_freshness_author' ); ?>

        </p>
    </li>

</ul><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
<div class="clearfix"></div>