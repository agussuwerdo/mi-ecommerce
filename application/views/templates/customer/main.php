<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $this->bc->get_title() ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="all,follow">
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="<?= base_url('assets/front/vendor/bootstrap/css/bootstrap.min.css') ?>">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="<?= base_url('assets/front/vendor/font-awesome/css/font-awesome.min.css') ?>">
	<!-- Google fonts - Roboto-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,700">
	<!-- Bootstrap Select-->
	<link rel="stylesheet" href="<?= base_url('assets/front/vendor/bootstrap-select/css/bootstrap-select.min.css') ?>">
	<!-- owl carousel-->
	<link rel="stylesheet" href="<?= base_url('assets/front/vendor/owl.carousel/assets/owl.carousel.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/front/vendor/owl.carousel/assets/owl.theme.default.css') ?>">
	<!-- theme stylesheet-->
	<link rel="stylesheet" href="<?= base_url('assets/front/css/style.default.css" id="theme-stylesheet') ?>">
	<!-- Custom stylesheet - for your changes-->
	<link rel="stylesheet" href="<?= base_url('assets/front/css/custom.css') ?>">
	<!-- Favicon and apple touch icons-->
	<link rel="shortcut icon" href="<?= base_url('assets/front/img/favicon.ico" type="image/x-icon') ?>">
	<link rel="apple-touch-icon" href="<?= base_url('assets/front/img/apple-touch-icon.png') ?>">
	<link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('assets/front/img/apple-touch-icon-57x57.png') ?>">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('assets/front/img/apple-touch-icon-72x72.png') ?>">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/front/img/apple-touch-icon-76x76.png') ?>">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('assets/front/img/apple-touch-icon-114x114.png') ?>">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('assets/front/img/apple-touch-icon-120x120.png') ?>">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('assets/front/img/apple-touch-icon-144x144.png') ?>">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('assets/front/img/apple-touch-icon-152x152.png') ?>">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
	<!-- Tweaks for older IEs-->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
	<script src="<?= base_url('assets/front/vendor/jquery/jquery.min.js') ?>"></script>
</head>

<body>
	<div id="all">
		<!-- Top bar-->
		<div class="top-bar">
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-md-6 d-md-block d-none">
						<p>Contact us on +420 777 555 333 or hello@universal.com.</p>
					</div>
					<div class="col-md-6">
						<div class="d-flex justify-content-md-end justify-content-between">
							<ul class="list-inline contact-info d-block d-md-none">
								<li class="list-inline-item"><a href="#"><i class="fa fa-phone"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>
							<?php if (is_customer_authorized()) { ?>
								<div class="login"><a href="<?= base_url('profile') ?>" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block"><?= $this->session->userdata('customer_name') ?> <?php $order_count = order_count_cust(); ?> <span <?= ($order_count == 0) ? 'hidden' : '' ?> class="badge badge-info order-count" style="display: inline;"><?= $order_count ?></span></span></a><a href="javascript:void(0)" onclick="confirm_logout_customer()" class="signup-btn"><i class="fa fa-sign-in"></i><span class="d-none d-md-inline-block">Logout</span></a></div>
							<?php } else {
							?>
								<div class="login"><a href="<?= base_url('login') ?>" class="login-btn"><i class="fa fa-sign-in"></i><span class="d-none d-md-inline-block">Sign In</span></a><a href="<?= base_url('register') ?>" class="signup-btn"><i class="fa fa-user"></i><span class="d-none d-md-inline-block">Sign Up</span></a></div>
							<?php } ?>
							<ul class="social-custom list-inline">
								<li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Top bar end-->
		<!-- Login Modal-->
		<div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalLabel" aria-hidden="true" class="modal fade">
			<div role="document" class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 id="login-modalLabel" class="modal-title">Customer Login</h4>
						<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
					</div>
					<div class="modal-body">
						<form action="customer-orders.html" method="get">
							<div class="form-group">
								<input id="email_modal" type="text" placeholder="email" class="form-control">
							</div>
							<div class="form-group">
								<input id="password_modal" type="password" placeholder="password" class="form-control">
							</div>
							<p class="text-center">
								<button class="btn btn-template-outlined"><i class="fa fa-sign-in"></i> Log in</button>
							</p>
						</form>
						<p class="text-center text-muted">Not registered yet?</p>
						<p class="text-center text-muted"><a href="customer-register.html"><strong>Register now</strong></a>! It is easy and done in 1 minute and gives you access to special discounts and much more!</p>
					</div>
				</div>
			</div>
		</div>
		<!-- Login modal end-->
		<!-- Navbar Start-->
		<?= $this->load->view('templates/customer/navbar') ?>
		<!-- Navbar End-->

		<div id="heading-breadcrumbs">
			<div class="container">
				<div class="row d-flex align-items-center flex-wrap">
					<div class="col-md-7">
						<h1 class="h2"><?= $this->bc->get_title(); ?></h1>
					</div>
					<div class="col-md-5">
						<?= $this->bc->render(); ?>
					</div>
				</div>
			</div>
		</div>
		<div id="content">
			<?= isset($content) ? $this->load->view($content) : ''; ?>
		</div>
		<!-- GET IT-->
		<div class="get-it">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 text-center p-3">
						<h3>Do you want cool website like this one?</h3>
					</div>
					<div class="col-lg-4 text-center p-3"> <a href="#" class="btn btn-template-outlined-white">Buy this template now</a></div>
				</div>
			</div>
		</div>
		<!-- FOOTER -->
		<footer class="main-footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<h4 class="h6">About Us</h4>
						<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
						<hr>
						<h4 class="h6">Join Our Monthly Newsletter</h4>
						<form>
							<div class="input-group">
								<input type="text" class="form-control">
								<div class="input-group-append">
									<button type="button" class="btn btn-secondary"><i class="fa fa-send"></i></button>
								</div>
							</div>
						</form>
						<hr class="d-block d-lg-none">
					</div>
					<div class="col-lg-6 text-center">
						<h4 class="h6">Contact</h4>
						<p class="text-uppercase"><strong>Universal Ltd.</strong><br>13/25 New Avenue <br>Newtown upon River <br>45Y 73J <br>England <br><strong>Great Britain</strong></p><a href="contact.html" class="btn btn-template-main">Go to contact page</a>
						<hr class="d-block d-lg-none">
					</div>
				</div>
			</div>
			<div class="copyrights">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 text-center-md">
							<p> <a href="https://github.com/agussuwerdo">@agussuwerdo</a> 2021. </p>
						</div>
						<div class="col-lg-8 text-right text-center-md">
							<p>Template design by <a href="https://bootstrapious.com/snippets">Bootstrapious </a>& <a href="https://fity.cz/">Fity</a></p>
							<!-- Please do not remove the backlink to us unless you purchase the Attribution-free License at https://bootstrapious.com/donate. Thank you. -->
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<!-- Javascript files-->
	<script src="<?= base_url('assets/front/vendor/popper.js/umd/popper.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/jquery.cookie/jquery.cookie.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/waypoints/lib/jquery.waypoints.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/jquery.counterup/jquery.counterup.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/owl.carousel/owl.carousel.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/js/jquery.parallax-1.1.3.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/bootstrap-select/js/bootstrap-select.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/vendor/jquery.scrollto/jquery.scrollTo.min.js') ?>"></script>
	<script src="<?= base_url('assets/front/js/front.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
	<!-- jquery-validation -->
	<script script src="<?= base_url('assets/back/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/helper.js') ?>"></script>
	<script src="<?= base_url('assets/js/order.js') ?>"></script>
	<script src="<?= base_url('assets/js/user.js') ?>"></script>
</body>

</html>
