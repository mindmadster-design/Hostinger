<?php
/**
 * SILIQ — WooCommerce Cart override
 *
 * Restyled cart with the SILIQ layout (.cart-page / .cart-layout / .cart-line-item).
 * Preserves all WooCommerce hooks for plugin compatibility.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 */
if (!defined('ABSPATH')) exit;

do_action('woocommerce_before_cart');
?>

<section class="cart-page">

  <div class="cart-page__header">
    <h1><?php esc_html_e('Your Bag', 'siliq'); ?></h1>
    <span class="cart-page__count"><?php
      $count = WC()->cart->get_cart_contents_count();
      printf(_n('%d item', '%d items', $count, 'siliq'), $count);
    ?></span>
  </div>

  <form class="cart-form woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <div class="cart-layout">

      <div class="cart-items-list">
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0 || !apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                continue;
            }

            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('siliq-product-thumb'), $cart_item, $cart_item_key);
            $variation_html = wc_get_formatted_cart_item_data($cart_item);
        ?>
          <div class="cart-line-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

            <div class="cart-line-item__media">
              <?php
              if (!$product_permalink) {
                  echo $thumbnail;
              } else {
                  printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
              }
              ?>
            </div>

            <div class="cart-line-item__details">
              <h3>
                <?php
                if (!$product_permalink) {
                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                } else {
                    echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                }
                do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                ?>
              </h3>

              <?php if ($variation_html) : ?>
                <p class="cart-line-item__variant"><?php echo wp_kses_post($variation_html); ?></p>
              <?php endif; ?>

              <div class="cart-line-item__actions">
                <?php
                if ($_product->is_sold_individually()) {
                    $product_quantity = sprintf('<span class="cart-line-item__qty-val">1</span><input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                } else {
                    $product_quantity = woocommerce_quantity_input(
                        array(
                            'input_name'   => "cart[{$cart_item_key}][qty]",
                            'input_value'  => $cart_item['quantity'],
                            'max_value'    => $_product->get_max_purchase_quantity(),
                            'min_value'    => '0',
                            'product_name' => $_product->get_name(),
                            'classes'      => array('cart-line-item__qty-input'),
                        ),
                        $_product,
                        false
                    );
                }
                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                ?>

                <?php
                echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                    '<a href="%s" class="cart-line-item__remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                    esc_attr__('Remove this item', 'siliq'),
                    esc_attr($product_id),
                    esc_attr($_product->get_sku()),
                    esc_html__('Remove', 'siliq')
                ), $cart_item_key);
                ?>
              </div>
            </div>

            <div class="cart-line-item__right">
              <span class="cart-line-item__price"><?php
                echo apply_filters(
                    'woocommerce_cart_item_subtotal',
                    WC()->cart->get_product_subtotal($_product, $cart_item['quantity']),
                    $cart_item,
                    $cart_item_key
                );
              ?></span>
            </div>

          </div>
        <?php endforeach; ?>

        <?php do_action('woocommerce_cart_contents'); ?>

        <!-- Update + coupon row -->
        <div class="cart-line-item cart-line-item--actions">
          <div class="cart-line-item__details" style="grid-column: 1 / -1;">
            <?php if (wc_coupons_enabled()) : ?>
              <div class="cart-coupon">
                <label for="coupon_code" class="screen-reader-text"><?php esc_html_e('Coupon:', 'siliq'); ?></label>
                <input type="text" name="coupon_code" class="cart-coupon__input" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'siliq'); ?>" />
                <button type="submit" class="link-underline" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'siliq'); ?>"><?php esc_html_e('Apply coupon', 'siliq'); ?></button>
                <?php do_action('woocommerce_cart_coupon'); ?>
              </div>
            <?php endif; ?>

            <button type="submit" class="link-underline" name="update_cart" value="<?php esc_attr_e('Update cart', 'siliq'); ?>"><?php esc_html_e('Update cart', 'siliq'); ?></button>
            <?php do_action('woocommerce_cart_actions'); ?>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
          </div>
        </div>

        <?php do_action('woocommerce_after_cart_contents'); ?>
      </div>

      <!-- Totals sidebar -->
      <div class="cart-summary">
        <h3><?php esc_html_e('Order Summary', 'siliq'); ?></h3>

        <?php do_action('woocommerce_before_cart_totals'); ?>

        <div class="cart-summary__row">
          <span><?php esc_html_e('Subtotal', 'siliq'); ?></span>
          <span><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
          <div class="cart-summary__row">
            <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
            <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
          </div>
        <?php endforeach; ?>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
          <div class="cart-summary__row">
            <span><?php esc_html_e('Shipping', 'siliq'); ?></span>
            <span><?php wc_cart_totals_shipping_html(); ?></span>
          </div>
        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
          <div class="cart-summary__row">
            <span><?php echo esc_html($fee->name); ?></span>
            <span><?php wc_cart_totals_fee_html($fee); ?></span>
          </div>
        <?php endforeach; ?>

        <?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
          <?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
            <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>
              <div class="cart-summary__row">
                <span><?php echo esc_html($tax->label); ?></span>
                <span><?php echo wp_kses_post($tax->formatted_amount); ?></span>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div class="cart-summary__row">
              <span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
              <span><?php wc_cart_totals_taxes_total_html(); ?></span>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="cart-summary__row cart-summary__row--total">
          <span><?php esc_html_e('Total', 'siliq'); ?></span>
          <span><?php wc_cart_totals_order_total_html(); ?></span>
        </div>

        <?php do_action('woocommerce_proceed_to_checkout'); ?>

        <p class="cart-summary__note"><?php esc_html_e('Complimentary shipping on orders over $150', 'siliq'); ?></p>

        <?php do_action('woocommerce_after_cart_totals'); ?>
      </div>

    </div>

    <?php do_action('woocommerce_after_cart_table'); ?>
  </form>

  <div style="text-align:center; margin-top: 48px;">
    <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="link-underline" data-cursor="hover"><?php esc_html_e('Continue Shopping', 'siliq'); ?></a>
  </div>

  <?php do_action('woocommerce_cart_collaterals'); ?>

</section>

<?php do_action('woocommerce_after_cart'); ?>
