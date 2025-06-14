<?php
include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['month']) && isset($_POST['year'])){
$month = sanitize_input($_POST['month']);
$year = sanitize_input($_POST['year']);

$stmt = $pdo->prepare("SELECT T.`first_name`,T.`last_name`,T.`propName`,U.`unitname`,P.`amount`,P.`partial_pay`, P.`month`,P.`year`,P.`status`,P.`payment_date` FROM tenantproperty T JOIN units U ON T.`unitID`=U.`unitID` JOIN `rent_collection` P ON T.`tenantID`=P.tenant_id WHERE P.`status`!='pending' AND MONTH(P.`payment_date`)=:month AND YEAR(P.`payment_date`)=:year");
$stmt->execute(['month' => $month, 'year' => $year]);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($payments){
    echo json_encode(['success' => true, 'payments' => $payments]);
}else{
    echo json_encode(['success' => false, 'message' => 'No payments found']);
}

}

?>