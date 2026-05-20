<?php
/**
 * SILIQ - WooCommerce Single Product
 */
get_header();

while (have_posts()) : the_post();
  global $product;
  $image = wp_get_attachment_image_url($product->get_image_id(), 'full');
  $gallery = $product->get_gallery_image_ids();
?>

<main>
  <!-- Breadcrumb -->
  <nav class="breadcrumb">
    <?php woocommerce_breadcrumb(); ?>
  </nav>

  <!-- Product Detail -->
  <section class="section product-detail">
    <div class="product-detail__grid">

      <!-- Gallery -->
      <div class="product-gallery">
        <?php if (!empty($gallery)) : ?>
        <div class="product-gallery__thumbs">
          <button class="thumb is-active" data-img="<?php echo esc_url($image); ?>" data-cursor="hover">
            <?php echo $product->get_image('siliq-product-thumb'); ?>
          </button>
          <?php foreach ($gallery as $gal_id) :
            $gal_url = wp_get_attachment_image_url($gal_id, 'full');
            $gal_thumb = wp_get_attachment_image_url($gal_id, 'siliq-product-thumb');
          ?>
            <button class="thumb" data-img="<?php echo esc_url($gal_url); ?>" data-cursor="hover">
              <img src="<?php echo esc_url($gal_thumb); ?>" alt="" />
            </button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="product-gallery__main">
          <img id="mainProductImg" src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" />
          <?php if ($product->is_on_sale()) : ?>
            <span class="product-card__tag">Sale</span>
          <?php elseif ($product->is_featured()) : ?>
            <span class="product-card__tag">New</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Info -->
      <div class="product-info">
        <p class="product-info__category"><?php echo wc_get_product_category_list($product->get_id(), ' &middot; '); ?></p>
        <h1 class="product-info__title"><?php the_title(); ?></h1>
        <p class="product-info__price"><?php echo $product->get_price_html(); ?></p>
        <div class="product-info__short"><?php echo wp_kses_post($product->get_short_description()); ?></div>

        <!-- Add to Cart Form -->
        <?php woocommerce_template_single_add_to_cart(); ?>

        <!-- Trust indicators -->
        <ul class="product-trust">
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 7h18M3 12h18M6 17h12"/></svg>
            Complimentary shipping over $150
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
            Ships within 2 business days
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M12 2L4 6v6c0 5 4 9 8 10 4-1 8-5 8-10V6l-8-4z"/></svg>
            Lifetime polishing &amp; minor repair
          </li>
          <li>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><path d="M3 9l9-6 9 6v12H3z"/><path d="M9 21V12h6v9"/></svg>
            Hand-finished in our atelier
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Product Tabs (Description, etc.) -->
  <section class="section section--tabs">
    <?php woocommerce_output_product_data_tabs(); ?>
  </section>

  <!-- Related Products -->
  <section class="section">
    <?php woocommerce_output_related_products(); ?>
  </section>
</main>

<?php endwhile; ?>

<?php get_footer(); ?>
