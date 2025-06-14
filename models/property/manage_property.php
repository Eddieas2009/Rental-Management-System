<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])){

   try{
        $token = sanitize_input($_POST['csrf_token']);
        if(verify_csrf_token($token)){

            $propName = sanitize_input($_POST['propName']);
            $location = sanitize_input($_POST['location']);
            $type = sanitize_input($_POST['type']);
            $status = sanitize_input($_POST['status']);
            $description = sanitize_input($_POST['description']);
            $createdBy = $auth_user['userID'];
            $createdAt = date('Y-m-d h:m:s');

            
            $stmt = $pdo->prepare("INSERT INTO properties (propName, location, type, status, description,createdBy,created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$propName, $location, $type, $status, $description, $createdBy, $createdAt]);
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Property added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error adding property']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
   }catch(Exception $e){
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
   }
}

/* ========================== Get Property ========================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['propID'])){
    try{
            $propID = sanitize_input($_POST['propID']);
            $stmt = $pdo->prepare("SELECT * FROM properties WHERE propertyID = ?");
            $stmt->execute([$propID]);
            $property = $stmt->fetch(PDO::FETCH_ASSOC);
            if($property){
                echo json_encode(['success' => true, 'property' => $property]);
            }else{
                echo json_encode(['success' => false, 'message' => 'Property not found']);
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
            $propID = sanitize_input($_POST['propertyId']);
            $propName = sanitize_input($_POST['propName']);
            $location = sanitize_input($_POST['location']);
            $type = sanitize_input($_POST['type']);
            $status = sanitize_input($_POST['status']);
            $description = sanitize_input($_POST['description']);
            $updatedBy = $auth_user['userID'];
            $updatedAt = date('Y-m-d h:m:s');

            $stmt = $pdo->prepare("UPDATE properties SET propName = ?, location = ?, type = ?, status = ?, description = ?, updatedBy = ?, updated_at = ? WHERE propertyID = ?");
            $stmt->execute([$propName, $location, $type, $status, $description, $updatedBy, $updatedAt, $propID]);
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Property updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error updating property']);
            }

        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

?>