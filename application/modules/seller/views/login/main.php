<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AdminLTE 3 | Log in (v2)</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/fontawesome-free/css/all.min.css') ?>">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/back/dist/css/adminlte.min.css') ?>">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?= base_url() ?>" class="h1"><b>mi </b>eCommerce</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Sign in to access seller page</p>

				<form id="form-login" autocomplete="off">
					<div class="input-group mb-3">
						<input type="email" class="form-control" placeholder="Email" id="email" name="email">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" placeholder="Password" id="pass" name="pass">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div>
						</div>
						<!-- /.col -->
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block">Sign In</button>
						</div>
						<!-- /.col -->
					</div>
				</form>

				<div class="social-auth-links text-center mt-2 mb-3">
					<p> default login : <strong>admin@mi.com</strong> - <strong>admin</strong> </p>
				</div>
				<!-- /.social-auth-links -->
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="<?= base_url('assets/back/plugins/jquery/jquery.min.js') ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/back/dist/js/adminlte.min.js') ?>"></script>
	<!-- login script -->
	<script>
		$(document).ready(function() {
			$('#form-login').submit(function(e) {
				e.preventDefault();
				$.ajax({
					url: site_url + "seller/login/authorize",
					type: "POST",
					data: $(this).serialize(),
					dataType: "json",
					success: function(res) {
						if (!res.status_code) {
							swal.fire('error', res.message || 'terjadi kesalahan', "error").then(() => {
								if (res.focus)
									$('#' + res.focus).focus();
							});
						} else {
							swal.fire('Sukses', res.message, "info").then(() => {
								window.location = site_url + res.url;
							});
						}
					},
					error: function(res) {
						if (res.message) {
							swal.fire('error', res.message, "error");
						} else {
							// error internal
							swal.fire('error', 'gagal mengambil data', "error");
						}
					}
				})
			})
		})
	</script>
	<script src="<?= base_url('assets/js/helper.js') ?>?<?= date('His') ?>"></script>
	<!-- SweetAlert2 -->
	<script src="<?= base_url('assets/back/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
</body>
<style>
	body.swal2-height-auto {
		height: 100vh !important;
	}
</style>

</html>
