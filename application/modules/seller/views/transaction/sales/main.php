<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<h3 class="card-title mt-2">Data Transaction</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="salesDataTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Invoice Number</th>
							<th>Customer</th>
							<th>Date</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Status</th>
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
	var salesDataTable = $('#salesDataTable')
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
				'url': base_url() + "seller/transaction/sales_page",
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
					"targets": 5,
					"orderable": true
				},
				{
					"render": function(data, type, row) {
						var status = '<span class="badge badge-info">Being prepared</span>';
						if(row['status'] == 0)
						status = '<span class="badge badge-warning">Waiting confirmation</span>';
						return status;
					},
					"targets": 6,
					"orderable": true
				},
				{
					"render": function(data, type, row) {
						var btn_process = '';
						if(row['status'] == 0)
						btn_process = `<a class="dropdown-item text-1" href="javascript:void(0)" onClick="confirm_transaction('${row['invoice_number']}')"><i class="fas fa-truck"></i> Process Order</a>`;
						return `<div class="btn-group flex-wrap">
												<button type="button" class="mb-1 mt-1 mr-1 btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
												<div class="dropdown-menu" role="menu">
													<a class="dropdown-item text-1" href="javascript:void(0)" onClick="view_sales_detail('${row['invoice_number']}')"><i class="fas fa-info-circle"></i> View Details</a>
													${btn_process}
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
					data: 'invoice_number'
				},
				{
					data: 'name'
				},
				{
					data: 'sales_date'
				},
				{
					data: 'quantity_total'
				},
				{
					data: 'retail_sales_total'
				},
				{
					data: 'status'
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
			$('#salesDataTable').DataTable().ajax.reload();
		else
			$('#salesDataTable').DataTable().ajax.reload(null, false);
	}

	function confirm_transaction(invoice_number) {
		Swal.fire({
			title: 'Confirm Transaction?',
			text: "Transaction will be processed",
			icon: 'warning',
			showCancelButton: true
		}).then(isConfirm => {
			if (isConfirm.value) {
				$.ajax({
					type: "POST",
					url: site_url + "seller/transaction/confirm_transaction",
					data: {
						invoice_number: invoice_number
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
