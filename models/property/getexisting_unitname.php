<?php

include '../../settings/config.php';

$unitname = $_POST['unitname'];

$stmt = $pdo->prepare("SELECT * FROM units WHERE unitname = ?");
$stmt->execute([$unitname]);
$unit = $stmt->fetch(PDO::FETCH_ASSOC);

if ($unit) {
    echo json_encode(false);
} else {
    echo json_encode(true);
}

?>