<?php
/* ========================== Check if user is logged in ========================== */

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();

}else{

	try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND acc_status = 'active'");
        $stmt->execute([$_SESSION['username']]);
        
        if ($stmt->rowCount() == 0) {
            // User no longer exists in database
			session_destroy();
			header("Location: index.php");
			exit();
		}else{
			$auth_user = $stmt->fetch(PDO::FETCH_ASSOC);
		}

	} catch(PDOException $e) {
        error_log("Error checking username: " . $e->getMessage());
        session_destroy();	
		header("Location: index.php");
		exit();
	}
}




?>