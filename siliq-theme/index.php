<?php
/**
 * SILIQ Theme - Default Template
 */
get_header();
?>

<main>
  <section class="section">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <article>
          <h2><?php the_title(); ?></h2>
          <?php the_content(); ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <p>No content found.</p>
    <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>
