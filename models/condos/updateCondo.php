<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateCondo'])){
    $condoID = sanitize_input($_POST['condoID']);
    $propertyID = sanitize_input($_POST['property']);
    $unitID = sanitize_input($_POST['unit']);
    $clientnames = sanitize_input($_POST['clientnames']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $sellamount = sanitize_input($_POST['sellamount']);
    $startdate = sanitize_input($_POST['startdate']);
    $userID = $auth_user['userID'];
    $datecreated = date('Y-m-d');
    $token = $_POST['update_csrf_token'];
    if(verify_csrf_token($token)){
        $stmt = $pdo->prepare("UPDATE condos SET cleintnames=:cleintnames,  phoneNo=:phoneNo,  email=:email,  sellAmount=:sellAmount,  startDate=:startDate,  unitID=:unitID,  propertyID=:propertyID,  userID=:userID WHERE condoID = :condoID");
        $stmt->bindParam(':cleintnames', $clientnames);
        $stmt->bindParam(':phoneNo', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sellAmount', $sellamount);
        $stmt->bindParam(':startDate', $startdate);
        $stmt->bindParam(':unitID', $unitID);
        $stmt->bindParam(':propertyID', $propertyID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':condoID', $condoID);
        $result = $stmt->execute();
        if($result){

            if($unitID != $oldunitID){
                $stmt = $pdo->prepare("UPDATE units SET unitstatus = 'Available' WHERE unitID = :unitID");
                $stmt->bindParam(':unitID', $oldunitID);
                $result = $stmt->execute();
                if($result){
                    $stmt = $pdo->prepare("UPDATE units SET unitstatus = 'Sold' WHERE unitID = :unitID");
                    $stmt->bindParam(':unitID', $unitID);
                    $result = $stmt->execute();
                }
            }

            echo json_encode(['success' => true, 'message' => 'Condo updated successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to update condo']);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    }
}





?>