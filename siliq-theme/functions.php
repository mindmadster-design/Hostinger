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


/* ============================================================
   7) Helper URL & utility functions used by templates
============================================================ */

/**
 * Resolve the URL for the Contact page. Tries (in order):
 *   1) page assigned to "template-contact.php"
 *   2) Customizer setting `contact_page_url`
 *   3) /contact slug
 */
if (!function_exists('siliq_get_contact_url')) {
    function siliq_get_contact_url() {
        $cached = wp_cache_get('siliq_contact_url', 'siliq');
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'template-contact.php',
            'number'     => 1,
        ));
        if (!empty($pages)) {
            $url = get_permalink($pages[0]->ID);
        } else {
            $custom = get_theme_mod('contact_page_url', '');
            $url = $custom ? $custom : home_url('/contact');
        }

        wp_cache_set('siliq_contact_url', $url, 'siliq', 5 * MINUTE_IN_SECONDS);
        return $url;
    }
}

/**
 * Resolve the URL for the Journal page. Same pattern as the contact resolver.
 */
if (!function_exists('siliq_get_journal_url')) {
    function siliq_get_journal_url() {
        $cached = wp_cache_get('siliq_journal_url', 'siliq');
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $pages = get_pages(array(
            'meta_key'   => '_wp_page_template',
            'meta_value' => 'template-journal.php',
            'number'     => 1,
        ));
        if (!empty($pages)) {
            $url = get_permalink($pages[0]->ID);
        } else {
            // Fall back to the WP "posts page" if set, else /journal.
            $posts_page_id = (int) get_option('page_for_posts');
            $url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/journal');
        }

        wp_cache_set('siliq_journal_url', $url, 'siliq', 5 * MINUTE_IN_SECONDS);
        return $url;
    }
}

/**
 * Estimated reading time for the current post (~225 wpm).
 */
if (!function_exists('siliq_reading_time')) {
    function siliq_reading_time($post = null) {
        $post = get_post($post);
        if (!$post) return '1 min read';
        $word_count = str_word_count(wp_strip_all_tags($post->post_content));
        $minutes = max(1, (int) ceil($word_count / 225));
        /* translators: %d: estimated reading time in minutes */
        return sprintf(_n('%d min read', '%d min read', $minutes, 'siliq'), $minutes);
    }
}

/**
 * Move the primary-nav fallback into functions.php so header.php stays clean.
 * (header.php's local definition is wrapped to avoid redeclaration.)
 */
if (!function_exists('siliq_fallback_menu')) {
    function siliq_fallback_menu() {
        $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
        echo '<a href="' . esc_url($shop) . '">' . esc_html__('Shop', 'siliq') . '</a>';
        echo '<a href="' . esc_url(home_url('/launches')) . '">' . esc_html__('Launches', 'siliq') . '</a>';
        echo '<a href="' . esc_url(siliq_get_journal_url()) . '">' . esc_html__('Journal', 'siliq') . '</a>';
        echo '<a href="' . esc_url(home_url('/about')) . '">' . esc_html__('About', 'siliq') . '</a>';
        echo '<a href="' . esc_url(siliq_get_contact_url()) . '">' . esc_html__('Contact', 'siliq') . '</a>';
    }
}

/* ============================================================
   8) Newsletter form handler (admin-post)
============================================================ */

function siliq_handle_newsletter() {
    if (!isset($_POST['siliq_newsletter_nonce']) || !wp_verify_nonce($_POST['siliq_newsletter_nonce'], 'siliq_newsletter')) {
        wp_safe_redirect(wp_get_referer() ?: home_url('/'));
        exit;
    }

    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    if (!is_email($email)) {
        wp_safe_redirect(wp_get_referer() ?: home_url('/'));
        exit;
    }

    // Persist to a private option so the site owner can export later.
    // (Use a real ESP integration in production — Mailchimp, ConvertKit, etc.)
    $existing = get_option('siliq_newsletter_subscribers', array());
    if (!is_array($existing)) $existing = array();

    $now = current_time('mysql');
    $found = false;
    foreach ($existing as $row) {
        if (isset($row['email']) && strtolower($row['email']) === strtolower($email)) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $existing[] = array('email' => $email, 'date' => $now, 'ip' => $_SERVER['REMOTE_ADDR'] ?? '');
        update_option('siliq_newsletter_subscribers', $existing, false);

        /**
         * Fires after a new newsletter subscriber is recorded.
         * Plugins / ESP integrations can hook into this.
         */
        do_action('siliq_newsletter_subscribed', $email);
    }

    $redirect = add_query_arg('siliq_subscribed', '1', wp_get_referer() ?: home_url('/'));
    wp_safe_redirect($redirect);
    exit;
}
add_action('admin_post_nopriv_siliq_newsletter', 'siliq_handle_newsletter');
add_action('admin_post_siliq_newsletter',        'siliq_handle_newsletter');

/* ============================================================
   9) Contact form handler (admin-post)
============================================================ */

function siliq_handle_contact() {
    if (!isset($_POST['siliq_contact_nonce']) || !wp_verify_nonce($_POST['siliq_contact_nonce'], 'siliq_contact')) {
        wp_safe_redirect(wp_get_referer() ?: home_url('/'));
        exit;
    }

    // Sanitize all inputs.
    $first   = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
    $last    = isset($_POST['last_name'])  ? sanitize_text_field(wp_unslash($_POST['last_name']))  : '';
    $email   = isset($_POST['email'])      ? sanitize_email(wp_unslash($_POST['email']))           : '';
    $phone   = isset($_POST['phone'])      ? sanitize_text_field(wp_unslash($_POST['phone']))      : '';
    $subject = isset($_POST['subject'])    ? sanitize_text_field(wp_unslash($_POST['subject']))    : 'General Enquiry';
    $message = isset($_POST['message'])    ? sanitize_textarea_field(wp_unslash($_POST['message'])): '';

    if (empty($first) || empty($last) || !is_email($email) || empty($message)) {
        wp_safe_redirect(wp_get_referer() ?: home_url('/'));
        exit;
    }

    $to       = apply_filters('siliq_contact_to_email', get_option('admin_email'));
    $headline = sprintf('[%s] %s — %s %s', get_bloginfo('name'), $subject, $first, $last);
    $body  = "From: {$first} {$last} <{$email}>\n";
    $body .= $phone ? "Phone: {$phone}\n" : '';
    $body .= "Subject: {$subject}\n\n";
    $body .= "Message:\n{$message}\n";
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $first . ' ' . $last . ' <' . $email . '>',
    );

    wp_mail($to, $headline, $body, $headers);

    do_action('siliq_contact_submitted', compact('first', 'last', 'email', 'phone', 'subject', 'message'));

    $redirect_to = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : siliq_get_contact_url();
    $redirect = add_query_arg('siliq_contacted', '1', $redirect_to) . '#contact-form';

    wp_safe_redirect($redirect);
    exit;
}
add_action('admin_post_nopriv_siliq_contact', 'siliq_handle_contact');
add_action('admin_post_siliq_contact',        'siliq_handle_contact');

/* ============================================================
   10) Customizer settings for the new page templates
============================================================ */

function siliq_customizer_pages($wp_customize) {

    /* ---- About page panel ---- */
    $wp_customize->add_section('siliq_about', array(
        'title'    => __('About Page', 'siliq'),
        'priority' => 50,
    ));
    $about_fields = array(
        'about_hero_image'    => array('label' => __('About Hero Image (URL)', 'siliq'),       'default' => 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?w=2400&q=80', 'type' => 'url',      'sanitize' => 'esc_url_raw'),
        'about_hero_eyebrow'  => array('label' => __('About Hero Eyebrow', 'siliq'),           'default' => 'Est. 1924',                                                                'type' => 'text',     'sanitize' => 'sanitize_text_field'),
        'about_hero_title'    => array('label' => __('About Hero Title (HTML allowed)', 'siliq'),'default' => 'A Century of Silver,<br><em>Quietly Perfected.</em>',                    'type' => 'textarea', 'sanitize' => 'wp_kses_post'),
        'about_hero_subtitle' => array('label' => __('About Hero Subtitle', 'siliq'),          'default' => 'Five generations. One material. No compromise.',                          'type' => 'text',     'sanitize' => 'sanitize_text_field'),
        'about_intro_text'    => array('label' => __('About Intro Statement', 'siliq'),        'default' => '',                                                                         'type' => 'textarea', 'sanitize' => 'wp_kses_post'),
    );
    foreach ($about_fields as $id => $f) {
        $wp_customize->add_setting($id, array('default' => $f['default'], 'sanitize_callback' => $f['sanitize']));
        $wp_customize->add_control($id, array('label' => $f['label'], 'section' => 'siliq_about', 'type' => $f['type']));
    }

    /* ---- Contact page panel ---- */
    $wp_customize->add_section('siliq_contact', array(
        'title'    => __('Contact Page', 'siliq'),
        'priority' => 55,
    ));
    $contact_fields = array(
        'contact_hero_image' => array('label' => __('Contact Hero Image URL', 'siliq'),  'default' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=2000&q=80', 'type' => 'url',  'sanitize' => 'esc_url_raw'),
        'contact_email'      => array('label' => __('Contact Email Address', 'siliq'),   'default' => 'hello@siliq.com',                                                       'type' => 'email','sanitize' => 'sanitize_email'),
        'contact_phone'      => array('label' => __('Contact Phone (display)', 'siliq'), 'default' => '+33 0 00 00 00',                                                        'type' => 'text', 'sanitize' => 'sanitize_text_field'),
        'contact_phone_tel'  => array('label' => __('Contact Phone (tel: link)', 'siliq'),'default'=> '+33000000000',                                                          'type' => 'text', 'sanitize' => 'sanitize_text_field'),
        'contact_address'    => array('label' => __('Atelier Address (line 1)', 'siliq'), 'default' => "14 Rue de l\u{2019}Argent",                                           'type' => 'text', 'sanitize' => 'sanitize_text_field'),
        'contact_address_2'  => array('label' => __('Atelier Address (line 2)', 'siliq'), 'default' => '75001 Paris, France · By appointment.',                              'type' => 'text', 'sanitize' => 'sanitize_text_field'),
        'contact_press_email'=> array('label' => __('Press / Wholesale Email', 'siliq'),  'default' => 'press@siliq.com',                                                    'type' => 'email','sanitize' => 'sanitize_email'),
    );
    foreach ($contact_fields as $id => $f) {
        $wp_customize->add_setting($id, array('default' => $f['default'], 'sanitize_callback' => $f['sanitize']));
        $wp_customize->add_control($id, array('label' => $f['label'], 'section' => 'siliq_contact', 'type' => $f['type']));
    }

    /* ---- Stores panel ---- */
    $wp_customize->add_section('siliq_stores', array(
        'title'    => __('Stores Page', 'siliq'),
        'priority' => 60,
    ));
    $wp_customize->add_setting('stores_hero_image', array(
        'default'           => 'https://images.unsplash.com/photo-1431274172761-fca41d930114?w=2000&q=80',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('stores_hero_image', array(
        'label'   => __('Stores Hero Image URL', 'siliq'),
        'section' => 'siliq_stores',
        'type'    => 'url',
    ));

    /* ---- Launches panel ---- */
    $wp_customize->add_section('siliq_launches', array(
        'title'    => __('Launches Page', 'siliq'),
        'priority' => 65,
    ));
    $launches_fields = array(
        'launches_hero_image'      => array('label' => __('Launches Hero Image URL', 'siliq'),        'default' => 'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=2000&q=80', 'type' => 'url',  'sanitize' => 'esc_url_raw'),
        'launches_tag_slug'        => array('label' => __('Product Tag Slug for "Launches"', 'siliq'),'default' => 'launches',                                                              'type' => 'text', 'sanitize' => 'sanitize_title'),
        'launches_editorial_image' => array('label' => __('Editorial Image URL', 'siliq'),            'default' => 'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?w=1400&q=80', 'type' => 'url', 'sanitize' => 'esc_url_raw'),
        'launches_cta_image'       => array('label' => __('Bespoke CTA Image URL', 'siliq'),          'default' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1400&q=80', 'type' => 'url', 'sanitize' => 'esc_url_raw'),
    );
    foreach ($launches_fields as $id => $f) {
        $wp_customize->add_setting($id, array('default' => $f['default'], 'sanitize_callback' => $f['sanitize']));
        $wp_customize->add_control($id, array('label' => $f['label'], 'section' => 'siliq_launches', 'type' => $f['type']));
    }

    /* ---- Journal panel ---- */
    $wp_customize->add_section('siliq_journal', array(
        'title'    => __('Journal Page', 'siliq'),
        'priority' => 70,
    ));
    $wp_customize->add_setting('journal_heading', array(
        'default'           => __('Letters from the bench.', 'siliq'),
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('journal_heading', array(
        'label'   => __('Journal Page Title', 'siliq'),
        'section' => 'siliq_journal',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('journal_lede', array(
        'default'           => __("Quiet stories from our atelier \u{2014} craft, heritage, styling, and the small moments that make a piece.", 'siliq'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('journal_lede', array(
        'label'   => __('Journal Page Lede', 'siliq'),
        'section' => 'siliq_journal',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'siliq_customizer_pages');

/* ============================================================
   11) Allow `launches` product tag in registered_taxonomy hooks
   (no-op until the user creates the tag in WC; documented here)
============================================================
   To use the Launches page, create products and tag them with
   "launches" (or whatever slug you set in Customize → Launches).
*/

/* ============================================================
   12) Register the `siliq_journal_page` query var
============================================================ */
function siliq_register_query_vars($vars) {
    $vars[] = 'siliq_journal_page';
    return $vars;
}
add_filter('query_vars', 'siliq_register_query_vars');

/* ============================================================
   13) Bust the URL caches when relevant pages are saved
============================================================ */
function siliq_clear_url_cache($post_id) {
    if (get_post_type($post_id) !== 'page') return;
    wp_cache_delete('siliq_contact_url', 'siliq');
    wp_cache_delete('siliq_journal_url', 'siliq');
}
add_action('save_post', 'siliq_clear_url_cache');
