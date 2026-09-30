<?php
get_header();
$wc  = class_exists('WooCommerce');
$img = (int) bazaar_opt('hero_image');
$url = bazaar_opt('hero_url') ?: ($wc ? wc_get_page_permalink('shop') : home_url('/'));
?>
<section class="hero">
  <div class="container hero-inner">
    <div>
      <h1><?php echo esc_html(bazaar_opt('hero_title', 'بلونار؛ انتخابی که پشیمانی ندارد')); ?></h1>
      <p><?php echo esc_html(bazaar_opt('hero_text', 'محصولات منتخب با ضمانت اصالت و ارسال سریع.')); ?></p>
      <a class="btn btn-accent" href="<?php echo esc_url($url); ?>"><?php echo esc_html(bazaar_opt('hero_btn', 'مشاهده محصولات')); ?></a>
    </div>
    <?php if ($img) : ?><div class="hero-img"><?php echo wp_get_attachment_image($img, 'bazaar-hero'); ?></div><?php endif; ?>
  </div>
</section>

<?php if ($wc && bazaar_opt('show_cats', true)) :
  $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 6, 'exclude' => [get_option('default_product_cat')]]);
  if ($cats && !is_wp_error($cats)) : ?>
<section class="section container">
  <div class="section-head"><h2>دسته‌بندی‌ها</h2></div>
  <div class="cats">
    <?php foreach ($cats as $c) : $tid = get_term_meta($c->term_id, 'thumbnail_id', true); ?>
      <a class="cat-card" href="<?php echo esc_url(get_term_link($c)); ?>">
        <?php echo $tid ? wp_get_attachment_image($tid, 'thumbnail') : ''; ?>
        <?php echo esc_html($c->name); ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; endif; ?>

<?php $cols = max(2, min(5, (int) bazaar_opt('cols', 4))); ?>
<?php if ($wc && bazaar_opt('show_new', true)) : ?>
<section class="section container">
  <div class="section-head"><h2>جدیدترین محصولات</h2><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">همه محصولات</a></div>
  <?php echo do_shortcode('[products limit="' . ($cols * 2) . '" columns="' . $cols . '" orderby="date" order="DESC"]'); ?>
</section>
<?php endif; ?>

<?php if ($wc && bazaar_opt('show_sale', true)) : ?>
<section class="section container">
  <div class="section-head"><h2>پیشنهادهای ویژه</h2></div>
  <?php echo do_shortcode('[sale_products limit="' . $cols . '" columns="' . $cols . '"]'); ?>
</section>
<?php endif; ?>

<?php if (bazaar_opt('show_features', true)) : ?>
<section class="section container">
  <div class="features">
    <div class="feature"><strong>ارسال سریع</strong><span>تحویل در کوتاه‌ترین زمان</span></div>
    <div class="feature"><strong>ضمانت اصالت</strong><span>همه کالاها اورجینال‌اند</span></div>
    <div class="feature"><strong>پرداخت امن</strong><span>درگاه‌های معتبر بانکی</span></div>
    <div class="feature"><strong>پشتیبانی</strong><span>پاسخگو در ساعات کاری</span></div>
  </div>
</section>
<?php endif; ?>

<?php if (!$wc) : ?>
<main class="container section"><div class="card">برای نمایش محصولات، افزونه ووکامرس را نصب و فعال کنید.</div></main>
<?php endif; ?>
<?php get_footer(); ?>
