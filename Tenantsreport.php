<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Active Tenants Report';  

$stmt = $pdo->prepare("select T.first_name,  T.last_name,T.email,T.phone,T.propName,U.`unitname`,T.move_in_date from tenantproperty T JOIN units U on T.`unitID`=U.`unitID` WHERE T.`status`='Active'");
$stmt->execute();
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor3">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:07 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo LOGO_URL; ?>" type="image/png" />
	<link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="assets/css/dark-theme.css" />
	<link rel="stylesheet" href="assets/css/semi-dark.css" />
	<link rel="stylesheet" href="assets/css/header-colors.css" />
	<title><?php echo $page_title; ?></title>
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
				<!--breadcrumb-->
				<div class="page-breadcrumb d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3"><?php echo $page_title; ?></div>
					<!-- <div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Table</li>
							</ol>
						</nav>
					</div> -->
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary" onclick="printTable()" ><i class="bx bx-printer"></i> Print</button>
                            <!-- <button type="button" class="btn btn-primary" onclick="paymentsfilterTable()" ><i class="bx bx-filter"></i> Filter</button> -->
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<!-- <h6 class="mb-0 text-uppercase"></h6> -->
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Tenant</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Property</th>
										<th>Unit</th>
										<th>Move In Date</th>
									</tr>
								</thead>
								<tbody id="paymentsTable">
                                    <?php foreach ($tenants as $tenant) { ?>
									<tr>
										<td><?php echo $tenant['first_name']; ?> <?php echo $tenant['last_name']; ?></td>
										<td><?php echo $tenant['email']; ?></td>
										<td><?php echo $tenant['phone']; ?></td>
										<td><?php echo $tenant['propName']; ?></td>
										<td><?php echo $tenant['unitname']; ?></td>
										<td class="text-end"><?php echo date('j F, Y', strtotime($tenant['move_in_date'])); ?></td>
									</tr>
                                    <?php } ?>
									</tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-end">Total Active Tenants</td>
                                            <td class="text-end" id="total"><?php echo count($tenants); ?></td>
                                            <td colspan="4" class="text-end"></td>
                                        </tr>
                                    </tfoot>
									
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<!--end page wrapper -->
		<div id="filterModal" class="modal fade" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Filter Payments</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="filterForm">
							<div class="mb-3">
								<label for="month" class="form-label">Month</label>
								<select class="form-select" id="month" name="month">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <select class="form-select" id="year" name="year">
                                    <?php for ($i = 2020; $i <= date('Y'); $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                        
                        
		





		<?php include 'includes/footer.php'; ?>

		
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src="assets/plugins/notifications/js/notifications.min.js"></script>
	<script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="assets/plugins/validation/jquery.validate.min.js"></script>
    <script src="assets/plugins/validation/additional-methods.min.js"></script>
    <script src="assets/scripts/filter.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
          } );
          function printTable(){
                var table = document.getElementById('example');
                var html = table.outerHTML;
                var popupWin = window.open('', '_blank', 'width=1000px,height=600px');
                popupWin.document.open();
                popupWin.document.write('<style>');
                popupWin.document.write('body { font-family: Arial, sans-serif; }');
                popupWin.document.write('table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 14px; }');
                popupWin.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
                popupWin.document.write('th { background-color: #f2f2f2; }');
                popupWin.document.write('h2 { text-align: left; margin-bottom: 20px; }');
                popupWin.document.write('.company-info { text-align: left; margin-bottom: 5px; }');
                popupWin.document.write('td:last-child { text-align: right; }');
                popupWin.document.write('</style>');
                popupWin.document.write('<h2><?php echo COMPANY_NAME; ?></h2>');
                popupWin.document.write('<div class="company-info">');
                popupWin.document.write('<p><?php echo COMPANY_ADDRESS; ?></p>');
                popupWin.document.write('<p>Email: <?php echo COMPANY_EMAIL; ?></p>');
                popupWin.document.write('<p>Phone: <?php echo COMPANY_PHONE; ?></p>');
                popupWin.document.write('<h4>Active Tenants Report</h4>');
                popupWin.document.write('</div>');
                popupWin.document.write('<html><head><title>Print Table</title></head><body onload="window.print()">' + html + '</body></html>');
                popupWin.document.close();
            }

	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
	<script src="assets/plugins/validation/validation-script.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>