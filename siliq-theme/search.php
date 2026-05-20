<?php
/**
 * SILIQ Theme - Search Results
 */
get_header();
?>

<main>
  <section class="page-header">
    <p class="eyebrow">Search Results</p>
    <h1 data-anim="words">Results for &ldquo;<?php echo get_search_query(); ?>&rdquo;</h1>
  </section>

  <section class="section section--shop-grid">
    <?php if (have_posts()) : ?>
      <div class="products-grid products-grid--lg">
        <?php while (have_posts()) : the_post(); ?>
          <?php if (get_post_type() === 'product') : global $product; ?>
            <a href="<?php the_permalink(); ?>" class="product-card reveal" data-cursor="view">
              <div class="product-card__media">
                <?php echo $product->get_image('siliq-product', array('class' => 'product-card__img product-card__img--1')); ?>
              </div>
              <div class="product-card__body">
                <h3><?php the_title(); ?></h3>
                <p class="product-card__price"><?php echo $product->get_price_html(); ?></p>
              </div>
            </a>
          <?php else : ?>
            <article>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <?php the_excerpt(); ?>
            </article>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    <?php else : ?>
      <div style="text-align:center; padding:80px 0;">
        <h2>No results found</h2>
        <p>Try a different search term or browse our collection.</p>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn--primary">Shop Now</a>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>
