<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editCondoPayment'])){
    $paymentID = sanitize_input($_POST['paymentID']);
    $condoID = sanitize_input($_POST['condoID']);
    $amount = sanitize_input($_POST['amount']);
    $oldAmount = sanitize_input($_POST['oldAmount']);
    $date = sanitize_input($_POST['paymentDate']);
    $description = sanitize_input($_POST['description']);
    $userID = $auth_user['userID'];
    $token = $_POST['csrf_token'];

    if(verify_csrf_token($token)){


        $stmt = $pdo->prepare("UPDATE condos SET totalpaid = totalpaid - :oldAmount + :amount WHERE condoID = :condoID");
        $stmt->bindParam(':oldAmount', $oldAmount);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':condoID', $condoID);
        $result = $stmt->execute();
        if($result){
       
            $stmt = $pdo->prepare("UPDATE condo_transactions SET amount = :amount, paymentDate = :paymentDate, description = :description, userID = :userID WHERE id = :paymentID");
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':paymentDate', $date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':paymentID', $paymentID);
            $result = $stmt->execute();
            if($result){
                echo json_encode(['success' => true, 'message' => 'Payment updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to update payment']);
            }
            
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to update condo']);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
}
