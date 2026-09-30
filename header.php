<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if (bazaar_opt('preloader', true)) : ?>
<noscript><style>#preloader{display:none!important}</style></noscript>
<div id="preloader" role="status" aria-label="در حال بارگذاری">
  <div class="pl-box">
    <?php if (has_custom_logo()) : the_custom_logo(); else : ?>
      <div class="pl-name"><?php bloginfo('name'); ?><i></i></div>
    <?php endif; ?>
    <div class="pl-bar"><span></span></div>
  </div>
</div>
<?php endif; ?>
<?php if ($t = bazaar_opt('topbar', 'ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان')) : ?>
<div class="topbar"><?php echo esc_html($t); ?></div>
<?php endif; ?>
<header class="site-header">
  <div class="container header-main">
    <div class="site-branding">
      <?php if (has_custom_logo()) : the_custom_logo(); else : ?>
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
      <?php endif; ?>
    </div>
    <div class="header-search" id="header-search">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="screen-reader-text" for="s">جستجو</label>
        <input type="search" id="s" name="s" placeholder="جستجوی محصول..." value="<?php echo esc_attr(get_search_query()); ?>">
        <?php if (class_exists('WooCommerce')) : ?><input type="hidden" name="post_type" value="product"><?php endif; ?>
        <button class="btn" type="submit">جستجو</button>
      </form>
    </div>
    <div class="header-actions">
      <button class="icon-link search-toggle" type="button" aria-label="جستجو" aria-expanded="false" aria-controls="header-search">🔍</button>
      <?php if (class_exists('WooCommerce')) : ?>
        <a class="icon-link" href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" aria-label="حساب کاربری">👤</a>
        <a class="icon-link" href="<?php echo esc_url(wc_get_cart_url()); ?>" aria-label="سبد خرید">🛒<span class="cart-count"><?php echo (int) WC()->cart->get_cart_contents_count(); ?></span></a>
      <?php endif; ?>
      <button class="menu-toggle" aria-controls="main-nav" aria-expanded="false" aria-label="منو">☰</button>
    </div>
  </div>
  <div class="nav-wrap">
    <div class="container">
      <nav id="main-nav" class="main-nav" aria-label="منوی اصلی">
        <?php wp_nav_menu(['theme_location' => 'primary', 'container' => false, 'fallback_cb' => function () { echo '<ul><li><a href="' . esc_url(home_url('/')) . '">خانه</a></li></ul>'; }]); ?>
      </nav>
    </div>
  </div>
</header>
