<?php

include '../../settings/config.php';

$revenueData = [];
$monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$stmt = $pdo->prepare("SELECT  CASE MONTH(payment_date)
    WHEN 1 THEN 'Jan'
    WHEN 2 THEN 'Feb'
    WHEN 3 THEN 'Mar'
    WHEN 4 THEN 'Apr'
    WHEN 5 THEN 'May'
    WHEN 6 THEN 'Jun'
    WHEN 7 THEN 'Jul'
    WHEN 8 THEN 'Aug'
    WHEN 9 THEN 'Sep'
    WHEN 10 THEN 'Oct'
    WHEN 11 THEN 'Nov'
    WHEN 12 THEN 'Dec'
    ELSE 'Invalid Month'
END AS month_name, sum(ifNULL(partial_pay,amount))totalamount from `rent_collection` where `year`=year(payment_date) GROUP BY month_name");
$stmt->execute();
$totalRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize revenue data array with zeros
$revenueData = array_fill(0, 12, 0);

// Map the revenue data to the correct months
foreach ($totalRevenue as $revenue) {
    $monthIndex = array_search($revenue['month_name'], $monthNames);
    if ($monthIndex !== false) {
        $revenueData[$monthIndex] = (float)$revenue['totalamount'];
    }
}


echo json_encode($revenueData);