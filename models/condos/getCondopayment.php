<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paymentID'])){
    $paymentID = sanitize_input($_POST['paymentID']);
    $stmt = $pdo->prepare("SELECT * FROM condo_transactions WHERE id = :paymentID");
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->execute();
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    if($payment){
        echo json_encode(['success' => true, 'data' => $payment]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Payment not found']);
    }
}