<?php
require_once 'settings/config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);
	
	$error='';
	$csrf_token = sanitize_input($_POST['csrf_token']);
	
	if (!verify_csrf_token($csrf_token)) {
		$error = "CSRF token validation failed";
	}
	
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
				if($row['role'] == 'tenant'){
					header("location: Requests.php");
				}else{
					header("location: Dashboard.php");
				}
                exit();
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Invalid username";
        }
    } catch(PDOException $e) {
        $error = "Connection failed: " . $e->getMessage();
    }
}


// Execute stored procedure to get due rent payments
$stmt = $pdo->prepare("CALL sp_get_due_rent_payments()");
$stmt->execute();

// Get the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the first statement before preparing a new one
$stmt->closeCursor();

// Insert results into payments table
if (!empty($results)) {
    $insertStmt = $pdo->prepare("INSERT INTO payments(tenant_id,property_id, amount, `month`, `year`, unitID) VALUES (:tenant_id, :property_id, :amount, :month, :year, :unitID)");
    
    foreach ($results as $row) {
        $insertStmt->bindParam(':tenant_id', $row['tenantID']);
        $insertStmt->bindParam(':property_id', $row['propertyID']);
        $insertStmt->bindParam(':amount', $row['rentamount']);
        $insertStmt->bindParam(':month', $row['MONTH']);
        $insertStmt->bindParam(':year', $row['YEAR']);
        $insertStmt->bindParam(':unitID', $row['unitID']);
        $insertStmt->execute();
    }
  
}



?>



<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:08 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo LOGO_URL; ?>" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Login</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="<?php echo LOGO_URL; ?>" width="100" alt="" />

						</div>
						<div class="card rounded-4">
							<div class="card-body">
								<div class="p-4 rounded">
									<div class="text-center">
										<h3 class="">Sign in</h3>
										
									</div>
									
										<hr/>
										<?php if (!empty($error)): ?>
											<div class="alert alert-danger"><?php echo $error; ?></div>
										<?php endif; ?>
									</div>
									<div class="form-body">
										<form class="row g-3" action="" method="post">
											<div class="col-12">
												<label for="username" class="form-label">Username</label>
												<input type="text" name="username" class="form-control" id="username" placeholder="Username">
											</div>
											<div class="col-12">
												<label for="password" class="form-label">Password</label>
												<div class="input-group" id="password">
													<input type="password" name="password" class="form-control border-end-0" id="password"  placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
												<input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
											</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													<br/>
													<button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Login</button>
													<br/>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#password a").on('click', function (event) {
				event.preventDefault();
				if ($('#password input').attr("type") == "text") {
					$('#password input').attr('type', 'password');
					$('#password i').addClass("bx-hide");
					$('#password i').removeClass("bx-show");
				} else if ($('#password input').attr("type") == "password") {
					$('#password input').attr('type', 'text');
					$('#password i').removeClass("bx-hide");
					$('#password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>


<!-- Mirrored from codervent.com/synadmin/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 01 Mar 2025 09:31:11 GMT -->
</html>