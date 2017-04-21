<?php while ( bbp_forums() ) : bbp_the_forum(); ?>
    <div class="col-md-12 bg-white pad-10 border-gray margin-bottom-10">
        <?php bbp_get_template_part( 'loop', 'single-forum' ); ?>
    </div>
<?php endwhile; ?>
<div class="clearfix"></div>

    