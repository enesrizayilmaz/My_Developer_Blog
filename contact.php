<?php
include 'partials/header.php';
?>
    <section class="empty__page">
        <h1>Contact Page</h1>
    </section>

<!-- CATEGORY BUTTONS -->
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
 </section>
<!-- CATEGORY BUTTONS FINISHED -->

<?php
include 'partials/footer.php';
?>

</body>
</html>