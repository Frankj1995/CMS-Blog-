<?php 

if(isset($_POST['create_post'])) {
    
    $title = escape($_POST['post_title']);
    $cat_id = escape($_POST['post_category']);
    $author = escape($_POST['post_author']);
    $status = escape($_POST['post_status']);
    $img = $_FILES['post_img']['name'];
    $img_temp = $_FILES['post_img']['tmp_name'];
    $tags = escape($_POST['post_tags']);
    $content = escape($_POST['post_content']);
    date_default_timezone_set("Europe/London");
    $date = date('m/d/Y h:i:s a', time());
    
    move_uploaded_file($img_temp, "../images/$img");
    
    $post_query = mysqli_query($connection, "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_img, post_content, post_tags, post_status) VALUES ('$cat_id', '$title', '$author', '$date', '$img', '$content', '$tags', '$status')");
    
    show_error($post_query);
    
    $post_id = mysqli_insert_id($connection);
    
    echo "<h3 class='bg-success'>Post Created</h3>" . " " . "<p style='margin-bottom: 15px;'><a href='../post.php?post_id=$post_id'>View Post</a><a style='margin-left: 20px;' href='posts.php'>View All Posts</a></p>";
}
 
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post-title">Post Title</label>
        <input id="post-title" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select name="post_category" id="post_category">
            <?php 
            
            $cat_query = mysqli_query($connection, "SELECT * FROM categories");
            show_error($cat_query);
            
            
            while($row = mysqli_fetch_assoc($cat_query)) {
                
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <label for="post-author">Post Author</label>
        <select name="post_author" id="post_author">
        <?php 
        
        $users_query = mysqli_query($connection, "SELECT * FROM users");
        show_error($users_query);
        
        while($row = mysqli_fetch_assoc($users_query)) {
            $username = $row['username'];
            echo "<option value='$username'>$username</option>";
            
        }
        ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post-status">Post Status</label>
        <select name="post_status" id="post_status">
            <option value="Draft">Draft</option>
            <option value="Published">Publish</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post-img">Post Image</label>
        <input id="post-img" type="file" name="post_img">
    </div>
    <div class="form-group">
        <label for="post-tags">Post Tags</label>
        <input id="post-tags" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post-content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="create_post">Add Post</button>
    </div>
</form>