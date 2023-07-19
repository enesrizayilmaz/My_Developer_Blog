<?php
require './config/database.php';
if(isset($_SESSION['user-id'])){
    $id = filter_var($_SESSION['user-id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection,$query);
    $avatar = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrysoft Blog</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="shortcut icon" type="image/png" href="<?= ROOT_URL ?>images/icons8-e-67.png"/>
    <script src="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/script/monochrome/bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@iconscout/unicons@4.0.8/css/line.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <nav>
        <div class="container nav__container">
            <a href="index.php" class="nav__logo">Enrysoft Blog</a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])): ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?=ROOT_URL . 'images/' . $avatar['avatar']?>">
                    </div>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Sign in</a></li>
            <?php endif ?>
            </ul>
            <button id="open__nav-btn">
                <i class="uil uil-bars"></i>
            </button>
            <button id="close__nav-btn">
                <i class="uil uil-multiply"></i>
            </button>
        </div>
    </nav>