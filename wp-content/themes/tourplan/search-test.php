<?php
/*
 * Template Name: Test Product Search
 */

/*$args = array(
    'post_type' => array('product', 'trips', 'travelog'),
    //'meta_key' => 'display_on_hompage',
    //'meta_value' => 'Yes',
    's' => 'htc',
    'posts_per_page' => 6);
*/

$q = new WP_Query(array(
    'post_type' => array('product'),
    'posts_per_page' => 8,
    's' => 'htc'
));

echo $q->request;
echo '<hr />';

//$p = $q->get_posts();

if($q->have_posts()) {
    while ($q->have_posts()) : the_post();
        $q->the_post();
        echo the_title() . '<br />';
    endwhile;
}

wp_reset_postdata();

?>