<?php
if (get_option('users_can_register')) {
	if ( isset( $_POST['submit'] ) ) {
		global $reg_errors;
		$reg_errors = new WP_Error;

		$user  = sanitize_text_field( $_POST['user'] );
		$email = sanitize_email( $_POST['email'] );

		if ( empty( $user ) ) {
			$reg_errors->add( "empty-user", "El campo nombre es obligatorio" );
		}

		if ( username_exists( $user ) ) {
			$reg_errors->add( "duplicate-user", "El nombre de usuario ya existe en nuestra base de datos" );
		}

		if ( empty( $email ) ) {
			$reg_errors->add( "empty-email", "El campo e-mail es obligatorio" );
		}

		if ( ! is_email( $email ) ) {
			$reg_errors->add( "invalid-email", "El e-mail no tiene un formato válido" );
		}

		if ( email_exists( $email ) ) {
			$reg_errors->add( "duplicate-email", "El email indicado ya esta en uso" );
		}

		if ( is_wp_error( $reg_errors ) ) {
			if ( count( $reg_errors->get_error_messages() ) > 0 ) {
				foreach ( $reg_errors->get_error_messages() as $error ) {
					echo $error . "<br />";
				}
			}
		}

		if ( count( $reg_errors->get_error_messages() ) == 0 ) {
			$password = wp_generate_password();

			$userdata = [
				'user_login' => $user,
				'user_email' => $email,
				'user_pass'  => $password,
			];

			$user_id = wp_insert_user( $userdata );

			if ( ! is_wp_error( $user_id ) ) {
				wp_new_user_notification( $user_id, null, 'user' );
			}
		}
	} else {
		?>
		<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
			<input type="text" name="user" value="<?php echo isset($_POST['user']) ? $_POST['user'] : null;?>" placeholder="Usuario" required aria-required="true" />
			<input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : null; ?>" placeholder="Email" required aria-required="true" />
			<input type="submit" id="submit" name="submit" value="Enviar" />
		</form>
		<?php
	}
} else {
	?>
	<p>Registro desactivado en estos momentos.</p>
	<?php
}
