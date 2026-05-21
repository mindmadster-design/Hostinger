<?php
/**
 * SILIQ Theme — Single Post (Journal article)
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<main class="single-article">

  <?php while (have_posts()) : the_post();
    $cats = get_the_category();
    $cat_label = !empty($cats) ? $cats[0]->name : __('Journal', 'siliq');
    $journal_url = siliq_get_journal_url();
  ?>

    <!-- Article header -->
    <section class="article-header">
      <nav class="breadcrumb">
        <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'siliq'); ?></a><span>/</span>
        <a href="<?php echo esc_url($journal_url); ?>"><?php esc_html_e('Journal', 'siliq'); ?></a><span>/</span>
        <span class="muted"><?php the_title(); ?></span>
      </nav>
      <p class="eyebrow" data-anim="fade-up"><?php echo esc_html($cat_label); ?></p>
      <h1 class="article-header__title" data-anim="words"><?php the_title(); ?></h1>
      <p class="article-header__meta">
        <span><?php echo esc_html(get_the_date()); ?></span>
        <span>&middot;</span>
        <span><?php echo esc_html(siliq_reading_time()); ?></span>
        <?php if ($author = get_the_author()) : ?>
          <span>&middot;</span>
          <span><?php echo esc_html($author); ?></span>
        <?php endif; ?>
      </p>
    </section>

    <!-- Featured image -->
    <?php if (has_post_thumbnail()) : ?>
      <section class="article-feature mask-reveal">
        <?php the_post_thumbnail('full', array('data-parallax' => '0.1')); ?>
      </section>
    <?php endif; ?>

    <!-- Body -->
    <article class="article-body">
      <div class="article-body__inner">
        <?php the_content(); ?>

        <?php
        wp_link_pages(array(
            'before' => '<p class="article-page-links">' . esc_html__('Pages:', 'siliq'),
            'after'  => '</p>',
        ));
        ?>

        <?php if (has_tag()) : ?>
          <p class="article-tags">
            <span class="muted"><?php esc_html_e('Tagged:', 'siliq'); ?></span> <?php the_tags('', ', '); ?>
          </p>
        <?php endif; ?>
      </div>
    </article>

    <!-- Post navigation -->
    <section class="article-nav">
      <?php
      $prev_post = get_previous_post();
      $next_post = get_next_post();
      ?>
      <?php if ($prev_post) : ?>
        <a class="article-nav__link article-nav__link--prev" href="<?php echo esc_url(get_permalink($prev_post)); ?>" data-cursor="hover">
          <span class="muted small">&larr; <?php esc_html_e('Previous', 'siliq'); ?></span>
          <h4><?php echo esc_html(get_the_title($prev_post)); ?></h4>
        </a>
      <?php else : ?>
        <span></span>
      <?php endif; ?>

      <?php if ($next_post) : ?>
        <a class="article-nav__link article-nav__link--next" href="<?php echo esc_url(get_permalink($next_post)); ?>" data-cursor="hover">
          <span class="muted small"><?php esc_html_e('Next', 'siliq'); ?> &rarr;</span>
          <h4><?php echo esc_html(get_the_title($next_post)); ?></h4>
        </a>
      <?php else : ?>
        <span></span>
      <?php endif; ?>
    </section>

    <?php if (comments_open() || get_comments_number()) : ?>
      <section class="section article-comments">
        <div class="article-body__inner">
          <?php comments_template(); ?>
        </div>
      </section>
    <?php endif; ?>

  <?php endwhile; ?>

  <?php
  // Related posts by first category
  $first_cat = !empty($cats) ? $cats[0]->term_id : 0;
  if ($first_cat) :
      $related = new WP_Query(array(
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'post__not_in'   => array(get_the_ID()),
          'cat'            => $first_cat,
          'orderby'        => 'rand',
      ));
      if ($related->have_posts()) : ?>
        <section class="section section--journal-grid">
          <div class="section__head section__head--center">
            <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Continue Reading', 'siliq'); ?></p>
            <h2 class="section__title" data-anim="words"><?php esc_html_e('More from the journal.', 'siliq'); ?></h2>
          </div>
          <div class="journal-grid">
            <?php while ($related->have_posts()) : $related->the_post();
              $thumb = get_the_post_thumbnail_url(get_the_ID(), 'siliq-collection');
              if (!$thumb) {
                  $thumb = 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=900&q=80';
              }
              $rcats = get_the_category();
              $rcat_label = !empty($rcats) ? $rcats[0]->name : __('Journal', 'siliq');
            ?>
              <a href="<?php the_permalink(); ?>" class="journal-card reveal" data-cursor="view">
                <div class="journal-card__media mask-reveal">
                  <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" />
                </div>
                <div class="journal-card__body">
                  <p class="eyebrow"><?php echo esc_html($rcat_label); ?></p>
                  <h3><?php the_title(); ?></h3>
                  <p class="journal-card__meta"><span class="muted small"><?php echo esc_html(get_the_date()); ?></span></p>
                </div>
              </a>
            <?php endwhile; ?>
          </div>
        </section>
      <?php endif;
      wp_reset_postdata();
  endif;
  ?>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
