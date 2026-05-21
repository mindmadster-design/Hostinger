<?php
/**
 * SILIQ — WooCommerce Login + Register override
 *
 * Restyled with .account-section / .account-tabs / .account-panel to match
 * the SILIQ design while preserving WC's login & registration logic.
 */
if (!defined('ABSPATH')) exit;

do_action('woocommerce_before_customer_login_form');
?>

<section class="account-section">

  <div class="page-header" style="padding: 0 0 48px;">
    <h1><?php esc_html_e('My Account', 'siliq'); ?></h1>
  </div>

  <div class="account-tabs" role="tablist">
    <button type="button" class="account-tab is-active" data-tab="signin" role="tab" aria-selected="true"><?php esc_html_e('Sign In', 'siliq'); ?></button>
    <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
      <button type="button" class="account-tab" data-tab="register" role="tab" aria-selected="false"><?php esc_html_e('Create Account', 'siliq'); ?></button>
    <?php endif; ?>
  </div>

  <!-- Sign In Panel -->
  <div class="account-panel is-active" id="panel-signin" role="tabpanel">
    <form class="account-form woocommerce-form woocommerce-form-login" method="post">
      <?php do_action('woocommerce_login_form_start'); ?>

      <label>
        <span><?php esc_html_e('Username or email address', 'siliq'); ?>&nbsp;<span class="required">*</span></span>
        <input type="text" name="username" autocomplete="username" required value="<?php echo (!empty($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : ''); ?>" />
      </label>

      <label>
        <span><?php esc_html_e('Password', 'siliq'); ?>&nbsp;<span class="required">*</span></span>
        <input class="woocommerce-Input" type="password" name="password" autocomplete="current-password" required />
      </label>

      <?php do_action('woocommerce_login_form'); ?>

      <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="account-form__forgot"><?php esc_html_e('Forgot password?', 'siliq'); ?></a>

      <p style="display:flex; align-items:center; gap:10px; font-size:0.9rem;">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox" style="display:inline-flex; align-items:center; gap:8px;">
          <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" value="forever" />
          <span><?php esc_html_e('Remember me', 'siliq'); ?></span>
        </label>
      </p>

      <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
      <button type="submit" class="btn btn--primary btn--block" name="login" value="<?php esc_attr_e('Sign In', 'siliq'); ?>"><?php esc_html_e('Sign In', 'siliq'); ?></button>

      <?php do_action('woocommerce_login_form_end'); ?>
    </form>
  </div>

  <!-- Register Panel -->
  <?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
    <div class="account-panel" id="panel-register" role="tabpanel">
      <form method="post" class="account-form woocommerce-form woocommerce-form-register" <?php do_action('woocommerce_register_form_tag'); ?>>

        <?php do_action('woocommerce_register_form_start'); ?>

        <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
          <label>
            <span><?php esc_html_e('Username', 'siliq'); ?>&nbsp;<span class="required">*</span></span>
            <input type="text" name="username" autocomplete="username" required value="<?php echo (!empty($_POST['username']) ? esc_attr(wp_unslash($_POST['username'])) : ''); ?>" />
          </label>
        <?php endif; ?>

        <label>
          <span><?php esc_html_e('Email Address', 'siliq'); ?>&nbsp;<span class="required">*</span></span>
          <input type="email" name="email" autocomplete="email" required value="<?php echo (!empty($_POST['email']) ? esc_attr(wp_unslash($_POST['email'])) : ''); ?>" />
        </label>

        <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
          <label>
            <span><?php esc_html_e('Password', 'siliq'); ?>&nbsp;<span class="required">*</span></span>
            <input type="password" name="password" autocomplete="new-password" required />
          </label>
        <?php else : ?>
          <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'siliq'); ?></p>
        <?php endif; ?>

        <?php do_action('woocommerce_register_form'); ?>

        <p class="woocommerce-FormRow form-row">
          <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
          <button type="submit" class="btn btn--primary btn--block" name="register" value="<?php esc_attr_e('Create Account', 'siliq'); ?>"><?php esc_html_e('Create Account', 'siliq'); ?></button>
        </p>

        <?php do_action('woocommerce_register_form_end'); ?>

        <p class="account-form__legal"><?php esc_html_e('By creating an account, you agree to our Terms of Service and Privacy Policy.', 'siliq'); ?></p>
      </form>
    </div>
  <?php endif; ?>

</section>

<script>
// Tab switching for Sign In / Create Account
(function(){
  var tabs = document.querySelectorAll('.account-tabs .account-tab');
  if (!tabs.length) return;
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(){
      tabs.forEach(function(t){ t.classList.toggle('is-active', t === tab); t.setAttribute('aria-selected', t === tab ? 'true' : 'false'); });
      document.querySelectorAll('.account-panel').forEach(function(p){
        p.classList.toggle('is-active', p.id === 'panel-' + tab.dataset.tab);
      });
    });
  });
})();
</script>

<?php do_action('woocommerce_after_customer_login_form'); ?>
