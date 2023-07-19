<?php
include 'partials/header.php';
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection,$query);

$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

unset($_SESSION['add-post-data']);
?>
<section class="form__section">
    <div class="container form__section-container">        
        <h2>Add Post</h2>
        <?php if (isset($_SESSION['add-post'])) : ?>
        <div class="alert__message error">
        <p>
        <?= $_SESSION['add-post']; 
                unset($_SESSION['add-post']);
                ?> 
        </p>
        </div>
        <?php endif ?>
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" value="<?= $title ?>" name="title" placeholder="Title">  
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)):?>
                <option value="<?= $category['id']?>"><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>  
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
            <div name="featured" class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured">
                <label for="is_featured" checked>Featured</label>
            </div>  
            <?php endif ?>
            <div name="thumbnail" class="form__control">
                <label for="thumbnail">Add Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
                
            <textarea name="body"  rows="20" placeholder="Body"></textarea>                     
            <button class="btn" name="submit" type="submit">Add Post</button>
        </form>
    </div>
</section>

<!-- FOOTER -->

<!-- FOOTER FINISHED -->

<?php
include '../partials/footer.php';
?>