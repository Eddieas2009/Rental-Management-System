<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Condominiums Payments';  

$condoID = $_GET['condo'];

$stmt = $pdo->prepare("SELECT C.`condoID`, C.`cleintnames`,C.`email`,C.`phoneNo`,C.`sellAmount`,C.`totalpaid`,C.`startDate`,C.`datecreated`,P.`unitname`,P.`propName` FROM propertyunits P join condos C ON P.`unitID`=C.`unitID` WHERE C.`condoID` = :condoID");
$stmt->bindParam(':condoID', $condoID);
$stmt->execute();
$condos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM condo_transactions WHERE condoID = :condoID");
$stmt->bindParam(':condoID', $condoID);
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);


function getProperties(){
	global $pdo;
    $pstmt = $pdo->prepare("SELECT * FROM properties WHERE status = 'Available' ORDER BY propName ASC");
    $pstmt->execute();
    $properties = $pstmt->fetchAll(PDO::FETCH_ASSOC);
    $html = '<option value="">Select Property</option>';
	foreach ($properties as $property) { 
		$html .= '<option value="'.$property['propertyID'].'">'.$property['propName'].'</option>';
	} 
	return $html;
}

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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCondoPaymentModal">Add Payment</button>
                            <a href="javascript:;" onclick="printStatement(<?php echo $condoID; ?>)" class="btn btn-primary">Print Statement</a>
						</div>
					</div>
				</div>
                <hr/>
				<!-- end breadcrumb-->
				<h6 class="mb-0 text-uppercase">
                    <?php echo $condos[0]['cleintnames']; ?> - <?php echo $condos[0]['propName']; ?> - <?php echo $condos[0]['unitname']; ?> - TOTAL PAID: <?php echo number_format($condos[0]['totalpaid'], 2); ?>
                </h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
                                        <th>Date</th>
										<th>Amount</th>
										<th>Description</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($payments as $payment) { ?>
									<tr>
                                    <td><?php echo date('d-M-Y', strtotime($payment['datecreated'])); ?></td>
                                    <td class="text-end"><?php echo number_format($payment['amount'], 2); ?></td>
										<td><?php echo $payment['description']; ?></td>
                                        <td>
											<a href="javascript:;" onclick="getCondopayment(<?php echo $payment['id']; ?>)" ><i class="bx bx-edit"></i>edit</a>
										</td>
									</tr>
                                    <?php } ?>
									
									
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<!--end page wrapper -->

        <!--=================== Add Condo Modal ===================-->

        <form  method="post" action="" class="modal fade" id="addCondoPaymentModal" tabindex="-1" aria-labelledby="addCondoPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addCondoPaymentModalLabel">Add Payment</h5>
					</div>  
                    <div class="modal-body">  
							<div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" >
                            </div>
                            <div class="mb-3">
                                <label for="paymentDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="paymentDate" name="paymentDate" >
                            </div> 
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" ></textarea>
                            </div>  
                            <input type="hidden" name="condoID" id="condoID" value="<?php echo $condoID; ?>">
                            <input type="hidden" name="createCondoPayment" id="createCondoPayment" value="1">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add condo Modal ===================-->

        <!--=================== Edit condo Modal ===================-->

        <form  method="post" action="" class="modal fade" id="editCondoPaymentModal" tabindex="-1" aria-labelledby="editCondoPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editCondoPaymentModalLabel">Edit Payment</h5>
					</div>  
                    <div class="modal-body">  
							<div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" >
                                <input type="hidden" name="oldAmount" id="oldAmount" >
                            </div>
                            <div class="mb-3">
                                <label for="paymentDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="paymentDate" name="paymentDate" >
                            </div> 
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" ></textarea>
                            </div>  
                            <input type="hidden" name="paymentID" id="paymentID" >
                            <input type="hidden" name="condoID" id="condoID" value="<?php echo $condoID; ?>">
                            <input type="hidden" name="editCondoPayment" id="editCondoPayment" value="1">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </div>
            </div>  
         </form>




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
    <script src="assets/scripts/condominiums_payments.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );



function printStatement(condoID){
    var table = document.getElementById('example');
                // Clone the table and remove the action column
                var clonedTable = table.cloneNode(true);
                var actionColumn = clonedTable.querySelector('th:last-child');
                if (actionColumn) {
                    actionColumn.parentNode.removeChild(actionColumn);
                }
                var actionCells = clonedTable.querySelectorAll('td:last-child');
                actionCells.forEach(function(cell) {
                    cell.parentNode.removeChild(cell);
                });

                var html = clonedTable.outerHTML;
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
                popupWin.document.write('td:nth-child(2) { text-align: right; }'); // Align amount column right
                popupWin.document.write('td:nth-child(3) { text-align: left; }'); // Align amount column right
                popupWin.document.write('</style>');
                popupWin.document.write('<h2><?php echo COMPANY_NAME; ?></h2>');
                popupWin.document.write('<div class="company-info">');
                popupWin.document.write('<p><?php echo COMPANY_ADDRESS; ?></p>');
                popupWin.document.write('<p>Email: <?php echo COMPANY_EMAIL; ?></p>');
                popupWin.document.write('<p>Phone: <?php echo COMPANY_PHONE; ?></p>');
                popupWin.document.write('<h4>Condominium Payments Statement</h4>');
                popupWin.document.write('<?php echo $condos[0]['cleintnames']; ?> - <?php echo $condos[0]['propName']; ?> - <?php echo $condos[0]['unitname']; ?>- Actual Amount: <?php echo number_format($condos[0]['sellAmount'], 2); ?> - TOTAL PAID: <?php echo number_format($condos[0]['totalpaid'], 2); ?>');
                popupWin.document.write('</div>');
                popupWin.document.write('<html><head><title>Print Statement</title></head><body onload="window.print()">' + html + '</body></html>');
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