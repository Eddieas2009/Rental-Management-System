<?php 
include 'settings/config.php'; 
include 'settings/checkloggedinuser.php';

$page_title = 'Users';  

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
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
										<th>Name</th>
										<th>Username</th>
										<th>Role</th>
										<th>Last Login</th>
										<th>Status</th>
										<th>Can View</th>
										<th>Can Edit</th>
										<th>Can Create</th>
										<th>Can Approve</th>
										<th>User ID</th>
									</tr>
								</thead>
								<tbody>
                                    <?php foreach ($users as $user) { ?>
									<tr>
										<td><?php echo $user['names']; ?></td>
										<td><?php echo $user['username']; ?></td>
										<td><?php echo $user['role']; ?></td>
										<td><?php echo $user['lastloginDate']; ?></td>
                                        <td>
											<a href="javascript:;" class="badge bg-<?php echo $user['acc_status'] == 'active' ? 'success' : 'danger'; ?>" onclick="changeStatus(<?php echo $user['userID']; ?>, '<?php echo $user['acc_status']; ?>')" ><?php echo $user['acc_status']; ?></a>
										</td>
                                        <td><?php echo $user['canview']; ?></td>
                                        <td><?php echo $user['canedit']; ?></td>
                                        <td><?php echo $user['cancreate']; ?></td>
                                        <td><?php echo $user['canaprove']; ?></td>
                                        <td><a href="javascript:;" onclick="GetUserDetails(<?php echo $user['userID']; ?>)" ><i class="bx bx-edit"></i>edit</a> | 
										<a href="javascript:;" onclick="ChangeUserPassword(<?php echo $user['userID']; ?>)" ><i class="bx bx-edit"></i>Change password</a></td>
									</tr>
                                    <?php } ?>
									
									
							</table>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<!--end page wrapper -->

        <!--=================== Add User Modal ===================-->

        <form  method="post" class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addUserModalLabel">Add User</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="names" class="form-label">Names</label>
                                <input type="text" class="form-control" id="names" name="names" required>
                            </div>  
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>  
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="tenant">Tenant</option>
                                </select>
                            </div>  
                            <div class="mb-3">
                                <input type="checkbox" class="form-check-input" id="canview" name="canview" value="1" >
                                <label for="canview" class="form-label">Can View</label>
                                <input type="checkbox" class="form-check-input" id="canedit" name="canedit" value="1" >
                                <label for="canedit" class="form-label">Can Edit</label>
                                <input type="checkbox" class="form-check-input" id="cancreate" name="cancreate" value="1" >
                                <label for="cancreate" class="form-label">Can Create</label>
                                <input type="checkbox" class="form-check-input" id="canaprove" name="canaprove" value="1" >
                                <label for="canaprove" class="form-label">Can Aprove</label>
                            </div>  
                            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
											
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </div>
            </div>  
         </form>
        <!--=================== End Add User Modal ===================-->

		<!--=================== Edit User Modal ===================-->

		<form  method="post" class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
					</div>  
                    <div class="modal-body">
                            <div class="mb-3">
                                <label for="names" class="form-label">Names</label>
                                <input type="text" class="form-control" id="names" name="names" required>
                            </div>  
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control disabled" id="username" readonly name="username" required>
                            </div> 
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                    <option value="tenant">Tenant</option>
                                </select>
                            </div>  
                            <div class="mb-3">
                                <input type="checkbox" class="form-check-input" id="canview" name="canview" value="1" >
                                <label for="canview" class="form-label">Can View</label>
                                <input type="checkbox" class="form-check-input" id="canedit" name="canedit" value="1" >
                                <label for="canedit" class="form-label">Can Edit</label>
                                <input type="checkbox" class="form-check-input" id="cancreate" name="cancreate" value="1" >
                                <label for="cancreate" class="form-label">Can Create</label>
                                <input type="checkbox" class="form-check-input" id="canaprove" name="canaprove" value="1" >
                                <label for="canaprove" class="form-label">Can Aprove</label>
                            </div>  
                            <input type="hidden" name="update_csrf_token" id="update_csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
								<input type="hidden" name="userId" id="userId" >	
								<input type="hidden" name="action" id="action" value="edit_user">
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </div>
            </div>  
         </form>
        
		<!--=================== End Edit User Modal ===================-->

		<!--=================== Change User Password Modal ===================-->

		<form  method="post" class="modal fade" id="ChangeUserPasswordModal" tabindex="-1" aria-labelledby="ChangeUserPasswordLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">	
						<h5 class="modal-title" id="ChangeUserPasswordLabel">Change User Password</h5>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label for="new_password" class="form-label">New Password</label>
							<input type="password" class="form-control" id="new_password" name="new_password" >
						</div>
						<div class="mb-3">
							<label for="confirm_password" class="form-label">Confirm Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" >
						</div>
						<input type="hidden" name="userId" id="userId" >	
						<input type="hidden" name="action" id="action" value="changepassword">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Change Password</button>
					</div>
				</div>
			</div>
		</form>
		<!--=================== End Change User Password Modal ===================-->



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
    <script src="assets/scripts/users.js"></script>
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