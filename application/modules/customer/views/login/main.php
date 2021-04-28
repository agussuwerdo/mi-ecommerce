<div id="content">
	<div class="container">
		<div class="d-flex justify-content-center">
			<div class="col-lg-6">
				<div class="box">
					<?php
					$error_msg = $this->session->flashdata('error');
					if ($error_msg) { ?>
						<div role="alert" class="alert alert-danger alert-dismissible">
							<button type="button" data-dismiss="alert" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button><?= $error_msg ?>
						</div>
					<?php } ?>
					<h2 class="text-uppercase">Login</h2>
					<p class="lead">Already our customer?</p>
					<hr>
					<form autocomplete="off" id="form-login-customer">
						<div class="form-group">
							<label for="email">Email</label>
							<input name="email" id="email" type="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label for="pass">Password</label>
							<input name="pass" id="pass" type="password" class="form-control" required>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Log in</button>
						</div>
					</form>
					<hr>
					<p class="text-center text-muted">Not registered yet?</p>
					<p class="text-center text-muted"><a href="<?=base_url('register')?>"><strong>Register now</strong></a>! It is easy and done in 1&nbsp;minute and gives you access to special discounts and much more!</p>
				</div>
			</div>
		</div>
	</div>
</div>
