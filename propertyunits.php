<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Property Units';  

$propertyID = isset($_GET['units']) ? (int)$_GET['units'] : 0;
$stmt = $pdo->prepare("SELECT * FROM units WHERE propertyID = :propertyID");
$stmt->execute(['propertyID' => $propertyID]);
$units = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("SELECT * FROM properties WHERE propertyID = :propertyID");
$stmt->execute(['propertyID' => $propertyID]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);


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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnitModal">Add Unit</button>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<h6 class="mb-0 text-uppercase">Property :  <?php echo $property['propName']; ?></h6>
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>unitName</th>
										<th>Bathrooms</th>
										<th>Bedrooms</th>
										<th>RentAmount (UGX)</th>
										<th>description</th>
										<th>status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($units as $unit) { ?>
									<tr>
										<td><?php echo $unit['unitname']; ?></td>
										<td><?php echo $unit['bathrooms']; ?></td>
										<td><?php echo $unit['bedrooms']; ?></td>
										<td class="text-end"><?php echo number_format($unit['rentamount'], 2); ?></td>
										<td><?php echo $unit['description']; ?></td>
										<td>
                                            <a href="javascript:;" class="badge bg-<?php echo $unit['unitstatus'] == 'available' ? 'success' : 'danger'; ?>" onclick="changeStatus(<?php echo $unit['unitID']; ?>, '<?php echo $unit['unitstatus']; ?>')" ><?php echo $unit['unitstatus']; ?></a>
                                        </td>
                                        <td><a href="javascript:;" onclick="getUnit(<?php echo $unit['unitID']; ?>)" ><i class="bx bx-edit"></i>edit</a> 
										
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

        <form  method="post" class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addUnitModalLabel">Add Unit</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="unitname" class="form-label">Unit name</label>
                                <input type="text" class="form-control" id="unitname" name="unitname" >
                            </div>  
                            <div class="mb-3">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <input type="text" class="form-control" id="bathrooms" name="bathrooms" >
                            </div>
                            <div class="mb-3">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <input type="text" class="form-control" id="bedrooms" name="bedrooms" >
                            </div>
                            <div class="mb-3">
                                <label for="rentamount" class="form-label">Rent Amount</label>
                                <input type="text" class="form-control" id="rentamount" name="rentamount" >
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" >
                            </div>
                            <div class="mb-3">
                                <label for="unitstatus" class="form-label">Status</label>
                                <select class="form-select" id="unitstatus" name="unitstatus" >
                                    <option value="">Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="rented">Rented</option>
                                </select>
                            </div> 
                            <input type="hidden" name="create" value="1">
                            <input type="hidden" name="propertyId" id="propertyId" value="<?php echo $property['propertyID']; ?>" >	
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
											
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Property</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add Property Modal ===================-->

		<!--=================== Edit Property Modal ===================-->

		<form  method="post" class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="unitname" class="form-label">Unit name</label>
                                <input type="text" class="form-control" id="unitname" name="unitname" >
                            </div>  
                            <div class="mb-3">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <input type="text" class="form-control" id="bathrooms" name="bathrooms" >
                            </div> 
                            <div class="mb-3">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <input type="text" class="form-control" id="bedrooms" name="bedrooms" >
                            </div>
                            <div class="mb-3">
                                <label for="rentamount" class="form-label">Rent Amount</label>
                                <input type="text" class="form-control" id="rentamount" name="rentamount" >
                            </div>  
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" >
                            </div> 
                            <div class="mb-3">
                                <label for="unitstatus" class="form-label">Status</label>
                                <select class="form-select" id="unitstatus" name="unitstatus" >
                                    <option value="">Select Status</option>
                                    <option value="available">Available</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="rented">Rented</option>
                                </select>
                            </div> 
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
								<input type="hidden" name="unitId" id="unitId" >	
								<input type="hidden" name="update" id="update" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Property</button>
                    </div>
                </div>
            </div>  
         </form>
        
		<!--=================== End Edit Property Modal ===================-->



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
    <script src="assets/scripts/propertyunits.js"></script>
	<script>
		
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script src="assets/plugins/validation/jquery.validate.min.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/table-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
</html>