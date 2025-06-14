<?php

include '../../settings/config.php';

$propName = sanitize_input($_POST['propName']);

$stmt = $pdo->prepare("SELECT * FROM properties WHERE propName = ?");
$stmt->execute([$propName]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

if ($property) {
    echo json_encode(false);
} else {
    echo json_encode(true);
}

?>