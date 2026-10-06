<?php

define('LUMEA_VERSION', '1.0.0');

function lumea_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'lumea'),
        'footer'  => __('Footer Menu', 'lumea'),
    ]);
}
add_action('after_setup_theme', 'lumea_setup');

function lumea_scripts() {
    wp_enqueue_style('lumea-main', get_template_directory_uri() . '/assets/css/main.css', [], LUMEA_VERSION);
    wp_enqueue_script('lumea-main', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], LUMEA_VERSION, true);

    wp_localize_script('lumea-main', 'lumea_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('lumea_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'lumea_scripts');

function lumea_widgets_init() {
    register_sidebar([
        'name'          => __('Shop Sidebar', 'lumea'),
        'id'            => 'shop-sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget__title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'lumea_widgets_init');

// Remove WooCommerce default styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Change WooCommerce products per page
add_filter('loop_shop_per_page', fn() => 12);

// Add WooCommerce product count badge to cart icon
add_filter('woocommerce_add_to_cart_fragments', function($fragments) {
    ob_start();
    ?>
    <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    return $fragments;
});
