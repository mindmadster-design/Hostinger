<?php
/**
 * Template Name: SILIQ — About
 *
 * The full editorial About page (heritage / atelier story).
 * Assign this template to a Page in WP admin: Page Attributes → Template → "SILIQ — About".
 *
 * Most copy can be edited via Appearance → Customize → "About Page" panel,
 * or directly in this template if a value isn't set.
 */
if (!defined('ABSPATH')) exit;
get_header();

$hero_image      = get_theme_mod('about_hero_image', 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?w=2400&q=80');
$hero_eyebrow    = get_theme_mod('about_hero_eyebrow', 'Est. 1924');
$hero_title      = get_theme_mod('about_hero_title', 'A Century of Silver,<br><em>Quietly Perfected.</em>');
$hero_subtitle   = get_theme_mod('about_hero_subtitle', 'Five generations. One material. No compromise.');
$intro_text      = get_theme_mod('about_intro_text', "We don\u{2019}t follow seasons. We refine forms. For a hundred years, our atelier has shaped silver into objects that resist trend, resist time \u{2014} and earn their place on the body.");
?>

<main>

  <!-- Full-screen hero -->
  <section class="about-hero">
    <div class="about-hero__media">
      <img src="<?php echo esc_url($hero_image); ?>" alt="<?php bloginfo('name'); ?> craftsmanship" />
      <div class="about-hero__overlay"></div>
    </div>
    <div class="about-hero__content">
      <p class="about-hero__eyebrow" data-anim="fade-up"><?php echo esc_html($hero_eyebrow); ?></p>
      <h1 class="about-hero__title" data-anim="words"><?php echo wp_kses_post($hero_title); ?></h1>
      <p class="about-hero__subtitle" data-anim="fade-up"><?php echo esc_html($hero_subtitle); ?></p>
      <div class="about-hero__scroll">
        <span><?php esc_html_e('Scroll to discover', 'siliq'); ?></span>
        <div class="about-hero__scroll-line"></div>
      </div>
    </div>
  </section>

  <!-- Intro statement -->
  <section class="about-intro">
    <div class="about-intro__inner">
      <p class="about-intro__text" data-anim="words"><?php echo wp_kses_post($intro_text); ?></p>
    </div>
  </section>

  <!-- If the page has its own content, render it here -->
  <?php if (have_posts()) : while (have_posts()) : the_post(); $page_content = get_the_content(); ?>
    <?php if (!empty(trim(strip_tags($page_content)))) : ?>
      <section class="section about-page-content">
        <div class="about-intro__inner">
          <?php the_content(); ?>
        </div>
      </section>
    <?php endif; ?>
  <?php endwhile; endif; ?>

  <!-- Story: image left / text right -->
  <section class="about-story">
    <div class="about-story__inner">
      <div class="about-story__media mask-reveal">
        <img src="<?php echo esc_url(get_theme_mod('about_story1_image', 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1400&q=80')); ?>" alt="<?php esc_attr_e('Silversmith at the bench', 'siliq'); ?>" data-parallax="0.15" />
      </div>
      <div class="about-story__copy">
        <p class="eyebrow" data-anim="fade-up"><?php echo esc_html(get_theme_mod('about_story1_eyebrow', 'Our Origin')); ?></p>
        <h2 data-anim="words"><?php echo wp_kses_post(get_theme_mod('about_story1_title', 'A workshop.<br>A hammer.<br>A bench.')); ?></h2>
        <p data-anim="fade-up"><?php echo esc_html(get_theme_mod('about_story1_p1', "SILIQ was founded on a single principle \u{2014} that an object worn close to the body should be made with care that lasts longer than its maker.")); ?></p>
        <p data-anim="fade-up"><?php echo esc_html(get_theme_mod('about_story1_p2', "What began as a single bench in a quiet atelier has grown into a house of silver \u{2014} but the hands remain the same. Five generations of silversmiths, each apprenticing under the last, refining a shared vocabulary of form.")); ?></p>
      </div>
    </div>
  </section>

  <!-- Animated counters -->
  <section class="about-counters">
    <div class="about-counters__inner">
      <?php
      $counters = array(
          array('count' => 100,   'label' => __('Years of Heritage', 'siliq')),
          array('count' => 5,     'label' => __('Generations of Makers', 'siliq')),
          array('count' => 925,   'label' => __('Sterling Silver Standard', 'siliq')),
          array('count' => 12000, 'label' => __('Pieces Crafted by Hand', 'siliq')),
      );
      foreach ($counters as $c) : ?>
        <div class="counter-item reveal">
          <span class="counter-item__number" data-count="<?php echo esc_attr($c['count']); ?>">0</span>
          <span class="counter-item__label"><?php echo esc_html($c['label']); ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Horizontal timeline -->
  <section class="about-timeline">
    <div class="about-timeline__head">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Our Journey', 'siliq'); ?></p>
      <h2 data-anim="words"><?php esc_html_e('A lineage of craft.', 'siliq'); ?></h2>
    </div>
    <div class="timeline">
      <div class="timeline__track">
        <?php
        $timeline = array(
            array('year' => '1924', 'title' => __('The First Bench', 'siliq'),          'desc' => __('A single silversmith opens a workshop in a quiet quarter. The first hallmarked ring is signed.', 'siliq')),
            array('year' => '1952', 'title' => __('Second Generation', 'siliq'),        'desc' => __("The founder\u{2019}s son takes the bench. Introduces lost-wax casting. The studio doubles in size.", 'siliq')),
            array('year' => '1978', 'title' => __('International Recognition', 'siliq'),'desc' => __('First feature in Vogue. The bridal collection launches. Atelier pieces enter private collections worldwide.', 'siliq')),
            array('year' => '1996', 'title' => __('The Apprenticeship', 'siliq'),       'desc' => __('A seven-year apprenticeship programme is formalised. No maker signs their work before completing it.', 'siliq')),
            array('year' => '2024', 'title' => __('A Centenary', 'siliq'),              'desc' => __('100 years of continuous craft. The fifth generation takes the bench. The same silver. The same care.', 'siliq')),
        );
        foreach ($timeline as $t) : ?>
          <div class="timeline__item reveal">
            <span class="timeline__year"><?php echo esc_html($t['year']); ?></span>
            <h3><?php echo esc_html($t['title']); ?></h3>
            <p><?php echo esc_html($t['desc']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Parallax break with quote -->
  <section class="about-parallax-break">
    <img src="<?php echo esc_url(get_theme_mod('about_break_image', 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=2400&q=80')); ?>" alt="" data-parallax="0.2" />
    <div class="about-parallax-break__text">
      <blockquote data-anim="words"><?php echo wp_kses_post(get_theme_mod('about_break_quote', "\u{201C}The right shape, made well, never goes out of style.\u{201D}")); ?></blockquote>
    </div>
  </section>

  <!-- Values grid -->
  <section class="about-values">
    <div class="about-values__head">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Our Standards', 'siliq'); ?></p>
      <h2 data-anim="words"><?php esc_html_e('A practice, not a trend.', 'siliq'); ?></h2>
    </div>
    <div class="about-values__grid">
      <?php
      $values = array(
          array('num' => '01', 'title' => __('Craft', 'siliq'),      'desc' => __('Every piece is cast, finished and polished entirely by hand. We measure progress in millimetres and decades, not in seasons.', 'siliq'),
                'svg' => '<circle cx="24" cy="24" r="20"/><path d="M24 4v40M4 24h40"/><path d="M24 12a12 12 0 0 1 0 24 12 12 0 0 1 0-24"/>'),
          array('num' => '02', 'title' => __('Heritage', 'siliq'),   'desc' => __('Five generations of silversmithing, kept alive by apprentices who train for seven years before they are permitted to sign their work.', 'siliq'),
                'svg' => '<path d="M8 40V8h32v32H8z"/><path d="M16 40V20h16v20"/><path d="M24 20V8"/>'),
          array('num' => '03', 'title' => __('Provenance', 'siliq'), 'desc' => __('Solid 925 sterling silver. Hallmarked. Recyclable. Traceable from raw bar to finished hallmark.', 'siliq'),
                'svg' => '<path d="M24 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L4 16h14z"/>'),
          array('num' => '04', 'title' => __('Longevity', 'siliq'),  'desc' => __("We make small editions on purpose. The number we sign is the number we can stand behind \u{2014} today, and in fifty years.", 'siliq'),
                'svg' => '<circle cx="24" cy="24" r="18"/><path d="M24 12v12l8 8"/>'),
      );
      foreach ($values as $v) : ?>
        <div class="about-value-card reveal">
          <div class="about-value-card__icon">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="0.8"><?php echo $v['svg']; ?></svg>
          </div>
          <span class="about-value-card__num"><?php echo esc_html($v['num']); ?></span>
          <h3><?php echo esc_html($v['title']); ?></h3>
          <p><?php echo esc_html($v['desc']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Atelier gallery -->
  <section class="about-gallery">
    <div class="about-gallery__head">
      <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('The Atelier', 'siliq'); ?></p>
      <h2 data-anim="words"><?php esc_html_e('Where things take time.', 'siliq'); ?></h2>
    </div>
    <div class="about-gallery__grid">
      <?php
      $gallery = array(
          array('src' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1600&q=80', 'class' => 'about-gallery__item--wide'),
          array('src' => 'https://images.unsplash.com/photo-1612722432474-b971cdcea546?w=1000&q=80'),
          array('src' => 'https://images.unsplash.com/photo-1633934542430-0905ec85aa4f?w=1000&q=80'),
          array('src' => 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=1000&q=80'),
          array('src' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1600&q=80', 'class' => 'about-gallery__item--wide'),
      );
      foreach ($gallery as $g) :
        $cls = 'about-gallery__item mask-reveal' . (isset($g['class']) ? ' ' . $g['class'] : '');
      ?>
        <div class="<?php echo esc_attr($cls); ?>">
          <img src="<?php echo esc_url($g['src']); ?>" alt="" data-parallax="0.1" />
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Story 2: reversed -->
  <section class="about-story about-story--reverse">
    <div class="about-story__inner">
      <div class="about-story__copy">
        <p class="eyebrow" data-anim="fade-up"><?php esc_html_e('Lineage', 'siliq'); ?></p>
        <h2 data-anim="words"><?php esc_html_e('Inherited,', 'siliq'); ?><br><?php esc_html_e('not invented.', 'siliq'); ?></h2>
        <p data-anim="fade-up"><?php echo esc_html__("Each piece carries forward a small library of techniques \u{2014} granulation, hand-engraving, lost-wax casting \u{2014} passed from master to apprentice across generations.", 'siliq'); ?></p>
        <p data-anim="fade-up"><?php esc_html_e('We make small editions on purpose. The number we sign is the number we can stand behind.', 'siliq'); ?></p>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn btn--ghost btn--dark" data-cursor="hover"><?php esc_html_e('Discover the Collection', 'siliq'); ?></a>
      </div>
      <div class="about-story__media mask-reveal">
        <img src="<?php echo esc_url(get_theme_mod('about_story2_image', 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1400&q=80')); ?>" alt="" data-parallax="0.15" />
      </div>
    </div>
  </section>

  <!-- Brand marquee -->
  <section class="brand-marquee" aria-hidden="true">
    <div class="brand-marquee__track">
      <?php for ($i = 0; $i < 2; $i++) : ?>
        <span>SILIQ</span>
        <span class="brand-marquee__dot">&bull;</span>
        <span><em>925 Sterling Silver</em></span>
        <span class="brand-marquee__dot">&bull;</span>
        <span>Hallmarked</span>
        <span class="brand-marquee__dot">&bull;</span>
        <span><em>Maison de Argent</em></span>
        <span class="brand-marquee__dot">&bull;</span>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Press -->
  <section class="section section--press">
    <p class="eyebrow press__eyebrow" data-anim="fade-up"><?php esc_html_e('As Featured In', 'siliq'); ?></p>
    <div class="press__row" data-anim="press">
      <span>VOGUE</span>
      <span>HARPER&rsquo;S BAZAAR</span>
      <span>ELLE</span>
      <span>FINANCIAL TIMES</span>
      <span>WALLPAPER*</span>
      <span>T MAGAZINE</span>
    </div>
  </section>

  <!-- Newsletter -->
  <?php get_template_part('template-parts/newsletter'); ?>

</main>

<?php get_footer(); ?>
