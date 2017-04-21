<?php bbp_breadcrumb(); ?>
<?php //bbp_forum_subscription_link(); ?>

<div class="row">
    <div class="col-md-6">
        <?php //bbp_single_forum_description(); ?>
        <?php bbp_get_template_part( 'loop', 'forums' ); ?>
    </div>
    <div class="clearfix"></div>
</div>


<?php if ( post_password_required() ) : ?>

    <?php bbp_get_template_part( 'form', 'protected' ); ?>

<?php else : ?>



    <?php if ( bbp_has_forums() ) : ?>



    <?php endif; ?>

    <?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

        <?php bbp_get_template_part( 'loop',       'topics'    ); ?>


        <?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

        <div class="bg-gray-light pad-10 border-gray">
        <?php //bbp_get_template_part( 'form',       'topic'     ); ?>
        </div>

    <?php elseif ( !bbp_is_forum_category() ) : ?>

        <?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>


        <?php //bbp_get_template_part( 'form',       'topic'     ); ?>


    <?php endif; ?>

<?php endif; ?>

<?php do_action( 'bbp_template_after_single_forum' ); ?>
