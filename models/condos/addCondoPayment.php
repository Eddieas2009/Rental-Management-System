<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createCondoPayment'])){
    $condoID = sanitize_input($_POST['condoID']);
    $amount = sanitize_input($_POST['amount']);
    $date = sanitize_input($_POST['paymentDate']);
    $description = sanitize_input($_POST['description']);
    $userID = $auth_user['userID'];
    $datecreated = date('Y-m-d');
    $token = $_POST['csrf_token'];
    if(verify_csrf_token($token)){

        $stmt = $pdo->prepare("UPDATE condos SET totalpaid = totalpaid + :amount WHERE condoID = :condoID");
        $stmt->bindParam(':condoID', $condoID);
        $stmt->bindParam(':amount', $amount);
        $result = $stmt->execute();
        if($result){

            $stmt = $pdo->prepare("INSERT INTO condo_transactions (amount,  paymentDate,  description,  condoID,  userID) VALUES (:amount, :paymentDate, :description, :condoID, :userID)");
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':paymentDate', $date);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':condoID', $condoID);
            $stmt->bindParam(':userID', $userID);
            $result = $stmt->execute();
            if($result){
                echo json_encode(['success' => true, 'message' => 'Payment added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to add payment']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to update condo']);
        }
       
    }
}