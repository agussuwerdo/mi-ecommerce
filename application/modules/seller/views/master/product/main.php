<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<h3 class="card-title mt-2">Data Master Product</h3>
				<div class="btn-group  float-sm-right">
					<button onclick="ajaxModal(site_url+'seller/master/product_input','Input product')" type="button" class="btn btn-default"><i class="fa fa-plus-square"></i> Create</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="productDataTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>SKU</th>
							<th>Name</th>
							<th>Category</th>
							<th>Sub Category</th>
							<th>Price</th>
							<th>Discount</th>
							<th>*</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /.col -->
</div>

<script>
	$(function() {
		// $("#example1").DataTable({
		// 	"responsive": true,
		// 	"lengthChange": false,
		// 	"autoWidth": false,
		// 	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		// }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		// $('#example2').DataTable({
		// 	"paging": true,
		// 	"lengthChange": false,
		// 	"searching": false,
		// 	"ordering": true,
		// 	"info": true,
		// 	"autoWidth": false,
		// 	"responsive": true,
		// });
	});

	var productDataTable = $('#productDataTable')
		.on('preXhr.dt', function(e, settings, data) {}).DataTable({
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			'processing': true,
			'serverSide': true,
			'responsive': true,
			'serverMethod': 'post',
			'ajax': {
				'async': true,
				'url': base_url() + "seller/master/product_page",
				'beforeSend': function(xhr) {},
				'error': function(jqXhr, textStatus, errorThrown) {
					var error_message = 'internal error';
					if (jqXhr.responseJSON !== undefined) {
						error_message = jqXhr['responseJSON']['message'];
					}
					swal.fire('error', error_message, "error");
				}
			},
			dom: '<"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"tr><"row"<"col-lg-6 mt-2"i><"col-lg-6"p>>',
			"columnDefs": [{
					render: function(data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					},
					"targets": 0,
					"orderable": false
				},
				{
					"render": function(data, type, row) {
						var res = number_format(data);
						return res;
					},
					className: 'text-right',
					"targets": [5, 6],
					"orderable": true
				},
				{
					"render": function(data, type, row) {
						return `<div class="btn-group flex-wrap">
												<button type="button" class="mb-1 mt-1 mr-1 btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
												<div class="dropdown-menu" role="menu">
													<a class="dropdown-item text-1" href="javascript:void(0)" onClick="ajaxModal('${site_url}seller/master/product_input/${encode(row['item_id'])}','Edit product')"><i class="fas fa-edit"></i>Edit</a>
													<a class="dropdown-item text-1" href="javascript:void(0)" onClick="delete_product('${encode(row['item_id'])}')"><i class="fas fa-trash-alt"></i> Delete</a>
												</div>
											</div>`;
					},
					"targets": 7
				}
			],
			'columns': [{
					defaultContent: ''
				},
				{
					data: 'sku'
				},
				{
					data: 'name'
				},
				{
					data: 'f_category_code'
				},
				{
					data: 'f_sub_category_code'
				},
				{
					data: 'price'
				},
				{
					data: 'discount'
				},
				{
					defaultContent: ''
				},
			],
			initComplete: function() {},
			drawCallback: function(settings) {},
			language: {
				searchPlaceholder: 'Search ...'
			},
			order: [
				[2, 'asc']
			],
			buttons: [{
				extend: 'copy'
			}, ],
		});

	function refreshDTPage(reset = false) {
		if (!reset)
			$('#productDataTable').DataTable().ajax.reload();
		else
			$('#productDataTable').DataTable().ajax.reload(null, false);
	}

	function delete_product(item_id) {
		Swal.fire({
			title: 'Delete Product?',
			text: "Product will be deleted",
			icon: 'warning',
			showCancelButton: true
		}).then(isConfirm => {
			if (isConfirm.value) {
				$.ajax({
					type: "POST",
					url: site_url + "seller/master/delete_product",
					data: {
						item_id: item_id
					},
					dataType: 'json',
					cache: false,
					success: function(response) {
						if (!response.status_code) {
							swal.fire(response['header'] || 'error', response['message'] || '', "error");
						} else {
							swal.fire(response['header'] || 'success', response['message'] || '', "success").then(() => {
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
				});
			}
		});

	}
</script>
