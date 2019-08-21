<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>

<?php 

if(isset($_POST['submit'])) {
    $search = escape($_POST['search']);
    
    $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_tags LIKE '%$search%'");
    
    show_error($post_query);
    
    $count = mysqli_num_rows($post_query);
    
    if($count === 0) {
        echo "<h1 style='text-align: center;'>Sorry, no results found</h1>";
        echo "<a href='index.php'><h2 style='text-align: center;' >Back to Homepage</h2></a>";
    } else {
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- Searched Blog Post -->
           <?php

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
                $post_content = substr($row['post_content'], 0, 200) . " ...";
                $post_tags = $row['post_tags'];
            ?>
            <h2>    
            <?php echo "<a href='#'>$post_title</a>"; ?>
            
            </h2>
            <p class="lead">
               
            <?php echo "by <a href='index.php'>$name</a>"; ?>
                
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_img;?>" alt="placeholders">
            <hr>
            
            <?php echo "<p>$post_content</p>"; ?>
            
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            <hr>
            <?php } ?>

                
           
            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>  
    <?php include "includes/markup/sidebar.php"; ?>
    <?php include "includes/markup/footer.php"; ?>
    <?php }
} ?> 