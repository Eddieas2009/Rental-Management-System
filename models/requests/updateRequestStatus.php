<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';



/* ========================== Get Property Unit By ID ========================== */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['GetPropertyUnitByID'])){

    try{

        $tenantID = sanitize_input($_POST['GetPropertyUnitByID']);
        $stmt = $pdo->prepare("SELECT P.`propertyID`,U.`unitID`,P.`propName`,U.`unitname` FROM tenantproperty P JOIN units U ON P.`unitID`=U.`unitID` WHERE P.`tenantID` = ?");
        $stmt->execute([$tenantID]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        if($property){
            echo json_encode(['success' => true, 'property' => $property]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Property not found']);
        }

    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Error fetching property details: ' . $e->getMessage()]);
    }

}

/* ========================== Add Request Details ========================== */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['created'])){

    try {
        $token = sanitize_input($_POST['csrf_token']);    

        if(verify_csrf_token($token)){

            $tenantName = sanitize_input($_POST['tenantNamelist']);
            $property = sanitize_input($_POST['propertyID']);
            $unitID = sanitize_input($_POST['unitID']);
            $maintenanceCatID = sanitize_input($_POST['maintenanceCatID']);
            $maintenanceSubCatID = sanitize_input($_POST['maintenanceSubCatID']);
            $priority = sanitize_input($_POST['priority']);
            $requestDetails = sanitize_input($_POST['requestDetails']);
            $userID = sanitize_input($auth_user['userID']);

            $stmt = $pdo->prepare("INSERT INTO `maintenance_requests`(property_id,  tenant_id,  unitID,  description, priority, userID, maintenanceCatID,  mainSubcatID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$property, $tenantName, $unitID, $requestDetails, $priority, $userID, $maintenanceCatID, $maintenanceSubCatID]);    

            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Request details added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Request details not added']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error adding request details: ' . $e->getMessage()]);
    }

}


/* ========================== Update Request Status ========================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){

    try {
            $token = sanitize_input($_POST['update_csrf_token']);

        if(verify_csrf_token($token)){

            $requestId = sanitize_input($_POST['requestId']);
            $status = sanitize_input($_POST['status']);
            $replynotice = sanitize_input($_POST['replynotice']);
            $userID = sanitize_input($auth_user['userID']);
            $updatedAt = date('Y-m-d h:m:s');

            $stmt = $pdo->prepare("UPDATE `maintenance_requests` SET `status` = ?, `replynotice` = ?,userID = ?,updated_at = ? WHERE `id` = ?");
            $stmt->execute([$status, $replynotice, $userID, $updatedAt, $requestId]);
                if($stmt->rowCount() > 0){
                    echo json_encode(['success' => true, 'message' => 'Request status updated successfully']);
                }else{
                    echo json_encode(['success' => false, 'message' => 'Request status not updated']);
                }

        }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating request status: ' . $e->getMessage()]);
    }

}

?>