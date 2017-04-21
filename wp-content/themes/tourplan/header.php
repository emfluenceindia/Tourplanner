<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <head>
        <meta name="viewport" content="width=device-width">
        <title><?php bloginfo('name') ?></title>
        <script src="//code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB69TTtConBHxaqoFAPCrX1U3ysPBhlfio"></script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="container-fluid">
            <header>
                <div class="row">
                    <div class="col-md-9 visible-lg visible-md hidden-sm hidden-xs">
                        <h1 class="site_name"><a class="tangerine" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
                        <h3 class="text-small text-green-dark"><?php bloginfo('description'); ?></h3>
                    </div>
                    <div class="col-md-3">
                        <div class="margin-top-20"><!--spacer--></div><?php get_search_form(); ?>
                        <div class="margin-top-20"><!--spacer--></div><?php //get_product_search_form(); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </header>
        </div>
        <div class="nav-container">
            <nav class="navbar navbar-default navbar-tourplan">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand text-white text-largest tangerine visible-xs visible-sm hidden-lg hidden-md" href="/">
                            Dream Destinations</a>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container' => false,
                        'menu_class' => 'nav navbar-nav'
                    )); ?>
                </div>
            </nav>
        </div>
        