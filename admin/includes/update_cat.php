
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php 
        if(isset($_GET['edit'])) {
            
            $cat_id = escape($_GET['edit']);
            
            $stmt = mysqli_prepare($connection, "SELECT cat_title FROM categories WHERE cat_id = ?");
            show_stmt_error($stmt);
            mysqli_stmt_bind_param($stmt, "i", $cat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $cat_title);
            
            while(mysqli_stmt_fetch($stmt)) {
                echo "<input class='form-control' value='$cat_title' type='text' name='cat_title'</input>";
            }
            mysqli_stmt_close($stmt);

        } 

        if(isset($_POST['update_cat'])) {
            
            $cat_title = escape($_POST['cat_title']);
            
            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
            show_stmt_error($stmt);
            mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            redirect("categories.php");
        }
        
        ?>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="update_cat">Edit Category</button>
    </div>
</form>
