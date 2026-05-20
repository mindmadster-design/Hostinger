<?php
/**
 * SILIQ Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('SILIQ_VERSION', '1.0.0');
define('SILIQ_DIR', get_template_directory());
define('SILIQ_URI', get_template_directory_uri());

/* ============================================================
   1) Theme Setup
============================================================ */
function siliq_setup() {
    // Title tag support
    add_theme_support('title-tag');

    // Post thumbnails
    add_theme_support('post-thumbnails');

    // Custom logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // HTML5 support
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary'    => __('Primary Navigation', 'siliq'),
        'mobile'     => __('Mobile Navigation', 'siliq'),
        'footer-shop'    => __('Footer - Shop', 'siliq'),
        'footer-house'   => __('Footer - House', 'siliq'),
        'footer-care'    => __('Footer - Care', 'siliq'),
        'footer-follow'  => __('Footer - Follow', 'siliq'),
    ));

    // Image sizes
    add_image_size('siliq-hero', 2000, 1200, true);
    add_image_size('siliq-product', 900, 1125, true);
    add_image_size('siliq-product-thumb', 400, 500, true);
    add_image_size('siliq-collection', 900, 1125, true);
}
add_action('after_setup_theme', 'siliq_setup');

/* ============================================================
   2) Enqueue Styles & Scripts
============================================================ */
function siliq_scripts() {
    // Google Fonts
    wp_enqueue_style('siliq-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&family=Italiana&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('siliq-main', SILIQ_URI . '/assets/css/main.css', array(), SILIQ_VERSION);

    // Theme stylesheet (required by WP)
    wp_enqueue_style('siliq-style', get_stylesheet_uri(), array('siliq-main'), SILIQ_VERSION);

    // Vendor scripts
    wp_enqueue_script('lenis', 'https://unpkg.com/lenis@1.1.20/dist/lenis.min.js', array(), '1.1.20', true);
    wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);
    wp_enqueue_script('split-type', 'https://unpkg.com/split-type@0.3.4/umd/index.min.js', array(), '0.3.4', true);

    // Main JS
    wp_enqueue_script('siliq-main', SILIQ_URI . '/assets/js/main.js', array('lenis', 'gsap', 'gsap-scrolltrigger', 'split-type'), SILIQ_VERSION, true);

    // Pass WooCommerce data to JS
    wp_localize_script('siliq-main', 'siliqData', array(
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('siliq_nonce'),
        'cartUrl'  => wc_get_cart_url(),
        'shopUrl'  => wc_get_page_permalink('shop'),
    ));
}
add_action('wp_enqueue_scripts', 'siliq_scripts');

/* ============================================================
   3) WooCommerce Customizations
============================================================ */

// Remove default WooCommerce wrappers
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function siliq_wc_wrapper_start() {
    echo '<main class="woocommerce-content">';
}
function siliq_wc_wrapper_end() {
    echo '</main>';
}
add_action('woocommerce_before_main_content', 'siliq_wc_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'siliq_wc_wrapper_end', 10);

// Remove default WooCommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Change products per page
function siliq_products_per_page($cols) {
    return 12;
}
add_filter('loop_shop_per_page', 'siliq_products_per_page');

// Change product columns
function siliq_loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'siliq_loop_columns');

// Cart count AJAX fragment
function siliq_cart_count_fragment($fragments) {
    $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'siliq_cart_count_fragment');

/* ============================================================
   4) Widgets
============================================================ */
function siliq_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Newsletter', 'siliq'),
        'id'            => 'footer-newsletter',
        'description'   => __('Newsletter signup area in footer', 'siliq'),
        'before_widget' => '<div class="newsletter">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'siliq_widgets_init');

/* ============================================================
   5) Customizer Settings
============================================================ */
function siliq_customizer($wp_customize) {
    // Announcement Bar
    $wp_customize->add_section('siliq_announcement', array(
        'title'    => __('Announcement Bar', 'siliq'),
        'priority' => 30,
    ));
    $wp_customize->add_setting('announcement_text_1', array(
        'default'           => 'Complimentary Shipping On Orders Over $150',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('announcement_text_1', array(
        'label'   => __('Announcement Text 1', 'siliq'),
        'section' => 'siliq_announcement',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('announcement_text_2', array(
        'default'           => 'Handcrafted In Limited Editions',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('announcement_text_2', array(
        'label'   => __('Announcement Text 2', 'siliq'),
        'section' => 'siliq_announcement',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('announcement_text_3', array(
        'default'           => 'Lifetime Repair Service',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('announcement_text_3', array(
        'label'   => __('Announcement Text 3', 'siliq'),
        'section' => 'siliq_announcement',
        'type'    => 'text',
    ));

    // Hero Section
    $wp_customize->add_section('siliq_hero', array(
        'title'    => __('Homepage Hero', 'siliq'),
        'priority' => 35,
    ));
    $wp_customize->add_setting('hero_eyebrow', array(
        'default'           => 'A Quiet Devotion To Craft — Since The First Sketch',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_eyebrow', array(
        'label'   => __('Hero Eyebrow Text', 'siliq'),
        'section' => 'siliq_hero',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Silver, <em>refined</em> into heirloom.',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title (HTML allowed)', 'siliq'),
        'section' => 'siliq_hero',
        'type'    => 'textarea',
    ));
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => '925 sterling silver, slowly handcrafted in limited editions.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'siliq'),
        'section' => 'siliq_hero',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_image', array(
        'label'   => __('Hero Background Image', 'siliq'),
        'section' => 'siliq_hero',
    )));
    $wp_customize->add_setting('hero_cta_text', array(
        'default'           => 'Discover The Collection',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_text', array(
        'label'   => __('Hero CTA Button Text', 'siliq'),
        'section' => 'siliq_hero',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('hero_cta_url', array(
        'default'           => '/shop',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_url', array(
        'label'   => __('Hero CTA Button URL', 'siliq'),
        'section' => 'siliq_hero',
        'type'    => 'url',
    ));

    // Brand Info
    $wp_customize->add_section('siliq_brand', array(
        'title'    => __('Brand Info', 'siliq'),
        'priority' => 40,
    ));
    $wp_customize->add_setting('brand_tagline', array(
        'default'           => 'Handcrafted 925 sterling silver jewellery, made in limited editions.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('brand_tagline', array(
        'label'   => __('Footer Brand Tagline', 'siliq'),
        'section' => 'siliq_brand',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'siliq_customizer');

/* ============================================================
   6) Helper Functions
============================================================ */
function siliq_get_announcement_texts() {
    return array(
        get_theme_mod('announcement_text_1', 'Complimentary Shipping On Orders Over $150'),
        get_theme_mod('announcement_text_2', 'Handcrafted In Limited Editions'),
        get_theme_mod('announcement_text_3', 'Lifetime Repair Service'),
    );
}
