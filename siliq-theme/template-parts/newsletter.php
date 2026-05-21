<?php
/**
 * Newsletter section — used across multiple page templates.
 *
 * Submits to admin-post.php?action=siliq_newsletter (handler in functions.php).
 */
if (!defined('ABSPATH')) exit;
?>
<section class="section section--newsletter">
  <div class="newsletter">
    <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Correspondence', 'siliq'); ?></p>
    <h2 data-anim="words"><?php esc_html_e('Letters from the atelier.', 'siliq'); ?></h2>
    <p class="newsletter__lede" data-anim="fade-up"><?php esc_html_e('First access to new pieces, private events, and quiet stories from the bench.', 'siliq'); ?></p>

    <?php if (isset($_GET['siliq_subscribed']) && $_GET['siliq_subscribed'] === '1') : ?>
      <p class="newsletter__success" data-anim="fade-up"><?php esc_html_e('Thank you — you are subscribed.', 'siliq'); ?></p>
    <?php else : ?>
      <form class="newsletter__form" data-anim="fade-up" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="siliq_newsletter" />
        <?php wp_nonce_field('siliq_newsletter', 'siliq_newsletter_nonce'); ?>
        <input type="email" name="email" placeholder="<?php esc_attr_e('Your email address', 'siliq'); ?>" required />
        <button type="submit" data-cursor="hover"><?php esc_html_e('Subscribe', 'siliq'); ?></button>
      </form>
    <?php endif; ?>

    <p class="newsletter__fine"><?php esc_html_e('By subscribing you agree to our Privacy Policy.', 'siliq'); ?></p>
  </div>
</section>
