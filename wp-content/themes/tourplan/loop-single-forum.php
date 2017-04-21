<div class="row">
    <div class="col-md-9"><a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></div>
    <div class="col-md-3 text-right text-small"><?php bbp_forum_freshness_link(); ?></div>
    <div class="clearfix"></div>
</div>
<hr class="hr-white-base" />
<p class="text-small text-gray"><?php bbp_forum_content(); ?></p>
<div class="row">
    <div class="col-md-7 text-small text-gray-dark">
        <b>Topics:</b> <?php bbp_forum_topic_count(); ?>. <b>Replies:</b> <?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="row margin-top-10">
    <div class="col-md-12 text-right">
        <a class="btn btn-primary text-small" href="<?php bbp_forum_permalink(); ?>">Create or View topics &raquo;</a>
    </div>
    <div class="clearfix"></div>
</div>
