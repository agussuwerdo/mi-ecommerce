<form autocomplete="off" id="form-input-category">
	<div class="">
		<div class="form-group">
			<label for="category_code">Category Code <code> (automatic)</code></label>
			<input readonly type="text" class="form-control form-control-border border-width-2" name="category_code" id="category_code" placeholder="Automatic" value="<?= $rowdata['category_code'] ?>">
		</div>
		<div class="form-group">
			<label for="sku">Category name <code> (unique)</code></label>
			<input type="text" class="form-control form-control-border" name="category_name" id="category_name" placeholder="Input Category name" value="<?= $rowdata['category_name'] ?>">
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-info">Save</button>
		<button type="button" class="btn btn-default float-right" onclick="closeAjaxModal()">Close</button>
	</div>
</form>
<script>
	$(document).ready(function() {
		$('#form-input-category').submit(function(e) {
			e.preventDefault();
			save_category(this);
		})
	})

	function save_category(e) {
		$.ajax({
			url: site_url + "seller/master/save_category",
			data: $(e).serialize(),
			type: "post",
			success: function(res) {
				if (!res.status_code) {
					swal.fire('error', res.message || 'terjadi kesalahan', "error").then(() => {
						if (res.focus)
							$('#' + res.focus).focus();
					});
				} else {
					swal.fire('Sukses', res.message, "info").then(() => {
						closeAjaxModal();
						refreshDTPage();
					});
				}
			},
			error: function(res) {
				if (res.message) {
					swal.fire('error', res.message, "error");
				} else {
					// error internal
					swal.fire('error', 'gagal mengambil data', "error");
				}
			}
		})
	}
</script>
