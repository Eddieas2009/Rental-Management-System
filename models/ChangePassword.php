<?php

require_once '../settings/config.php';
require_once '../settings/checkloggedinuser.php';




if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $new_password = sanitize_input($_POST['new_password']);
    $confirm_password = sanitize_input($_POST['confirm_password']);
    $token = sanitize_input($_POST['pass_csrf_token']);

    if(verify_csrf_token($token)){
        if($new_password != $confirm_password){
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            exit;
        }

        $hashed_password = hash_password($new_password);

        $sql = $pdo->prepare("UPDATE users SET password = :password WHERE userID = :id");
        $sql->execute(['password' => $hashed_password, 'id' => $auth_user['userID']]);
        if($sql->rowCount() > 0){
            echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to change password']);
        }
        exit;



    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }
}



