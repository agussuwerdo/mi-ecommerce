<div class="">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="orderdate">Order Date</label>
				<input id="orderdate" type="text" class="form-control" readonly value="<?= $sales_row['sales_date'] ?>">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="totalitems">Total Items</label>
				<input id="totalitems" type="text" class="form-control text-right" readonly value="<?= number_format($sales_row['quantity_total'] ?: 0) ?> Pcs">
			</div>
		</div>
	</div>
	<hr>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th colspan="2" class="border-top-0">Product</th>
					<th class="border-top-0">Quantity</th>
					<th class="border-top-0">Unit price</th>
					<th class="border-top-0">Discount</th>
					<th class="border-top-0">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($sales_detail_list->result_array() as $order) { ?>
					<tr>
						<td><a href="<?= base_url('product') . '/' . $order['slug'] ?>"><img width="100px" src="<?= empty_image() ?>" alt="White Blouse Armani" class="img-fluid"></a></td>
						<td><a href="<?= base_url('product') . '/' . $order['slug'] ?>"><?= $order['f_name'] ?></a></td>
						<td><?= number_format($order['quantity'] ?: 0) ?></td>
						<td>Rp <?= number_format($order['price'] ?: 0) ?></td>
						<td>Rp <?= number_format($order['discount'] ?: 0) ?></td>
						<td>Rp <?= number_format($order['retail_sales'] ?: 0) ?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" class="text-right">Order Subtotal</th>
					<th> Rp <?= number_format($sales_row['price_total'] ?: 0) ?></th>
				</tr>
				<tr>
					<th colspan="5" class="text-right">Discount Total</th>
					<th> Rp <?= number_format($sales_row['discount_total'] ?: 0) ?></th>
				</tr>
				<tr>
					<th colspan="5" class="text-right">Shipping and handling</th>
					<th> Rp <?= number_format($sales_row['shipping_cost'] ?: 0) ?></th>
				</tr>
				<tr>
					<th colspan="5" class="text-right">Total</th>
					<th> Rp <?= number_format($sales_row['retail_sales_total'] ?: 0) ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
	<hr>
	<div class="row addresses">
		<div class="col-md-6 text-right">
			<h3 class="text-uppercase">Status</h3>
			<p>
				<?php if ($sales_row['status'] == 0) { ?>
					<span class="badge badge-warning">Waiting confirmation</span>
				<?php } else { ?>
					<span class="badge badge-info">Being prepared</span>
				<?php } ?>
			</p>
		</div>
		<div class="col-md-6 text-right">
			<h3 class="text-uppercase">Shipping address</h3>
			<p><?= $sales_row['customer_address_name'] ?><br><?= $sales_row['customer_address'] ?></p>
		</div>
	</div>
</div>
