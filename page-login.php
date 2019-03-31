<?php while (have_posts()): the_post(); ?>

	<?php the_content(); ?>

	<?php if(is_user_logged_in()): ?>
		<a href="<?php echo wp_logout_url(home_url()); ?>">Cerrar Sesión</a>
	<?php else: ?>
		<?php wp_login_form(['redirect' => home_url()]); ?>
	<?php endif; ?>

<?php endwhile; ?>
