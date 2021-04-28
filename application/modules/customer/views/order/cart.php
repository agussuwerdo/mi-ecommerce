<div class="col-lg-12">
	<p class="text-muted lead">You currently have <?= $carts['total_quantity'] ?> item(s) in your cart.</p>
</div>
<div id="basket" class="col-lg-9">
	<div class="box mt-0 pb-0 no-horizontal-padding">
		<form id="form-cart-contents" autocomplete="off">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th colspan="2">Product</th>
							<th>Quantity</th>
							<th>price</th>
							<th>Discount</th>
							<th colspan="2">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;
						if ($carts['total_items'] == 0) {
							echo '
								<div class="text-center">
								<h3> Your Cart is empty</h3>
								<p class="buttons"><a href="' . base_url() . '" class="btn btn-template-outlined"><i class="fa fa-shopping-cart"></i> Shop Now</a></p>
								</div>';
						} else
							foreach ($carts['carts'] as $rowid => $cart) { ?>
							<input type="hidden" name="<?= $no ?>[rowid]" value="<?= $rowid ?>">
							<input type="hidden" name="<?= $no ?>[id]" value="<?= $cart['id'] ?>">
							<tr>
								<td><a href="<?= $cart['options']['product_link'] ?>"><img src="<?= empty_image() ?>" alt="<?= $cart['name'] ?>" class="img-fluid"></a></td>
								<td><a href="<?= $cart['options']['product_link'] ?>"><?= $cart['name'] ?></a></td>
								<td>
									<input name="<?= $no ?>[qty]" id="qty_<?= $rowid ?>" type="number" value="<?= $cart['qty'] ?>" min="1" max="<?= $cart['qty_stock'] ?: 1 ?>" class="form-control">
								</td>
								<td>Rp <?= number_format($cart['options']['original_price'] ?: 0) ?></td>
								<td>Rp <?= number_format($cart['options']['discount'] ?: 0) ?></td>
								<td>Rp <?= number_format($cart['subtotal'] ?: 0) ?></td>
								<td><a href="#" class="remove-item-button" data-remove-id="<?= $rowid ?>"><i class="fa fa-trash-o"></i></a></td>
							</tr>
						<?php $no++;
							} ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="5">Total</th>
							<th colspan="2">Rp <?= number_format($carts['total_price'] ?: 0) ?></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="box-footer d-flex justify-content-between align-items-center">
				<div class="left-col"><a href="<?= base_url() ?>" class="btn btn-secondary mt-0"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
				<div class="right-col">
					<button type="submit" class="btn btn-secondary"><i class="fa fa-refresh"></i> Update cart</button>
					<a href="<?= base_url('checkout') ?>" class="btn btn-template-outlined">Proceed to checkout <i class="fa fa-chevron-right"></i></a>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="col-lg-3">
	<div id="order-summary" class="box mt-0 mb-4 p-0">
		<div class="box-header mt-0">
			<h3>Order summary</h3>
		</div>
		<p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td>Order subtotal</td>
						<th>Rp <?= number_format($carts['total_price'] ?: 0) ?></th>
					</tr>
					<tr <?= ($carts['total_items'] == 0) ? 'hidden' : '' ?>>
						<td>Shipping and handling</td>
						<th>Rp <?= number_format($carts['total_shipping'] ?: 0) ?></th>
					</tr>
					<tr <?= ($carts['total_items'] == 0) ? 'hidden' : '' ?> class="total">
						<td>Total</td>
						<th>Rp <?= number_format($carts['total_retail_sales'] ?: 0) ?></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#form-cart-contents').submit(function(e) {
			update_cart(1);
			e.preventDefault();
		})
		$('.remove-item-button').click(function() {
			$id_prd = $(this).data('remove-id');
			$(`#qty_${$id_prd}`).val(0);
			update_cart(1);
		})
	});
</script>
