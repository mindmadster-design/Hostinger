<?php
/**
 * Template Name: SILIQ — Contact
 *
 * Contact page with hero, contact methods, form, atelier hours, map, FAQ.
 *
 * Form posts to admin-post.php?action=siliq_contact (handler in functions.php).
 * Editable values live in Appearance → Customize → "Contact Page".
 */
if (!defined('ABSPATH')) exit;
get_header();

$hero_image = get_theme_mod('contact_hero_image', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=2000&q=80');
$email      = get_theme_mod('contact_email', 'hello@siliq.com');
$phone      = get_theme_mod('contact_phone', '+33 0 00 00 00');
$phone_tel  = get_theme_mod('contact_phone_tel', '+33000000000');
$address    = get_theme_mod('contact_address', '14 Rue de l’Argent');
$address_2  = get_theme_mod('contact_address_2', '75001 Paris, France · By appointment.');
$press      = get_theme_mod('contact_press_email', 'press@siliq.com');

$submitted  = isset($_GET['siliq_contacted']) && $_GET['siliq_contacted'] === '1';
?>

<main>

  <!-- Page hero -->
  <section class="page-hero">
    <div class="page-hero__media">
      <img src="<?php echo esc_url($hero_image); ?>" alt="<?php esc_attr_e('SILIQ Atelier', 'siliq'); ?>" data-parallax="0.18" />
    </div>
    <div class="page-hero__content">
      <p class="page-hero__crumb" data-anim="fade-up"><?php
        echo esc_html(get_bloginfo('name')); ?> / <?php the_title();
      ?></p>
      <h1 data-anim="words"><?php esc_html_e('Get in', 'siliq'); ?> <em><?php esc_html_e('touch.', 'siliq'); ?></em></h1>
      <p class="page-hero__lede" data-anim="fade-up"><?php echo esc_html__("Whether you are considering a piece, planning a commission, or visiting the atelier \u{2014} we\u{2019}d love to hear from you.", 'siliq'); ?></p>
    </div>
  </section>

  <!-- Contact methods -->
  <section class="section section--contact-methods">
    <div class="contact-methods">
      <a href="#contact-form" class="contact-method-card reveal" data-cursor="hover">
        <div class="contact-method-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="0.8">
            <rect x="4" y="8" width="24" height="16" />
            <path d="M4 10l12 9 12-9" />
          </svg>
        </div>
        <p class="eyebrow"><?php esc_html_e('Write', 'siliq'); ?></p>
        <h3><?php echo esc_html($email); ?></h3>
        <p class="contact-method-card__meta"><?php echo esc_html__("For general enquiries \u{2014} we reply within 24h.", 'siliq'); ?></p>
        <span class="link-arrow"><?php esc_html_e('Send a note', 'siliq'); ?> &rarr;</span>
      </a>

      <a href="tel:<?php echo esc_attr($phone_tel); ?>" class="contact-method-card reveal" data-cursor="hover">
        <div class="contact-method-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="0.8">
            <path d="M22 19v3a3 3 0 0 1-3 3 18 18 0 0 1-15-15 3 3 0 0 1 3-3h3a1 1 0 0 1 1 0.7l1.5 4.5-2.5 2.5a14 14 0 0 0 6 6l2.5-2.5 4.5 1.5a1 1 0 0 1 0.7 1z"/>
          </svg>
        </div>
        <p class="eyebrow"><?php esc_html_e('Call', 'siliq'); ?></p>
        <h3><?php echo esc_html($phone); ?></h3>
        <p class="contact-method-card__meta"><?php echo esc_html__("Tuesday \u{2014} Saturday, 10.00 \u{2014} 18.00 CET.", 'siliq'); ?></p>
        <span class="link-arrow"><?php esc_html_e('Speak with us', 'siliq'); ?> &rarr;</span>
      </a>

      <a href="#map" class="contact-method-card reveal" data-cursor="hover">
        <div class="contact-method-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="0.8">
            <path d="M16 4a8 8 0 0 1 8 8c0 6-8 16-8 16S8 18 8 12a8 8 0 0 1 8-8z" />
            <circle cx="16" cy="12" r="3" />
          </svg>
        </div>
        <p class="eyebrow"><?php esc_html_e('Visit', 'siliq'); ?></p>
        <h3><?php echo esc_html($address); ?></h3>
        <p class="contact-method-card__meta"><?php echo esc_html($address_2); ?></p>
        <span class="link-arrow"><?php esc_html_e('View location', 'siliq'); ?> &rarr;</span>
      </a>

      <a href="mailto:<?php echo esc_attr($press); ?>" class="contact-method-card reveal" data-cursor="hover">
        <div class="contact-method-card__icon">
          <svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="0.8">
            <path d="M6 6h12l8 8v12H6z" />
            <path d="M18 6v8h8" />
          </svg>
        </div>
        <p class="eyebrow"><?php esc_html_e('Press & Wholesale', 'siliq'); ?></p>
        <h3><?php echo esc_html($press); ?></h3>
        <p class="contact-method-card__meta"><?php esc_html_e('Editorial requests, samples, B2B partnerships.', 'siliq'); ?></p>
        <span class="link-arrow"><?php esc_html_e('Get in touch', 'siliq'); ?> &rarr;</span>
      </a>
    </div>
  </section>

  <!-- Form + atelier image -->
  <section class="section section--contact" id="contact-form">
    <div class="contact-grid contact-grid--reverse">
      <div class="contact-form-wrap">
        <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Send a Message', 'siliq'); ?></p>
        <h2 data-anim="words"><?php esc_html_e('Tell us a little about', 'siliq'); ?> <em><?php esc_html_e('your enquiry.', 'siliq'); ?></em></h2>
        <p data-anim="fade-up" class="contact-form-wrap__lede"><?php echo esc_html__("Use the form below for anything \u{2014} we read every message, and reply by hand.", 'siliq'); ?></p>

        <?php if ($submitted) : ?>
          <p class="contact-form__success"><?php esc_html_e('Sent ✓ — thank you. We will reply by hand.', 'siliq'); ?></p>
        <?php else : ?>
          <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="siliq_contact" />
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(get_permalink()); ?>" />
            <?php wp_nonce_field('siliq_contact', 'siliq_contact_nonce'); ?>

            <div class="contact-form__row">
              <label>
                <span><?php esc_html_e('First Name', 'siliq'); ?></span>
                <input type="text" name="first_name" required />
              </label>
              <label>
                <span><?php esc_html_e('Last Name', 'siliq'); ?></span>
                <input type="text" name="last_name" required />
              </label>
            </div>
            <div class="contact-form__row">
              <label>
                <span><?php esc_html_e('Email', 'siliq'); ?></span>
                <input type="email" name="email" required />
              </label>
              <label>
                <span><?php esc_html_e('Phone', 'siliq'); ?> <small>(<?php esc_html_e('optional', 'siliq'); ?>)</small></span>
                <input type="tel" name="phone" />
              </label>
            </div>
            <label>
              <span><?php esc_html_e('Subject', 'siliq'); ?></span>
              <select name="subject">
                <option><?php esc_html_e('General Enquiry', 'siliq'); ?></option>
                <option><?php esc_html_e('Commission', 'siliq'); ?></option>
                <option><?php esc_html_e('Repair Service', 'siliq'); ?></option>
                <option><?php esc_html_e('Press', 'siliq'); ?></option>
                <option><?php esc_html_e('Wholesale', 'siliq'); ?></option>
                <option><?php esc_html_e('Atelier Visit', 'siliq'); ?></option>
              </select>
            </label>
            <label>
              <span><?php esc_html_e('Message', 'siliq'); ?></span>
              <textarea rows="6" name="message" required placeholder="<?php esc_attr_e('Tell us what you have in mind...', 'siliq'); ?>"></textarea>
            </label>
            <button type="submit" class="btn btn--primary" data-cursor="hover"><?php esc_html_e('Send Message', 'siliq'); ?></button>
          </form>
        <?php endif; ?>
      </div>

      <div class="contact-aside">
        <div class="contact-aside__media mask-reveal">
          <img src="<?php echo esc_url(get_theme_mod('contact_aside_image', 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1400&q=80')); ?>" alt="" data-parallax="0.15" />
        </div>
        <div class="contact-aside__hours">
          <p class="eyebrow"><?php esc_html_e('Atelier Hours', 'siliq'); ?></p>
          <ul class="hours-list">
            <li><span><?php esc_html_e('Monday', 'siliq'); ?></span><span class="muted"><?php esc_html_e('Closed', 'siliq'); ?></span></li>
            <li><span><?php esc_html_e('Tuesday', 'siliq'); ?></span><span>10.00 &mdash; 18.00</span></li>
            <li><span><?php esc_html_e('Wednesday', 'siliq'); ?></span><span>10.00 &mdash; 18.00</span></li>
            <li><span><?php esc_html_e('Thursday', 'siliq'); ?></span><span>10.00 &mdash; 18.00</span></li>
            <li><span><?php esc_html_e('Friday', 'siliq'); ?></span><span>10.00 &mdash; 18.00</span></li>
            <li><span><?php esc_html_e('Saturday', 'siliq'); ?></span><span>10.00 &mdash; 18.00</span></li>
            <li><span><?php esc_html_e('Sunday', 'siliq'); ?></span><span class="muted"><?php esc_html_e('By appointment', 'siliq'); ?></span></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Map / atelier exterior -->
  <section class="section--map mask-reveal" id="map">
    <img src="<?php echo esc_url(get_theme_mod('contact_map_image', 'https://images.unsplash.com/photo-1431274172761-fca41d930114?w=2000&q=80')); ?>" alt="" data-parallax="0.12" />
    <div class="section--map__caption">
      <p class="eyebrow"><?php esc_html_e('Visit The Atelier', 'siliq'); ?></p>
      <h3><?php echo esc_html($address); ?><br><?php echo esc_html($address_2); ?></h3>
      <p class="muted small"><?php echo esc_html__("By appointment, Tuesday \u{2014} Saturday.", 'siliq'); ?></p>
      <a href="#contact-form" class="link-underline" data-cursor="hover"><?php esc_html_e('Book a visit', 'siliq'); ?></a>
    </div>
  </section>

  <?php get_template_part('template-parts/brand-marquee'); ?>

  <!-- FAQ -->
  <section class="section section--faq">
    <div class="section__head section__head--center">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Frequently Asked', 'siliq'); ?></p>
      <h2 class="section__title" data-anim="words"><?php esc_html_e('A few quiet answers.', 'siliq'); ?></h2>
    </div>
    <div class="faq">
      <?php
      $faqs = array(
          array(__('How long does a custom commission take?', 'siliq'),     __("Bespoke pieces typically take 6\u{2013}10 weeks. We\u{2019}ll share sketches, then a wax model for approval before casting. Larger or more intricate pieces may take longer \u{2014} we will always be transparent about timing.", 'siliq')),
          array(__('Do you offer engraving?', 'siliq'),                     __("Yes \u{2014} every piece can be engraved by hand. Add a note at checkout, or write to us for monogram options. Engraving is complimentary on most pieces.", 'siliq')),
          array(__('What is your repair policy?', 'siliq'),                 __('Each SILIQ piece comes with lifetime polishing and minor repair, complimentary. For more substantial repairs, we provide a fair quote — repair before replacement, always.', 'siliq')),
          array(__('Do you ship internationally?', 'siliq'),                __("Yes \u{2014} we ship worldwide via insured express courier. Orders above \$150 ship complimentary. International orders may incur customs duties depending on the destination.", 'siliq')),
          array(__('Can I visit the atelier?', 'siliq'),                    __('By appointment, with pleasure. Email us to arrange a visit. We are happy to receive private appointments outside of regular hours by arrangement.', 'siliq')),
          array(__('What is your return policy?', 'siliq'),                 __('Standard pieces may be returned within 14 days for a full refund or exchange, provided they are unworn and in original condition. Bespoke and engraved pieces are final sale.', 'siliq')),
      );
      foreach ($faqs as $i => $faq) :
        $is_open = $i === 0 ? 'open' : '';
      ?>
        <details class="faq__item" <?php echo $is_open; ?>>
          <summary><?php echo esc_html($faq[0]); ?></summary>
          <p><?php echo esc_html($faq[1]); ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </section>

  <?php
  // Render the page's own content if any was added in the WP editor
  if (have_posts()) : while (have_posts()) : the_post();
    $extra = trim(strip_tags(get_the_content()));
    if (!empty($extra)) : ?>
      <section class="section">
        <div class="contact-form-wrap"><?php the_content(); ?></div>
      </section>
    <?php endif;
  endwhile; endif; ?>

</main>

<?php get_footer(); ?>
