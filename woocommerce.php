<?php get_header(); ?>
<main class="site-main container">
  <?php
  $sidebar = (is_shop() || is_product_category() || is_product_tag()) && is_active_sidebar('shop-sidebar');
  ?>
  <div class="shop-layout <?php echo $sidebar ? 'has-sidebar' : ''; ?>">
    <?php if ($sidebar) : ?><aside><?php dynamic_sidebar('shop-sidebar'); ?></aside><?php endif; ?>
    <div><?php woocommerce_content(); ?></div>
  </div>
</main>
<?php get_footer(); ?>
