<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['propertyID'])){
    $propertyID = sanitize_input($_POST['propertyID']);
    $html = '<option value="">Select Unit</option>';
    $stmt = $pdo->prepare("SELECT * FROM units WHERE propertyID = :propertyID AND unitstatus = 'Available'");
    $stmt->bindParam(':propertyID', $propertyID);
    $stmt->execute();
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($units){
        foreach($units as $unit){
            $html .= '<option value="'.$unit['unitID'].'">'.$unit['unitname'].'</option>';
        }
        echo $html;
    }else{
        echo '<option value="">No units found</option>';
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['triggeredpropertyID'])){
    $propertyID = sanitize_input($_POST['triggeredpropertyID']);
    $html = '<option value="">Select Unit</option>';
    $stmt = $pdo->prepare("SELECT * FROM units WHERE propertyID = :propertyID");
    $stmt->bindParam(':propertyID', $propertyID);
    $stmt->execute();
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($units){
        foreach($units as $unit){
            $html .= '<option value="'.$unit['unitID'].'">'.$unit['unitname'].'</option>';
        }
        echo $html;
    }else{
        echo '<option value="">No units found</option>';
    }
}



?>