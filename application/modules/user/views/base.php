<!DOCTYPE html>
<html lang="en">
	<head>
		<?= $header ?>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<!-- Preloader -->
			<div class="preloader flex-column justify-content-center align-items-center">
				<img class="animation__shake" src="<?= base_url('public/templates/AdminLTE/v3/') ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
			</div>
			<!-- Navbar -->
			<?= $navbar ?>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
			<?= $sidebar_left ?>
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<?php if (isset($page_info) && is_array($page_info)) : ?>
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0"><?= $page_info['title'] ?></h1>
							</div>
							<!-- /.col -->
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-right">
									<?php foreach ($page_info['breadcrumb'] as $breadcrumb) : ?>
										<?php if ($breadcrumb == end($page_info['breadcrumb'])) : ?>
											<li class="breadcrumb-item active"><?= $breadcrumb['text'] ?></a></li>
											<?php else: ?>
											<li class="breadcrumb-item"><a href="<?= $breadcrumb['link'] ?>"><?= $breadcrumb['text'] ?></a></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ol>
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.container-fluid -->
				</div>
				<?php endif; ?>
				<!-- /.content-header -->
				<!-- Main content -->
				<?= $content ?>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
			<?= $footer ?>
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/jquery/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- ChartJS -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/chart.js/Chart.min.js"></script>
		<!-- Sparkline -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/sparklines/sparkline.js"></script>
		<!-- JQVMap -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/jqvmap/jquery.vmap.min.js"></script>
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/jquery-knob/jquery.knob.min.js"></script>
		<!-- daterangepicker -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/moment/moment.min.js"></script>
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/daterangepicker/daterangepicker.js"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
		<!-- Summernote -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/summernote/summernote-bs4.min.js"></script>
		<!-- overlayScrollbars -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
		<!-- AdminLTE App -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>dist/js/adminlte.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>dist/js/demo.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="<?= base_url('public/templates/AdminLTE/v3/') ?>dist/js/pages/dashboard.js"></script>
	</body>
</html>
