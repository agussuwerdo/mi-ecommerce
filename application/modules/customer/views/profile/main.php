<div id="content">
	<div class="container">
		<div class="row bar mb-0">
			<div id="customer-orders" class="col-md-9">
				<div id="pills-tabContent" class="tab-content">
					<div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" class="tab-pane fade show active">
						<p class="text-muted lead">My order list.</p>
						<div class="">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Order</th>
											<th>Date</th>
											<th>Total</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if ($order_list->num_rows() == 0) echo '<h4 class="ml-5">NO DATA</h4>';
										foreach ($order_list->result_array() as $order) { ?>
											<tr>
												<th>#<?= $order['invoice_number'] ?></th>
												<td><?= $order['sales_date'] ?></td>
												<td>Rp. <?= number_format($order['retail_sales_total']) ?></td>
												<td>
													<?php if ($order['status'] == 0) { ?>
														<span class="badge badge-warning">Waiting confirmation</span>
													<?php } else { ?>
														<span class="badge badge-info">Being prepared</span>
													<?php } ?>
												</td>
												<td><a href="javascript:void(0)" onclick="view_sales_detail('<?= $order['invoice_number'] ?>')" class="btn btn-template-outlined btn-sm">View Detail</a></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="pills-wishlist" role="tabpanel" aria-labelledby="pills-wishlist-tab" class="tab-pane fade">
						<p class="text-muted lead">My wish list.</p>
						<div class="row products">
							<?php
							if ($wish_list->num_rows() == 0) echo '<h4 class="ml-5">NO DATA</h4>';
							foreach ($wish_list->result_array() as $product) {
								$product_url = base_url('product/' . $product['slug']);
								$dicounted_price = $product['price'] - $product['discount'];
							?>
								<div class="col-lg-3 col-md-4">
									<div class="product">
										<div class="image"><a href="<?= $product_url ?>"><img src="<?= empty_image() ?>" alt="<?= $product['name'] ?>" class="img-fluid image1"></a></div>
										<div class="text">
											<h3 class="h5"><a href="<?= $product_url ?>"><?= $product['name'] ?></a></h3>
											<p class="price">
												<del <?= ($product['discount']) ? '' : 'hidden' ?>>Rp <?= number_format($product['price']) ?></del> Rp <?= number_format($dicounted_price) ?>
											</p>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" class="tab-pane fade">
						<p class="text-muted lead">My profile.</p>
						<div id="customer-account" class="col-lg-10 clearfix">
							<p class="lead">Change your personal details or your password here.</p>
							<div class="box mt-5">
								<div class="heading">
									<h3 class="text-uppercase">Change password</h3>
								</div>
								<form id="form-profile-update-password" class="needs-validation">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="old_password">Old password</label>
												<input minlength="8" name="old_password" id="old_password" type="password" class="form-control">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="new_password">New password</label>
												<input minlength="8" name="new_password" id="new_password" type="password" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="new_password_confirm">Retype new password</label>
												<input minlength="8" name="new_password_confirm" id="new_password_confirm" type="password" class="form-control" equalTo="#new_password">
											</div>
										</div>
									</div>
									<div class="text-center">
										<button type="submit" class="btn btn-template-outlined"><i class="fa fa-save"></i> Save new password</button>
									</div>
								</form>
							</div>
							<div class="box mt-5">
								<div class="heading">
									<h3 class="text-uppercase">Personal details</h3>
								</div>
								<form id="form-profile-update-user" class="needs-validation">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="user_name">Name</label>
												<input name="user_name" id="user_name" type="text" class="form-control" required value="<?= $this->session->userdata('customer_name') ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="lastname">Adress</label>
												<textarea name="user_adress" id="user_adress" cols="30" rows="2" class="form-control" required><?= $this->session->userdata('customer_adress') ?></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 text-center">
											<button type="submit" class="btn btn-template-outlined"><i class="fa fa-save"></i> Save changes</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 mt-4 mt-md-0">
				<!-- CUSTOMER MENU -->
				<div class="panel panel-default sidebar-menu">
					<div class="panel-heading">
						<h3 class="h4 panel-title">Customer section</h3>
					</div>
					<div class="panel-body">
						<ul class="nav nav-pills flex-column text-sm">
							<li class="nav-item"><a id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" class="nav-link active"><i class="fa fa-list"></i> My orders</a></li>
							<li class="nav-item"><a id="pills-wishlist-tab" data-toggle="pill" href="#pills-wishlist" role="tab" aria-controls="pills-wishlist" aria-selected="false" class="nav-link"><i class="fa fa-heart"></i> My wishlist</a></li>
							<li class="nav-item"><a id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" class="nav-link"><i class="fa fa-user"></i> My account</a></li>
							<li class="nav-item"><a href="javascript:void(0)" onclick="confirm_logout_customer()" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
