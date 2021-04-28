<form autocomplete="off" id="form-input-product">
	<div class="">
		<input hidden type="text" name="item_id" id="item_id" value="<?= encode($rowdata['item_id']) ?>">
		<div class="form-group">
			<label for="sku">SKU <code> (unique)</code></label>
			<input type="text" class="form-control form-control-border" name="sku" id="sku" placeholder="Input SKU" value="<?= $rowdata['sku'] ?>">
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control form-control-border border-width-2" name="name" id="name" placeholder="Product Name" value="<?= $rowdata['name'] ?>">
		</div>
		<div class="form-group">
			<label for="description">Description</label>
			<textarea name="description" id="description" rows="2" class="form-control form-control-border border-width-2" placeholder="Product Description"><?= $rowdata['description'] ?></textarea>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					<label for="price">Price</label>
					<input type="text" class="form-control form-control-border border-width-2 number-format" name="price" id="price" placeholder="Price" value="<?= number_format($rowdata['price'] ?: 0) ?>">
				</div>
				<div class="col-sm-6">
					<label for="discount">Discount</label>
					<input type="text" class="form-control form-control-border border-width-2 number-format" name="discount" id="discount" placeholder="enter amount ex: (10.000)" value="<?= number_format($rowdata['discount'] ?: 0) ?>">
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="f_category_code">Category</label>
			<select class="form-control select2bs4" style="width: 100%;" name="f_category_code" id="f_category_code">
				<option></option>
				<?php foreach ($list_category->result_array() as $row) { ?>
					<option <?= ($rowdata['f_category_code'] == $row['category_code']) ? 'selected' : '' ?> value="<?= $row['category_code'] ?>"><?= $row['category_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label for="f_sub_category_code">Sub Category</label>
			<select class="custom-select form-control-border" name="f_sub_category_code" id="f_sub_category_code">
			</select>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-sm-6">
					<label for="price">Stock</label>
					<input min="1" type="number" class="form-control form-control-border border-width-2" name="stock" id="stock" placeholder="Quantity Stock" value="<?= $rowdata['stock'] ?>">
				</div>
				<div class="col-sm-6">
					<label for="discount">Weight (gr)</label>
					<input type="text" class="form-control form-control-border border-width-2 number-format" name="weight" id="weight" placeholder="Product weight in gram" value="<?= number_format($rowdata['weight'] ?: 0) ?>">
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<button type="submit" class="btn btn-info">Save</button>
		<button type="button" class="btn btn-default float-right" onclick="closeAjaxModal()">Close</button>
	</div>
</form>
<script>
	$(document).ready(function() {
		get_sub_category('<?= $rowdata['f_category_code'] ?>');
		$('#f_category_code').select2({
			theme: 'bootstrap4',
			allowClear: true,
			placeholder: "Choose Category"
		})
		$('#f_category_code').change(function(e) {
			var selected = $(this).val();
			get_sub_category(selected);
		})
		$('#form-input-product').submit(function(e) {
			e.preventDefault();
			save_product(this);
		})
		$(".number-format").on('keyup', function() {
			var $this = $(this);
			var input = $this.val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt(input, 10) : 0;
			$this.val(function() {
				return (input === 0) ? "" : input.toLocaleString("en-US");
			});
		});

	})

	function get_sub_category(selected) {
		var default_val = '<?= $rowdata['f_sub_category_code'] ?>';
		var el = $('select[name="f_sub_category_code"]');
		el.prop("disabled", true);
		$.ajax({
			url: site_url + "seller/master/get_sub_category",
			data: {
				category_code: selected
			},
			type: "get"
		}).then(function(response) {
			el.empty()
				.select2({
					data: response.data,
					allowClear: true,
					placeholder: "Choose Sub Category",
					theme: "bootstrap4"
				})
				.val(default_val).trigger('change');
			el.prop("disabled", false);
		}).catch(function(response) {
			if (response.message) {
				swal.fire('error', response.message, "error");
			} else {
				swal.fire('error', 'gagal mengambil data', "error");
			}
			el.prop("disabled", false);
		})
	}

	function save_product(e) {
		$.ajax({
			url: site_url + "seller/master/save_product",
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
