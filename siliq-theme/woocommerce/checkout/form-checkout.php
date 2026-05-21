<?php
/**
 * SILIQ — WooCommerce Checkout Form override
 *
 * Restyled checkout layout (.checkout-page / .checkout-layout / .checkout-summary).
 * Preserves all WC hooks. Editable in WP without losing extension support.
 */
if (!defined('ABSPATH')) exit;

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<section class="checkout-page">

  <div class="checkout-page__header">
    <h1><?php esc_html_e('Checkout', 'siliq'); ?></h1>
    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="link-underline" data-cursor="hover"><?php esc_html_e('Return to bag', 'siliq'); ?></a>
  </div>

  <form name="checkout" method="post" class="checkout-form woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <div class="checkout-layout">

      <!-- Left: customer + shipping + payment -->
      <div>
        <?php if ($checkout->get_checkout_fields()) : ?>
          <?php do_action('woocommerce_checkout_before_customer_details'); ?>

          <div class="checkout-section">
            <p class="checkout-section__title"><?php esc_html_e('Billing & Shipping', 'siliq'); ?></p>
            <div class="checkout-fields">
              <?php do_action('woocommerce_checkout_billing'); ?>
              <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>
          </div>

          <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>
      </div>

      <!-- Right: order review + payment -->
      <div class="checkout-summary">
        <h3 id="order_review_heading"><?php esc_html_e('Your Order', 'siliq'); ?></h3>

        <?php do_action('woocommerce_checkout_before_order_review'); ?>

        <div id="order_review" class="woocommerce-checkout-review-order">
          <?php do_action('woocommerce_checkout_order_review'); ?>
        </div>

        <?php do_action('woocommerce_checkout_after_order_review'); ?>
      </div>

    </div>

  </form>
</section>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
