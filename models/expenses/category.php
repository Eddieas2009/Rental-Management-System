<?php
include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCategory'])){

    $token = sanitize_input($_POST['csrf_token']);

    if(verify_csrf_token($token)){

        $catName = sanitize_input($_POST['catName']);

        $stmt = $pdo->prepare("INSERT INTO `expense_categories`(`catname`) VALUES (?)");
        $stmt->execute([$catName]);

        if($stmt->rowCount() > 0){
            echo json_encode(['success' => true, 'message' => 'Category added successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to add category']);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    }

}


/* Get Category Details */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])){

    $id = sanitize_input($_POST['id']);

    $stmt = $pdo->prepare("SELECT * FROM `expense_categories` WHERE `id` = ?");
    $stmt->execute([$id]);

    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if($category){
        echo json_encode(['success' => true, 'category' => $category]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Category not found']);
    }
}


/* Update Category */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

    try {
        $token = sanitize_input($_POST['update_csrf_token']);

    if(verify_csrf_token($token)){

        $catName = sanitize_input($_POST['catName']);
        $catID = sanitize_input($_POST['catID']);

        $stmt = $pdo->prepare("UPDATE `expense_categories` SET `catname` = ? WHERE `id` = ?");
        $stmt->execute([$catName, $catID]);

        if($stmt->rowCount() > 0){
            echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
        }else{
            echo json_encode(['success' => false, 'message' => 'Failed to update category']);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }

    
}


