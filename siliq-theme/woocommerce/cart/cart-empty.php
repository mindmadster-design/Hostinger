<?php
/**
 * SILIQ — Empty cart
 */
if (!defined('ABSPATH')) exit;

do_action('woocommerce_cart_is_empty');
?>

<section class="cart-page">
  <div class="cart-empty">
    <h2><?php esc_html_e('Your bag is empty', 'siliq'); ?></h2>
    <p><?php echo esc_html__("Looks like you haven\u{2019}t added anything yet. Discover our handcrafted collections.", 'siliq'); ?></p>
    <p>
      <a class="btn btn--primary" data-cursor="hover" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
        <?php echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Shop Now', 'siliq'))); ?>
      </a>
    </p>
  </div>
</section>
