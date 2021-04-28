<form autocomplete="off" id="form-input-category">
	<div class="">
		<div class="form-group">
			<label for="category_code">Category Code</label>
			<div <?= $rowdata['f_category_code'] ? 'hidden' : '' ?>>
				<select class=" form-control select2bs4" style="width: 100%;" name="f_category_code" id="f_category_code">
					<option></option>
					<?php foreach ($list_category->result_array() as $row) { ?>
						<option <?= ($rowdata['f_category_code'] == $row['category_code']) ? 'selected' : '' ?> value="<?= $row['category_code'] ?>"><?= $row['category_name'] ?></option>
					<?php } ?>
				</select>
			</div>
			<input <?= $rowdata['f_category_code'] ? '' : 'hidden' ?> readonly type="text" class="form-control form-control-border border-width-2" placeholder="Automatic" value="<?= $rowdata['f_category_code'] ?>">
		</div>
		<div class="form-group">
			<label for="sku">Sub Category Code <code> Automatic </code></label>
			<input readonly type="text" class="form-control form-control-border" name="sub_category_code" id="sub_category_code" placeholder="Automatic" value="<?= $rowdata['sub_category_code'] ?>">
		</div>
		<div class="form-group">
			<label for="sku">Sub Category Name</label>
			<input type="text" class="form-control form-control-border" name="sub_category_name" id="sub_category_name" placeholder="Input Category name" value="<?= $rowdata['sub_category_name'] ?>">
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-info">Save</button>
		<button type="button" class="btn btn-default float-right" onclick="closeAjaxModal()">Close</button>
	</div>
</form>
<script>
	$(document).ready(function() {
		$('#f_category_code').select2({
			theme: 'bootstrap4',
			allowClear: true,
			placeholder: "Choose Category"
		})
		$('#form-input-category').submit(function(e) {
			e.preventDefault();
			save_sub_category(this);
		})
	})

	function save_sub_category(e) {
		$.ajax({
			url: site_url + "seller/master/save_sub_category",
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
