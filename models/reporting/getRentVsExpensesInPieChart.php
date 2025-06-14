<?php

include '../../settings/config.php';

$stmt = $pdo->prepare("SELECT sum(ifNULL(partial_pay,amount))totalamount from `rent_collection` where `year`=year(payment_date)");
$stmt->execute();
$totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT sum(amount)totalamount from `expenses` where YEAR(expense_date)=YEAR(curdate())");
$stmt->execute();
$totalExpenses = $stmt->fetch(PDO::FETCH_ASSOC); 

$totalRevenue = $totalRevenue['totalamount'];
$totalExpenses = $totalExpenses['totalamount'];
$data = [
    ['name' => 'Rent', 'y' => (float)$totalRevenue],
    ['name' => 'Expenses', 'y' => (float)$totalExpenses]
];


echo json_encode($data);