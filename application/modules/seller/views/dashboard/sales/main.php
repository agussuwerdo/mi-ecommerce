<div class="row">
	<div class="col-md-6">

		<!-- DONUT CHART -->
		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Top Product Categories</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col (LEFT) -->
	<div class="col-md-6">
		<!-- PIE CHART -->
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Top 10 Products</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->

	</div>
	<!-- /.col (RIGHT) -->
</div>
<!-- ChartJS -->
<script src="<?= base_url('assets/back/plugins/chart.js/Chart.min.js') ?>"></script>
<!-- /.row -->
<script>
	//-------------
	//- DONUT CHART -
	//-------------
	// Get context with jQuery - using jQuery's .get() method.
	var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
	var donutData = {
		labels: <?=json_encode($cart_by_category['labels'])?>,
		datasets: [{
			data: <?=json_encode($cart_by_category['data'])?>,
			backgroundColor: <?=json_encode($cart_by_category['color'])?>,
		}]
	}
	var donutOptions = {
		maintainAspectRatio: false,
		responsive: true,
	}
	//Create pie or douhnut chart
	// You can switch between pie and douhnut using the method below.
	new Chart(donutChartCanvas, {
		type: 'doughnut',
		data: donutData,
		options: donutOptions
	})


	var pieData = {
		labels: <?=json_encode($cart_by_product['labels'])?>,
		datasets: [{
			data: <?=json_encode($cart_by_product['data'])?>,
			backgroundColor: <?=json_encode($cart_by_product['color'])?>,
		}]
	}
	//-------------
	//- PIE CHART -
	//-------------
	// Get context with jQuery - using jQuery's .get() method.
	var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
	var pieOptions = {
		maintainAspectRatio: false,
		responsive: true,
	}
	//Create pie or douhnut chart
	// You can switch between pie and douhnut using the method below.
	new Chart(pieChartCanvas, {
		type: 'pie',
		data: pieData,
		options: pieOptions
	})
</script>
