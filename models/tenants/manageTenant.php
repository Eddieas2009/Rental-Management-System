<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tenantById'])){

    try{
        $tenantId = sanitize_input($_POST['tenantById']);
        $stmt = $pdo->prepare("SELECT * FROM tenants WHERE tenantID = :tenantId");
        $stmt->execute(['tenantId' => $tenantId]);
        $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
        if($tenant){
            echo json_encode(['success' => true, 'tenant' => $tenant]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Tenant not found']);
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getUnits'])){
    $propertyId = sanitize_input($_POST['getUnits']);
    $stmt = $pdo->prepare("SELECT * FROM units WHERE propertyID = :propertyId AND unitstatus = 'available'");
    $stmt->execute(['propertyId' => $propertyId]);
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($units){
        echo json_encode(['success' => true, 'units' =>$units]);
    }else{
        echo json_encode(['success' => false, 'error' => 'No available units found']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getUnitsinUpdate'])){
   
    $propertyId = sanitize_input($_POST['getUnitsinUpdate']);
    $stmt = $pdo->prepare("SELECT * FROM units WHERE propertyID = :propertyId");
    $stmt->execute(['propertyId' => $propertyId]);
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($units){
        echo json_encode(['success' => true, 'units' =>$units]);
    }else{
        echo json_encode(['success' => false, 'error' => 'No available units found']);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getRentAmount'])){
    try{
        $unitId = sanitize_input($_POST['getRentAmount']);
        $stmt = $pdo->prepare("SELECT rentamount FROM units WHERE unitID = :unitId AND unitstatus = 'available'");
        $stmt->execute(['unitId' => $unitId]);
        $unit = $stmt->fetch(PDO::FETCH_ASSOC);
        if($unit){
            echo json_encode(['success' => true, 'rentamount' => $unit['rentamount']]);
        }else{
            echo json_encode(['success' => false, 'error' => 'No available units found']);
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

function updateUnitStatus($unitId, $status){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE units SET unitstatus = ? WHERE unitID = ?");
    $stmt->execute([$status, $unitId]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addTenant'])){

    try{
        $token = sanitize_input($_POST['csrf_token']);
        if(verify_csrf_token($token)){
            $propertyID = sanitize_input($_POST['property']);
            $first_name = sanitize_input($_POST['first_name']);
            $last_name = sanitize_input($_POST['last_name']);
            $email = sanitize_input($_POST['email']);
            $phone = sanitize_input($_POST['phone']);
            $move_in_date = sanitize_input($_POST['move_in_date']);
            $createdBy = $auth_user['userID'];
            $createdAt = date('Y-m-d h:m:s');
            $unitID = sanitize_input($_POST['unit']);

            $stmt = $pdo->prepare("INSERT INTO tenants (propertyID,first_name, last_name, email, phone, move_in_date, created_at, created_by,unitID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$propertyID, $first_name, $last_name, $email, $phone, $move_in_date, $createdAt, $createdBy, $unitID]);
            if($stmt->rowCount() > 0){
                updateUnitStatus($unitID, 'rented');
                echo json_encode(['success' => true, 'message' => 'Tenant added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error adding tenant']);
            }

        }

    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

    try{
        $token = sanitize_input($_POST['update_csrf_token']);
        if(verify_csrf_token($token)){
            $tenantId = sanitize_input($_POST['tenantId']);
            $propertyID = sanitize_input($_POST['property']);
            $first_name = sanitize_input($_POST['first_name']);
            $last_name = sanitize_input($_POST['last_name']);
            $email = sanitize_input($_POST['email']);
            $phone = sanitize_input($_POST['phone']);
            $move_in_date = sanitize_input($_POST['move_in_date']);
            $status = sanitize_input($_POST['status']);
            $updatedBy = $auth_user['userID'];
            $updatedAt = date('Y-m-d h:m:s');
            $unitID = sanitize_input($_POST['unit']);
            $oldunit = sanitize_input($_POST['oldunit']);

            $stmt = $pdo->prepare("UPDATE tenants SET propertyID = ?, first_name = ?, last_name = ?, email = ?, phone = ?, move_in_date = ?, status = ?, updated_at = ?, unitID = ? WHERE tenantID = ?");
            $stmt->execute([$propertyID, $first_name, $last_name, $email, $phone, $move_in_date, $status, $updatedAt, $unitID, $tenantId]);
            if($stmt->rowCount() > 0){
                if($status == 'Active'){
                    updateUnitStatus($unitID, 'rented');
                }else{
                    updateUnitStatus($unitID, 'available');
                }
                echo json_encode(['success' => true, 'message' => 'Tenant updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error updating tenant']);
            }
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}






?>