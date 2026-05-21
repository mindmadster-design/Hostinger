<?php
/**
 * SILIQ Theme — Archive (categories, tags, author, date for posts)
 *
 * Reuses the journal-grid presentation. WooCommerce product archives have
 * their own template at woocommerce/archive-product.php.
 */
if (!defined('ABSPATH')) exit;
get_header();

$archive_title = get_the_archive_title();
$archive_desc  = get_the_archive_description();
?>

<main>

  <!-- Page header -->
  <section class="page-header">
    <p class="eyebrow" data-anim="fade-up"><?php
      echo esc_html(get_bloginfo('name')); ?> / <?php
      if (is_category())      esc_html_e('Category', 'siliq');
      elseif (is_tag())       esc_html_e('Tag', 'siliq');
      elseif (is_author())    esc_html_e('Author', 'siliq');
      elseif (is_date())      esc_html_e('Archive', 'siliq');
      else                    esc_html_e('Journal', 'siliq');
    ?></p>
    <h1 data-anim="words"><?php echo wp_kses_post($archive_title); ?></h1>
    <?php if ($archive_desc) : ?>
      <p class="page-header__lede" data-anim="fade-up"><?php echo wp_kses_post($archive_desc); ?></p>
    <?php endif; ?>
  </section>

  <!-- Category tabs -->
  <?php
  $categories = get_categories(array('hide_empty' => true));
  if (!empty($categories) && (is_category() || is_home() || is_archive())) :
    $current_cat_id = is_category() ? get_queried_object_id() : 0;
    $journal_url = siliq_get_journal_url();
  ?>
    <section class="journal-tabs">
      <div class="journal-tabs__inner">
        <a class="journal-tab<?php echo $current_cat_id ? '' : ' is-active'; ?>" href="<?php echo esc_url($journal_url); ?>" data-cursor="hover"><?php esc_html_e('All', 'siliq'); ?></a>
        <?php foreach (array_slice($categories, 0, 6) as $cat) : ?>
          <a class="journal-tab<?php echo $current_cat_id === $cat->term_id ? ' is-active' : ''; ?>" href="<?php echo esc_url(get_category_link($cat)); ?>" data-cursor="hover"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- Articles grid -->
  <section class="section section--journal-grid">
    <?php if (have_posts()) : ?>
      <div class="journal-grid">
        <?php while (have_posts()) : the_post();
          $thumb = get_the_post_thumbnail_url(get_the_ID(), 'siliq-collection');
          if (!$thumb) {
              $thumb = 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=900&q=80';
          }
          $cats = get_the_category();
          $cat_label = !empty($cats) ? $cats[0]->name : __('Journal', 'siliq');
        ?>
          <a href="<?php the_permalink(); ?>" class="journal-card reveal" data-cursor="view">
            <div class="journal-card__media mask-reveal">
              <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" />
            </div>
            <div class="journal-card__body">
              <p class="eyebrow"><?php echo esc_html($cat_label); ?></p>
              <h3><?php the_title(); ?></h3>
              <p class="journal-card__meta"><span class="muted small"><?php echo esc_html(get_the_date()); ?></span> &middot; <span class="muted small"><?php echo esc_html(siliq_reading_time()); ?></span></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>

      <div class="shop-pagination" data-anim="fade-up">
        <?php
        $big = 999999999;
        $pagination = paginate_links(array(
            'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format'    => '?paged=%#%',
            'current'   => max(1, get_query_var('paged')),
            'total'     => $GLOBALS['wp_query']->max_num_pages,
            'type'      => 'array',
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'mid_size'  => 2,
        ));
        if (!empty($pagination)) {
            foreach ($pagination as $link) {
                // Treat prev/next arrows as buttons; numbers as nums.
                if (strpos($link, '&larr;') !== false || strpos($link, '&rarr;') !== false || strpos($link, '←') !== false || strpos($link, '→') !== false) {
                    echo str_replace('page-numbers', 'shop-pagination__btn', $link);
                } else {
                    echo str_replace('page-numbers', 'shop-pagination__num', $link);
                }
            }
        }
        ?>
      </div>

    <?php else : ?>
      <div style="text-align:center; padding: 80px 0;">
        <h2><?php esc_html_e('Nothing here yet', 'siliq'); ?></h2>
        <p><?php esc_html_e('Try a different category, or browse the journal.', 'siliq'); ?></p>
        <a href="<?php echo esc_url(siliq_get_journal_url()); ?>" class="btn btn--primary" data-cursor="hover"><?php esc_html_e('Read the Journal', 'siliq'); ?></a>
      </div>
    <?php endif; ?>
  </section>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
