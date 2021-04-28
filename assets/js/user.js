$(document).ready(function () {
	$("#form-login-customer").submit(function (e) {
		e.preventDefault();
        if ($(this).valid())
			act_login_customer(this);
	});
	$("#form-login-forgot").submit(function (e) {
		e.preventDefault();
        if ($(this).valid())
		act_forgot_customer();
	});
	$("#form-login-register-user").submit(function (e) {
		e.preventDefault();
        if ($(this).valid())
		act_register_customer(this);
	});
	$("#form-profile-update-password").submit(function (e) {
		e.preventDefault();
        if ($(this).valid()) {
			profile_update_password(this);
		}
	});
	$("#form-profile-update-user").submit(function (e) {
		e.preventDefault();
        if ($(this).valid()) {
			profile_update_user(this);
		}
	});
});

function act_login_customer(form) {
	$.ajax({
		url: site_url + "customer/login/authorize",
		type: "post",
		data: $(form).serialize(),
	})
		.then(function (res) {
			if (!res.status_code) {
				swal
					.fire("error", res.message || "terjadi kesalahan", "error")
					.then(() => {
						if (res.focus) $("#" + res.focus).focus();
					});
			} else {
				swal
					.fire("success", res.message || "Login sukses", "success")
					.then(() => {
						window.location = site_url;
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

function act_forgot_customer() {
	swal
		.fire("success", "Please check your email to proceed", "info")
		.then(function () {
			window.location.reload();
		});
}

function act_register_customer(form) {
	$.ajax({
		url: site_url + "customer/login/register",
		type: "post",
		data: $(form).serialize(),
	})
		.then(function (res) {
			if (!res.status_code) {
				swal
					.fire("error", res.message || "terjadi kesalahan", "error")
					.then(() => {
						if (res.focus) $("#" + res.focus).focus();
					});
			} else {
				Swal.fire("info", res.message , "info").then(() => {
					window.location = site_url + "login";
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

function profile_update_password(form) {
	$.ajax({
		url: site_url + "customer/profile/update_password",
		type: "post",
		data: $(form).serialize(),
	})
		.then(function (res) {
			if (!res.status_code) {
				swal
					.fire("error", res.message || "terjadi kesalahan", "error")
					.then(() => {
						if (res.focus) $("#" + res.focus).focus();
					});
			} else {
				Swal.fire("info", res.message || "Success", "info").then(() => {
					$('#old_password').val('');
					$('#new_password').val('');
					$('#new_password_confirm').val('');
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

function profile_update_user(form) {
	$.ajax({
		url: site_url + "customer/profile/update_user",
		type: "post",
		data: $(form).serialize(),
	})
		.then(function (res) {
			if (!res.status_code) {
				swal
					.fire("error", res.message || "terjadi kesalahan", "error")
					.then(() => {
						if (res.focus) $("#" + res.focus).focus();
					});
			} else {
				Swal.fire("info", res.message || "Success", "info");
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
