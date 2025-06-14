<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Tenants';  

$stmt = $pdo->prepare("SELECT * FROM tenantproperty T JOIN units U ON T.unitID = U.unitID");
$stmt->execute();
$tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenantModal">Add Tenant</button>
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
										<th>First Name</th>
										<th>Last Name</th>
										<th>Property</th>
										<th>Unit</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Move In Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($tenants as $tenant) { ?>
									<tr>
										<td><?php echo $tenant['first_name']; ?></td>
										<td><?php echo $tenant['last_name']; ?></td>
										<td><?php echo $tenant['propName']; ?></td>
										<td><?php echo $tenant['unitname']; ?></td>
										<td><?php echo $tenant['email']; ?></td>
										<td><?php echo $tenant['phone']; ?></td>
                                        <td><?php echo $tenant['move_in_date']; ?></td>
                                        <td><span class="badge bg-<?php echo $tenant['status'] == 'Active' ? 'success' : 'danger'; ?>"><?php echo $tenant['status']; ?></span></td>
                                        <td>
											<a href="javascript:;" onclick="getTenant(<?php echo $tenant['tenantID']; ?>)" ><i class="bx bx-edit"></i>edit</a>  | 
											<a href="javascript:;" onclick="getTenantPayments(<?php echo $tenant['tenantID']; ?>)" ><i class="bx bx-show"></i>Payments</a>
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

        <form  method="post" action="" class="modal fade" id="addTenantModal" tabindex="-1" aria-labelledby="addTenantModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addTenantModalLabel">Add Tenant</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" >
                            </div>  
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" >
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
                                <label for="rentamount" class="form-label">Rent Amount</label>
                                <input type="number" class="form-control" id="rentamount" name="rentamount" readonly >
                            </div>
                            <div class="mb-3">
                                <label for="move_in_date" class="form-label">Move In Date</label>
                                <input type="date" class="form-control" id="move_in_date" name="move_in_date" >
                            </div>  
                            <input type="hidden" name="create" value="1">
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
							<input type="hidden" name="addTenant" id="addTenant" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						
                        <button type="submit" class="btn btn-primary">Add Tenant</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add Property Modal ===================-->

		<!--=================== Edit Property Modal ===================-->

		<form  method="post" class="modal fade" id="editTenantModal" tabindex="-1" aria-labelledby="editTenantModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editTenantModalLabel">Edit Tenant</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" >
                            </div>  
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" >
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
                                <label for="property" class="form-label">Property</label>
                                <select class="form-select select2" id="property" name="property" >
								<?php echo getProperties(); ?>
                                </select>
                            </div>
							<div class="mb-3" id="unit_container">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select select2" id="unit" name="unit" >
                                    
                                </select>
								<input type="hidden" name="oldunit" id="oldunit" value="" >
                            </div>
							<div class="mb-3">
                                <label for="rentamount" class="form-label">Rent Amount</label>
                                <input type="number" class="form-control" id="rentamount" name="rentamount" readonly >
								<input type="hidden" name="oldrentamount" id="oldrentamount" value="" >
                            </div>
                            <div class="mb-3">
                                <label for="move_in_date" class="form-label">Move In Date</label>
                                <input type="text" class="form-control" id="move_in_date" name="move_in_date" >
                            </div>  
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" >
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>  
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
								<input type="hidden" name="tenantId" id="tenantId" >	
								<input type="hidden" name="update" id="update" value="1">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Tenant</button>
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
    <script src="assets/scripts/tenants.js"></script>
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