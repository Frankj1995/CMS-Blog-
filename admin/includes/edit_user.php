<?php 

if(isset($_GET['edit_user'])) {
    
    $user_id = escape($_GET['edit_user']);
    $user_query = mysqli_query($connection, "SELECT * FROM users WHERE user_id = $user_id");
    show_error($user_query);
    
    while($row = mysqli_fetch_assoc($user_query)) {
        $first_name = $row['user_first_name'];
        $last_name = $row['user_last_name'];
        $username = $row['username'];
        $email = $row['user_email'];
        $get_password = $row['user_password'];
        $user_role = $row['role'];
        $image = $row['user_img'];
    }
} else {
    header("Location: index.php");
}

if(isset($_POST['edit_user'])) {
    
    $first_name = escape($_POST['first_name']);
    $last_name = escape($_POST['last_name']);
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $post_password = escape($_POST['password']);
    $user_role = escape($_POST['user_role']);
    $img = $_FILES['user_img']['name'];
    $img_temp = $_FILES['user_img']['tmp_name'];
    
    if($post_password != $get_password && !empty($post_password)) {
        $password = password_hash($post_password, PASSWORD_BCRYPT, array("cost" => 12));
    } else {
        $password = $get_password;
    }

    $edit_user_query = mysqli_query($connection, "UPDATE users SET user_first_name = '$first_name', user_last_name = '$last_name', username = '$username', user_email = '$email', user_password = '$password', role = '$user_role', user_img = '$img' WHERE user_id = $user_id" );
    
    show_error($edit_user_query); 
    
    echo "<h3 class='bg-success'>User Updated</h3>" . " " . "<p style='margin-bottom: 15px;'><a href='users.php'>View Users</a></p>";

}

?>
   

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input value="<?php echo $first_name ?>"id="first_name" type="text" class="form-control" name="first_name">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input value="<?php echo $last_name ?>" id="last_name" type="text" class="form-control" name="last_name">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php echo $username ?>" id="" type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input value="<?php echo $email ?>" class="form-control" id="email" type="email" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input autocomplete="off" id="password" type="password" class="form-control" name="password" placeholder="New Password">
    </div>
    <div class="form-group">
        <label for="post-img">Profile Picture</label>
        <img class="img-responsive" width="100" src="../images/<?php echo $image ?>" alt="profile picture">
        <input id="user_img" type="file" name="user_img">
    </div>
    <div class="form-group">
        <label for="user_role">Select User Role</label>
        <select name="user_role" id="user_role">
            <option selected="selected" value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php 
            
            if(is_admin()) {
                echo "<option value='Subscriber'>Subscriber</option>";
            } else {
                echo  "<option value='Admin'>Admin</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="edit_user">Edit User</button>
    </div>
</form>