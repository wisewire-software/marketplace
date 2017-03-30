
<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
	<?php foreach ( $attributes['errors'] as $error ) : ?>
		<div class="alert alert-danger">
			<?php echo $error; ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<?php if ( $attributes['lost_password_sent'] )  { ?>
	<div class="alert alert-success">
		<?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
	</div>
<?php } else { ?>

<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
	<div class="form-group">
		<input type="email" name="user_login" id="user_login" class="form-control" placeholder="Email*" required>
	</div>

	<div class="form-group form-group-button">
		<button class="btn" type="submit" name="submit">Submit</button>
	</div>
</form>
            	
<?php } ?>