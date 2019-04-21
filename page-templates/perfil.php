<?php
/**
 * Template Name: Perfil
 */

if (!is_user_logged_in()) {
    wp_redirect(home_url());
}

$success = false;
$user = wp_get_current_user();

if (!empty($_FILES['avatar'])) {
	$errors = new WP_Error();

	$uploaded_image = $_FILES['avatar'];
	if ($uploaded_image['error']) {
		$errors->add('upload_error', 'Error al subir la imagen');
    }
    else {
	    $editor = wp_get_image_editor($uploaded_image['tmp_name']);
	    if (!is_wp_error($editor)) {
		    $editor->resize(140, 140, true);
		    $uploads = wp_upload_dir();
		    $saved_image = $editor->save($uploads['basedir'] . AVATAR_FOLDER . $user->ID);
		    update_user_meta($user->ID, AVATAR_META_KEY, $saved_image['file']);
	    }
	    else {
		    $errors->add('image_error', 'Error en el archivo de imagen');
        }
    }

	if (!$errors->has_errors()) {
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
    <form class="single-form__form" action="<?php echo esc_url(get_permalink()); ?>" method="post" enctype="multipart/form-data">
		<?php if (isset($errors) && $errors->has_errors()): $messages = $errors->get_error_messages() ?>
            <div class="single-form__error-msg">
				<?php foreach ($messages as $message): ?>
                    <p><?php echo $message ?></p>
				<?php endforeach; ?>
            </div>
		<?php endif; ?>
        <?php if ($success): ?>
            <div class="single-form__success-msg">El avatar se ha actualizado correctamente. Vuelve al <a href="<?php echo get_home_url(); ?>">índice</a>.</div>
        <?php endif; ?>

        <div class="single-form__avatar">
	        <?php echo get_avatar($user->ID); ?>
        </div>
        <div class="file-upload">
            <input class="file-upload__input" type="file" id="avatar" name="avatar" accept="image/x-png,image/gif,image/jpeg" />
            <label class="file-upload__label" for="avatar">Selecciona una imagen</label>
        </div>
        <button class="single-form__button" type="submit">Subir imagen</button>
    </form>
</div>

<?php wp_footer(); ?>
</body>
</html>
