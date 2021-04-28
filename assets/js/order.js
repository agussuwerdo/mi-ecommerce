$(document).ready(function () {
	$("#form-order-product").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: site_url + "customer/order/save_cart",
			type: "post",
			data: $(this).serialize(),
		})
			.then(function (res) {
				if (!res.status_code) {
					swal.fire("error", res.message || "terjadi kesalahan", "error");
				} else {
					Swal.fire({
						toast: true,
						position: "top",
						showConfirmButton: false,
						timerProgressBar: true,
						timer: 3000,
						icon: "success",
						title: res.message,
					});
				}
				refresh_cart_count();
			})
			.catch(function (res) {
				if (res.message) {
					swal.fire("error", res.message, "error");
				} else {
					// error internal
					swal.fire("error", "gagal mengambil data", "error");
				}
			});
	});

	$(document).on("click", ".quantity .plus", function () {
		var $qty = $(this).parents(".quantity").find(".qty");
		var currentVal = parseInt($qty.val());
		var maxVal = $qty.attr("max") || 1000;
		if (!isNaN(currentVal) && currentVal < maxVal) {
			$qty.val(currentVal + 1);
		}
	});

	$(document).on("click", ".quantity .minus", function () {
		var $qty = $(this).parents(".quantity").find(".qty");
		var currentVal = parseInt($qty.val());
		if (!isNaN(currentVal) && currentVal > 1) {
			$qty.val(currentVal - 1);
		}
	});
	get_cart();
});

function get_cart() {
	$.ajax({
		url: site_url + "customer/order/cart_contents",
		dataType: "html",
	}).then(function (response) {
		$("#cart-contents").html(response);
		refresh_cart_count();
	});
}

function update_cart(show_msg = 1) {
	$.ajax({
		url: site_url + "customer/order/update_cart",
		data: $("#form-cart-contents").serialize(),
		type: "post",
	})
		.then(function (res) {
			if (!res.status_code)
				swal.fire("error", res.message || "terjadi kesalahan", "error");
			else {
				if (show_msg)
					Swal.fire({
						toast: true,
						position: "top",
						timerProgressBar: true,
						showConfirmButton: false,
						timer: 3000,
						icon: "success",
						title: res.message,
					}).then(() => {});
			}
			refresh_cart_count();
			get_cart();
		})
		.catch(function (res) {
			if (res.message) {
				swal.fire("error", res.message || "terjadi kesalahan", "error");
			} else {
				swal.fire("error", "gagal mengupdate keranjang", "error");
			}
			get_cart();
		});
}

function refresh_cart_count() {
	$.ajax({
		url: site_url + "customer/order/get_cart_count",
	}).then(function (res) {
		if (res.carts.total_items)
			$(".cart-count").show().text(res.carts.total_items);
		else $(".cart-count").hide();
	});
}

function submit_checkout() {
	Swal.fire({
		title: "Submit Order?",
		text: "Your order will be placed",
		icon: "warning",
		showCloseButton: false,
		showCancelButton: true,
		confirmButtonText: "Yes",
		cancelButtonText: "Cancel",
		confirmButtonColor: "#d33",
	}).then(function (a) {
		if (a.value) {
			ajax_submit_checkout();
		}
	});
}

function ajax_submit_checkout() {
	$.ajax({
		url: site_url + "customer/order/submit_order",
		type: "post",
	}).then(function (res) {
		if (!res.status_code) {
			swal.fire("error", res.message || "terjadi kesalahan", "error");
		} else {
			Swal.fire("success", res.message || "Checkout success", "success").then(function(){
				window.location = site_url + "profile";
			});
		}
	})
	.catch(function (res) {
		if (res.message) {
			swal.fire("error", res.message, "error");
		} else {
			// error internal
			swal.fire("error", "gagal mengambil data", "error");
		}
	});
}

function wishlist(i) {
	var el = $(i);
	var id = $(i).data('item-id');
	$.ajax({ url: site_url + `customer/product/in_wish?id=${id}` })
		.then(function (r) {
			if (!r.status_code) {
				if (r.noauth)
					showLoginMsg();
			} else {
				if (r.type) {
					el.find("i").removeClass("fa-heart-o").addClass("fa-heart text-danger");
					el.attr('title', 'Remove from wishlist');
					el.attr('data-original-title', 'Remove from wishlist');
					Swal.fire({
						toast: true,
						position: "top",
						showConfirmButton: false,
						timerProgressBar: true,
						timer: 3000,
						icon: "success",
						title: 'Product added to wishlist',
					})
				} else {
					el.find("i").removeClass("fa-heart text-danger").addClass("fa-heart-o");
					el.attr('title', 'Add to wishlist');
					el.attr('data-original-title', 'Add to wishlist');
					Swal.fire({
						toast: true,
						position: "top",
						showConfirmButton: false,
						timerProgressBar: true,
						timer: 3000,
						icon: "success",
						title: 'Product removed from wishlist',
					})
				}
			}
		});
}

function showLoginMsg() {
	Swal.fire({
		title: 'You have to login first',
		icon: 'info',
		html:
			`<div class="form-row">
                      <div class="form-group col">
                          <a href="${site_url}login" class="btn btn-dark btn-modern btn-block text-uppercase rounded-0 font-weight-bold text-3 py-3 ladda-button" data-loading-text="Loading..."><span class="ladda-label"><i class="fa fa-sign-in"></i> Sign In</span><span class="ladda-spinner"></span></a>
                      </div>
                  </div>`,
		showCloseButton: false,
		showConfirmButton: false
	})
}
