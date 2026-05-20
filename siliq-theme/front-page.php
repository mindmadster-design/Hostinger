<?php
/**
 * SILIQ Theme - Homepage Template
 */
get_header();

$hero_image = get_theme_mod('hero_image', 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=2000&q=80');
$hero_eyebrow = get_theme_mod('hero_eyebrow', 'A Quiet Devotion To Craft — Since The First Sketch');
$hero_title = get_theme_mod('hero_title', 'Silver, <em>refined</em> into heirloom.');
$hero_subtitle = get_theme_mod('hero_subtitle', '925 sterling silver, slowly handcrafted in limited editions.');
$hero_cta_text = get_theme_mod('hero_cta_text', 'Discover The Collection');
$hero_cta_url = get_theme_mod('hero_cta_url', wc_get_page_permalink('shop'));
?>

<main>

  <!-- Hero -->
  <section class="hero">
    <div class="hero__media">
      <img src="<?php echo esc_url($hero_image); ?>" alt="<?php bloginfo('name'); ?>" data-parallax="0.2" />
    </div>
    <div class="hero__content">
      <p class="eyebrow" data-anim="fade-up"><?php echo esc_html($hero_eyebrow); ?></p>
      <h1 class="hero__title" data-anim="words"><?php echo wp_kses_post($hero_title); ?></h1>
      <p class="hero__subtitle" data-anim="fade-up"><?php echo esc_html($hero_subtitle); ?></p>
      <div class="hero__cta" data-anim="fade-up">
        <a href="<?php echo esc_url($hero_cta_url); ?>" class="btn btn--primary" data-cursor="hover"><?php echo esc_html($hero_cta_text); ?></a>
        <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn--ghost" data-cursor="hover">Our Heritage</a>
      </div>
    </div>
    <div class="hero__scroll">
      <span>Scroll</span>
      <span class="hero__scroll-line"></span>
    </div>
  </section>

  <!-- Product Categories / Collections -->
  <section class="section section--collections" id="collections">
    <div class="section__head">
      <p class="eyebrow" data-anim="fade-up">The Collections</p>
      <h2 class="section__title" data-anim="words">Pieces with intention.</h2>
    </div>
    <div class="collections-grid">
      <?php
      $categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'number'     => 4,
        'exclude'    => array(get_option('default_product_cat')),
      ));
      if ($categories && !is_wp_error($categories)) :
        foreach ($categories as $cat) :
          $thumb_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
          $thumb_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'siliq-collection') : 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=900&q=80';
      ?>
        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="collection-card reveal" data-cursor="explore">
          <div class="collection-card__media mask-reveal">
            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" />
          </div>
          <div class="collection-card__body">
            <h3><?php echo esc_html($cat->name); ?></h3>
            <span class="link-arrow">Explore &rarr;</span>
          </div>
        </a>
      <?php
        endforeach;
      endif;
      ?>
    </div>
  </section>

  <!-- Brand Marquee -->
  <section class="brand-marquee" aria-hidden="true">
    <div class="brand-marquee__track">
      <span>SILIQ</span>
      <span class="brand-marquee__dot">&bull;</span>
      <span><em>925 Sterling Silver</em></span>
      <span class="brand-marquee__dot">&bull;</span>
      <span>Handcrafted</span>
      <span class="brand-marquee__dot">&bull;</span>
      <span><em>Maison de Argent</em></span>
      <span class="brand-marquee__dot">&bull;</span>
      <span>SILIQ</span>
      <span class="brand-marquee__dot">&bull;</span>
      <span><em>925 Sterling Silver</em></span>
      <span class="brand-marquee__dot">&bull;</span>
      <span>Handcrafted</span>
      <span class="brand-marquee__dot">&bull;</span>
      <span><em>Maison de Argent</em></span>
      <span class="brand-marquee__dot">&bull;</span>
    </div>
  </section>

  <!-- Featured Products -->
  <section class="section section--featured" id="shop">
    <div class="section__head section__head--row">
      <div>
        <p class="eyebrow" data-anim="fade-up">Featured</p>
        <h2 class="section__title" data-anim="words">New This Season</h2>
      </div>
      <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="link-underline" data-cursor="hover">View all</a>
    </div>
    <div class="products-grid">
      <?php
      $featured = new WP_Query(array(
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'meta_key'       => '_featured',
        'meta_value'     => 'yes',
        'orderby'        => 'date',
        'order'          => 'DESC',
      ));
      // Fallback to recent products if no featured ones
      if (!$featured->have_posts()) {
        $featured = new WP_Query(array(
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'orderby'        => 'date',
          'order'          => 'DESC',
        ));
      }
      if ($featured->have_posts()) :
        while ($featured->have_posts()) : $featured->the_post();
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
            <p class="product-card__meta"><?php echo wp_kses_post(wc_get_product_category_list($product->get_id())); ?></p>
            <p class="product-card__price"><?php echo $product->get_price_html(); ?></p>
          </div>
        </a>
      <?php
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="section section--newsletter">
    <div class="newsletter">
      <p class="eyebrow" data-anim="fade-up">Correspondence</p>
      <h2 data-anim="words">Letters from the atelier.</h2>
      <p class="newsletter__lede" data-anim="fade-up">First access to new pieces, private events, and quiet stories from the bench.</p>
      <form class="newsletter__form" data-anim="fade-up" action="#" method="post">
        <input type="email" name="email" placeholder="Your email address" required />
        <button type="submit" data-cursor="hover">Subscribe</button>
      </form>
      <p class="newsletter__fine">By subscribing you agree to our Privacy Policy.</p>
    </div>
  </section>

</main>

<?php get_footer(); ?>
