<?php

include '../../settings/config.php';
include '../../settings/checkloggedinuser.php';


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['getSubCategoriesList'])){

   try {
    
    $categoryID = sanitize_input($_POST['getSubCategoriesList']);

    $stmt = $pdo->prepare("SELECT * FROM `maint_subcategory` WHERE `catID` = :categoryID");
    $stmt->bindParam(':categoryID', $categoryID);
    $stmt->execute();
    $subCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($subCategories){
        echo json_encode(['success' => true, 'subCategories' => $subCategories]);
    }else{
        echo json_encode(['success' => false, 'message' => 'No subcategories found']);
    }
    

   } catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
   }

 
}


/* Add Sub Category */

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addSubCategory'])){

    try {
        $token = sanitize_input($_POST['csrf_token']);
        if(verify_csrf_token($token)){

            $subCategoryName = sanitize_input($_POST['subCatName']);
            $categoryID = sanitize_input($_POST['categoryID']);
            $stmt = $pdo->prepare("INSERT INTO `maint_subcategory` (`subcatName`, `catID`) VALUES (:subCategoryName, :categoryID)");
            $stmt->bindParam(':subCategoryName', $subCategoryName);
            $stmt->bindParam(':categoryID', $categoryID);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Sub Category Added Successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]]);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF Token']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}


/* Get Sub Category Details */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['getSubCategoryDetails'])){

    try {
        $subCatID = sanitize_input($_POST['getSubCategoryDetails']);
        $stmt = $pdo->prepare("SELECT * FROM `maint_subcategory` WHERE `subcatID` = :subCatID");
        $stmt->bindParam(':subCatID', $subCatID);
        $stmt->execute();
        $subCategory = $stmt->fetch(PDO::FETCH_ASSOC);

        if($subCategory){
            echo json_encode(['success' => true, 'data' => $subCategory]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Sub Category Not Found']);
        }
    }catch(Exception $e){
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
}




/* Update Sub Category */

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])){

    try {
        $token = sanitize_input($_POST['update_csrf_token']);
        if(verify_csrf_token($token)){

            $subCatID = sanitize_input($_POST['subCatId']);
            $subCatName = sanitize_input($_POST['subCatName']);

            $stmt = $pdo->prepare("UPDATE `maint_subcategory` SET `subcatName` = :subCatName WHERE `subcatID` = :subCatID");
            $stmt->bindParam(':subCatName', $subCatName);
            $stmt->bindParam(':subCatID', $subCatID);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                echo json_encode(['success' => true, 'message' => 'Sub Category Updated Successfully']);
            }else{
                echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]]);
            }
        }else{
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF Token']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    
    
}
?>