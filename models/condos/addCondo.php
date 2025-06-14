<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCondo'])){
    $propertyID = sanitize_input($_POST['property']);
    $unitID = sanitize_input($_POST['unit']);
    $clientnames = sanitize_input($_POST['clientnames']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $sellamount = sanitize_input($_POST['sellamount']);
    $downpayment = sanitize_input($_POST['downpayment']);
    $startdate = sanitize_input($_POST['startdate']);
    $description = sanitize_input($_POST['description']);
    $userID = $auth_user['userID'];
    $datecreated = date('Y-m-d');

    $token = $_POST['csrf_token'];
    if(verify_csrf_token($token)){
        $stmt = $pdo->prepare("INSERT INTO condos (cleintnames,  phoneNo,  email,   sellAmount,  totalpaid,  startDate,  datecreated,  unitID,  propertyID,  userID) VALUES (:clientnames, :phone, :email, :sellamount, :totalpaid, :startdate, :datecreated, :unitID, :propertyID, :userID)");
        $stmt->bindParam(':clientnames', $clientnames);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sellamount', $sellamount);
        $stmt->bindParam(':totalpaid', $downpayment);
        $stmt->bindParam(':startdate', $startdate);
        $stmt->bindParam(':datecreated', $datecreated);
        $stmt->bindParam(':unitID', $unitID);
        $stmt->bindParam(':propertyID', $propertyID);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $lastInsertId = $pdo->lastInsertId();
        if($lastInsertId){

            $stmt = $pdo->prepare("INSERT INTO `condo_transactions`(amount,  paymentDate,  description , condoID,  userID) VALUES (:amount, :paymentDate, :description, :condoID, :userID)");
            $stmt->bindParam(':amount', $downpayment);
            $stmt->bindParam(':paymentDate', $startdate);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':condoID', $lastInsertId);
            $stmt->bindParam(':userID', $userID);
            $result = $stmt->execute();
            if($result){
                $stmt = $pdo->prepare("UPDATE units SET unitstatus = 'Sold' WHERE unitID = :unitID");
                $stmt->bindParam(':unitID', $unitID);
               $res = $stmt->execute();

                if($res){
                    echo json_encode(['success' => true, 'message' => 'Condo added successfully']);
                }else{
                    echo json_encode(['success' => false, 'message' => 'Failed to add condo transaction']);
                }
            }
           
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to add condo']);
        }
    }
}
