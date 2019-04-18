<?php
    if (is_user_logged_in()) {
	    wp_redirect(home_url());
    }

    if (!empty($_GET) && isset($_GET['login']) && $_GET['login'] == 'failed') {
        switch ($_GET['reason']) {
            case 'invalid_username':
                $error = 'Usuario o email incorrecto';
                break;
	        case 'incorrect_password':
		        $error = 'Contraseña invalida';
		        break;
            default:
	            $error = 'Error en el login';
                break;
        }
    }

    if (!empty($_GET) && isset($_GET['referer'])) {
        $referer = $_GET['referer'];
    }

    if (!empty($_GET) && isset($_GET['login']) && $_GET['login'] == 'false') {
        $just_logged_out = true;
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
			<?php include "img/brand.svg"; ?>
		</a>
        <form class="single-form__form" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post">
            <?php if (isset($error) && $error): ?>
                <div class="single-form__error-msg"><?php echo $error ?></div>
            <?php endif; ?>
	        <?php if (isset($referer) && $referer): ?>
                <div class="single-form__success-msg">Hemos enviado un correo a <strong><?php echo $referer ?></strong> con tu contraseña.</div>
            <?php endif; ?>
	        <?php if (isset($just_logged_out) && $just_logged_out): ?>
                <div class="single-form__info-msg">
                    Te has desconectado con éxito. Vuelve a la <a href="<?php echo esc_url(home_url()); ?>">portada</a> o entra de nuevo.
                </div>
	        <?php endif; ?>
            <input placeholder="Usuario o email" type="text" name="log" class="single-form__input" value="" size="20" required />
            <input placeholder="Contraseña" type="password" name="pwd" class="single-form__input" value="" size="20" required />
            <label class="single-form__remember"><input name="rememberme" type="checkbox" value="forever" /> Recordarme</label>
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url()); ?>" />
            <button class="single-form__button" type="submit">Entrar</button>
            <p class="single-form__register-text">
                ¿No tienes cuenta? <a class="single-form__register-link" href="<?php echo home_url(REGISTER_URL); ?>">¡Registrate!</a>
            </p>
        </form>
	</div>

	<?php wp_footer(); ?>
</body>
</html>