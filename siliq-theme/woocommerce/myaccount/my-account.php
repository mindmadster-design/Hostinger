<?php
/**
 * SILIQ — WooCommerce My Account override (logged-in dashboard)
 *
 * Wraps WC's default dashboard layout in our .account-section / .dashboard
 * container, with a top header that greets the user.
 */
if (!defined('ABSPATH')) exit;

$current_user = wp_get_current_user();
?>

<section class="account-section dashboard is-active">

  <div class="dashboard__header">
    <h1>
      <?php
      printf(
          /* translators: %s: user first name */
          esc_html__('Welcome back, %s', 'siliq'),
          '<em>' . esc_html($current_user->display_name) . '</em>'
      );
      ?>
    </h1>
    <a class="dashboard__logout" href="<?php echo esc_url(wc_logout_url(wc_get_page_permalink('myaccount'))); ?>"><?php esc_html_e('Sign Out', 'siliq'); ?></a>
  </div>

  <div class="woocommerce-MyAccount-content-wrapper">
    <nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_attr_e('Account navigation', 'siliq'); ?>">
      <ul>
        <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
          <li class="<?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
            <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="woocommerce-MyAccount-content">
      <?php
      /**
       * Note: this is the default WC content rendering for the active endpoint.
       * It will display the dashboard, orders, addresses, account-details, etc.
       */
      do_action('woocommerce_account_content');
      ?>
    </div>
  </div>

</section>
