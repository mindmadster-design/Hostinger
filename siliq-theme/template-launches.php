<?php
/**
 * Template Name: SILIQ — Launches
 *
 * Bridal / launches collection page. Pulls products tagged "launches"
 * (slug-configurable via Customizer) for the featured grid; falls back to
 * featured products if no products carry the tag.
 */
if (!defined('ABSPATH')) exit;
get_header();

$hero_image  = get_theme_mod('launches_hero_image', 'https://images.unsplash.com/photo-1606800052052-a08af7148866?w=2000&q=80');
$tag_slug    = get_theme_mod('launches_tag_slug', 'launches');
$shop_url    = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
$contact_url = (function_exists('siliq_get_contact_url')) ? siliq_get_contact_url() : home_url('/contact');
?>

<main>

  <!-- Tall hero -->
  <section class="page-hero page-hero--tall">
    <div class="page-hero__media">
      <img src="<?php echo esc_url($hero_image); ?>" alt="" data-parallax="0.18" />
    </div>
    <div class="page-hero__content">
      <p class="page-hero__crumb" data-anim="fade-up"><?php
        echo esc_html(get_bloginfo('name')); ?> / <?php the_title();
      ?></p>
      <h1 data-anim="words"><?php esc_html_e('For the', 'siliq'); ?> <em><?php esc_html_e('quiet', 'siliq'); ?></em> <?php esc_html_e('moment.', 'siliq'); ?></h1>
      <p class="page-hero__lede" data-anim="fade-up"><?php echo esc_html__("Engagement rings, wedding bands, and bridal suites \u{2014} solid 925 sterling silver, hand-finished and signed.", 'siliq'); ?></p>
      <a href="#bridal-essentials" class="btn btn--ghost" data-cursor="hover"><?php esc_html_e('Discover', 'siliq'); ?></a>
    </div>
  </section>

  <!-- Editorial intent -->
  <section class="section section--editorial">
    <div class="editorial">
      <div class="editorial__copy">
        <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('An Heirloom in the Making', 'siliq'); ?></p>
        <h2 data-anim="words"><?php esc_html_e('A piece that begins one chapter and outlasts many.', 'siliq'); ?></h2>
        <p data-anim="fade-up"><?php echo esc_html__("Our bridal pieces are designed to be worn for a lifetime \u{2014} past the day itself, past the photographs, past the small ceremonies that follow. They are made simply, in solid silver, so they can be polished, repaired, and passed on.", 'siliq'); ?></p>
        <p data-anim="fade-up"><?php esc_html_e('Each is hallmarked with the date you receive it, by hand.', 'siliq'); ?></p>
      </div>
      <div class="editorial__media mask-reveal">
        <img src="<?php echo esc_url(get_theme_mod('launches_editorial_image', 'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?w=1400&q=80')); ?>" alt="" data-parallax="0.15" />
      </div>
    </div>
  </section>

  <!-- Bridal essentials -->
  <section class="section section--bridal-essentials" id="bridal-essentials">
    <div class="section__head section__head--center">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('The Bridal Edit', 'siliq'); ?></p>
      <h2 class="section__title" data-anim="words"><?php esc_html_e('Three quiet pieces.', 'siliq'); ?></h2>
    </div>

    <div class="bridal-essentials">
      <?php
      $essentials = array(
          array('num' => '01', 'title' => __('Engagement Rings', 'siliq'),
                'desc' => __("Hand-cast solitaires, signets and quiet bands \u{2014} designed to be worn before, during, and long after the proposal.", 'siliq'),
                'image' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=1200&q=80'),
          array('num' => '02', 'title' => __('Wedding Bands', 'siliq'),
                'desc' => __('Plain bands in three weights, in matte or polished finish, sized for every hand. Engraving is complimentary.', 'siliq'),
                'image' => 'https://images.unsplash.com/photo-1535632787350-4e68ef0ac584?w=1200&q=80'),
          array('num' => '03', 'title' => __('Bridal Suites', 'siliq'),
                'desc' => __('Earrings, pendants and chains chosen to be worn with the dress. Pieces that recede, then quietly catch the light.', 'siliq'),
                'image' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1200&q=80'),
      );
      foreach ($essentials as $e) : ?>
        <a href="<?php echo esc_url($shop_url); ?>" class="bridal-card reveal" data-cursor="explore">
          <div class="bridal-card__media mask-reveal">
            <img src="<?php echo esc_url($e['image']); ?>" alt="<?php echo esc_attr($e['title']); ?>" />
          </div>
          <div class="bridal-card__body">
            <p class="eyebrow"><?php echo esc_html($e['num']); ?></p>
            <h3><?php echo esc_html($e['title']); ?></h3>
            <p><?php echo esc_html($e['desc']); ?></p>
            <span class="link-arrow"><?php esc_html_e('Explore', 'siliq'); ?> &rarr;</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <?php
  $marquee_args = array('items' => array(
      array('text' => __('Bespoke Bridal', 'siliq'),       'em' => false),
      array('text' => __('Hand-engraved', 'siliq'),        'em' => true),
      array('text' => __('Hallmarked With The Date', 'siliq'), 'em' => false),
      array('text' => __('Signed By Maker', 'siliq'),      'em' => true),
  ));
  get_template_part('template-parts/brand-marquee', null, $marquee_args);
  ?>

  <!-- Featured bridal pieces -->
  <section class="section section--featured">
    <div class="section__head section__head--center">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Selected For The Day', 'siliq'); ?></p>
      <h2 class="section__title" data-anim="words"><?php esc_html_e('A small bridal selection.', 'siliq'); ?></h2>
    </div>
    <div class="products-grid">
      <?php
      $bridal_query_args = array(
          'post_type'      => 'product',
          'posts_per_page' => 4,
          'tax_query'      => array(array(
              'taxonomy' => 'product_tag',
              'field'    => 'slug',
              'terms'    => $tag_slug,
          )),
      );
      $bridal = class_exists('WooCommerce') ? new WP_Query($bridal_query_args) : null;

      // Fallback to featured/recent products if WC is on but no tagged ones found.
      if ($bridal && !$bridal->have_posts()) {
          $bridal = new WP_Query(array(
              'post_type'      => 'product',
              'posts_per_page' => 4,
              'meta_key'       => '_featured',
              'meta_value'     => 'yes',
          ));
      }

      if ($bridal && $bridal->have_posts()) :
          while ($bridal->have_posts()) : $bridal->the_post();
              global $product;
              $image = wp_get_attachment_image_url($product->get_image_id(), 'siliq-product');
              $gallery = $product->get_gallery_image_ids();
              $image2 = !empty($gallery) ? wp_get_attachment_image_url($gallery[0], 'siliq-product') : $image;
      ?>
        <a href="<?php the_permalink(); ?>" class="product-card reveal" data-cursor="view">
          <div class="product-card__media">
            <img class="product-card__img product-card__img--1" src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" />
            <img class="product-card__img product-card__img--2" src="<?php echo esc_url($image2); ?>" alt="<?php the_title_attribute(); ?>" />
            <span class="product-card__tag"><?php esc_html_e('Launches', 'siliq'); ?></span>
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
      else :
          // Fallback: show static placeholders if WooCommerce isn't installed.
          $placeholders = array(
              array('Vow Solitaire',         '925 Sterling Silver, single setting',  '$420', 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=900&q=80'),
              array('Anelle Wedding Band',   '925 Sterling Silver, polished',         '$210', 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?w=900&q=80'),
              array('Lume Bridal Pendant',   '925 Sterling Silver, fine chain',       '$240', 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=900&q=80'),
              array('Cinta Bridal Drops',    '925 Sterling Silver, pair',             '$295', 'https://images.unsplash.com/photo-1633934542430-0905ec85aa4f?w=900&q=80'),
          );
          foreach ($placeholders as $p) : ?>
            <a href="<?php echo esc_url($shop_url); ?>" class="product-card reveal" data-cursor="view">
              <div class="product-card__media">
                <img class="product-card__img product-card__img--1" src="<?php echo esc_url($p[3]); ?>" alt="" />
                <span class="product-card__tag"><?php esc_html_e('Launches', 'siliq'); ?></span>
              </div>
              <div class="product-card__body">
                <h3><?php echo esc_html($p[0]); ?></h3>
                <p class="product-card__meta"><?php echo esc_html($p[1]); ?></p>
                <p class="product-card__price"><?php echo esc_html($p[2]); ?></p>
              </div>
            </a>
          <?php endforeach;
      endif; ?>
    </div>
  </section>

  <!-- Quote -->
  <section class="section section--quote">
    <blockquote data-anim="words"><?php echo esc_html__('"My ring has been quietly polished by their atelier four times in eleven years. Each time, returned more like itself."', 'siliq'); ?></blockquote>
    <cite data-anim="fade-up"><?php echo esc_html__('— Léa M., Lyon · married 2014', 'siliq'); ?></cite>
  </section>

  <!-- Bespoke CTA -->
  <section class="section section--bridal-cta">
    <div class="bridal-cta">
      <div class="bridal-cta__media mask-reveal">
        <img src="<?php echo esc_url(get_theme_mod('launches_cta_image', 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1400&q=80')); ?>" alt="" data-parallax="0.15" />
      </div>
      <div class="bridal-cta__copy">
        <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('By Appointment', 'siliq'); ?></p>
        <h2 data-anim="words"><?php esc_html_e('A private hour at the atelier.', 'siliq'); ?></h2>
        <p data-anim="fade-up"><?php esc_html_e('For bespoke bridal, we welcome a small number of couples each season. Together we sketch, choose silver weight, agree the engraving, and meet again to approve the wax model before casting.', 'siliq'); ?></p>
        <p data-anim="fade-up"><?php echo esc_html__("Allow 8\u{2013}12 weeks. The first conversation is over tea, in person or by video.", 'siliq'); ?></p>
        <div class="bridal-cta__actions" data-anim="fade-up">
          <a href="<?php echo esc_url($contact_url); ?>" class="btn btn--primary" data-cursor="hover"><?php esc_html_e('Book An Appointment', 'siliq'); ?></a>
          <a href="<?php echo esc_url($contact_url); ?>" class="link-underline" data-cursor="hover"><?php esc_html_e('Or write to us', 'siliq'); ?></a>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
