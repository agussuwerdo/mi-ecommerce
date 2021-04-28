<div id="content">
	<div class="container">
		<div class="row">
			<div id="checkout" class="col-lg-9">
				<div class="box">
					<form id="form-checkout-submit">
						<input hidden type="text" name="step" value="4">
						<ul class="nav nav-pills nav-fill">
							<li class="nav-item"><a href="<?= base_url('checkout') ?>" class="nav-link"> <i class="fa fa-map-marker"></i><br>Address</a></li>
							<li class="nav-item"><a href="<?= base_url('checkout/delivery') ?>" class="nav-link"><i class="fa fa-truck"></i><br>Delivery Method</a></li>
							<li class="nav-item"><a href="<?= base_url('checkout/payment') ?>" class="nav-link"><i class="fa fa-money"></i><br>Payment Method</a></li>
							<li class="nav-item"><a href="<?= base_url('checkout/review') ?>" class="nav-link active"><i class="fa fa-eye"></i><br>Order Review</a></li>
						</ul>
						<div class="content">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th colspan="2">Product</th>
											<th>Quantity</th>
											<th>Unit price</th>
											<th>Discount</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php $carts = cart_data();
										if ($carts['total_items'])
											foreach ($carts['carts'] as $rowid => $cart) { ?>
											<tr>
												<td><a href="<?= $cart['options']['product_link'] ?>"><img src="<?= empty_image() ?>" alt="<?= $cart['name'] ?>"></a></td>
												<td><a href="<?= $cart['options']['product_link'] ?>"><?= $cart['name'] ?></a></td>
												<td><?= number_format($cart['qty'] ?: 0) ?></td>
												<td>Rp <?= number_format($cart['options']['original_price'] ?: 0) ?></td>
												<td>Rp <?= number_format($cart['options']['discount'] ?: 0) ?></td>
												<td>Rp <?= number_format($cart['subtotal'] ?: 0) ?></td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="5">Total</th>
											<th colspan="2">Rp <?= number_format($carts['total_price'] ?: 0) ?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="box-footer d-flex flex-wrap align-items-center justify-content-between">
							<div class="left-col"><a href="<?= base_url('checkout/payment') ?>" class="btn btn-secondary mt-0"><i class="fa fa-chevron-left"></i>Back to payment method</a></div>
							<div class="right-col">
								<button type="submit" class="btn btn-template-main">Place the order<i class="fa fa-chevron-right"></i></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<?= $this->load->view('checkout/summary') ?>
		</div>
	</div>
</div>
<script>
$('#form-checkout-submit').submit(function(e){
	e.preventDefault();
	submit_checkout();
})
</script>
