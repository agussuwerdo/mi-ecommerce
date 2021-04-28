<div class="col-lg-3">
	<div id="order-summary" class="box mb-4 p-0">
		<div class="box-header mt-0">
			<h3>Order summary</h3>
		</div>
		<p class="text-muted text-small">Shipping and additional costs are calculated based on the values you have entered.</p>
		<?php $carts = cart_data();?>
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
