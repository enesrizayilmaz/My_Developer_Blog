<?php
require 'config/database.php';

if(isset($_GET['id'])){

    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

    $update_query =  "UPDATE posts SET category_id = 13 WHERE category_id=$id";
    $update_result = mysqli_query($connection,$update_query);

    if(!mysqli_errno($connection)){
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection,$query);
        $_SESSION['delete-category-success'] = "Category deleted success";
    }

    $delete_category_query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $delete_category_result = mysqli_query($connection,$delete_category_query);
    if(mysqli_errno($connection)){
    $_SESSION['delete-category'] = "Error, you cant delete ";}
else{
    $_SESSION ['delete-category-success'] = "Deleted category successfully";
}
}
header('location:' . ROOT_URL . 'admin/manage-categories.php');
die();
?>