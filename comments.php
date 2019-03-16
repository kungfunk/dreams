<?php if (post_password_required()) { return; }; ?>

<div class="comments">
    <?php comment_form([
	    'label_submit' => '+ Publicar',
	    'class_form' => 'comments__form',
        'comment_field' => '<textarea id="comment" name="comment" class="comments__textarea" aria-required="true" placeholder="Escribe tu comentario"></textarea>',
    ]); ?>

	<?php if (have_comments()): ?>
		<ol class="comment__list">
			<?php wp_list_comments([
				'style'      => 'ol',
				'short_ping' => true,
			]); ?>
		</ol>

		<?php the_comments_navigation(); ?>

		<?php if (!comments_open()): ?>
			<p class="comments__closed">Los comentarios estan cerrados en esta entrada</p>
        <?php endif; ?>
	<?php endif; ?>
</div>
