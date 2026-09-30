<?php if (post_password_required()) return; ?>
<div id="comments" class="comments-area">
<?php if (have_comments()) : ?><h2>دیدگاه‌ها</h2><ol><?php wp_list_comments(['style' => 'ol']); ?></ol><?php endif; ?>
<?php comment_form(); ?>
</div>
