<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Expenses Report';  
if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])){
    $dateFrom = sanitize_input($_GET['dateFrom']);
    $dateTo = sanitize_input($_GET['dateTo']);
}else{
    $dateFrom = date('Y-m-d');
    $dateTo = date('Y-m-d');
}
$stmt = $pdo->prepare("SELECT E.*,C.`catname` FROM `expenses` E JOIN `expense_categories` C ON E.`category_id`=C.`id` WHERE E.`expense_date` BETWEEN ? AND ?");
$stmt->execute([$dateFrom, $dateTo]);
$expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
                            <button type="button" class="btn btn-primary" onclick="paymentsfilterTable()" ><i class="bx bx-filter"></i> Filter</button>
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
										<th>Category</th>
										<th>Description</th>
										<th>Date</th>
										<th>Payment Method</th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody id="paymentsTable">
                                    <?php 
                                    $total = 0;
                                    $grouped_expenses = [];
                                    $expenses_by_category = [];
                                    
                                    // Group expenses by category and calculate totals
                                    foreach ($expenses as $expense) {
                                        $catname = $expense['catname'];
                                        if (!isset($grouped_expenses[$catname])) {
                                            $grouped_expenses[$catname] = 0;
                                            $expenses_by_category[$catname] = [];
                                        }
                                        $grouped_expenses[$catname] += $expense['amount'];
                                        $expenses_by_category[$catname][] = $expense;
                                        $total += $expense['amount'];
                                    }

                                    // Display expenses grouped by category with subtotals
                                    foreach ($expenses_by_category as $catname => $category_expenses) {
                                        // Display category header
                                        echo '<tr class="table-secondary"><td style="text-align: left !important;" colspan="5"><strong>' . $catname . '</strong></td></tr>';

                                        
                                    
                                        
                                        // Display individual expenses for this category
                                        foreach ($category_expenses as $expense) {
                                    ?>
									<tr>
										<td><?php //echo $expense['catname']; ?></td>
										<td><?php echo $expense['description']; ?></td>
										<td><?php echo $expense['expense_date']; ?></td>
										<td><?php echo $expense['payment_method']; ?></td>
										<td class="text-end"><?php echo number_format($expense['amount'], 2); ?></td>
									</tr>
                                    <?php }// Add subtotal row for each category
                                    echo '<tr class="table-info"><td colspan="4" class="text-end"><strong>Subtotal</strong></td><td class="text-end"><strong>' . number_format($grouped_expenses[$catname], 2) . '</strong></td></tr>';

                                 }?>
									</tbody>
                                    <tfoot>
                                        <tr style="border-top: 2px double #000; font-weight: bold;">
                                            <td colspan="4" class="text-end">GRAND TOTAL</td>
                                            <td class="text-end" id="total"><?php echo number_format($total, 2); ?></td>
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
						<form id="filterForm" method="post">
							<div class="mb-3">
								<label for="dateFrom" class="form-label">Date From</label>
								<input type="date" class="form-control" id="dateFrom" name="dateFrom">
                            </div>
                            <div class="mb-3">
                                <label for="dateTo" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="dateTo" name="dateTo">
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
                popupWin.document.write('<h4>Monthly Payments Report</h4>');
                popupWin.document.write('</div>');
                popupWin.document.write('<html><head><title>Print Table</title></head><body>' + html + '</body></html>');
                popupWin.document.close();
            }

	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#filterForm').submit(function(e) {
				e.preventDefault();
				var dateFrom = $('#dateFrom').val();
				var dateTo = $('#dateTo').val();
                if(dateFrom == '' || dateTo == ''){
                    alert('Please select a date range');
                    return false;
                }
               window.location.href = 'Expensesreport.php?dateFrom=' + dateFrom + '&dateTo=' + dateTo;
				
            });
        });
    </script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>