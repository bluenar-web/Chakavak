<footer class="site-footer">
  <div class="container">
    <div class="footer-widgets">
      <?php for ($i = 1; $i <= 3; $i++) { if (is_active_sidebar('footer-' . $i)) dynamic_sidebar('footer-' . $i); } ?>
    </div>
    <div class="footer-bottom">
      <?php wp_nav_menu(['theme_location' => 'footer', 'container' => false, 'depth' => 1, 'fallback_cb' => false]); ?>
      © <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
