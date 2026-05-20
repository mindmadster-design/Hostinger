<?php
/**
 * SILIQ - WooCommerce Shop / Product Archive
 */
get_header();
?>

<main>
  <section class="page-header">
    <p class="eyebrow" data-anim="fade-up"><?php woocommerce_breadcrumb(); ?></p>
    <h1 data-anim="words"><?php woocommerce_page_title(); ?></h1>
    <?php if (is_product_category() && category_description()) : ?>
      <p class="page-header__lede" data-anim="fade-up"><?php echo category_description(); ?></p>
    <?php else : ?>
      <p class="page-header__lede" data-anim="fade-up">Solid 925 sterling silver, hand-finished in our atelier. Each piece is hallmarked and signed.</p>
    <?php endif; ?>
  </section>

  <section class="section section--shop-grid">
    <?php if (woocommerce_product_loop()) : ?>
      <div class="products-grid products-grid--lg">
        <?php while (have_posts()) : the_post();
          global $product;
          $image = wp_get_attachment_image_url($product->get_image_id(), 'siliq-product');
          $gallery = $product->get_gallery_image_ids();
          $image2 = !empty($gallery) ? wp_get_attachment_image_url($gallery[0], 'siliq-product') : $image;
        ?>
          <a href="<?php the_permalink(); ?>" class="product-card reveal" data-cursor="view">
            <div class="product-card__media">
              <img class="product-card__img product-card__img--1" src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" />
              <img class="product-card__img product-card__img--2" src="<?php echo esc_url($image2); ?>" alt="<?php the_title_attribute(); ?>" />
              <?php if ($product->is_on_sale()) : ?>
                <span class="product-card__tag">Sale</span>
              <?php elseif ($product->is_featured()) : ?>
                <span class="product-card__tag">New</span>
              <?php endif; ?>
            </div>
            <div class="product-card__body">
              <h3><?php the_title(); ?></h3>
              <p class="product-card__meta"><?php echo wc_get_product_category_list($product->get_id()); ?></p>
              <p class="product-card__price"><?php echo $product->get_price_html(); ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>

      <?php woocommerce_pagination(); ?>

    <?php else : ?>
      <div style="text-align:center; padding:80px 0;">
        <h2>No products found</h2>
        <p>Check back soon — new pieces are added regularly.</p>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php get_footer(); ?>
