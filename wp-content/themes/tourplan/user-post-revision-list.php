<?php
    /*
     * Template Name: Revision List
     */
?>

<?php
    get_header();
    $userid = get_current_user_id();
    echo $userid;

    $query = new WP_Query(
        array(
            'author' => 6,
            'post_type' => array('topic', 'travelog'),
            'post_status' => array('publish', 'inherit'),
            'meta_key' => '_travelog_year_visited',
            'meta_value' => '20',
            'meta_compare' => 'LIKE'
        )
    );

    /*$query = new WP_Query(
        array(
            'post_type' => array('trips'),
            'meta_key' => 'display_on_hompage',
            'meta_value' => 'Yes',
            'posts_per_page' => 9,
            'paged' => $currentPage
        )
    );*/

    echo $query->request . '<br /><br />';

    if($query->have_posts()) {
        while($query->have_posts()) : $query->the_post();
            $author=get_the_author($post->ID);
            echo wp_sprintf('%s: %s', __($author), the_title());
            echo '<br />';
            //echo get_the_author($post->ID) . ' -> ' . the_title() . '<br />';
        endwhile;
    }

    get_footer();
?>