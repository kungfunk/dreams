<?php
/**
 * Template Name: Registro
 */

if (is_user_logged_in() || !get_option('users_can_register')) {
	wp_redirect(home_url());
}

if (!empty($_POST)) {
	$errors = register_new_user($_POST['user'], $_POST['email']);
    if (!is_wp_error($errors)) {
	    wp_redirect(home_url(LOGIN_URL . '?referer=' . $_POST['email']));
    }
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('single-form-page'); ?>>
<div class="single-form">
    <a href="<?php echo get_home_url(); ?>" class="single-form__logo">
	    <?php include get_template_directory() . '/img/brand.svg'; ?>
    </a>
    <form class="single-form__form" action="<?php echo esc_url(get_permalink()); ?>" method="post">
		<?php if (isset($errors) && $errors->has_errors()): $messages = $errors->get_error_messages() ?>
            <div class="single-form__error-msg">
                <?php foreach ($messages as $message): ?>
                    <p><?php echo $message ?></p>
                <?php endforeach; ?>
            </div>
		<?php endif; ?>
        <input placeholder="Usuario" type="text" name="user" class="single-form__input" value="" size="20" required />
        <input placeholder="Email" type="text" name="email" class="single-form__input" value="" size="50" required />
        <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>" />
        <button class="single-form__button" type="submit">Registrarse</button>
        <p class="single-form__info">Te enviaremos una contraseña generada a tu correo electronico. No te preocupes, puedes cambiarla mas tarde desde tu perfil.</p>
        <p class="single-form__register-text">
            ¿Ya tienes cuenta? <a class="single-form__register-link" href="<?php echo home_url(LOGIN_URL); ?>">¡Entra!</a>
        </p>
    </form>
</div>

<?php wp_footer(); ?>
</body>
</html>
