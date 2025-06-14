<?php
// Email configuration
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require '../../PHPMailer/src/Exception.php';

require_once __DIR__ . '/../../settings/config.php';
require_once __DIR__ . '/../../settings/checkloggedinuser.php';

function UpdatePaymentOnMailSent($paymentID){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE payments SET emailsent = emailsent+1, datesent = CURDATE() WHERE id = ?");
    $stmt->execute([$paymentID]);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compose_mail']) ){
    $paymentID = sanitize_input($_POST['paymentID']);
    $tenantID = sanitize_input($_POST['tenantID']);
    $sendto = sanitize_input($_POST['sendto']);
    $subject = sanitize_input($_POST['subject']);
    $message = sanitize_input($_POST['message']);

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = 'localhost';
        $mail->SMTPAuth = false;
        $mail->Username = 'info@rms.kwikcomputing.co';
        $mail->Password = 'Rms@2025/mails';
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 25;

        $mail->setFrom('info@rms.kwikcomputing.co', 'Property Management Team');
        $mail->addAddress($sendto);
        $mail->addReplyTo('info@rms.kwikcomputing.co', 'Property Management Team');
        $mail->addCC('eddieas2012@gmail.com');
        $mail->addBCC('eddieas2024@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if($mail->send()){
            UpdatePaymentOnMailSent($paymentID);
            echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Email sending failed: ' . $mail->ErrorInfo]);
        }
    }catch(Exception $e){
            echo json_encode(['success' => false, 'message' => 'Email sending failed: ' . $e->getMessage()]);
    }

}




?>