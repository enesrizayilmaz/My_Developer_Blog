<?php
require 'partials/header.php';
if(isset($_GET['search']) && isset($_GET['submit'])){
    $search = filter_var($_GET['search'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC";
    $posts = mysqli_query($connection,$query); 
    }else{
        header('location:' . ROOT_URL . 'blog.php');
        die();
    }
?>

<?php if(mysqli_num_rows($posts) > 0) : ?>
    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Title Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>
<section class="posts section__extra-margin" >
        <div class="container posts__container">
            <?php while($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail']?>">
                </div>
                <div class="post__info">
                    <?php
                    $category_id=$post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection,$category_query);
                    $category = mysqli_fetch_assoc($category_result);
                    ?>
                    <a href="<?=ROOT_URL ?>category-posts.php?id<?=$post['category_id'] ?>" class="category__button">Wild Life</a>
                    <h3 class="post__title">
                        <a href="post.php?id=<?=$post['id']?>"><?= $post['title']?></a>
                    </h3>
                    <p class="post__body">
                    <?php
                    $reelpost = $post['body'];  
                    $reelpost2 = substr($reelpost,0,100);                      
                    ?>                  
                <?=  $reelpost2 ?>
                    </p>
                    <div class="post__author">
                        <?php
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($connection,$author_query);
                        $author = mysqli_fetch_assoc($author_result); 
                        ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}"?></h5>
                            <small><?= date("M d, Y - H:i",strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>   
            <?php endwhile ?>
            </div>     
    </section>
    <?php else : ?>
    
    <?php endif ?>
    <section class="category__buttons">
    <div class="container category__buttons-container">
                <?php
                $all_categories_query = "SELECT * FROM categories";
                $all_categories = mysqli_query($connection,$all_categories_query);
                ?>
            <?php while($category = mysqli_fetch_assoc($all_categories)) :?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?=$category['id'] ?>" class="category__button"><?= $category['title']?></a>
                <?php endwhile?>
    </div>
    <div style="text-align: center;" class="alert__message.error">
            <p>No posts found for this search</p>
        </div>
 </section>



<?php
include './partials/footer.php';
?>