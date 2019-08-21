<?php ob_start(); ?>
<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

       
        <!-- Blog Entries Column -->
        <div class="col-md-8">
<!--            <h2>All Posts By Frank Lockett</h2>-->
            <!-- First Blog Post -->
            <?php

             if(isset($_GET['author'])) {
                 $author = escape($_GET['author']);
                 
                 if(is_admin()) {
                    $author_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_author = '$author' ORDER BY post_id DESC");
                    show_error($author_query);     
                 } else {
                    $author_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_author = '$author' AND post_status = 'Published' ORDER BY post_id DESC");
                    show_error($author_query);
                    if(mysqli_num_rows($author_query) === 0) {
                        echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
                    }
                 }
             

                 while($row = mysqli_fetch_assoc($author_query)) {
                     $post_id = $row['post_id'];
                     $post_title = $row['post_title'];
                     $post_author = $row['post_author'];
                     
                     $user_query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$post_author'");
                     show_error($user_query);
                     $user_query_count = mysqli_num_rows($user_query);
                     
                     if($user_query_count > 0) {
                         while($user_row = mysqli_fetch_assoc($user_query)) {
                            $user_first_name = $user_row['user_first_name'];
                            $user_last_name = $user_row['user_last_name'];
                            $username = $user_row['username'];
                            if(!empty($user_first_name)) {
                                $name = $user_first_name . " " . $user_last_name;     
                            } else {
                                $name = $username;
                            }
                         }
                     } else {
                        $name = $post_author;     
                     }
                     
                     $post_date = $row['post_date'];
                     $post_img = $row['post_img'];
                     $post_content = substr($row['post_content'], 0, 100);
                     $post_tags = $row['post_tags'];
                     $post_status = $row['post_status'];
            ?>
            <h1>    
                <?php echo "<a href='post.php?post_id=$post_id'>$post_title</a>"; ?>
            </h1>
            <p class="lead">
                <?php echo "by <a href='author_post.php?author=$post_author'>$name</a>"; ?>
            </p>
            <p>
               <span class="glyphicon glyphicon-time"></span>  
               <?php echo $post_date; ?>  
            </p>
            <hr>
            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_img);?>" alt="placeholders">
            <hr>
            <p>
                <?php echo $post_content; ?>    
            </p>
            <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php  
                } 
            } ?>
        </div>
<?php include "includes/markup/sidebar.php"; ?>
<?php include "includes/markup/footer.php"; ?>

