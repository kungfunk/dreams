<?php
/**
 * Template Name: Recuperar password
 */

if (is_user_logged_in()) {
	wp_redirect(home_url());
}

// Copied from wp-login.php line 329
function retrieve_password() {
	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) || ! is_string( $_POST['user_login'] ) ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or email address.' ) );
	} elseif ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
		if ( empty( $user_data ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) );
		}
	} else {
		$login     = trim( $_POST['user_login'] );
		$user_data = get_user_by( 'login', $login );
	}

	do_action( 'lostpassword_post', $errors );

	if ( $errors->has_errors() ) {
		return $errors;
	}

	if ( ! $user_data ) {
		$errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: There is no account with that username or email address.' ) );
		return $errors;
	}

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	$key        = get_password_reset_key( $user_data );

	if ( is_wp_error( $key ) ) {
		return $key;
	}

	if ( is_multisite() ) {
		$site_name = get_network()->site_name;
	} else {
		$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	$message = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
	$message .= sprintf( __( 'Site Name: %s' ), $site_name ) . "\r\n\r\n";
	$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
	$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
	$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
	$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";

	$title = sprintf( __( '[%s] Password Reset' ), $site_name );
	$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );
	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

	if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
		wp_die( __( 'The email could not be sent.' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.' ) );
	}

	return true;
}

if ('POST' == $_SERVER['REQUEST_METHOD']) {
	$errors = retrieve_password();
	if (!is_wp_error($errors)) {
		$referer = $_POST['user_login'];
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
		<?php if (isset($referer) && $referer): ?>
			<div class="single-form__success-msg">
				Hemos enviado un correo a <strong><?php echo $referer ?></strong> con un enlace para recuperar tu contraseña.
			</div>
		<?php endif; ?>
		<input placeholder="Usuario o email" type="text" name="user_login" class="single-form__input" value="" size="20" required />
		<input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>" />
		<button class="single-form__button" type="submit">Recuperar contraseña</button>
		<p class="single-form__info">Recibirás un enlace para crear la contraseña nueva por correo electrónico.</p>
	</form>
</div>

<?php wp_footer(); ?>
</body>
</html>