<?php
/**
 * Brand marquee strip — used across multiple page templates.
 * Pass an array of strings as $args['items'] for custom content.
 */
if (!defined('ABSPATH')) exit;

$items = isset($args['items']) && is_array($args['items']) ? $args['items'] : array(
    array('text' => 'SILIQ',                  'em' => false),
    array('text' => '925 Sterling Silver',    'em' => true),
    array('text' => 'Handcrafted',            'em' => false),
    array('text' => 'Maison de Argent',       'em' => true),
);
?>
<section class="brand-marquee" aria-hidden="true">
  <div class="brand-marquee__track">
    <?php for ($i = 0; $i < 2; $i++) :
      foreach ($items as $item) : ?>
        <span><?php
          if (!empty($item['em'])) {
              echo '<em>' . esc_html($item['text']) . '</em>';
          } else {
              echo esc_html($item['text']);
          }
        ?></span>
        <span class="brand-marquee__dot">&bull;</span>
      <?php endforeach;
    endfor; ?>
  </div>
</section>
