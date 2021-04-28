<div class="container">
	<div class="row bar">
		<!-- LEFT COLUMN _________________________________________________________-->
		<div class="col-lg-9">
			<p class="lead">SKU : <?= $product['sku'] ?></p>
			<p class="goToDescription"><a href="#details" class="scroll-to text-uppercase">Scroll to product details</a></p>
			<div id="productMain" class="row">
				<div class="col-sm-6">
					<div data-slider-id="1" class="owl-carousel shop-detail-carousel">
						<div> <img src="<?= empty_image() ?>" alt="" class="img-fluid"></div>
						<div> <img src="<?= empty_image() ?>" alt="" class="img-fluid"></div>
						<div> <img src="<?= empty_image() ?>" alt="" class="img-fluid"></div>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if ($product['stock'] == 0) { ?>
						<h5 class="mt-3 text-center">Stock not available</h5>
					<?php } else { ?>
						<h5 class="mt-3 text-center">Stock : <?= $product['stock'] ?: 0 ?> Pcs</h5>
					<?php } ?>
					<div class="mt-0 box">
						<form id="form-order-product" class="shop">
							<input type="text" name="order_item_id" id="order_item_id" value="<?= $product['item_id'] ?>">
							<div class="d-flex justify-content-center">
								<div class="quantity quantity-lg">
									<input type="button" style="display: block;" class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="-">
									<input readonly type="number" style="display: block;" class="input-text qty text" title="Qty" value="1" name="order_quantity" min="1" step="1" max="<?= $product['stock'] ?: 1 ?>">
									<input type="button" style="display: block;" class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary" value="+">
								</div>
							</div>
							<?php
							$dicounted_price = $product['price'] - $product['discount'];
							?>
							<p class="price mt-0">
								<del <?= ($product['discount']) ? '' : 'hidden' ?>>Rp <?= number_format($product['price']) ?><br></del> Rp <?= number_format($dicounted_price) ?>
							</p>
							<p class="text-center">
								<button <?= ($product['stock'] == 0) ? 'disabled' : '' ?> type="submit" class="btn btn-template-outlined"><i class="fa fa-shopping-cart"></i> Add to cart</button>
								<button data-item-id="<?=$product['item_id']?>" onclick="wishlist(this)" type="button" data-toggle="tooltip" data-placement="top" title="<?=$product['in_wish']?'Remove from wishlist':'Add to wishlist';?>" class="btn btn-default"><i class="fa <?=$product['in_wish']?'fa-heart text-danger':'fa-heart-o';?>"></i></button>
							</p>
						</form>
					</div>
					<div data-slider-id="1" class="owl-thumbs">
						<button class="owl-thumb-item"><img src="<?= empty_image() ?>" alt="" class="img-fluid"></button>
						<button class="owl-thumb-item"><img src="<?= empty_image() ?>" alt="" class="img-fluid"></button>
						<button class="owl-thumb-item"><img src="<?= empty_image() ?>" alt="" class="img-fluid"></button>
					</div>
				</div>
			</div>
			<div id="details" class="box mb-4 mt-4">
				<h4>Product details</h4>
				<p ><?= nl2br($product['description']) ?></p>
			</div>
			<div id="product-social" class="box social text-center mb-5 mt-5">
				<h4 class="heading-light">Show it to your friends</h4>
				<ul class="social list-inline">
					<li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="external facebook"><i class="fa fa-facebook"></i></a></li>
					<li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="external gplus"><i class="fa fa-google-plus"></i></a></li>
					<li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="external twitter"><i class="fa fa-twitter"></i></a></li>
					<li class="list-inline-item"><a href="#" data-animate-hover="pulse" class="email"><i class="fa fa-envelope"></i></a></li>
				</ul>
			</div>
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
							<div class="image"><a href="<?= $product_url ?>"><img src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
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
			<div class="row" hidden>
				<div class="col-lg-3 col-md-6">
					<div class="box text-uppercase mt-0 mb-small">
						<h3>Products viewed recently</h3>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="product">
						<div class="image"><a href="#"><img src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
						<div class="text">
							<h3 class="h5"><a href="shop-detail.html">Fur coat</a></h3>
							<p class="price">$143</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="product">
						<div class="image"><a href="#"><img src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
						<div class="text">
							<h3 class="h5"><a href="shop-detail.html">Fur coat</a></h3>
							<p class="price">$143</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="product">
						<div class="image"><a href="#"><img src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
						<div class="text">
							<h3 class="h5"><a href="shop-detail.html">Fur coat</a></h3>
							<p class="price">$143</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<!-- MENUS AND FILTERS-->
			<div class="panel panel-default sidebar-menu">
				<div class="panel-heading">
					<h3 class="h4 panel-title">Categories</h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills flex-column text-sm category-menu">
						<?php foreach ($category_list as $cat) { ?>
							<li class="nav-item">
								<a href="<?= base_url('product?cat=' . $cat['category_code']) ?>" class="nav-link d-flex align-items-center justify-content-between">
									<span><?= $cat['category_name'] ?> </span></a>
								<ul class="nav nav-pills flex-column">
									<?php foreach ($cat['sub_category'] as $sub_cat) { ?>
										<li class="nav-item"><a href="<?= base_url('product?cat=' . $cat['category_code'] . '&subcat=' . $sub_cat['sub_category_code']) ?>" class="nav-link"><?= $sub_cat['sub_category_name'] ?></a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="banner"><a href="#"><img src="<?= base_url('assets/front/img/banner.jpg') ?>" alt="sales 2014" class="img-fluid"></a></div>
		</div>
	</div>
</div>
<style>
	.shop .quantity {
		margin: 0 15px 25px 0;
		overflow: hidden;
		position: relative;
		width: 125px;
		height: 40px;
		float: left;
	}

	.shop .quantity .minus {
		background: transparent;
		border: 1px solid #F0F0F0;
		border-radius: 2px;
		box-shadow: none;
		color: #5E5E5E;
		cursor: pointer;
		display: block;
		font-size: 12px;
		font-weight: bold;
		height: 40px;
		line-height: 13px;
		margin: 0;
		overflow: visible;
		outline: 0;
		padding: 0;
		position: absolute;
		text-align: center;
		text-decoration: none;
		vertical-align: text-top;
		width: 40px;
		border-radius: 0.25rem 0 0 0.25rem;
	}

	.shop .quantity .plus {
		background: transparent;
		border: 1px solid #F0F0F0;
		border-radius: 2px;
		box-shadow: none;
		color: #5E5E5E;
		cursor: pointer;
		display: block;
		font-size: 12px;
		font-weight: bold;
		height: 40px;
		line-height: 13px;
		margin: 0;
		overflow: visible;
		outline: 0;
		padding: 0;
		position: absolute;
		text-align: center;
		text-decoration: none;
		vertical-align: text-top;
		width: 40px;
		border-radius: 0 0.25rem 0.25rem 0;
		right: 0;
		top: 0;
	}

	.shop .quantity .qty {
		border: 1px solid #F0F0F0;
		box-shadow: none;
		float: left;
		height: 40px;
		padding: 0 39px;
		text-align: center;
		width: 125px;
		font-weight: bold;
		font-size: 1em;
		outline: 0;
		border-radius: .25rem;
	}

	.shop .quantity .qty::-webkit-inner-spin-button,
	.shop .quantity .qty::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	.shop .quantity .qty::-ms-clear {
		display: none;
	}

	.shop .quantity.quantity-lg {
		height: 45px;
	}

	.shop .quantity.quantity-lg .minus {
		height: 45px;
		width: 45px;
	}

	.shop .quantity.quantity-lg .plus {
		height: 45px;
		width: 45px;
	}

	.shop .quantity.quantity-lg .qty {
		height: 45px;
	}
</style>
