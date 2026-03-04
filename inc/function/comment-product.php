<?php
function buildpro_comment_callback($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
?>
    <li <?php comment_class('comment-item'); ?> id="comment-<?php comment_ID(); ?>">

        <div class="comment-header">
            <div class="comment-avatar">
                <?php echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'comment-avatar-img']); ?>
            </div>
            <h4 class="comment-author"><?php echo get_comment_author_link(); ?></h4>
            <div class="comment-meta-text">
                <div class="text-sm text-gray-500">
                    <?php printf(__('%1$s lúc %2$s', 'buildpro'), get_comment_date(), get_comment_time()); ?>
                    <?php edit_comment_link(__('(Sửa)', 'buildpro'), '  ', ''); ?>
                </div>
            </div>
        </div>

        <p class="comment-awaiting-moderation"><?php _e('Bình luận đang chờ duyệt.', 'buildpro'); ?></p>
        <div class="comment-content">
            <div class="comment-content prose prose-slate max-w-none">
                <?php comment_text(); ?>
            </div>
        </div>
        <div class="comment-actions">

            <?php comment_reply_link(array_merge($args, [
                'add_below' => 'comment',
                'depth'     => $depth,
                'before'    => '',
                'after'     => '',
            ])); ?>

        </div>

    </li>
<?php
}
