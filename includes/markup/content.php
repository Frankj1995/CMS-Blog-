<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <!-- First Blog Post -->
           <?php 
            
            $post_count_query = mysqli_query($connection, "SELECT * FROM posts");
            $post_row_count = mysqli_num_rows($post_count_query);
            $post_limit = 5;
            $post_count = ceil($post_row_count / $post_limit);
            
            if(isset($_GET['page'])) {
                $page = escape($_GET['page']);
                $post_num = ($page * $post_limit) - $post_limit;
            } else {
                $post_num = 0;
                $page = 0;
            }
            if(is_admin()) {
                $post_query = mysqli_query($connection, "SELECT * FROM posts ORDER BY post_id DESC LIMIT $post_num, $post_limit");
                show_error($post_query);
                if(mysqli_num_rows($post_query) === 0) {
                    echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
                }
            } else {
                $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_id DESC LIMIT $post_num, $post_limit");
                show_error($post_query);  
                if(mysqli_num_rows($post_query) === 0) {
                    echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
                }
            }
            
            while($row = mysqli_fetch_assoc($post_query)) {
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
                $post_content = substr($row['post_content'], 0, 200) . " ...";
                $post_tags = $row['post_tags'];
                $post_status = $row['post_status'];

            ?>
            <h1>    
                <?php echo "<a href='post.php?post_id=$post_id'>$post_title</a>"; ?>
            </h1>
            <p class="lead">
               
                <?php echo "by <a href='author_post.php?author=$post_author'>$name</a>"; ?>
                
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <hr>
            <a href="post.php?post_id=<?php echo $post_id ?>">
            <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_img); ?>" alt="placeholders">
            </a>
            <hr>
            
            <?php echo "<p>$post_content</p>"; ?>
            
            <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
  <?php } ?>
        </div> <!--/.row -->
<?php include "includes/markup/sidebar.php"; ?>
<ul class="pager">
    <?php 

    for($i = 1; $i <= $post_count; $i++) {
        
        if($i == $page) {
            echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
        } else {
            echo "<li><a href='index.php?page=$i'>$i</a></li>";
        }
       
    }

    ?>
</ul>

<!-- /.row -->
<hr>