<?php
/**
 * SILIQ Theme — Default Page Template
 *
 * Used for any standard Page that doesn't have a "Template Name" assigned.
 */
if (!defined('ABSPATH')) exit;
get_header();
?>

<main>

  <?php while (have_posts()) : the_post(); ?>

    <!-- Page header -->
    <section class="page-header">
      <p class="eyebrow" data-anim="fade-up">
        <?php
        if ($parent_id = wp_get_post_parent_id(get_the_ID())) {
            echo esc_html(get_the_title($parent_id)) . ' / ';
        }
        echo esc_html(get_bloginfo('name'));
        ?>
      </p>
      <h1 data-anim="words"><?php the_title(); ?></h1>
      <?php if ($excerpt = get_the_excerpt()) : ?>
        <p class="page-header__lede" data-anim="fade-up"><?php echo esc_html($excerpt); ?></p>
      <?php endif; ?>
    </section>

    <!-- Featured image -->
    <?php if (has_post_thumbnail()) : ?>
      <section class="page-feature mask-reveal">
        <?php the_post_thumbnail('full', array('data-parallax' => '0.1')); ?>
      </section>
    <?php endif; ?>

    <!-- Body -->
    <section class="section page-body">
      <div class="article-body__inner">
        <?php the_content(); ?>

        <?php
        wp_link_pages(array(
            'before' => '<p class="article-page-links">' . esc_html__('Pages:', 'siliq'),
            'after'  => '</p>',
        ));
        ?>
      </div>
    </section>

    <?php if (comments_open() || get_comments_number()) : ?>
      <section class="section">
        <div class="article-body__inner">
          <?php comments_template(); ?>
        </div>
      </section>
    <?php endif; ?>

  <?php endwhile; ?>

</main>

<?php get_footer(); ?>
