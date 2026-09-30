<?php get_header(); ?>
<main class="site-main container">
  <?php if (have_posts()) : ?>
    <?php if (is_home() || is_archive() || is_search()) : ?>
      <?php if (is_archive()) the_archive_title('<h1>', '</h1>'); if (is_search()) echo '<h1>نتایج جستجو: ' . esc_html(get_search_query()) . '</h1>'; ?>
      <div class="posts-grid">
      <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class('post-card'); ?>>
          <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
          <div class="body"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></div>
        </article>
      <?php endwhile; ?>
      </div>
      <?php the_posts_pagination(); ?>
    <?php else : while (have_posts()) : the_post(); ?>
      <article <?php post_class('entry'); ?>>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php the_content(); ?>
        <?php if (is_single() && (comments_open() || get_comments_number())) comments_template(); ?>
      </article>
    <?php endwhile; endif; ?>
  <?php else : ?>
    <div class="entry"><h1>چیزی پیدا نشد</h1><p>عبارت دیگری را جستجو کنید یا به <a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a> برگردید.</p></div>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
