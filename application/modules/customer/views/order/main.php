<div class="container">
	<div class="row bar">
		<div class="row" id="cart-contents"></div>

		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="box text-uppercase mt-0 mb-small">
					<h3>You may also like these products</h3>
				</div>
			</div>
			<?php foreach ($random_product->result_array() as $row) {
				$product_url = base_url('product/' . $row['slug']);
				$dicounted_price = $row['price'] - $row['discount'];
			?>
				<div class="col-lg-3 col-md-6">
					<div class="product">
						<div class="image"><a href="<?= $product_url ?>"><img width="150px" src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
						<div class="text">
							<h3 class="h5"><a href="<?= $product_url ?>"><?= $row['name'] ?></a></h3>
							<p class="price">
								<del <?= ($row['discount']) ? '' : 'hidden' ?>>Rp <?= number_format($row['price']) ?></del> Rp <?= number_format($dicounted_price) ?>
							</p>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		get_cart();
	});
</script>
