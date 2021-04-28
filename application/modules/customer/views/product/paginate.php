<div class="container">
	<div class="row bar">
		<div class="col-md-12">
			<div class="d-flex justify-content-center">
				<div class="p-2 bd-highlight">
					<?php
					$default_search = $this->input->get('q', TRUE)
					?>
                    <form autocomplete="off" role="search" action="<?= base_url('product') ?>" method="get">
					<div class="input-group" data-widget="sidebar-search">
						<input class="form-control form-control-sidebar" name="q" type="search" placeholder="Search" aria-label="Search" value="<?= $default_search ?>">
						<div class="input-group-append">
							<button class="btn btn-outline-primary" type="submit">
								<i class="fa fa-search fa-fw"></i>
							</button>
						</div>
					</div>
					</form>
				</div>
			</div>
			<p class="text-muted lead text-center"></p>
			<div class="products-big">
				<div class="row products">
					<?php foreach ($products->result_array() as $product) {
						$product_url = base_url('product/' . $product['slug']); 
						$dicounted_price = $product['price'] - $product['discount'];
						?>
						<div class="col-lg-3 col-md-4">
							<div class="product">
								<div class="image"><a href="<?= $product_url ?>"><img src="<?= empty_image() ?>" alt="" class="img-fluid image1"></a></div>
								<div class="text">
									<h3 class="h5"><a href="<?= $product_url ?>"><?= $product['name'] ?></a></h3>
									<p class="price">
									<del <?=($product['discount'])?'':'hidden'?>>Rp <?=number_format($product['price'])?></del> Rp <?=number_format($dicounted_price)?>
									</p>
								</div>
								<div class="ribbon-holder">
									<div <?=($product['discount'])?'':'hidden'?> class="ribbon sale">SALE</div>
									<div class="ribbon new">NEW</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="row" hidden>
				<div class="col-md-12 banner mb-small text-center"><a href="#"><img src="<?= empty_image() ?>" alt="" class="img-fluid"></a></div>
			</div>
			<div class="pages">
				<p hidden class="loadMore text-center"><a href="#" class="btn btn-template-outlined"><i class="fa fa-chevron-down"></i> Load more</a></p>
				<nav aria-label="Page navigation example" class="d-flex justify-content-center">
					<?= $paging ?>
				</nav>
			</div>
		</div>
	</div>
</div>
