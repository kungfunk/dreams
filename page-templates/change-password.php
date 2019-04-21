<?php
/**
 * Template Name: Cambiar contraseña
 */

if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

$success = false;

if (!empty($_POST)) {
	$user = wp_get_current_user();
	$errors = new WP_Error();

    if (!isset($_POST['old_password']) || !isset($_POST['new_password']) || !isset($_POST['check_password'])) {
	    $errors->add('all_fields', 'Todos los campos deben estar rellenos');
    }

    if (!wp_check_password($_POST['old_password'], $user->data->user_pass, $user->ID)) {
	    $errors->add('wrong_old_password', 'La contraseña actual es incorrecta');
	}

	if ($_POST['new_password'] !== $_POST['check_password']) {
		$errors->add('password_missmatch', 'Las contraseñas no coinciden');
	}

	if (strlen($_POST['new_password']) < 8) {
		$errors->add('password_missmatch', 'La contraseña debe tener como minimo 8 caracteres');
	}

	if (!$errors->has_errors()) {
		wp_update_user(['ID' => $user->ID, 'user_pass' => esc_attr($_POST['new_password'])]);
		$success = true;
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
        <?php if ($success): ?>
            <div class="single-form__success-msg">La contraseña se ha actualizado correctamente. Vuelve al <a href="<?php echo get_home_url(); ?>">índice</a>.</div>
        <?php endif; ?>
        <input placeholder="Contraseña actual" type="text" name="old_password" class="single-form__input" value="" required />
        <input placeholder="Nueva contraseña" type="text" name="new_password" class="single-form__input" value="" title="La contraseña tiene que tener al menos 8 caracteres de longitud" pattern=".{8,}" required />
        <input placeholder="Repetir contraseña" type="text" name="check_password" class="single-form__input" value="" title="La contraseña tiene que tener al menos 8 caracteres de longitud" pattern=".{8,}" required />
        <button class="single-form__button" type="submit">Cambiar contraseña</button>
    </form>
</div>

<?php wp_footer(); ?>
</body>
</html>
