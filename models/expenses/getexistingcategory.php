<?php 
include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';

$catName = sanitize_input($_POST['catName']);

$stmt = $pdo->prepare("SELECT * FROM `expense_categories` WHERE `catname` = ?");
$stmt->execute([$catName]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if($category){
    echo json_encode(false);
}else{
    echo json_encode(true);
}