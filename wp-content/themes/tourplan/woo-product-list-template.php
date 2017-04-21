<?php
/*
 * Template Name: Product List Template
 * Description: Template file to hold product list shortcode
 * Version: 1.0
 */
?>

<?php get_header(); ?>
<div class="container">
    <h3 class="text-large roboto-c module-head">Products</h3>
    <hr />
    <?php echo do_shortcode('[woo_products_by_tags]'); ?>
</div>
<?php get_footer(); ?>