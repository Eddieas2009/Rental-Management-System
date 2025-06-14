<?php

// Email configuration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

function UpdatePaymentOnMailSent($paymentID){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE payments SET emailsent = emailsent+1, datesent = CURDATE() WHERE id = ?");
    $stmt->execute([$paymentID]);
}

$stmt = $pdo->prepare("SELECT 
        t.tenantID,
        t.propertyID,
        t.move_in_date,
        u.rentamount,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y-%m-%d') AS due_date,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%m') AS MONTH,
        DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y') AS YEAR,
        u.unitID
    FROM tenantproperty t
    JOIN units u ON t.unitID = u.unitID
    CROSS JOIN (
        SELECT a.N + b.N * 10 AS number
        FROM 
            (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
             UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) a,
            (SELECT 0 AS N UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 
             UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) b
    ) n
    WHERE t.status = 'Active'
    AND DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y-%m-%d') <= CURDATE()
    AND NOT EXISTS (
        SELECT 1 
        FROM payments p 
        WHERE p.tenant_id = t.tenantID
        AND p.month = DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%m')
        AND p.year = DATE_FORMAT(DATE_ADD(t.move_in_date, INTERVAL n.number MONTH), '%Y')
    )
    ORDER BY t.tenantID, due_date");
$stmt->execute();
$countPendingPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);


if($countPendingPayments > 0){

// Get all tenants with due payments
$bstmt = $pdo->prepare("SELECT DISTINCT
  `t`.`email`      AS `email`,
  `t`.`first_name` AS `first_name`,
  `t`.`last_name`  AS `last_name`,
  SUM(`p`.`amount`) `amount`
FROM (`payments` `p`
   JOIN `tenants` `t`
     ON ((`p`.`tenant_id` = `t`.`tenantID`)))
WHERE `p`.`status` = 'pending' GROUP BY `t`.`email`, `t`.`first_name`, `t`.`last_name`");
$bstmt->execute();
$duePayments = $bstmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($duePayments as $payment) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
     
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'eddieas2025@gmail.com';                     //SMTP username
        $mail->Password   = 'jiaxobivwusegpqr';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom('eddieas2025@gmail.com', 'Property Management');
        $mail->addAddress($payment['email'], $payment['first_name'] . ' ' . $payment['last_name']);
        $mail->addCC('kwiklydia@gmail.com');
        $mail->addBCC('ahebwa@kwikcomputing.co');

        // Format the month and year
        //$monthYear = date('F Y', mktime(0, 0, 0, $payment['month'], 1, $payment['year']));
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "Rent Payment Reminder";
        
        $message = "<p>Dear " . $payment['first_name'] . " " . $payment['last_name'] . ",</p>";
        $message .= "<p>This is a friendly reminder that your rent payment of UGX" . number_format($payment['amount'], 2) . " is due.</p>";
        $message .= "<p>Please ensure your payment is made on time to avoid any late fees.</p>";
        $message .= "<p>Best regards,<br>Property Management Team</p>";
        
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        if($mail->send()){
            UpdatePaymentOnMailSent($payment['id']);
        }


    } catch (Exception $e) {
        // Log error but continue with other emails
        error_log("Email could not be sent to {$payment['email']}. Mailer Error: {$mail->ErrorInfo}");
    }
}

}


?>