<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<h3 class="card-title mt-2">Data Master Category</h3>
				<div class="btn-group  float-sm-right">
					<button onclick="ajaxModal(site_url+'seller/master/category_input','Input Category')" type="button" class="btn btn-default"><i class="fa fa-plus-square"></i> Create</button>
				</div>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="categoryDataTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Category Code</th>
							<th>Category Name</th>
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
	var categoryDataTable = $('#categoryDataTable')
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
				'url': base_url() + "seller/master/category_page",
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
						return `<div class="btn-group flex-wrap">
												<button type="button" class="mb-1 mt-1 mr-1 btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
												<div class="dropdown-menu" role="menu">
													<a class="dropdown-item text-1" href="javascript:void(0)" onClick="ajaxModal('${site_url}seller/master/category_input/${encode(row['category_code'])}','Edit Category')"><i class="fas fa-edit"></i>Edit</a>
													<a class="dropdown-item text-1" href="javascript:void(0)" onClick="delete_category('${encode(row['category_code'])}')"><i class="fas fa-trash-alt"></i> Delete</a>
												</div>
											</div>`;
					},
					"targets": 3
				}
			],
			'columns': [{
					defaultContent: ''
				},
				{
					data: 'category_code'
				},
				{
					data: 'category_name'
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
			$('#categoryDataTable').DataTable().ajax.reload();
		else
			$('#categoryDataTable').DataTable().ajax.reload(null, false);
	}

	function delete_category(category_code) {
		Swal.fire({
			title: 'Delete Category?',
			text: "Category will be deleted",
			icon: 'warning',
			showCancelButton: true
		}).then(isConfirm => {
			if (isConfirm.value) {
				$.ajax({
					type: "POST",
					url: site_url + "seller/master/delete_category",
					data: {
						category_code: category_code
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
