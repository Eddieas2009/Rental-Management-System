<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Pending Payments';  

$stmt = $pdo->prepare("SELECT T.`first_name`,T.`last_name`,T.`propName`,U.`unitname`,P.`amount`,R.`partial_pay`, P.`month`,P.`year` FROM tenantproperty T JOIN units U ON T.`unitID`=U.`unitID` 
JOIN `payments` P ON T.`tenantID`=P.tenant_id LEFT JOIN `total_partial_paid` R ON P.`id`=R.`paymentID` WHERE P.`status`='pending'");
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
										<th>Property</th>
										<th>Unit</th>
										<th>Month</th>
										<th>Amount</th>
										<th>Partial Payment</th>
										<th>Balance</th>
									</tr>
								</thead>
								<tbody>
                                    <?php 
                                    $grouped_tenants = [];
                                    $total = 0;
                                    
                                    // Group tenants by name, property and unit
                                    foreach ($tenants as $tenant) {
                                        $key = $tenant['first_name'] . ' ' . $tenant['last_name'] . '|' . 
                                               $tenant['propName'] . '|' . $tenant['unitname'];
                                        if (!isset($grouped_tenants[$key])) {
                                            $grouped_tenants[$key] = [
                                                'name' => $tenant['first_name'] . ' ' . $tenant['last_name'],
                                                'property' => $tenant['propName'],
                                                'unit' => $tenant['unitname'],
                                                'total_amount' => 0,
                                                'total_partial' => 0,
                                                'months' => []
                                            ];
                                        }
                                        $grouped_tenants[$key]['total_amount'] += $tenant['amount'];
                                        $grouped_tenants[$key]['total_partial'] += ($tenant['partial_pay'] ?? 0);
                                        $grouped_tenants[$key]['months'][] = [
                                            'month' => $tenant['month'],
                                            'year' => $tenant['year'],
                                            'amount' => $tenant['amount'],
                                            'partial_pay' => $tenant['partial_pay'] ?? 0
                                        ];
                                        $total += $tenant['amount'];
                                    }

                                    // Display grouped data
                                    foreach ($grouped_tenants as $group) {
                                        $first_row = true;
                                        foreach ($group['months'] as $month_data) {
                                    ?>
                                        <tr>
                                            <?php if ($first_row) { ?>
                                                <td rowspan="<?php echo count($group['months']); ?>"><?php echo $group['name']; ?></td>
                                                <td rowspan="<?php echo count($group['months']); ?>"><?php echo $group['property']; ?></td>
                                                <td rowspan="<?php echo count($group['months']); ?>"><?php echo $group['unit']; ?></td>
                                            <?php } ?>
                                            <td><?php echo date('F', mktime(0, 0, 0, $month_data['month'], 1)); ?> <?php echo $month_data['year']; ?></td>
                                            <td class="text-end"><?php echo number_format($month_data['amount'], 2); ?></td>
                                            <td class="text-end"><?php echo number_format($month_data['partial_pay'], 2); ?></td>
                                            <td class="text-end"><?php echo number_format($month_data['amount'] - $month_data['partial_pay'], 2); ?></td>
                                        </tr>
                                    <?php 
                                            $first_row = false;
                                        }
                                        // Add subtotal row for each group
                                    ?>
                                        <tr class="table-secondary">
                                            <td colspan="4" class="text-end"><strong>Subtotal</strong></td>
                                            <td class="text-end"><strong><?php echo number_format($group['total_amount'], 2); ?></strong></td>
                                            <td class="text-end"><strong><?php echo number_format($group['total_partial'], 2); ?></strong></td>
                                            <td class="text-end"><strong><?php echo number_format($group['total_amount'] - $group['total_partial'], 2); ?></strong></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Grand Total</strong></td>
                                            <td class="text-end"><strong><?php echo number_format($total, 2); ?></strong></td>
                                            <td class="text-end"><strong><?php echo number_format(array_sum(array_column($grouped_tenants, 'total_partial')), 2); ?></strong></td>
                                            <td class="text-end"><strong><?php echo number_format($total - array_sum(array_column($grouped_tenants, 'total_partial')), 2); ?></strong></td>
                                        </tr>
                                    </tfoot>
									
							</table>
						</div>
					</div>
				</div>
				
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
	<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
	<script src="assets/plugins/notifications/js/notifications.min.js"></script>
	<script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="assets/plugins/validation/jquery.validate.min.js"></script>
    <script src="assets/plugins/validation/additional-methods.min.js"></script>
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
                popupWin.document.write('<h4>Pending Payments Report</h4>');
                popupWin.document.write('</div>');
                popupWin.document.write('<html><head><title>Print Table</title></head><body>' + html + '</body></html>');
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