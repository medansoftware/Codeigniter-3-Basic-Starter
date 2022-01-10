<!DOCTYPE html>
<html>
	<head>
	<?= $header ?>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				<!-- Logo -->
				<a href="<?= base_url('public/templates/AdminLTE/v2/') ?>index2.html" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>A</b>LT</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Admin</b>LTE</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<?= $navbar ?>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<?= $sidebar_left ?>
			<!-- Content Wrapper. Contains page content -->
			<?= $content ?>
			<!-- /.content-wrapper -->
			<?= $footer ?>
			<!-- Control Sidebar -->
			<?= $sidebar_right ?>
			<!-- /.control-sidebar -->
			<!-- Add the sidebar's background. This div must be placed
				immediately after the control sidebar -->
			<div class="control-sidebar-bg"></div>
		</div>
		<!-- ./wrapper -->
		<!-- jQuery 3 -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- FastClick -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>dist/js/adminlte.min.js"></script>
		<!-- Sparkline -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
		<!-- jvectormap  -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
		<!-- SlimScroll -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<!-- ChartJS -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>bower_components/chart.js/Chart.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>dist/js/pages/dashboard2.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="<?= base_url('public/templates/AdminLTE/v2/') ?>dist/js/demo.js"></script>
	</body>
</html>
