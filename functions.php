<?php
if (!defined('ABSPATH')) exit;
define('BAZAAR_VER', '1.0.0');

add_action('after_setup_theme', function () {
    load_theme_textdomain('bluenar', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo', ['height' => 60, 'width' => 200, 'flex-width' => true, 'flex-height' => true]);
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    register_nav_menus([
        'primary' => __('منوی اصلی', 'bluenar'),
        'footer'  => __('منوی فوتر', 'bluenar'),
    ]);
    add_image_size('bazaar-hero', 900, 600, true);
});

add_action('widgets_init', function () {
    $args = ['before_widget' => '<section id="%1$s" class="widget %2$s">', 'after_widget' => '</section>', 'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>'];
    register_sidebar($args + ['name' => __('سایدبار فروشگاه', 'bluenar'), 'id' => 'shop-sidebar']);
    for ($i = 1; $i <= 3; $i++) {
        register_sidebar($args + ['name' => sprintf(__('فوتر %d', 'bluenar'), $i), 'id' => 'footer-' . $i]);
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_rtl()) {
        wp_enqueue_style('bazaar-font', 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;600;800&display=swap', [], null);
    }
    wp_enqueue_style('bluenar', get_stylesheet_uri(), [], BAZAAR_VER);
    wp_add_inline_style('bluenar', bazaar_custom_css());
    wp_enqueue_script('bluenar', get_template_directory_uri() . '/assets/js/main.js', [], BAZAAR_VER, true);
});

function bazaar_opt($key, $default = '') {
    return get_theme_mod($key, $default);
}

function bazaar_custom_css() {
    return sprintf(
        ':root{--primary:%s;--accent:%s;--bg:%s;--text:%s;--radius:%dpx;--container:%dpx;--cols:%d}',
        esc_attr(bazaar_opt('primary', '#1e40d8')),
        esc_attr(bazaar_opt('accent', '#d6284f')),
        esc_attr(bazaar_opt('bg', '#f4f6fb')),
        esc_attr(bazaar_opt('text', '#14213d')),
        (int) bazaar_opt('radius', 12),
        (int) bazaar_opt('container', 1240),
        (int) bazaar_opt('cols', 4)
    );
}

/* ---------- Customizer ---------- */
add_action('customize_register', function ($wp) {
    $wp->add_panel('bluenar', ['title' => __('تنظیمات قالب Bluenar', 'bluenar'), 'priority' => 30]);

    $wp->add_section('bazaar_style', ['title' => __('رنگ و ظاهر', 'bluenar'), 'panel' => 'bluenar']);
    foreach (['primary' => ['رنگ اصلی', '#1e40d8'], 'accent' => ['رنگ تاکیدی', '#d6284f'], 'bg' => ['پس‌زمینه', '#f4f6fb'], 'text' => ['رنگ متن', '#14213d']] as $k => $v) {
        $wp->add_setting($k, ['default' => $v[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'refresh']);
        $wp->add_control(new WP_Customize_Color_Control($wp, $k, ['label' => $v[0], 'section' => 'bazaar_style']));
    }
    $nums = ['radius' => ['گردی گوشه‌ها (px)', 12, 0, 32], 'container' => ['عرض محتوا (px)', 1240, 960, 1600], 'cols' => ['تعداد ستون محصولات در دسکتاپ', 4, 2, 5]];
    foreach ($nums as $k => $v) {
        $wp->add_setting($k, ['default' => $v[1], 'sanitize_callback' => 'absint']);
        $wp->add_control($k, ['label' => $v[0], 'section' => 'bazaar_style', 'type' => 'number', 'input_attrs' => ['min' => $v[2], 'max' => $v[3]]]);
    }

    $wp->add_section('bazaar_home', ['title' => __('صفحه اصلی', 'bluenar'), 'panel' => 'bluenar']);
    $texts = [
        'topbar'     => ['متن نوار بالای سایت', 'ارسال رایگان برای سفارش‌های بالای ۵۰۰ هزار تومان'],
        'hero_title' => ['عنوان هیرو', 'بلونار؛ انتخابی که پشیمانی ندارد'],
        'hero_text'  => ['توضیح هیرو', 'محصولات منتخب با ضمانت اصالت و ارسال سریع.'],
        'hero_btn'   => ['متن دکمه هیرو', 'مشاهده محصولات'],
        'hero_url'   => ['لینک دکمه هیرو', ''],
    ];
    foreach ($texts as $k => $v) {
        $wp->add_setting($k, ['default' => $v[1], 'sanitize_callback' => $k === 'hero_url' ? 'esc_url_raw' : 'sanitize_text_field']);
        $wp->add_control($k, ['label' => $v[0], 'section' => 'bazaar_home', 'type' => 'text']);
    }
    $wp->add_setting('hero_image', ['sanitize_callback' => 'absint']);
    $wp->add_control(new WP_Customize_Media_Control($wp, 'hero_image', ['label' => __('تصویر هیرو', 'bluenar'), 'section' => 'bazaar_home', 'mime_type' => 'image']));
    foreach (['show_cats' => 'نمایش دسته‌بندی‌ها', 'show_new' => 'نمایش جدیدترین محصولات', 'show_sale' => 'نمایش تخفیف‌دارها', 'show_features' => 'نمایش مزایای فروشگاه'] as $k => $l) {
        $wp->add_setting($k, ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
        $wp->add_control($k, ['label' => $l, 'section' => 'bazaar_home', 'type' => 'checkbox']);
    }
});

/* ---------- WooCommerce ---------- */
add_action('wp', function () {
    if (!class_exists('WooCommerce')) return;
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
});
add_filter('loop_shop_columns', function () { return max(2, min(5, (int) bazaar_opt('cols', 4))); });
add_filter('loop_shop_per_page', function () { return 12; });
add_filter('woocommerce_add_to_cart_fragments', function ($f) {
    $f['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $f;
});

add_action('customize_register', function ($wp) {
    $wp->add_setting('preloader', ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp->add_control('preloader', ['label' => 'صفحه لودینگ اولیه', 'section' => 'bazaar_home', 'type' => 'checkbox']);
});
