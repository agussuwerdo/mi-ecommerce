<div id="content">
	<div class="container">
		<div class="d-flex justify-content-center">
			<div class="col-lg-6">
				<div class="box">
					<h2 class="text-uppercase">Forgot Password</h2>
					<p class="lead">Forgot your account credentials?</p>
					<p>Please enter your email adress, We will send the reset password link via email</p>
					<hr>
					<form autocomplete="off" id="form-login-forgot">
						<div class="form-group">
							<label for="email-login">Email</label>
							<input required id="email-login" type="email" class="form-control">
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-template-outlined"><i class="fa fa-user-md"></i> Send Reset Password Link</button>
						</div>
					</form>
					<hr>
					<p class="text-center text-muted">Already Registered?</p>
					<p class="text-center text-muted"><a href="<?= base_url('login') ?>"><strong>Login Now</strong></a></p>
					<hr>
					<p class="text-center text-muted">Not registered yet?</p>
					<p class="text-center text-muted"><a href="<?= base_url('register') ?>"><strong>Register Now</strong></a></p>
				</div>
			</div>
		</div>
	</div>
</div>
