
<form name="resetpassform" id="resetpassform" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post" autocomplete="off">
	<input type="hidden" id="user_login" name="rp_login" value="<?php echo esc_attr( $attributes['login'] ); ?>" autocomplete="off" />
	<input type="hidden" name="rp_key" value="<?php echo esc_attr( $attributes['key'] ); ?>" />

	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<div class="alert alert-danger">
				<?php echo $error; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

	<div class="form-group">
		<input type="password" name="pass1" id="pass1" class="form-control" size="20" value="" autocomplete="off" placeholder="New password*" required>
	</div>
	
	<div class="form-group">
		<input type="password" name="pass2" id="pass2" class="form-control" size="20" value="" autocomplete="off" placeholder="Repeat new password*" required>
	</div>
  
  <p class="description"><?php echo wp_get_password_hint(); ?></p>
  
	<div class="form-group form-group-button">
		<button class="btn" type="submit" name="submit" id="resetpass-button">Reset Password</button>
	</div>

</form>


		
