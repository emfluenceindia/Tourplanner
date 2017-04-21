<?php
/*
 * Plugin Name: WooCommerce - List Products by Tags
 * Description: List WooCommerce products by tags using a shortcode, ex: [woo_products_by_tags tags="shoes,socks"]
 * Version: 1.0
 * Author: Remi Corson
 */

function woo_products_by_tags_shortcode($atts, $content = null) {
// Get attribuets
    extract(shortcode_atts(array(
        "tags" => ''
    ), $atts));

    ob_start();
    // Define Query Arguments
    $args = array(
        'post_type' 	 => 'product',
        'posts_per_page' => 30,
        'product_tag' 	 => $tags
    );

    // Create the new query
    $loop = new WP_Query( $args );

    // Get products number
    $product_count = $loop->post_count;

    // If results
    if( $product_count > 0 ) : ?>
        <div class="clearfix"></div>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); global $product;
            global $post; ?>
            <div class="row">
                <div class="col-md-2 image-deco">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                        <?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
                    </a>
                </div>
                <div class="col-md-10">
                    <a class="text-large" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php  the_title();?></a>
                    <div class="margin-top-10 text-small">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="margin-top-10 text-medium text-gray">
                        Price: <?php echo $product->get_price_html(); ?>
                    </div>
                    <div class="margin-top-10 text-small bold">
                        <a class="btn btn-success text-small" href="<?php  the_permalink(); ?>" title="<?php the_title(); ?>">Product Detail &raquo;</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <hr />
        <?php endwhile; ?>
    <?php else :

        _e('No product matching your criteria.');

    endif; // endif $product_count > 0

    return ob_get_clean();
}

add_shortcode("woo_products_by_tags", "woo_products_by_tags_shortcode");

?>
