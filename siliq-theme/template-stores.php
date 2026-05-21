<?php
/**
 * Template Name: SILIQ — Stores
 *
 * Stores / locations page. Stores are configured via Appearance → Customize → "Stores"
 * (up to 3 cards). Falls back to defaults shown in the static preview.
 */
if (!defined('ABSPATH')) exit;
get_header();

$hero_image = get_theme_mod('stores_hero_image', 'https://images.unsplash.com/photo-1431274172761-fca41d930114?w=2000&q=80');

$default_stores = array(
    array(
        'eyebrow' => __('Flagship Atelier', 'siliq'),
        'name'    => 'Paris',
        'address' => "14 Rue de l\u{2019}Argent, 75001 Paris, France",
        'image'   => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1400&q=80',
        'hours'   => 'Tue–Sat · 10.00 — 18.00',
        'phone'   => '+33 0 00 00 00 00',
        'phone_tel' => '+33000000000',
        'email'   => 'paris@siliq.com',
        'transit_label' => __('Métro', 'siliq'),
        'transit' => 'Louvre-Rivoli, Châtelet',
    ),
    array(
        'eyebrow' => __('Mayfair Showroom', 'siliq'),
        'name'    => 'London',
        'address' => '7 Mount Street, London W1K 2BS, United Kingdom',
        'image'   => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=1400&q=80',
        'hours'   => 'Mon–Sat · 11.00 — 19.00',
        'phone'   => '+44 0 0000 0000',
        'phone_tel' => '+44000000000',
        'email'   => 'london@siliq.com',
        'transit_label' => __('Tube', 'siliq'),
        'transit' => 'Bond Street, Green Park',
    ),
    array(
        'eyebrow' => __('Brera Studio', 'siliq'),
        'name'    => 'Milan',
        'address' => 'Via Solferino 9, 20121 Milano, Italy',
        'image'   => 'https://images.unsplash.com/photo-1531572753322-ad063cecc140?w=1400&q=80',
        'hours'   => 'Tue–Sat · 10.30 — 19.00',
        'phone'   => '+39 02 0000 0000',
        'phone_tel' => '+39000000000',
        'email'   => 'milano@siliq.com',
        'transit_label' => __('Metro', 'siliq'),
        'transit' => 'Lanza, Moscova',
    ),
);

$contact_url = (function_exists('siliq_get_contact_url')) ? siliq_get_contact_url() : home_url('/contact');
?>

<main>

  <!-- Page hero -->
  <section class="page-hero">
    <div class="page-hero__media">
      <img src="<?php echo esc_url($hero_image); ?>" alt="" data-parallax="0.18" />
    </div>
    <div class="page-hero__content">
      <p class="page-hero__crumb" data-anim="fade-up"><?php
        echo esc_html(get_bloginfo('name')); ?> / <?php the_title();
      ?></p>
      <h1 data-anim="words"><?php esc_html_e('Visit', 'siliq'); ?> <em><?php esc_html_e('us.', 'siliq'); ?></em></h1>
      <p class="page-hero__lede" data-anim="fade-up"><?php esc_html_e('Three small rooms in three quiet cities. Each one is staffed by a maker who can handle a piece, polish a ring, or take a commission.', 'siliq'); ?></p>
    </div>
  </section>

  <!-- Stores grid -->
  <section class="section section--stores">
    <?php foreach ($default_stores as $i => $s) :
      $reverse_class = ($i === 1) ? ' store-card--reverse' : '';
    ?>
      <div class="store-card<?php echo esc_attr($reverse_class); ?>">
        <div class="store-card__media mask-reveal">
          <img src="<?php echo esc_url($s['image']); ?>" alt="<?php echo esc_attr($s['name']); ?>" data-parallax="0.12" />
        </div>
        <div class="store-card__copy">
          <p class="eyebrow" data-anim="fade-up"><?php echo esc_html($s['eyebrow']); ?></p>
          <h2 data-anim="words"><?php echo esc_html($s['name']); ?></h2>
          <p data-anim="fade-up"><?php echo esc_html($s['address']); ?></p>
          <ul class="store-info">
            <li><span class="muted"><?php esc_html_e('Hours', 'siliq'); ?></span><span><?php echo esc_html($s['hours']); ?></span></li>
            <li><span class="muted"><?php esc_html_e('Phone', 'siliq'); ?></span><span><a href="tel:<?php echo esc_attr($s['phone_tel']); ?>" class="link-underline" data-cursor="hover"><?php echo esc_html($s['phone']); ?></a></span></li>
            <li><span class="muted"><?php esc_html_e('Email', 'siliq'); ?></span><span><a href="mailto:<?php echo esc_attr($s['email']); ?>" class="link-underline" data-cursor="hover"><?php echo esc_html($s['email']); ?></a></span></li>
            <li><span class="muted"><?php echo esc_html($s['transit_label']); ?></span><span><?php echo esc_html($s['transit']); ?></span></li>
          </ul>
          <div class="store-card__actions">
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn--ghost btn--dark" data-cursor="hover"><?php esc_html_e('Book Appointment', 'siliq'); ?></a>
            <a href="#" class="link-underline" data-cursor="hover"><?php esc_html_e('Get directions', 'siliq'); ?> &rarr;</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>

  <!-- Stockists -->
  <section class="section section--stockists">
    <div class="section__head section__head--center">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Stockists Worldwide', 'siliq'); ?></p>
      <h2 class="section__title" data-anim="words"><?php esc_html_e('Found in good hands.', 'siliq'); ?></h2>
    </div>
    <div class="stockist-list" data-anim="press">
      <?php
      $stockists = array(
          'DOVER STREET MARKET — TOKYO',
          '10 CORSO COMO — SEOUL',
          'BERGDORF GOODMAN — NEW YORK',
          'THE WEBSTER — MIAMI',
          'LANE CRAWFORD — HONG KONG',
          'HOLT RENFREW — TORONTO',
          'SISTER — STOCKHOLM',
          'RUE MADAME — BARCELONA',
          'NET-A-PORTER — ONLINE',
          'MR PORTER — ONLINE',
      );
      foreach ($stockists as $stockist) : ?>
        <span><?php echo esc_html($stockist); ?></span>
      <?php endforeach; ?>
    </div>
  </section>

  <?php
  $marquee_args = array('items' => array(
      array('text' => 'Paris',                   'em' => false),
      array('text' => 'London',                  'em' => true),
      array('text' => 'Milan',                   'em' => false),
      array('text' => 'Visit By Appointment',    'em' => true),
  ));
  get_template_part('template-parts/brand-marquee', null, $marquee_args);
  ?>

  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
