<div id="content">
	<div class="container">
		<div class="d-flex justify-content-center">
			<div class="col-lg-6">
				<div class="box">
					<h2 class="text-uppercase">New account</h2>
					<p class="lead">Not our registered customer yet?</p>
					<p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
					<p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
					<hr>
					<form id="form-login-register-user">
						<div class="form-group">
							<label for="name-login">Name</label>
							<input name="name" id="name-login" type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="email-login">Email</label>
							<input name="email" id="email-login" type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="email-login">Adress</label>
							<input name="adress" id="adress-login" type="text" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="password-login">Password</label>
							<input name="pass" minlength="8" id="password-login" type="password" class="form-control" required>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-template-outlined"><i class="fa fa-user-md"></i> Register</button>
						</div>
					</form>
					<hr>
					<p class="text-center text-muted">Already Registered?</p>
					<p class="text-center text-muted"><a href="<?=base_url('login')?>"><strong>Login Now</strong></a></p>
					<hr>
					<p class="text-center text-muted">Forgot Password?</p>
					<p class="text-center text-muted"><a href="<?=base_url('forgot')?>"><strong>Forgot Password</strong></a></p>
				</div>
			</div>
		</div>
	</div>
</div>
