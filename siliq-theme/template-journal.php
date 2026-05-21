<?php
/**
 * Template Name: SILIQ — Journal
 *
 * Journal landing — featured (latest sticky or first post) + grid of recent
 * posts + category tabs (built from real WP categories).
 *
 * Assign this template to a Page (e.g. /journal). It paginates via the
 * ?siliq_journal_page=N query var to coexist with normal page pagination.
 */
if (!defined('ABSPATH')) exit;
get_header();

// Pagination using a custom query var so the page itself remains static.
$paged = max(1, (int) get_query_var('paged'));
if ($paged === 1 && !empty($_GET['siliq_journal_page'])) {
    $paged = max(1, (int) $_GET['siliq_journal_page']);
}

// Featured = first sticky, else first post.
$featured_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'post__in'       => get_option('sticky_posts'),
    'ignore_sticky_posts' => 1,
));
if (!$featured_query->have_posts()) {
    $featured_query = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
    ));
}

// Skip the featured post in the grid below.
$featured_id = 0;
if ($featured_query->have_posts()) {
    $featured_query->the_post();
    $featured_id = get_the_ID();
    rewind_posts();
}

// Posts grid.
$grid_query = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'post__not_in'   => array($featured_id),
    'ignore_sticky_posts' => 1,
));

$categories = get_categories(array('hide_empty' => true));
?>

<main>

  <!-- Page header -->
  <section class="page-header">
    <p class="eyebrow" data-anim="fade-up"><?php
      echo esc_html(get_bloginfo('name')); ?> / <?php the_title();
    ?></p>
    <h1 data-anim="words"><?php
      $journal_h1 = get_theme_mod('journal_heading', __('Letters from the bench.', 'siliq'));
      echo wp_kses_post($journal_h1);
    ?></h1>
    <p class="page-header__lede" data-anim="fade-up"><?php
      $journal_lede = get_theme_mod('journal_lede', __("Quiet stories from our atelier \u{2014} craft, heritage, styling, and the small moments that make a piece.", 'siliq'));
      echo esc_html($journal_lede);
    ?></p>
  </section>

  <!-- Category tabs -->
  <?php if (!empty($categories)) : ?>
    <section class="journal-tabs">
      <div class="journal-tabs__inner">
        <a class="journal-tab is-active" href="<?php the_permalink(); ?>" data-cursor="hover"><?php esc_html_e('All', 'siliq'); ?></a>
        <?php foreach (array_slice($categories, 0, 6) as $cat) : ?>
          <a class="journal-tab" href="<?php echo esc_url(get_category_link($cat)); ?>" data-cursor="hover"><?php echo esc_html($cat->name); ?></a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- Featured post -->
  <?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post();
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
    if (!$thumb) {
        $thumb = 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=2000&q=80';
    }
    $cats = get_the_category();
    $cat_label = !empty($cats) ? $cats[0]->name : __('Featured', 'siliq');
  ?>
    <section class="section section--journal-featured">
      <a href="<?php the_permalink(); ?>" class="journal-featured" data-cursor="view">
        <div class="journal-featured__media mask-reveal">
          <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" data-parallax="0.12" />
        </div>
        <div class="journal-featured__copy">
          <p class="eyebrow"><?php echo esc_html($cat_label); ?> &middot; <?php esc_html_e('Featured', 'siliq'); ?></p>
          <h2 data-anim="words"><?php the_title(); ?></h2>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 36)); ?></p>
          <div class="journal-featured__meta">
            <span class="muted small"><?php echo esc_html(get_the_date()); ?></span>
            <span class="muted small">&middot;</span>
            <span class="muted small"><?php echo esc_html(siliq_reading_time()); ?></span>
          </div>
          <span class="link-underline"><?php esc_html_e('Read the story', 'siliq'); ?></span>
        </div>
      </a>
    </section>
  <?php endwhile; wp_reset_postdata(); endif; ?>

  <!-- Articles grid -->
  <section class="section section--journal-grid">
    <?php if ($grid_query->have_posts()) : ?>
      <div class="journal-grid">
        <?php while ($grid_query->have_posts()) : $grid_query->the_post();
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

      <?php if ($grid_query->max_num_pages > 1) : ?>
        <div class="shop-pagination" data-anim="fade-up">
          <?php
          $prev = $paged > 1 ? add_query_arg('siliq_journal_page', $paged - 1, get_permalink()) : '';
          $next = $paged < $grid_query->max_num_pages ? add_query_arg('siliq_journal_page', $paged + 1, get_permalink()) : '';
          ?>
          <?php if ($prev) : ?>
            <a class="shop-pagination__btn" href="<?php echo esc_url($prev); ?>" aria-label="Previous">&larr;</a>
          <?php else : ?>
            <button class="shop-pagination__btn" disabled aria-label="Previous">&larr;</button>
          <?php endif; ?>

          <?php for ($i = 1; $i <= min(5, $grid_query->max_num_pages); $i++) : ?>
            <?php if ($i === $paged) : ?>
              <span class="shop-pagination__num is-active"><?php echo esc_html(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></span>
            <?php else : ?>
              <a class="shop-pagination__num" href="<?php echo esc_url(add_query_arg('siliq_journal_page', $i, get_permalink())); ?>"><?php echo esc_html(str_pad($i, 2, '0', STR_PAD_LEFT)); ?></a>
            <?php endif; ?>
          <?php endfor; ?>

          <?php if ($next) : ?>
            <a class="shop-pagination__btn" href="<?php echo esc_url($next); ?>" data-cursor="hover" aria-label="Next">&rarr;</a>
          <?php else : ?>
            <button class="shop-pagination__btn" disabled aria-label="Next">&rarr;</button>
          <?php endif; ?>
        </div>
      <?php endif; ?>

    <?php else : ?>
      <div style="text-align:center; padding: 80px 0;">
        <p class="muted"><?php esc_html_e('No stories yet. Check back soon.', 'siliq'); ?></p>
      </div>
    <?php endif;
    wp_reset_postdata(); ?>
  </section>

  <?php
  $marquee_args = array('items' => array(
      array('text' => __('The Journal', 'siliq'),              'em' => false),
      array('text' => __('Stories From The Bench', 'siliq'),   'em' => true),
      array('text' => __('Craft', 'siliq'),                    'em' => false),
      array('text' => __('Heritage', 'siliq'),                 'em' => true),
      array('text' => __('Styling', 'siliq'),                  'em' => false),
      array('text' => __('Launches', 'siliq'),                 'em' => true),
  ));
  get_template_part('template-parts/brand-marquee', null, $marquee_args);
  ?>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
