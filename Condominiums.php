<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Condominiums';  

$stmt = $pdo->prepare("SELECT C.`condoID`, C.`cleintnames`,C.`email`,C.`phoneNo`,C.`sellAmount`,C.`totalpaid`,C.`startDate`,C.`datecreated`,P.`unitname`,P.`propName` FROM propertyunits P join condos C ON P.`unitID`=C.`unitID`");
$stmt->execute();
$condos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCondoModal">Add New Condo</button>
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
                                        <th>Property</th>
										<th>Unit</th>
										<th>Client Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Sell Amount</th>
										<th>Total Paid</th>
										<th>Balance</th>
										<th>Start Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($condos as $condo) { ?>
									<tr>
                                    <td><?php echo $condo['propName']; ?></td>
                                    <td><?php echo $condo['unitname']; ?></td>
										<td><?php echo $condo['cleintnames']; ?></td>
										<td><?php echo $condo['email']; ?></td>
										<td><?php echo $condo['phoneNo']; ?></td>
										<td class="text-end"><?php echo number_format($condo['sellAmount'], 2); ?></td>
										<td class="text-end"><?php echo number_format($condo['totalpaid'], 2); ?></td>
										<td class="text-end"><?php echo number_format($condo['sellAmount'] - $condo['totalpaid'], 2); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($condo['startDate'])); ?></td>
                                        <td>
											<a href="javascript:;" onclick="getCondo(<?php echo $condo['condoID']; ?>)" ><i class="bx bx-edit"></i>edit</a>  | 
											<a href="javascript:;" onclick="window.location.href='condominiums_payments.php?condo=<?php echo $condo['condoID']; ?>'" ><i class="bx bx-show"></i>Payments</a>
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

        <form  method="post" action="" class="modal fade" id="addCondoModal" tabindex="-1" aria-labelledby="addCondoModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addCondoModalLabel">Add Condo</h5>
					</div>  
                    <div class="modal-body">  
							<div class="mb-3">
                                <label for="property" class="form-label">Property</label>
                                <select class="form-select select2" id="property" name="property" >
										<?php echo getProperties(); ?>
                                </select>
                            </div>
							<div class="mb-3" id="unit_container">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select select2" id="unit" name="unit" >
                                    
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="clientnames" class="form-label">Client Names</label>
                                <input type="text" class="form-control" id="clientnames" name="clientnames" >
                            </div>  
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" >
                            </div>
                            <div class="mb-3">
                                <label for="sellamount" class="form-label">Sell Amount</label>
                                <input type="number" class="form-control" id="sellamount" name="sellamount" >
                            </div>
                            <div class="mb-3">
                                <label for="downpayment" class="form-label">Down Payment</label>
                                <input type="number" class="form-control" id="downpayment" name="downpayment" >
                            </div>
							<div class="mb-3">
                                <label for="startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startdate" name="startdate" >
                            </div>  
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" ></textarea>
                            </div>  
                            <input type="hidden" name="create" value="1">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
							<input type="hidden" name="addCondo" id="addCondo" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						
                        <button type="submit" class="btn btn-primary">Add Condo</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add condo Modal ===================-->

        <!--=================== Edit condo Modal ===================-->
        <form  method="post" action="" class="modal fade" id="editCondoModal" tabindex="-1" aria-labelledby="editCondoModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editCondoModalLabel">Edit Condo</h5>
					</div>  
                    <div class="modal-body">  
							<div class="mb-3">
                                <label for="property" class="form-label">Property</label>
                                <select class="form-select select2" id="property" name="property" >
										<?php echo getProperties(); ?>
                                </select>
                            </div>
							<div class="mb-3" id="unit_container">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select select2" id="unit" name="unit" >
                                    
                                </select>
                                <input type="hidden" name="oldunit" id="oldunit" >
                            </div>
                            <div class="mb-3">
                                <label for="clientnames" class="form-label">Client Names</label>
                                <input type="text" class="form-control" id="clientnames" name="clientnames" >
                            </div>  
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" >
                            </div>
                            <div class="mb-3">
                                <label for="sellamount" class="form-label">Sell Amount</label>
                                <input type="number" class="form-control" id="sellamount" name="sellamount" >
                            </div>
							<div class="mb-3">
                                <label for="startdate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startdate" name="startdate" >
                            </div>   
                            <input type="hidden" name="updateCondo" id="updateCondo" value="1">
                            <input type="hidden" name="condoID" id="condoID" value="">
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Edit condo Modal ===================-->





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
    <script src="assets/scripts/condominiums.js"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
	<script src="assets/plugins/validation/validation-script.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>