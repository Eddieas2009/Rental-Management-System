<?php
require_once 'settings/config.php';
require_once 'settings/checkloggedinuser.php';
/* require_once 'models/tenants/truckpendingpayments.php'; */



function getTotalTenants(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tenantproperty WHERE status = 'Active'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalProperties(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM properties");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalUnits(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM units");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalAvailableUnits(){
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM units WHERE unitstatus = 'available'");
    $stmt->execute();
    return $stmt->fetchColumn();
}


?>


<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor3">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/index3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:27:45 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo LOGO_URL; ?>" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<link href="assets/plugins/highcharts/css/highcharts.css" rel="stylesheet" />
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<title>Dashboard</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<?php include 'includes/sidemenu.php'; ?>
		<!--end sidebar wrapper -->
		<!--start header -->
		<?php include 'includes/header.php'; ?>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row row-cols-1 row-cols-lg-4">
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-cosmic">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Properties</p>
										<h5 class="mb-0 text-white"><?php echo getTotalProperties(); ?></h5>
									</div>
									<div class="ms-auto text-white"><i class='bx bx-buildings font-30'></i>
									</div>
								</div>
								<div class="progress bg-white-2 radius-10 mt-4" style="height:4.5px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 46%"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-burning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Units</p>
										<h5 class="mb-0 text-white"><?php echo getTotalUnits(); ?></h5>
									</div>
									<div class="ms-auto text-white"><i class='bx bx-wallet font-30'></i>
									</div>
								</div>
								<div class="progress bg-white-2 radius-10 mt-4" style="height:4.5px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 72%"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-Ohhappiness">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Total Tenants</p>
										<h5 class="mb-0 text-white"><?php echo getTotalTenants(); ?></h5>
									</div>
									<div class="ms-auto text-white"><i class='bx bx-group font-30'></i>
									</div>
								</div>
								<div class="progress bg-white-2 radius-10 mt-4" style="height:4.5px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 68%"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 overflow-hidden bg-gradient-moonlit">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-white">Available Units</p>
										<h5 class="mb-0 text-white"><?php echo getTotalAvailableUnits(); ?></h5>
									</div>
									<div class="ms-auto text-white"><i class='bx bx-chat font-30'></i>
									</div>
								</div>
								<div class="progress  bg-white-2 radius-10 mt-4" style="height:4.5px;">
									<div class="progress-bar bg-white" role="progressbar" style="width: 66%"></div>
								</div>
							</div>
						</div>
					</div>
				</div><!--end row-->
				
				<div class="card radius-10">
					<div class="card-header border-bottom-0 bg-transparent">
						<div class="d-lg-flex align-items-center">
							<div>
								<h6 class="font-weight-bold mb-2 mb-lg-0">Monthly Revenue</h6>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div id="chart1"></div>
					</div>
				</div>
				
				
				<!--end row-->
<!--end row-->
<div class="row">
					<div class="col-12 col-lg-8 d-lg-flex align-items-lg-stretch">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<div id="barChart1"></div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4 d-lg-flex align-items-lg-stretch">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<div id="chart4"></div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
				

			</div>
		</div>
		<!--end page wrapper -->
		<?php include 'includes/footer.php'; ?>
		
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
	<script src="assets/plugins/highcharts/js/highcharts.js"></script>
	<script src="assets/js/index3.js"></script>
	<script src="assets/js/index4.js"></script>
	<script>
		new PerfectScrollbar('.best-selling-products');
		new PerfectScrollbar('.recent-reviews');
		new PerfectScrollbar('.support-list');

	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
    <script src="assets/plugins/validation/validation-script.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/index3.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:27:51 GMT -->
</html>