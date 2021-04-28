<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->bc->get_title() ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/fontawesome-free/css/all.min.css') ?>">
	<!-- DataTables -->
	<link rel="stylesheet" href=" <?= base_url('assets/back/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href=" <?= base_url('assets/back/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href=" <?= base_url('assets/back/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/back/dist/css/adminlte.min.css') ?>">
	<!-- Select2 -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/select2/css/select2.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?= base_url('assets/back/plugins/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
	<!-- jQuery -->
	<script src="<?= base_url('assets/back/plugins/jquery/jquery.min.js') ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	<!-- bs-custom-file-input -->
	<script src="<?= base_url('assets/back/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
	<!-- DataTables  & Plugins -->
	<script src="<?= base_url('assets/back/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/jszip/jszip.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/pdfmake/pdfmake.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/pdfmake/vfs_fonts.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
	<script src="<?= base_url('assets/back/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/back/dist/js/adminlte.min.js') ?>"></script>
	<!-- eModal -->
	<script src="<?= base_url('assets/back/plugins/emodal/eModal.js') ?>"></script>
	<!-- helper -->
	<script src="<?= base_url('assets/js/helper.js') ?>?<?= date('His') ?>"></script>
	<!-- Select2 -->
	<script src="<?= base_url('assets/back/plugins/select2/js/select2.full.min.js') ?>"></script>
	<!-- SweetAlert2 -->
	<script src="<?= base_url('assets/back/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
</head>
<?php $order_count = order_count_seller(); ?>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
				<li class="nav-item d-none d-sm-inline-block">
					<a href="<?= base_url('seller') ?>" class="nav-link">Home</a>
				</li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<!-- Navbar Search -->
				<li class="nav-item">
					<a class="nav-link" data-widget="navbar-search" href="#" role="button">
						<i class="fas fa-search"></i>
					</a>
					<div class="navbar-search-block">
						<form class="form-inline">
							<div class="input-group input-group-sm">
								<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
								<div class="input-group-append">
									<button class="btn btn-navbar" type="submit">
										<i class="fas fa-search"></i>
									</button>
									<button class="btn btn-navbar" type="button" data-widget="navbar-search">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</li>
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown">
					<a class="nav-link" data-toggle="dropdown" href="#">
						<i class="far fa-bell"></i>
						<span class="badge badge-warning navbar-badge"><?= $order_count ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header"> Notifications</span>
						<div class="dropdown-divider"></div>
						<div class="dropdown-divider"></div>
						<a href="<?=base_url('seller/transaction/sales')?>" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> <?= $order_count ?> new transaction
							<span class="float-right text-muted text-sm">1 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?=base_url('seller/transaction/sales')?>" class="dropdown-item dropdown-footer">See All Transactions</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
			</ul>
		</nav>
		<!-- /.navbar -->
		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="<?= base_url('assets/back/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="#" class="d-block"><?= $this->session->userdata('seller_name') ?></a>
					</div>
				</div>

				<!-- SidebarSearch Form -->
				<div class="form-inline">
					<div class="input-group" data-widget="sidebar-search">
						<input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
						<div class="input-group-append">
							<button class="btn btn-sidebar">
								<i class="fas fa-search fa-fw"></i>
							</button>
						</div>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						<li class="nav-item <?= get_menu_active('dashboard', true) ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link <?= get_menu_active('dashboard', true) ? 'active' : '' ?>">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('seller/dashboard/sales') ?>" class="nav-link <?= get_menu_active('seller/dashboard/sales') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Sales</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item <?= get_menu_active('transaction', true) ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link <?= get_menu_active('transaction', true) ? 'active' : '' ?>">
								<i class="nav-icon fas fa-copy"></i>
								<p>
									Transaction
									<i class="fas fa-angle-left right"></i>
									<span <?= ($order_count == 0) ? 'hidden' : '' ?> class="badge badge-info right"><?= $order_count ?></span>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= base_url('seller/transaction/sales') ?>" class="nav-link <?= get_menu_active('seller/transaction/sales') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Sales</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item <?= get_menu_active('master', true) ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link <?= get_menu_active('master', true) ? 'active' : '' ?>">
								<i class="nav-icon fas fa-chart-pie"></i>
								<p>
									Master Data
									<i class="right fas fa-angle-left"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= site_url('seller/master/product') ?>" class="nav-link <?= get_menu_active('seller/master/product') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Product</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= site_url('seller/master/category') ?>" class="nav-link <?= get_menu_active('seller/master/category') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Category</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= site_url('seller/master/sub_category') ?>" class="nav-link <?= get_menu_active('seller/master/sub_category') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Sub Category</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-item <?= get_menu_active('reporting', true) ? 'menu-open' : '' ?>">
							<a href="#" class="nav-link <?= get_menu_active('reporting', true) ? 'active' : '' ?>">
								<i class="nav-icon fas fa-tree"></i>
								<p>
									Reporting
									<i class="fas fa-angle-left right"></i>
								</p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="<?= site_url('seller/reporting/daily') ?>" class="nav-link <?= get_menu_active('seller/reporting/daily') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Sales Daily</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= site_url('seller/reporting/monthly') ?>" class="nav-link <?= get_menu_active('seller/reporting/monthly') ? 'active' : '' ?>">
										<i class="far fa-circle nav-icon"></i>
										<p>Sales Monthly</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="nav-header">Operations</li>
						<li class="nav-item">
							<a href="<?=base_url()?>" class="nav-link">
								<i class="nav-icon far fa-circle text-primary"></i>
								<p class="text">Back to Store</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="javascript:void(0)" onclick="confirm_logout_seller()" class="nav-link">
								<i class="nav-icon far fa-circle text-danger"></i>
								<p class="text">Logout Seller</p>
							</a>
						</li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1><?= $this->bc->get_title() ?></h1>
						</div>
						<div class="col-sm-6">
							<?= $this->bc->render() ?>
						</div>
					</div>
				</div><!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<?= isset($content) ? $this->load->view($content) : '' ?>
					<!-- /.row -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
			<div id="temp-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Attention</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<h5>Loading...</h5>
							<div class=progress>
								<div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Version</b> 3.1.0
			</div>
			<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

</body>

</html>
