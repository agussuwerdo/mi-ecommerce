<div id="content">
	<div class="container">
		<div class="row">
			<div id="checkout" class="col-lg-9">
				<div class="box">
					<form method="get" action="<?= base_url('checkout/submit') ?>">
						<input hidden type="text" name="step" value="3">
						<ul class="nav nav-pills nav-fill">
							<li class="nav-item"><a href="<?= base_url('checkout') ?>" class="nav-link"> <i class="fa fa-map-marker"></i><br>Address</a></li>
							<li class="nav-item"><a href="<?= base_url('checkout/delivery') ?>" class="nav-link"><i class="fa fa-truck"></i><br>Delivery Method</a></li>
							<li class="nav-item"><a href="<?= base_url('checkout/payment') ?>" class="nav-link active"><i class="fa fa-money"></i><br>Payment Method</a></li>
							<li class="nav-item"><a href="#" class="nav-link disabled"><i class="fa fa-eye"></i><br>Order Review</a></li>
						</ul>
						<div class="content">
							<div class="row">
								<div class="col-sm-6">
									<div class="box payment-method">
										<h4>Bank Transfer</h4>
										<p>VISA and Mastercard only.</p>
										<div class="box-footer text-center">
											<input checked type="radio" name="payment" value="payment2">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer d-flex flex-wrap align-items-center justify-content-between">
							<div class="left-col"><a href="<?=base_url('checkout/delivery')?>" class="btn btn-secondary mt-0"><i class="fa fa-chevron-left"></i>Back to delivery method</a></div>
							<div class="right-col">
								<button type="submit" class="btn btn-template-main">Review order<i class="fa fa-chevron-right"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?= $this->load->view('checkout/summary') ?>
		</div>
	</div>
</div>
