<?php ob_start(); ?>
<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>

<?php 

if(isset($_POST['liked'])) {
    
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $searchPost = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
    $post = mysqli_fetch_assoc($searchPost);
    $likes = $post['post_likes'];
    
    mysqli_query($connection, "UPDATE posts SET post_likes = $likes + 1 WHERE post_id = $post_id");
    
    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES ($user_id, $post_id)");
    exit();
} 

if(isset($_POST['unliked'])) {
    
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $searchPost = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
    $post = mysqli_fetch_assoc($searchPost);
    $likes = $post['post_likes'];
    
    mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id");
    
    mysqli_query($connection, "UPDATE posts SET post_likes = $likes - 1 WHERE post_id = $post_id");
    exit();
} 

?>
<!-- Page Content -->
<div class="container">

    <div class="row">

       
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- First Blog Post -->
            <?php

             if(isset($_GET['post_id'])) {
               
                 $post_id = escape($_GET['post_id']);
                 
                 $view_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
                 $views = mysqli_fetch_assoc($view_query); 
                 $view_count = $views['post_view_count'];
                 
                 $views_query = mysqli_query($connection, "UPDATE posts SET post_view_count = $view_count + 1 WHERE post_id = $post_id");
                  
                 if(is_admin()) {
                    $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
                    show_error($post_query);     
                 } else {
                    $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'Published'");
                    show_error($post_query);
                    if(mysqli_num_rows($post_query) === 0) {
                        echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
                    }
                 }

                 while($row = mysqli_fetch_assoc($post_query)) {
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
                     $post_content = $row['post_content'];
                     $post_tags = $row['post_tags'];
                 }
            ?>
            <h1>    
                <?php echo "<a href='post.php?post_id=$post_id'>$post_title</a>"; ?>
            </h1>
            <p class="lead">
                <?php echo "by <a href='author_post.php?author=$post_author&post_id=$post_id'>$name</a>"; ?>
            </p>
            <p> 
                <span class="glyphicon glyphicon-time"></span> 
                <?php echo $post_date; ?>
            </p>
            <hr>
            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_img); ?>" alt="placeholders">
            
            <hr>
            
            <p>
                <?php echo $post_content; ?>    
            </p>
            <hr>
            <?php if(is_logged_on()) { ?>
            <div class="row">
                <p class="pull-right">
                    <a data-toggle="tooltip" data-placement="top" title="<?php echo liked_post($post_id) ? 'I liked this before' : 'Want to like it?'?>" class="<?php echo liked_post($post_id) ? 'unlike' : 'like'?>" href=""><span class="glyphicon glyphicon-thumbs-<?php echo liked_post($post_id) ? 'down' : 'up'?>"></span><?php echo liked_post($post_id) ? ' Unlike' : ' Like'?></a>
                </p>    
            </div>
            <div class="row">
                <p class="pull-right">Likes: <?php echo get_post_likes($post_id); ?></p>    
            </div>
            <?php include "includes/markup/comments.php"; ?>
            <?php } else { ?>
            <div class="row">
                <p class="pull-right">You need to <a href="login.php"> Login </a>to like posts</p>    
            </div>
            <div class="row">
                <p class="pull-right">Likes: <?php echo get_post_likes($post_id); ?></p>    
            </div>
            <?php } 
             } else { 
                 header("Location: index.php"); 
             } 
            ?>
        </div>
<?php include "includes/markup/sidebar.php"; ?>
<?php include "includes/markup/footer.php"; ?>

<script>
    $(document).ready(function() {
        
        $("[data-toggle='tooltip']").tooltip();
        
        var post_id = <?php echo $post_id; ?>;
        var user_id = <?php echo logged_in_user_id(); ?>;
            
        $(".like").click(function() {
            $.ajax({
                url: "post.php?post_id=<?php echo $post_id ?>",
                type: 'post',
                data: {
                    liked: 1,
                    post_id: post_id,
                    user_id: user_id
                }
            });
        });
        
         $(".unlike").click(function() {
            $.ajax({
                url: "post.php?post_id=<?php echo $post_id ?>",
                type: 'post',
                data: {
                    unliked: 1,
                    post_id: post_id,
                    user_id: user_id
                }
            });
        });
    });    
    
</script>
