<div id="content">
	<div class="container">
		<div class="row">
			<div id="checkout" class="col-lg-9">
				<div class="box border-bottom-0">
					<form method="get" action="<?= base_url('checkout/submit') ?>">
						<input hidden type="text" name="step" value="1">
						<ul class="nav nav-pills nav-fill">
							<li class="nav-item"><a href="<?= base_url('checkout') ?>" class="nav-link active"> <i class="fa fa-map-marker"></i><br>Address</a></li>
							<li class="nav-item"><a href="#" class="nav-link disabled"><i class="fa fa-truck"></i><br>Delivery Method</a></li>
							<li class="nav-item"><a href="#" class="nav-link disabled"><i class="fa fa-money"></i><br>Payment Method</a></li>
							<li class="nav-item"><a href="#" class="nav-link disabled"><i class="fa fa-eye"></i><br>Order Review</a></li>
						</ul>
						<div class="content">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="firstname">Receiver Name</label>
										<input id="firstname" type="text" class="form-control" value="<?=$this->session->userdata('customer_name')?>">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="company">Receiver Adress</label>
										<textarea name="receiver_adress" id="receiver_adress" cols="30" rows="2" class="form-control"><?=$this->session->userdata('customer_adress')?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="box-footer d-flex flex-wrap align-items-center justify-content-between">
							<div class="left-col"><a href="<?= base_url('cart') ?>" class="btn btn-secondary mt-0"><i class="fa fa-chevron-left"></i>Back to basket</a></div>
							<div class="right-col">
								<button type="submit" class="btn btn-template-main">Continue to Delivery Method<i class="fa fa-chevron-right"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?= $this->load->view('checkout/summary') ?>
		</div>
	</div>
</div>
