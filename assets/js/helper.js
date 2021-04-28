function base_url() {
	var pathparts = location.pathname.split("/");
	if (location.host == "localhost") {
		var url = location.origin + "/" + pathparts[1].trim("/") + "/";
	} else {
		var url = location.origin + "/";
	}
	return url;
}

function ajaxModal(data, title = "") {
	var params = {
		type: "POST",
		beforeSend: function () {
			$("#temp-modal .modal-body")
				.empty()
				.html(
					`<h5>Loading...</h5><div class=progress><div class="progress-bar progress-bar-striped active" style="width: 100%"></div></div>`
				);
		},
	};

	if (typeof data === "object") {
		$.extend(params, data);
		title = data.title || "Attention";
	} else {
		params.url = data;
	}

	$("#temp-modal").modal();
	$("#temp-modal .modal-title").text(title);
	$.ajax(params).done(function (response) {
		$("#temp-modal .modal-body").empty().html(response);
	});
}
function closeAjaxModal() {
	$("#temp-modal").modal("hide");
}

function number_format(
	amount,
	decimalCount = 0,
	decimal = ".",
	thousands = ","
) {
	try {
		decimalCount = Math.abs(decimalCount);
		decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

		const negativeSign = amount < 0 ? "-" : "";

		let i = parseInt(
			(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount))
		).toString();
		let j = i.length > 3 ? i.length % 3 : 0;

		return (
			negativeSign +
			(j ? i.substr(0, j) + thousands : "") +
			i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
			(decimalCount
				? decimal +
				  Math.abs(amount - i)
						.toFixed(decimalCount)
						.slice(2)
				: "")
		);
	} catch (e) {
		console.log("number_format failed : ", e);
	}
}

function encode(str) {
	encodedString = btoa(str);
	return encodedString;
}

function decode(str) {
	decodedString = atob(str);
	return decodedString;
}

$("#temp-modal").on("shown.bs.modal", function () {
	$(document).off("focusin.modal");
});

function confirm_logout_seller() {
	Swal.fire({
		title: "Logout Seller?",
		text: "Your login session will be ended",
		icon: "warning",
		showCloseButton: false,
		showCancelButton: true,
		confirmButtonText: "Yes",
		cancelButtonText: "Cancel",
		confirmButtonColor: "#d33",
	}).then(function (a) {
		if (a.value) {
			window.location = site_url + "seller/login/deauthorize";
		}
	});
}

function confirm_logout_customer() {
	Swal.fire({
		title: "Logout?",
		text: "Your login session will be ended",
		icon: "warning",
		showCloseButton: false,
		showCancelButton: true,
		confirmButtonText: "Yes",
		cancelButtonText: "Cancel",
		confirmButtonColor: "#d33",
	}).then(function (a) {
		if (a.value) {
			window.location = site_url + "customer/login/deauthorize";
		}
	});
}

function view_sales_detail(invoice_number) {
	Swal.fire({
		title: "Detail Order " + invoice_number,
		html: "<div></div>",
		// customClass: "swal-wide",
		width: 768,
		// timer: 2000,
		// timerProgressBar: true,
		showCloseButton: true,
		showConfirmButton: false,
		willOpen: () => {
			Swal.showLoading();
			$.ajax({
				type: "GET",
				url: site_url + "customer/profile/sales_detail/" + invoice_number,
				data: {},
				dataType: "html",
				success: function (response) {
					const content = Swal.getContent();
					if (content) {
						const b = content.querySelector("div");
						if (b) {
							b.innerHTML = response;
						}
					}
					Swal.hideLoading();
				},
				error: function (jqXhr, textStatus, errorThrown) {
					var error_message = "internal error";
					if (jqXhr.responseJSON !== undefined) {
						error_message = jqXhr["responseJSON"]["message"];
					}
					Swal.hideLoading();
				},
			});
		},
		willClose: () => {
			// clearInterval(timerInterval)
		},
	}).then((result) => {
		/* Read more about handling dismissals below */
		if (result.dismiss === Swal.DismissReason.timer) {
			console.log("I was closed by the timer");
		}
	});
}
var site_url = base_url();
