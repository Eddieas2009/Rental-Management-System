<?php

require_once '../../settings/config.php';
require_once '../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user'){
    try{
        if(isset($_POST['csrf_token']) && verify_csrf_token($_POST['csrf_token'])){
        
            $names = sanitize_input($_POST['names']);
            $username = sanitize_input($_POST['username']);
            $password = sanitize_input($_POST['password']);
            $password = hash_password($password);
            $role = sanitize_input($_POST['role']);
            $canview = sanitize_input($_POST['canview']);
            $canedit = sanitize_input($_POST['canedit']);
            $cancreate = sanitize_input($_POST['cancreate']);
            $canaprove = sanitize_input($_POST['canaprove']);

            $sql = $pdo->prepare("INSERT INTO users (names, username, password, role, canview, canedit, cancreate, canaprove) VALUES (:names, :username, :password, :role, :canview, :canedit, :cancreate, :canaprove)");
            $sql->execute([
                'names' => $names,
                'username' => $username,
                'password' => $password,
                'role' => $role,
                'canview' => $canview,
                'canedit' => $canedit,
                'cancreate' => $cancreate,
                'canaprove' => $canaprove
            ]);

            if($sql->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'User added successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error adding user']);
            }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }
        
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage() ]);
    }
}


/* =============================== START OF GET USER =============================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_user'){
    try{
        if(isset($_POST['id'])){
            $id = sanitize_input($_POST['id']);
            $sql = $pdo->prepare("SELECT * FROM users WHERE userID = :id");
            $sql->execute(['id' => $id]);
            $user = $sql->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'user' => $user]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage() ]);
    }
}

/* =============================== END OF GET USER =============================== */   



/* =============================== START OF EDIT USER =============================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_user'){
    try{
        if(isset($_POST['update_csrf_token']) && verify_csrf_token($_POST['update_csrf_token'])){
            $id = sanitize_input($_POST['userId']);
            $names = sanitize_input($_POST['names']);
            $role = sanitize_input($_POST['role']);
            $canview = sanitize_input($_POST['canview']);
            $canedit = sanitize_input($_POST['canedit']);
            $cancreate = sanitize_input($_POST['cancreate']);
            $canaprove = sanitize_input($_POST['canaprove']);

            $sql = $pdo->prepare("UPDATE users SET names = :names, role = :role, canview = :canview, canedit = :canedit, cancreate = :cancreate, canaprove = :canaprove WHERE userID = :id");
            $sql->execute([
                'names' => $names,
                'role' => $role,
                'canview' => $canview,
                'canedit' => $canedit,
                'cancreate' => $cancreate,
                'canaprove' => $canaprove,
                'id' => $id
            ]);

            if($sql->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'User updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error updating user']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage() ]);
    }
}

/* =============================== END OF EDIT USER =============================== */

/* =============================== START OF CHANGE STATUS =============================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_status'){
    try{
        if(isset($_POST['id']) && isset($_POST['acc_status'])){
            $id = sanitize_input($_POST['id']);
            $status = sanitize_input($_POST['acc_status']);
            $status = ($status == 'active') ? 'inactive' : 'active';
            $sql = $pdo->prepare("UPDATE users SET acc_status = :acc_status WHERE userID = :id");
            $sql->execute(['acc_status' => $status, 'id' => $id]);

            if($sql->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Status changed successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error changing status']);
            }
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage() ]);
    }
}

/* =============================== END OF CHANGE STATUS =============================== */

/* =============================== START OF CHANGE PASSWORD =============================== */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'changepassword'){
    try{
        if(isset($_POST['userId']) && isset($_POST['new_password'])){
            $id = sanitize_input($_POST['userId']);
            $new_password = sanitize_input($_POST['new_password']);
            $new_password = hash_password($new_password);
            $sql = $pdo->prepare("UPDATE users SET password = :password WHERE userID = :id");
            $sql->execute(['password' => $new_password, 'id' => $id]);
            if($sql->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error changing password']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
    }catch(PDOException $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage() ]);
    }
}
