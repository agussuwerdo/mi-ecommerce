<header class="nav-holder make-sticky">
	<div id="navbar" role="navigation" class="navbar navbar-expand-lg">
		<div class="container"><a href="<?= base_url() ?>" class="navbar-brand home"><img height="60px" src="<?= logo_image() ?>" alt="Mi Ecommerce logo" class="d-none d-md-inline-block"><img src="<?= logo_image() ?>" height="50px" alt="Universal logo" class="d-inline-block d-md-none"><span class="sr-only">Mi ecommerce- go to homepage</span></a>
			<button type="button" data-toggle="collapse" data-target="#navigation" class="navbar-toggler btn-template-outlined"><span class="sr-only">Toggle navigation</span><i class="fa fa-align-justify"></i></button>
			<div id="navigation" class="navbar-collapse collapse">
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item dropdown "><a href="javascript: void(0)" data-toggle="dropdown" class="dropdown-toggle">Categories <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php foreach (category_list() as $cat) { ?>
								<li class="dropdown-item  dropdown-submenu"><a id="navBar<?= $cat['category_code'] ?>" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?= $cat['category_name'] ?></a>
									<ul aria-labelledby="navbar<?= $cat['category_code'] ?>" class="dropdown-menu">
									<?php foreach($cat['sub_category'] as $sub_cat){?>
										<li class="dropdown-item"><a href="<?= base_url('product?subcat=' . $sub_cat['sub_category_code']) ?>" class="nav-link"><?=$sub_cat['sub_category_name']?></a></li>
									<?php }?>
									</ul>
								</li>
							<?php } ?>
						</ul>
					</li>
					<li class="nav-item dropdown menu-large"><a href="<?=base_url('cart')?>">My Cart <span class="badge badge-info cart-count"></span></a>
					</li>
					<li class="nav-item dropdown"><a href="<?=base_url('seller')?>" >Login Seller</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="contact.html" class="nav-link">Login Customer</a></li>
							<li class="dropdown-item"><a href="contact2.html" class="nav-link">Login Seller</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div id="search" class="collapse clearfix">
				<form role="search" class="navbar-form">
					<div class="input-group">
						<input type="text" placeholder="Search" class="form-control"><span class="input-group-btn">
							<button type="submit" class="btn btn-template-main"><i class="fa fa-search"></i></button></span>
					</div>
				</form>
			</div>
		</div>
	</div>
</header>
