<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <?php //the_title( '<h1 class="text-large module-head roboto-c">', '</h1><hr />' ); ?>
            <?php
                if(is_bbpress()){ ?>
                    <div class="row">
                        <div class="col-md-9">
                            <h1 class="text-large module-head roboto-c"><?php the_title(); ?></h1>
                        </div>
                        <div class="col-md-2">
                            <?php
                                //echo get_post_type();
                                $forum_id = bbp_get_forum_id();
                                $topic_id = bbp_get_topic_id();
                                if($forum_id == 0) { ?>
                                    <a href="/new-topic/" class="btn btn-primary text-small" title="Create New Topic">Create New Topic</a>
                                <?php } else { ?>
                                    <a href="/new-topic/?f=<?php echo bbp_get_forum_id(); ?>" class="btn btn-primary text-small" title="Create New Topic">Create New Topic</a>
                                <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr />
                <?php } else{
                    echo the_title( '<h1 class="text-large module-head roboto-c">', '</h1><hr />' );
                }
            ?>
            <?php
            the_content();
            wp_link_pages( array(
                'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
                'after'  => '</div>',
            ) );
            ?>
        </div>
        <div class="col-md-3">
            <?php
                if (is_active_sidebar('site-user-login')) { ?>
                    <div class="bg-white border-gray pad-10">
                        <?php dynamic_sidebar('site-user-login'); ?>
                    </div>
                    <?php
                }

                if(is_bbpress()){
                    if(is_active_sidebar('forum-topic-sidebar')){
                        dynamic_sidebar('forum-topic-sidebar');
                    }
                }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
