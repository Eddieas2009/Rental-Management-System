<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestId'])){

    try {
        $requestId = sanitize_input($_POST['requestId']);

        $stmt = $pdo->prepare("SELECT * FROM `maintenance_requests` R JOIN ms_subcategory S ON R.`mainSubcatID`=S.`subcatID` WHERE R.`id` = ?");
        $stmt->execute([$requestId]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if($request){

            $stmt = $pdo->prepare("SELECT T.`first_name`,T.`last_name`,T.`propName`,U.`unitname` from `tenantproperty` T join units U ON T.`unitID`=U.`unitID` WHERE T.`tenantID`= ? ");
            $stmt->execute([$request['tenant_id']]);
            $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
            if($tenant){
                echo json_encode(['success' => true, 'request' => $request, 'tenant' => $tenant]);
            }else{
                echo json_encode(['success' => false, 'message' => 'Tenant not found']);
            }


        }else{
            echo json_encode(['success' => false, 'message' => 'Request not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error fetching request details: ' . $e->getMessage()]);
    }

}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maintenanceCatID'])){

    try {
        $maintenanceCatID = sanitize_input($_POST['maintenanceCatID']);

        $stmt = $pdo->prepare("SELECT * FROM `maint_subcategory` WHERE `catID` = ?");
        $stmt->execute([$maintenanceCatID]);
        $subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($subcategories){
            echo json_encode(['success' => true, 'sub' => $subcategories]);
        }else{
            echo json_encode(['success' => false, 'message' => 'No subcategories found']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Error fetching maintenance sub category: ' . $e->getMessage()]);
    }

}



?>