<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Payments';  

$stmt = $pdo->prepare("SELECT * FROM tenantproperty T JOIN units U ON T.`unitID`=U.`unitID` WHERE T.`tenantID` = :tenantID");
$stmt->execute(['tenantID' => $_GET['id']]);
$tenants = $stmt->fetch(PDO::FETCH_ASSOC);



$tstmt = $pdo->prepare("SELECT P.*,R.`partial_pay` from payments P LEFT JOIN total_partial_paid R ON P.`id`=R.`paymentID` WHERE P.`tenant_id` =:tenantID");
$tstmt->execute(['tenantID' => $_GET['id']]);
$payments = $tstmt->fetchAll(PDO::FETCH_ASSOC);




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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">Add Payment</button>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Tenant: <?php echo $tenants['first_name']; ?> <?php echo $tenants['last_name']; ?>&nbsp; | &nbsp;Property: <?php echo $tenants['propName']; ?>&nbsp; | &nbsp;Unit : <?php echo $tenants['unitname']; ?></h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
                                        <th>Payment Date</th>
                                        <th>Month</th>
										<th>Year</th>
										<th>Amount</th>
										<th>Partial Payment</th>
										<th>Balance</th>
										<th>Payment Method</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($payments as $payment) { ?>
									<tr>
										<td><?php echo $payment['payment_date']; ?></td>
										<td><?php echo date('F', mktime(0, 0, 0, $payment['month'], 1)); ?></td>
										<td><?php echo $payment['year']; ?></td>
										<td class="text-end"><?php echo number_format($payment['amount']); ?></td>
										<td class="text-end"><?php echo number_format($payment['partial_pay']??0); ?></td>
										<td class="text-end"><?php echo number_format($payment['amount'] - $payment['partial_pay']??0); ?></td>
										<td><?php echo $payment['payment_method']; ?></td>
										<td><?php echo $payment['status']; ?></td>
                                        <td>
											<a href="javascript:;" onclick="viewpartialPayment(<?php echo $payment['id']; ?>)" ><i class="bx bx-show" style="hover:underline !important"></i>Partial Payment</a> | 
											<a href="javascript:;" onclick="getPaymentDetails(<?php echo $payment['id']; ?>)" ><i class="bx bx-edit"></i>edit</a>
											<?php if($payment['status'] == 'Pending'){ ?> |
												<a href="javascript:;" onclick="composeMail(<?php echo  $payment['id']; ?>, <?php echo  $_GET['id']; ?>)" ><i class="bx bx-envelope"></i> email</a>
											<?php } ?>
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

        <!--=================== Add Property Modal ===================-->

        <form  method="post" action="" class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Rent Amount</label>
                                <input type="text" class="form-control" readonly id="amount" name="amount" value="<?php echo $tenants['rentamount']; ?>" >
                            </div>  
                            <div class="mb-3">
                                <label for="month" class="form-label">Month</label>
                                <input type="text" class="form-control" id="month" name="month" >
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="text" class="form-control" id="year" name="year" >
                            </div>
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" >
                            </div>  
							<div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-select select2" id="payment_method" name="payment_method" >
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
							<div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select select2" id="status" name="status" >
                                    <option value="">Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>
                            <input type="hidden" name="create" value="1">
							<input type="hidden" name="tenant_id" value="<?php echo $tenants['tenantID']; ?>">
							<input type="hidden" name="property_id" value="<?php echo $tenants['propertyID']; ?>">
							<input type="hidden" name="unit_id" value="<?php echo $tenants['unitID']; ?>">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
							<input type="hidden" name="addPayment" id="addPayment" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Payment</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add Property Modal ===================-->

		<!--=================== Edit Payment Modal ===================-->

		<form  method="post" class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" >
                            </div>  
                            <div class="mb-3">
                                <label for="month" class="form-label">Month</label>
                                <input type="text" class="form-control" id="month" name="month" >
                            </div> 
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="text" class="form-control" id="year" name="year" >
                            </div>  
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" >
                            </div>  
							<div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-select select2" id="payment_method" name="payment_method" >
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>  
							
							<div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select select2" id="status" name="status" >
                                    <option value="">Select Status</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
									<option value="Late">Late</option>
                                </select>
                            </div>
                           
                            <input type="hidden" name="paymentId" id="paymentId" >	
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

								<input type="hidden" name="tenantId" id="tenantId" >
								<input type="hidden" name="update" id="update" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Payment</button>
                    </div>
                </div>
            </div>  
         </form>
        
		<!--=================== End Edit Property Modal ===================-->


		<!--=================== Compose Mail Modal ===================-->
		<form method="post" action="" class="modal fade" id="composeMailModal" tabindex="-1" aria-labelledby="composeMailModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="composeMailModalLabel">Compose Mail</h5>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="sendto" class="form-label">Send To</label>
							<input type="text" class="form-control" id="sendto" name="sendto" >
						</div>
						<div class="mb-3">
							<label for="subject" class="form-label">Subject</label>
							<input type="text" class="form-control" id="subject" name="subject" value="Rent Payment Reminder">
						</div>
						<div class="mb-3">
							<label for="message" class="form-label">Message</label>
							<textarea class="form-control" id="message" name="message" rows="5"></textarea>
						</div>
						<input type="hidden" name="paymentID" id="paymentID" >
						<input type="hidden" name="tenantID" id="tenantID" >
						<input type="hidden" name="compose_mail" id="compose_mail" value="1">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" id="sendMailButton" class="btn btn-primary">Send Mail</button>
					</div>
				</div>
			</div>
		</form>
		
<!--  ========================== View partial payment ========================== -->
<div method="post" action="" class="modal fade" id="viewpartialPaymentModal" tabindex="-1" aria-labelledby="viewpartialPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="viewpartialPaymentModalLabel">Partial Payment</h5>
					</div>
					<div class="modal-body">
						<button class="btn btn-primary mb-3" id="addPartialPayment">Add Partial Payment</button>
					<div class="table-responsive">
							<table id="example1" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
                                        <th>Date</th>
                                        <th>Partial Payment</th>
										<th>Mode</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="partialPaymentTable"></tbody>
								<tfoot>
									<tr>
										<td>Total</td>
										<td  class="text-end" id="totalPartialPayment"></td>
									</tr>
								</tfoot>
									
							</table>
						</div>
						
						<input type="hidden" name="paymentID" id="paymentID" >
						<input type="hidden" name="createPartialPayment" id="createPartialPayment" >
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>	
		<!--  ========================== End View partial payment ========================== -->

		<form method="post" action="" class="modal fade" id="editPartialPaymentModal" tabindex="-1" aria-labelledby="editPartialPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editPartialPaymentModalLabel">Edit Partial Payment</h5>
					</div>
					<div class="modal-body">
						<div class="row" style="margin: 0 5px">
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="date" class="col-sm-3 col-form-label">Date &nbsp; </label>
								<div class="col-sm-9">
								<input type="date" class="form-control" name="date" id="date" >
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="amount" class="col-sm-3 col-form-label">Amount &nbsp;</label>
								<div class="col-sm-9">
								<input type="number" class="form-control" name="amount" id="amount" >
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="paymentmethod" class="col-sm-3 col-form-label">Mode</label>
								<div class="col-sm-9">
								<select class="form-select select2" id="paymentmethod" name="paymentmethod" >
								<option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
								</div>
							</div>
						</div>
						
						</div>
						<input type="hidden" name="partial_ID" id="partial_ID" >
						<input type="hidden" name="editPartialPayment" id="editPartialPayment" value="1" >
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="closeEditPartialPaymentModal">Close</button>
						<button class="btn btn-primary">Update</button>
					</div>
				</div>
			</div>
		</form>	

		<!--  ========================== Add Partial Payment Modal =================== -->
		<form method="post" action="" class="modal fade" id="addPartialPaymentModal" tabindex="-1" aria-labelledby="addPartialPaymentModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addPartialPaymentModalLabel">Add Partial Payment</h5>
					</div>
					<div class="modal-body">
						<div class="row" style="margin: 0 5px">
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="date" class="col-sm-3 col-form-label">Date &nbsp; </label>
								<div class="col-sm-9">
								<input type="date" class="form-control" name="date" id="date" >
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="amount" class="col-sm-3 col-form-label">Amount &nbsp;</label>
								<div class="col-sm-9">
								<input type="number" class="form-control" name="amount" id="amount" >
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3 row">
								<label for="paymentmethod" class="col-sm-3 col-form-label">Mode</label>
								<div class="col-sm-9">
								<select class="form-select select2" id="paymentmethod" name="paymentmethod" >
								<option value="">Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
								</div>
							</div>
						</div>
						<input type="hidden" name="paymentID" id="paymentID" >
						<input type="hidden" name="createPartialPayment" id="createPartialPayment" value="1" >
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="CloseAddPartialPaymentModal">Close</button>
						<button class="btn btn-primary">Save</button>
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
    <script src="assets/scripts/payments.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
			$('#example1').DataTable();
		  } );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>