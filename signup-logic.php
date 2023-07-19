<?php
require 'config/database.php';
$avatar_default = 0;
if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS); 
    $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    if(!$firstname){
        $_SESSION['signup']="Please enter your First Name ";
    }elseif(!$lastname){
        $_SESSION['signup']="Please enter your Last Name ";
    }elseif(!$username){
        $_SESSION['signup']="Please enter your Username ";
    }elseif(!$email){
        $_SESSION['signup']="Please enter your Email ";
    }elseif(strlen($createpassword) < 6 || strlen($confirmpassword) < 6){
        $_SESSION['signup']="Password should be bigger than 6 character ";
    }
    else{
        if($createpassword !== $confirmpassword ){
            $_SESSION['signup'] = "Passwords do not match!";
        }else{
            $password = $createpassword;
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $user_check_result = mysqli_query($connection,$user_check_query);
            if(mysqli_num_rows($user_check_result)>0){
                $_SESSION['signup']="Username or Email already exist";
            }
            //AVATAR START
            else{
                if(!$avatar['name']){
                    $avatar_name = 'avatardefault.jpg';
                    $avatar_destination_path = 'images/' . $avatar_name;
                    $avatar_default = 1;
                    // $_SESSION['signup']="Please add your Avatar ";
                } 
                else{
                    $time = time();
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = 'images/' . $avatar_name;
                    $allowed_files=['png','jpg','jpeg'];
                    $extention = explode('.',$avatar_name);
                    $extention = end($extention);
                    if(in_array($extention,$allowed_files)){
                        if($avatar['size'] < 1000000){
                            move_uploaded_file($avatar_tmp_name,$avatar_destination_path);
                        }else{
                            $_SESSION['signup'] = 'File size too big. Should be less than 1mb';
                        }
                    }else{
                        $_SESSION['signup'] = "File shuld be png, jpg or jpeg";
                    }
                }
                }
               
            //AVATAR FINISHED
        }
    }
    if(isset($_SESSION['signup'])){
        
        $_SESSION['signup-data'] = $_POST;
        header('location:'.ROOT_URL.'signup.php');
        die();
    }else{
        $inset_user_query = "INSERT INTO users SET firstname = '$firstname',lastname = '$lastname', username ='$username',
        email = '$email', password = '$password', avatar = '$avatar_name', is_admin = 0 ";
         $inset_user_query = mysqli_query($connection,$inset_user_query);
         if(!mysqli_errno($connection)){
            $_SESSION['signup-success']="Registration successful. Please log in!";
            header('location:' . ROOT_URL . 'signin.php');
            die();
         }
    }

}else{
header('location:'.ROOT_URL.'signup.php');
die();
}
?>