<?php
include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


/* Add Expense */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addExpense'])){

    try {
        $token = sanitize_input($_POST['csrf_token']);

        if(verify_csrf_token($token)){
            $catName = sanitize_input($_POST['catName']);
            $amount = sanitize_input($_POST['amount']);
            $description = sanitize_input($_POST['description']);
            $expenseDate = sanitize_input($_POST['expense_date']);
            $paymentMethod = sanitize_input($_POST['payment_method']);
            $createdBy = $auth_user['userID'];
            $createdAt = date('Y-m-d h:m:s');

            $stmt = $pdo->prepare("INSERT INTO expenses (category_id, amount, `description`, expense_date, payment_method, created_by, datecreated) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$catName, $amount, $description, $expenseDate, $paymentMethod, $createdBy, $createdAt]);

            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Expense added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to add expense']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            exit;
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

}

/* Get Expense Details */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getAction'])){
    $expenseID = sanitize_input($_POST['expenseID']);

    $stmt = $pdo->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->execute([$expenseID]);
    $expense = $stmt->fetch(PDO::FETCH_ASSOC);

    if($expense){
        echo json_encode(['success' => true, 'expense' => $expense]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Expense not found']);
    }
}




/* Update Expense */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

    try {
        $token = sanitize_input($_POST['update_csrf_token']);

        if(verify_csrf_token($token)){

            $expenseID = sanitize_input($_POST['expenseID']);
            $catName = sanitize_input($_POST['catName']);
            $amount = sanitize_input($_POST['amount']);
            $description = sanitize_input($_POST['description']);
            $expenseDate = sanitize_input($_POST['expense_date']);
            $paymentMethod = sanitize_input($_POST['payment_method']);
            $updatedBy = $auth_user['userID'];
            $updatedAt = date('Y-m-d h:m:s');

            $stmt = $pdo->prepare("UPDATE expenses SET category_id = ?, amount = ?, `description`=?, expense_date = ?, payment_method = ?, updated_by= ?, date_updated = ? WHERE id = ?");
            $stmt->execute([$catName, $amount, $description, $expenseDate, $paymentMethod, $updatedBy, $updatedAt, $expenseID]);
                        

            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Expense updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to update expense']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            exit;
        }




        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }







}

?>
