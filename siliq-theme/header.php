<?php
/**
 * SILIQ Theme Header
 */
if (!defined('ABSPATH')) exit;
$announcements = siliq_get_announcement_texts();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="#0F0F10" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="dns-prefetch" href="https://images.unsplash.com" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- Custom cursor -->
  <div class="cursor-dot" aria-hidden="true"></div>
  <div class="cursor-ring" aria-hidden="true"></div>

  <!-- Announcement bar -->
  <div class="announcement">
    <div class="announcement__track">
      <?php foreach ($announcements as $i => $text) : ?>
        <span><?php echo esc_html($text); ?></span>
        <span>&middot;</span>
      <?php endforeach; ?>
      <?php foreach ($announcements as $i => $text) : ?>
        <span><?php echo esc_html($text); ?></span>
        <span>&middot;</span>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Header -->
  <header class="header" id="header">
    <div class="header__inner">
      <nav class="nav nav--left">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => 'siliq_fallback_menu',
          'depth'          => 1,
        ));
        ?>
      </nav>

      <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="<?php bloginfo('name'); ?>" data-cursor="logo">
        <?php
        if (has_custom_logo()) {
            the_custom_logo();
        } else {
            echo 'SILIQ';
        }
        ?>
      </a>

      <div class="nav nav--right">
        <a href="<?php echo esc_url(home_url('/search')); ?>" class="icon-btn" aria-label="Search" data-cursor="hover">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        </a>
        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="icon-btn" aria-label="Account" data-cursor="hover">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/></svg>
        </a>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="icon-btn cart-trigger" aria-label="Cart" data-cursor="hover">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M6 7h12l-1.2 11.2a2 2 0 0 1-2 1.8H9.2a2 2 0 0 1-2-1.8L6 7z"/><path d="M9 7V5a3 3 0 0 1 6 0v2"/></svg>
          <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <button class="icon-btn menu-trigger" id="menuTrigger" aria-label="Menu" data-cursor="hover">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile menu drawer -->
  <div class="drawer drawer--menu" id="mobileMenu" aria-hidden="true" data-lenis-prevent>
    <div class="drawer__overlay" data-close></div>
    <aside class="drawer__panel drawer__panel--left">
      <button class="drawer__close" data-close aria-label="Close menu">&times;</button>
      <nav class="drawer-nav">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'mobile',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => 'siliq_fallback_menu',
          'depth'          => 1,
        ));
        ?>
        <hr />
        <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">Account</a>
        <a href="<?php echo esc_url(home_url('/search')); ?>">Search</a>
      </nav>
    </aside>
  </div>

  <!-- Cart drawer -->
  <div class="drawer drawer--cart" id="cartDrawer" aria-hidden="true" data-lenis-prevent>
    <div class="drawer__overlay" data-close></div>
    <aside class="drawer__panel drawer__panel--right">
      <div class="drawer__head">
        <h3>Your Bag <span class="muted">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span></h3>
        <button class="drawer__close" data-close aria-label="Close cart">&times;</button>
      </div>
      <div class="cart-items">
        <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
          <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $product = $cart_item['data'];
            $thumbnail = wp_get_attachment_image_url($product->get_image_id(), 'siliq-product-thumb');
          ?>
            <div class="cart-item">
              <?php if ($thumbnail) : ?>
                <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" />
              <?php endif; ?>
              <div>
                <h4><?php echo esc_html($product->get_name()); ?></h4>
                <p class="muted"><?php echo esc_html('Qty: ' . $cart_item['quantity']); ?></p>
                <p class="cart-item__price"><?php echo $product->get_price_html(); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <p class="muted" style="padding:24px 0;">Your bag is empty.</p>
        <?php endif; ?>
      </div>
      <div class="drawer__foot">
        <div class="cart-totals">
          <span>Subtotal</span>
          <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
        </div>
        <p class="muted small">Shipping and taxes calculated at checkout.</p>
        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn--primary btn--block" data-cursor="hover">Checkout</a>
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="link-underline cart-view" data-cursor="hover">View bag</a>
      </div>
    </aside>
  </div>

<?php
// Fallback menu if no menu is assigned
function siliq_fallback_menu() {
    echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">Shop</a>';
    echo '<a href="' . esc_url(home_url('/launches')) . '">Launches</a>';
    echo '<a href="' . esc_url(home_url('/about')) . '">About</a>';
    echo '<a href="' . esc_url(home_url('/contact')) . '">Contact</a>';
}
?>
