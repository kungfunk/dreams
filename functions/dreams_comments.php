<?php
function dreams_comments($comment, $args, $depth) {
?>
	<li <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID() ?>">

	<?php if ($comment->comment_type === 'pingback' || $comment->comment_type === 'trackback'): ?>
		<div class="comment__pingback-entry">
			<span class="comment__pingback-heading">Pingback:</span> <?php comment_author_link(); ?>
		</div>
	<?php else: ?>
		<div class="comment__container">
			<div class="comment__avatar">
				<?php echo get_avatar($comment->user_id, $args['avatar_size']); ?>
			</div>
			<div class="comment__data">
				<cite class="comment__author"><?php echo get_comment_author_link() ?></cite>
				<div class="comment__meta">
					<a class="comment__date" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
						<?php echo get_comment_date(); ?>
					</a>
					<span class="comment__edit-link"><?php edit_comment_link('[Editar]'); ?></span>
				</div>
				<div class="comment__text"><?php comment_text(); ?></div>
				<?php if ($comment->comment_approved == '0'): ?>
					<div class="comment__awaiting-moderation">Tu comentario aun no ha sido moderado</div>
				<?php endif; ?>
				<div class="comment__reply">
					<?php comment_reply_link(array_merge($args, ['depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '→ Responder'])); ?>
					<?php $num_replies = get_comments(['parent' => $comment->comment_ID, 'count' => true]) ?>
					<?php if ($num_replies > 0): ?>
						<span class="comment_replies-number">(<?php echo $num_replies ?> respuestas)</span>
					<?php endif ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php
}