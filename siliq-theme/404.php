<?php
/**
 * SILIQ Theme — 404 Not Found
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<main>

  <section class="section section--404">
    <div class="error-404">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('404', 'siliq'); ?></p>
      <h1 data-anim="words"><?php esc_html_e('A piece, mislaid.', 'siliq'); ?></h1>
      <p class="error-404__lede" data-anim="fade-up"><?php echo esc_html__("The page you are looking for has been moved, retired, or never existed. Try a search, or browse the collection \u{2014} the silver is still where it should be.", 'siliq'); ?></p>

      <div class="error-404__search" data-anim="fade-up">
        <?php get_search_form(); ?>
      </div>

      <div class="error-404__actions" data-anim="fade-up">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary" data-cursor="hover"><?php esc_html_e('Return Home', 'siliq'); ?></a>
        <?php if (function_exists('wc_get_page_permalink')) : ?>
          <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn--ghost" data-cursor="hover"><?php esc_html_e('Browse the Shop', 'siliq'); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
