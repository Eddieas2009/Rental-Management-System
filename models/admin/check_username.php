<?php

require_once '../../settings/config.php';

$username = sanitize_input($_POST['username']);

$sql =$pdo->prepare("SELECT * FROM users WHERE username = :username");
$sql->execute(['username' => $username]);
$result = $sql->fetch(PDO::FETCH_ASSOC);

if($result){
    echo json_encode(false);
}else{
    echo json_encode(true);
}
