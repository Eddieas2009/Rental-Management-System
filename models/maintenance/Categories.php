<?php
include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addCategory'])){
        try{  
            $token = sanitize_input($_POST['csrf_token']);
            if(verify_csrf_token($token)){

                $catName = sanitize_input($_POST['catName']);
                $stmt = $pdo->prepare("INSERT INTO maint_category(catName) VALUES (:catName)");
                $stmt->execute(['catName' => $catName]);
                if($stmt->rowCount() > 0){
                    echo json_encode(['success' => true, 'message' => 'Category added successfully']);
                }else{
                    echo json_encode(['success' => false, 'message' => 'Failed to add category']);
                }
            }else{
                echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            }

        }catch(Exception $e){
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
      
}

/* Get Category Details */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getCategoryDetails'])){
    try{
        $catID = sanitize_input($_POST['getCategoryDetails']);
        $stmt = $pdo->prepare("SELECT * FROM maint_category WHERE catID = :catID");
        $stmt->execute(['catID' => $catID]);                
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if($category){
            echo json_encode(['success' => true, 'category' => $category]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Category not found']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

/* Update Category */
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
    try{
        $token = sanitize_input($_POST['update_csrf_token']);
        if(verify_csrf_token($token)){
            $catID = sanitize_input($_POST['catID']);
            $catName = sanitize_input($_POST['catName']);
            $stmt = $pdo->prepare("UPDATE maint_category SET catName = :catName WHERE catID = :catID");
            $stmt->execute(['catName' => $catName, 'catID' => $catID]);
            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Failed to update category']);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}








?>
