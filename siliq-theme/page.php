<?php
/**
 * SILIQ Theme - Page Template
 */
get_header();
?>

<main>
  <section class="page-header">
    <h1 data-anim="words"><?php the_title(); ?></h1>
  </section>

  <section class="section">
    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </section>
</main>

<?php get_footer(); ?>
