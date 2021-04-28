<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<h3 class="card-title mt-2">Report Monthly</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<table id="reportMonthlyDataTable" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Year</th>
							<th>Month</th>
							<th>Quantity</th>
							<th>Retail Sales</th>
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
	var reportMonthlyDataTable = $('#reportMonthlyDataTable')
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
				'url': base_url() + "seller/reporting/sales_monthly_page",
				'beforeSend': function(xhr) {},
				'error': function(jqXhr, textStatus, errorThrown) {
					var error_message = 'internal error';
					if (jqXhr.responseJSON !== undefined) {
						error_message = jqXhr['responseJSON']['message'];
					}
					swal.fire('error', error_message, "error");
				}
			},
			dom: 'B<"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"tr><"row"<"col-lg-6 mt-2"i><"col-lg-6"p>>',
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
					"targets": [3, 4],
					"orderable": true
				},
				{
					"targets": 5,
					"visible": false
				}
			],
			'columns': [{
					defaultContent: ''
				},
				{
					data: 'year_name'
				},
				{
					data: 'month_name'
				},
				{
					data: 'quantity_total'
				},
				{
					data: 'retail_sales_total'
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
			buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
		});

	function refreshDTPage(reset = false) {
		if (!reset)
			$('#reportMonthlyDataTable').DataTable().ajax.reload();
		else
			$('#reportMonthlyDataTable').DataTable().ajax.reload(null, false);
	}
</script>
