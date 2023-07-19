<?php
include 'partials/header.php';

$category_query = "SELECT * FROM categories";
$categories = mysqli_query($connection,$category_query);

if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection,$query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:' . ROOT_URL . 'admin/');
    die();
}

?>
<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST" >
         <input name="id" type="hidden" value="<?= $post['id'] ?>">
         <input name="previous_thumbnail_name" type="hidden" value="<?= $post['thumbnail'] ?>">
            <input name="title" type="text" value="<?= $post['title'] ?>" placeholder="Title">  
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) :?>
                <option value="<?=$category['id']?>"><?=$category['title']?></option>
                <?php endwhile ?>
            </select>  
            <?php if(isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" 
                <?php if ($post['is_featured']) : ?>
                    checked>
             <?php else : ?>
                 
                <?php endif ?>
                <label for="is_featured" >Featured</label>
            </div>  
            <?php endif ?>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <?php 
            $postc = $post['body'];
            $postcontent = html_entity_decode($postc);
            ?>
            <textarea name="body" rows="20" placeholder="Body"><?= $postcontent  ?></textarea> 
            <button class="btn" name="submit" type="submit">Edit Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
