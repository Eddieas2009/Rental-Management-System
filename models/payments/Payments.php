<?php

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

function checkpaidMonth($tenantID, $month, $year){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE tenant_id = :tenantID AND month = :month AND year = :year");
    $stmt->bindParam(':tenantID', $tenantID);
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        return true;
    }else{
        return false;
    }
}

/*  ========================== Get payment details ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['get_payment_details'])){
    $paymentID = sanitize_input($_POST['paymentID']);
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE id = :paymentID");
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo json_encode(['success' => true, 'data' => $result]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Payment not found']);
    }
}



/*  ========================== Add Payment ========================== */


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])){

    $token = sanitize_input($_POST['csrf_token']);

    if(verify_csrf_token($token)){
        
        $amount = sanitize_input($_POST['amount']);
        $month = sanitize_input($_POST['month']);
        $year = sanitize_input($_POST['year']);
        $unitID = sanitize_input($_POST['unit_id']);
        $tenantID = sanitize_input($_POST['tenant_id']);
        $propertyID = sanitize_input($_POST['property_id']);
        $payment_date = sanitize_input($_POST['payment_date']);
        $payment_method = sanitize_input($_POST['payment_method']);
        $status = sanitize_input($_POST['status']);
        $userID = $auth_user['userID'];
        if(checkpaidMonth($tenantID, $month, $year)){
            echo json_encode(['success' => false, 'message' => 'Tenant could have already paid for this month or has a pending approval payment']);
            exit;
        }else{
            $stmt = $pdo->prepare("INSERT INTO payments (tenant_id, property_id, amount, month, year, payment_date, payment_method, status, unitID, userID) VALUES (:tenantID, :propertyID, :amount, :month, :year, :payment_date, :payment_method, :status, :unitID, :userID)");
            $stmt->bindParam(':tenantID', $tenantID);
            $stmt->bindParam(':propertyID', $propertyID);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':unitID', $unitID);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Payment added successfully']);
            }else{
                    echo json_encode(['success' => false, 'message' => 'Error adding payment']);
            }
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    }
}

/*  ========================== Edit Payment ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

    try {
        $token = sanitize_input($_POST['update_csrf_token']);

        if(verify_csrf_token($token)){
            $paymentID = sanitize_input($_POST['paymentId']);
            $amount = sanitize_input($_POST['amount']);
            $month = sanitize_input($_POST['month']);
            $year = sanitize_input($_POST['year']);
            $payment_date = sanitize_input($_POST['payment_date']);
            $payment_method = sanitize_input($_POST['payment_method']);
            $status = sanitize_input($_POST['status']);
            $userID = $auth_user['userID'];

            $stmt = $pdo->prepare("UPDATE payments SET amount=:amount, month=:month, year=:year, payment_date=:payment_date, payment_method=:payment_method, status=:status, userID=:userID WHERE id = :paymentID");
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':paymentID', $paymentID);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Payment updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error updating payment']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error updating payment: ' . $e->getMessage()]);
    }
}


/*  ========================== Compose Mail ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compose_mail'])){
    $paymentID = sanitize_input($_POST['paymentID']);
    $tenantID = sanitize_input($_POST['tenantID']);
    $stmt = $pdo->prepare("SELECT DISTINCT
    `t`.`email`,`t`.`first_name`,`t`.`last_name`,`p`.`amount`,`p`.`month`,`p`.`year` ,`p`.`status`     
    FROM `payments` `p` JOIN `tenants` `t` ON `p`.`tenant_id` = `t`.`tenantID`
    WHERE `p`.`tenant_id` = :tenantID AND p.id = :paymentID");

    $stmt->bindParam(':tenantID', $tenantID);
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo json_encode(['success' => true, 'data' => $result]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Payment not found']);
    }
}


/*  ========================== Get partial payment ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['get_partial_payment'])){
    $paymentID = sanitize_input($_POST['paymentID']);
    $stmt = $pdo->prepare("SELECT * FROM partial_payments WHERE paymentID = :paymentID");
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($result){
        echo json_encode(['success' => true, 'data' => $result]);
    }else{
        echo json_encode(['success' => false, 'message' => 'No partial payment found']);
    }
}


/*  ========================== Add partial payment ========================== */
function GetPaymentDetails($paymentID, $amnt){
    global $pdo;
    $stmt = $pdo->prepare("SELECT M.`amount`, SUM(P.`amount`)as remainingRent FROM partial_payments P JOIN payments M oN P.`paymentID`=M.`id` WHERE P.`paymentID` = :paymentID GROUP BY P.`paymentID`");
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        return  $result['amount'] - ($result['remainingRent'] + $amnt);
    }else{
        return false;
    }
}

function UpdatePayment($paymentId, $status, $payment_date, $paymentmethod,$Id){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE payments SET payment_date=:payment_date, payment_method = :paymentmethod, status = :status, userID = :userID WHERE id = :paymentID");
    $stmt->bindParam(':payment_date', $payment_date);
    $stmt->bindParam(':paymentmethod', $paymentmethod);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':userID', $Id);
    $stmt->bindParam(':paymentID', $paymentId);
    $stmt->execute();
}
function UpdatePartialPaymentStatus($paymentId, $status,$Id){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE payments SET payment_date = CURDATE(), status = :status, userID = :userID WHERE id = :paymentID");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':userID', $Id);
    $stmt->bindParam(':paymentID', $paymentId);
    $stmt->execute();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createPartialPayment'])){

    
    $paymentID = sanitize_input($_POST['paymentID']);
    $date = sanitize_input($_POST['date']);
    $amount = sanitize_input($_POST['amount']);
    $paymentmethod = sanitize_input($_POST['paymentmethod']);
    $remainingRent = GetPaymentDetails($paymentID, $amount);
    $userID = $auth_user['userID'];

    if($remainingRent <= 0){
        UpdatePayment($paymentID, 'Paid', $date, $paymentmethod, $userID);
     }else{
        UpdatePartialPaymentStatus($paymentID, 'Partial',$userID);
     }

    $stmt = $pdo->prepare("INSERT INTO partial_payments (amount, datereceived, paymentID, paymentmode) VALUES (:amount, :datereceived, :paymentID, :paymentmethod)");
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':datereceived', $date);
    $stmt->bindParam(':paymentID', $paymentID);
    $stmt->bindParam(':paymentmethod', $paymentmethod);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        
        echo json_encode(['success' => true, 'message' => 'Partial payment added successfully']);
    }else{
        echo json_encode(['success' => false, 'message' => 'Error adding partial payment']);
    }
   

}

/*  ========================== Edit partial payment ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['partialPaymentID'])){
    $partialPaymentID = sanitize_input($_POST['partialPaymentID']);
    $stmt = $pdo->prepare("SELECT * FROM partial_payments WHERE partialID = :partialPaymentID");
    $stmt->bindParam(':partialPaymentID', $partialPaymentID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo json_encode(['success' => true, 'data' => $result]);
    }else{
        echo json_encode(['success' => false, 'message' => 'No partial payment found']);
    }
}


/*  ========================== Update partial payment ========================== */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editPartialPayment'])){
    $partialPaymentID = sanitize_input($_POST['partial_ID']);
    $amount = sanitize_input($_POST['amount']);
    $date = sanitize_input($_POST['date']);
    $paymentmethod = sanitize_input($_POST['paymentmethod']);
    $stmt = $pdo->prepare("UPDATE partial_payments SET amount=:amount, datereceived=:date, paymentmode=:paymentmethod WHERE partialID = :partialPaymentID");
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':paymentmethod', $paymentmethod);
    $stmt->bindParam(':partialPaymentID', $partialPaymentID);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        echo json_encode(['success' => true, 'message' => 'Partial payment updated successfully']);
    }else{
        echo json_encode(['success' => false, 'message' => 'Error updating partial payment']);
    }
}
