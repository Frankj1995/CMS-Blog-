<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

       
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- Categories Blog Post -->
            <?php

             if(isset($_GET['category'])) {
                 $cat_id = escape($_GET['category']);
                 if(is_admin()) {
                     $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_img, post_content, post_tags FROM posts WHERE post_category_id = ?");
                     show_error($stmt1);
                    
                 } else {
                     $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_img, post_content, post_tags FROM posts WHERE post_category_id = ? AND post_status = ?");
                     show_error($stmt2);
                     $published = 'Published';
                 }
             }
             
             if(isset($stmt1)) {
                 mysqli_stmt_bind_param($stmt1, "i", $cat_id);
                 mysqli_stmt_execute($stmt1);
                 mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_img, $post_content, $post_tags);
                 $stmt = $stmt1;
             } else {
                 mysqli_stmt_bind_param($stmt2, "is", $cat_id, $published);
                 mysqli_stmt_execute($stmt2);
                 mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_img, $post_content, $post_tags);
                 $stmt = $stmt2;
             }
            
             mysqli_stmt_store_result($stmt);
                                           
             if(mysqli_stmt_num_rows($stmt) === 0) {
                 echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
             }  
                 
             while(mysqli_stmt_fetch($stmt)) {
            ?>
            <h2>    
            <?php echo "<a href='post.php?post_id=$post_id'>$post_title</a>"; ?>
            
            </h2>
            <p class="lead">
               
            <?php echo "by <a href='author_post.php?author=$post_author'>$post_author</a>"; ?>
                
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_img);?>" alt="placeholders">
            <hr>
            
            <?php echo "<p>$post_content</p>"; ?>
            
            <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php 
            } 
            mysqli_stmt_close($stmt);
            ?>
        </div>
<?php include "includes/markup/sidebar.php"; ?>
<?php include "includes/markup/footer.php"; ?>

