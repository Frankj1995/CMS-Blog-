<?php 


if(!is_admin()) {
    redirect("index.php");
}


if(isset($_GET['edit'])) {
    
    $post_id = escape($_GET['edit']);
    $query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
    show_error($query);
    
    while($row = mysqli_fetch_assoc($query)) {
        $title = $row['post_title'];
        $cat_id = $row['post_category_id'];
        $author = $row['post_author'];
        $date = $row['post_date'];
        $image = $row['post_img'];
        $content = $row['post_content'];
        $tags = $row['post_tags'];
        $comments = $row['post_comment_count'];
        $status = $row['post_status'];
    }
}

if(isset($_POST['update_post'])) {
    
    $title = escape($_POST['post_title']);
    $cat_id = escape($_POST['post_category']);
    $author = escape($_POST['post_author']);
    $status = escape($_POST['post_status']);
    $img = $_FILES['post_img']['name'];
    $img_temp = $_FILES['post_img']['tmp_name'];
    $tags = escape($_POST['post_tags']);
    $content = escape($_POST['post_content']);
    
    move_uploaded_file($img_temp, "../images/$img");
    
    if(empty($img)) {
        
        $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $post_id");
        
        show_error($post_query);
        
        while($row = mysqli_fetch_assoc($post_query)) {
            $img = $row['post_img'];
        }
    }
    
    $query = mysqli_query($connection, "UPDATE posts SET post_title = '$title', post_category_id = '$cat_id', post_author = '$author', post_status = '$status', post_date = now(), post_img = '$img', post_tags = '$tags', post_content = '$content' WHERE post_id = $post_id");
    
    show_error($query);
    
    echo "<h3 class='bg-success'>Post Updated</h3>" . " " . "<p style='margin-bottom: 15px;'><a href='../post.php?post_id=$post_id'>View Post</a><a style='margin-left: 20px;' href='posts.php'>View All Posts</a></p>";
}

?>
   
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post-title">Post Title</label>
        <input value="<?php echo $title ?>" id="post-title" type="text" class="form-control" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category Id</label>
        <select name="post_category" id="post_category">
            <?php 
            
            $query = mysqli_query($connection, "SELECT * FROM categories");
            show_error($query);
            
            
            while($row = mysqli_fetch_assoc($query)) {
                
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <label for="post-author">Post Author</label>
        <input value="<?php echo $author ?>" id="post-author" type="text" class="form-control" name="post_author">
    </div>
    <div class="form-group">
        <label for="post-status">Post Status</label>
        <select name="post_status" id="post_status">
            <option selected="selected" value="<?php echo $status; ?>"><?php echo $status; ?></option>
            <?php 
            
            if($status === 'Draft') {
                echo "<option value='Published'>Publish</option>";
            } else {
                echo  "<option value='Draft'>Draft</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post-img">Post Image</label>
        <img class="img-responsive" width="100" src="../images/<?php echo $image ?>" alt="post-img">
        <input id="post-img" type="file" name="post_img">
    </div>
    <div class="form-group">
        <label for="post-tags">Post Tags</label>
        <input value="<?php echo $tags ?>" id="post-tags" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post-content">Post Content</label>
        <textarea class="form-control" id="body" name="post_content" cols="30" rows="10"><?php echo $content ?></textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="update_post">Edit Post</button>
    </div>
</form>