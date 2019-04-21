<?php if (post_password_required()) { return; }; ?>

<div class="comments">
    <?php if (is_user_logged_in()): ?>
	    <?php if (!comments_open()): ?>
            <p class="comments__closed">Los comentarios estan cerrados en esta entrada</p>
	    <?php else: ?>
            <div class="comments__response">
                <div class="response__avatar">
                    <?php $current_user = wp_get_current_user(); ?>
	                <?php echo get_avatar($current_user->ID, 58); ?>
                </div>
                <?php comment_form([
                    'label_submit' => '+ Publicar',
                    'class_form' => 'comments__form',
                    'comment_field' => '
                        <textarea id="comment" name="comment" class="response__textarea" aria-required="true" placeholder="Escribe tu comentario"></textarea>
                        <div class="response__actions">
                            <button class="response__action response__action--strong format-button" data-cursor-position="3" data-html="<b></b>">B</button>
                            <button class="response__action response__action--italic format-button" data-cursor-position="3" data-html="<i></i>">I</button>
                            <button class="response__action response__action--strike format-button" data-cursor-position="8" data-html="<strike></strike>">S</button>
                            <button class="response__action response__action--link format-button" data-cursor-position="9" data-html="<a href=></a>">🔗</button>
                            <button class="response__action format-button" data-cursor-position="12" data-html="<blockquote></blockquote>">“”</button>
                        </div>',
                    'logged_in_as' => '',
                ]); ?>
            </div>
	    <?php endif; ?>
    <?php else: ?>
        <a class="comments__login-link" href="<?php echo wp_login_url(get_permalink()); ?>" title="Entrar">Entra y comenta</a>
    <?php endif; ?>

    <?php if (have_comments()): ?>
        <ol class="comments__list">
            <?php wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 38,
                'callback' => 'dreams_comments'
            ]); ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php endif; ?>
</div>