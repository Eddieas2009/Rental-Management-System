<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])){

   try{
        $token = sanitize_input($_POST['csrf_token']);
        if(verify_csrf_token($token)){

            $unitname = sanitize_input($_POST['unitname']);
            $bathrooms = sanitize_input($_POST['bathrooms']);
            $bedrooms = sanitize_input($_POST['bedrooms']);
            $rentamount = sanitize_input($_POST['rentamount']);
            $unitstatus = sanitize_input($_POST['unitstatus']);
            $description = sanitize_input($_POST['description']);
            $propertyID = sanitize_input($_POST['propertyId']);
            $createdBy = $auth_user['userID'];
            $createdAt = date('Y-m-d h:m:s');

            
            $stmt = $pdo->prepare("INSERT INTO units (unitname, bathrooms, bedrooms, rentamount, description, unitstatus, propertyID) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$unitname, $bathrooms, $bedrooms, $rentamount, $description, $unitstatus, $propertyID]);
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Unit added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error adding unit']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
   }catch(Exception $e){
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
   }
}

/* ========================== Get Property ========================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unitID'])){
    try{
            $unitID = sanitize_input($_POST['unitID']);
            $stmt = $pdo->prepare("SELECT * FROM units WHERE unitID = ?");
            $stmt->execute([$unitID]);
            $unit = $stmt->fetch(PDO::FETCH_ASSOC);
            if($unit){
                echo json_encode(['success' => true, 'unit' => $unit]);
            }else{
                echo json_encode(['success' => false, 'message' => 'Unit not found']);
            }

    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

/* ========================== Update Property ========================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){

    try{
        $token = sanitize_input($_POST['update_csrf_token']);
        if(verify_csrf_token($token)){
            $unitID = sanitize_input($_POST['unitId']);
            $unitname = sanitize_input($_POST['unitname']);
            $bathrooms = sanitize_input($_POST['bathrooms']);
            $bedrooms = sanitize_input($_POST['bedrooms']);
            $rentamount = sanitize_input($_POST['rentamount']);
            $unitstatus = sanitize_input($_POST['unitstatus']);
            $description = sanitize_input($_POST['description']);

            $stmt = $pdo->prepare("UPDATE units SET unitname = ?, bathrooms = ?, bedrooms = ?, rentamount = ?, description = ?, unitstatus = ? WHERE unitID = ?");
            $stmt->execute([$unitname, $bathrooms, $bedrooms, $rentamount, $description, $unitstatus, $unitID]);
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Unit updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error updating unit']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

?>