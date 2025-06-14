<?php
require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['condoID'])){
    $condoID = sanitize_input($_POST['condoID']);
    $stmt = $pdo->prepare("SELECT * FROM condos WHERE condoID = :condoID");
    $stmt->bindParam(':condoID', $condoID);
    $stmt->execute();
    $condo = $stmt->fetch(PDO::FETCH_ASSOC);
    if($condo){
        echo json_encode(['success' => true, 'data' => $condo]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Condo not found']);
    }
}

