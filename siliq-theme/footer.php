<?php
/**
 * SILIQ Theme Footer
 */
if (!defined('ABSPATH')) exit;
?>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer__inner">
      <div class="footer__brand">
        <span class="logo logo--sm">SILIQ</span>
        <p><?php echo esc_html(get_theme_mod('brand_tagline', 'Handcrafted 925 sterling silver jewellery, made in limited editions.')); ?></p>
      </div>
      <div class="footer__col">
        <h4>Shop</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer-shop',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => function() {
              echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">All Jewellery</a>';
              echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">Rings</a>';
              echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">Necklaces</a>';
              echo '<a href="' . esc_url(wc_get_page_permalink('shop')) . '">Earrings</a>';
          },
          'depth' => 1,
        ));
        ?>
      </div>
      <div class="footer__col">
        <h4>House</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer-house',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => function() {
              echo '<a href="' . esc_url(home_url('/about')) . '">About</a>';
              echo '<a href="' . esc_url(home_url('/stores')) . '">Stores</a>';
              echo '<a href="' . esc_url(home_url('/journal')) . '">Journal</a>';
              echo '<a href="' . esc_url(home_url('/contact')) . '">Contact</a>';
          },
          'depth' => 1,
        ));
        ?>
      </div>
      <div class="footer__col">
        <h4>Care</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer-care',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => function() {
              echo '<a href="' . esc_url(home_url('/contact')) . '">Customer Service</a>';
              echo '<a href="#">Shipping &amp; Returns</a>';
              echo '<a href="#">Repair Service</a>';
              echo '<a href="#">Sizing Guide</a>';
              echo '<a href="#">FAQ</a>';
          },
          'depth' => 1,
        ));
        ?>
      </div>
      <div class="footer__col">
        <h4>Follow</h4>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'footer-follow',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => function() {
              echo '<a href="#">Instagram</a>';
              echo '<a href="#">Pinterest</a>';
              echo '<a href="#">TikTok</a>';
          },
          'depth' => 1,
        ));
        ?>
      </div>
    </div>
    <div class="footer__base">
      <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
      <p>925 &middot; Hallmarked &middot; Crafted by hand</p>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
