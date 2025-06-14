<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Tenant Service Requests';  





$stmt = $pdo->prepare("select id,subcatName,catName,created_at,priority,`status` from `maintenance_requests` R join ms_subcategory S on R.`mainSubcatID`=S.`subcatID` WHERE R.`status` != 'Resolved' AND R.`status` != 'Cancelled'");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


function GetTenantName(){
    global $pdo;
	$html='';
    $stmt = $pdo->prepare("SELECT tenantID,first_name,last_name FROM tenants where status = 'Active'");
	$stmt->execute();
    $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($tenants as $tenant){
        $html.='<option value="'.$tenant['tenantID'].'">'.$tenant['first_name'].' '.$tenant['last_name'].'</option>';
    }
    return $html;

}

function GetMaintenanceCategory(){
    global $pdo;
    $html='';
    $stmt = $pdo->prepare("SELECT catID,catName FROM maint_category");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($categories as $category){
        $html.='<option value="'.$category['catID'].'">'.$category['catName'].'</option>';
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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddRequestDetailsModal">Add Request</button>
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
                                        <th>Ticket No</th>
                                        <th>Service Category</th>
										<th>Service Request</th>
										<th>Created At</th>
										<th>Priority</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($categories as $category) { ?>
									<tr>
                                        <td><?php echo $category['id']; ?></td>
                                        <td><?php echo $category['catName']; ?></td>
										<td><?php echo $category['subcatName']; ?></td>
										<td><?php echo $category['created_at']; ?></td>
										<td><?php if($category['priority']=='Low') echo '<span class="badge bg-primary">Low</span>'; else if($category['priority']=='Medium') echo '<span class="badge bg-warning">Medium</span>'; else if($category['priority']=='High') echo '<span class="badge bg-danger">High</span>'; else  echo '<span class="badge bg-dark">Critical</span>'; ?></td>
										<td><?php if($category['status']=='Pending') echo '<span class="badge bg-primary">Pending</span>'; else if($category['status']=='In Progress') echo '<span class="badge bg-info">In Progress</span>'; else if($category['status']=='Resolved') echo '<span class="badge bg-success">Resolved</span>'; else  echo '<span class="badge bg-danger">Cancelled</span>'; ?></td>
										<td>
											<a href="javascript:;" onclick="getRequestDetails(<?php echo $category['id']; ?>)" ><i class="bx bx-show"></i>Details</a>
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

        <form  method="post" action="" class="modal fade" id="AddRequestDetailsModal" tabindex="-1" aria-labelledby="AddRequestDetailsModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AddRequestDetailsModalLabel">Request Details</h5>
					</div>  
                    <div class="modal-body">
                            <div class="row">
								<div class="col-md-6">

										<div class="mb-3">
											<label for="tenantNamelist" class="form-label">Tenant Name</label>
											<select class="form-select" id="tenantNamelist" name="tenantNamelist" >
												<option value="">Select Tenant</option>
												<?php echo GetTenantName(); ?>
											</select>
										</div>
										<div class="mb-3">
											<label for="property" class="form-label">Property</label>
											<input type="text" class="form-control" id="property" name="property" readonly >
											<input type="hidden" name="propertyID" id="propertyID" >
										</div>
										<div class="mb-3">
											<label for="unit" class="form-label">Unit</label>
											<input type="text" class="form-control" id="unit" name="unit" readonly >
											<input type="hidden" name="unitID" id="unitID" >
										</div>
										<div class="mb-3">
											<label for="maintenanceCatID" class="form-label">Service Category</label>
											<select class="form-select" id="maintenanceCatID" name="maintenanceCatID" >
												<option value="">Select Service Category</option>
												<?php echo GetMaintenanceCategory(); ?>
											</select>
										</div>
										<div class="mb-3">
											<label for="maintenanceSubCatID" class="form-label">Service Request</label>
											<select class="form-select" id="maintenanceSubCatID" name="maintenanceSubCatID" >
												
											</select>
										</div>
								</div>
							
									<div class="col-md-6">
										<div class="mb-3">
											<label for="priority" class="form-label">Priority</label>
											<select class="form-select" id="priority" name="priority" >
												<option value="">Select Priority</option>
												<option value="Low">Low</option>
												<option value="Medium">Medium</option>
												<option value="High">High</option>
											</select>
										</div>
										<div class="mb-3">
											<label for="requestDetails" class="form-label">Request Details</label>
											<textarea class="form-control" id="requestDetails" name="requestDetails" placeholder="Enter Request Details"></textarea>
										</div>
									</div>
								</div>

                            <input type="hidden" name="created" id="created" value="1">
							<input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Request</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add Property Modal ===================-->

		<!--=================== Edit Payment Modal ===================-->

		<form  method="post" class="modal fade" id="getRequestDetailsModal" tabindex="-1" aria-labelledby="getRequestDetailsModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="getRequestDetailsModalLabel">Request Details</h5>
					</div>  
                    <div class="modal-body">
                        <div class='row'>
                            <div class="col-md-6"><span class="ticketNo fs-5"></span></div>
                            <div class="col-md-6"><span class="dateCreated fs-5"></span></div>
                        </div>
                        <hr/>
                            <div class="row">
                                <div class="col-md-6">
                                	<div class="mb-3">
										<label for="tenantName" class="form-label">Tenant Name</label>
										<input type="text" class="form-control" id="tenantName" name="tenantName"  readonly>
                                    </div>
                                    <div class="mb-3">
										<label for="propName" class="form-label">Property Name</label>
										<input type="text" class="form-control" id="propName" name="propName"  readonly>
                                    </div>

                                    <div class="mb-3">
										<label for="unitName" class="form-label">Unit Name</label>
										<input type="text" class="form-control" id="unitName" name="unitName"  readonly>
                                    </div>


                                	<div class="mb-3">
										<label for="categoryName" class="form-label">Service Category</label>
										<input type="text" class="form-control" id="categoryName" name="categoryName"  readonly>
                                    </div>
                                    <div class="mb-3">
										<label for="subcatName" class="form-label">Service Request</label>
										<input type="text" class="form-control" id="subcatName" name="subcatName"  readonly>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                <?php if($auth_user['role'] != 'tenant'){ ?>
                                <div class="mb-3">
                                    <label for="staticEmail" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" >
                                        <option value="Pending">Pending</option>
                                        <option value="Queried">Queried</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <?php }else{ ?>
                                <input type="hidden" name="status" id="status" value="">
                                <?php } ?>
                                <div class="mb-3 row mt-5">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Priority</label>
                                    <div class="col-sm-10">
                                    <span  id="priority" ></span>  
                                </div></div>

                                <div class="mb-3 mt-2">
                                <label for="requestDetails" class="form-label">Request Details</label>
                                <textarea class="form-control" id="requestDetails" name="requestDetails" readonly></textarea>
                            </div>  

                            
                            <input type="hidden" name="requestId" id="requestId" >	
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

								<input type="hidden" name="update" id="update" value="1">
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="replynotice" class="form-label">Reply</label>
                                <textarea class="form-control" id="replynotice" name="replynotice"></textarea>
                            </div>


                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Request</button>
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
	<script src="assets/scripts/Requests.js"></script>
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