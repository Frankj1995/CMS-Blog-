<?php 

if(isset($_POST['add_user'])) {

    
    $first_name = escape($_POST['first_name']);
    $last_name = escape($_POST['last_name']);
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    $user_role = escape($_POST['user_role']);
    $img = $_FILES['user_img']['name'];
    $img_temp = $_FILES['user_img']['tmp_name'];
    $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));
    
    $add_user_query = mysqli_query($connection, "INSERT INTO users (username, user_password, user_first_name, user_last_name, user_email, role, user_img) VALUES ('$username', '$password', '$first_name', '$last_name', '$email', '$user_role', '$img')");
    
    show_error($add_user_query);
    
    echo "<h3 class='bg-success' >User Created</h3>" . " " . "<p style='margin-bottom: 15px;'><a href='users.php'>View Users</a></p>";
}
 
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input id="first_name" type="text" class="form-control" name="first_name">
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input id="last_name" type="text" class="form-control" name="last_name">
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="" type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" type="email" name="email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" type="password" class="form-control" name="password">
    </div>
     <div class="form-group">
        <label for="user_img">Profile Picture</label>
        <input id="user_img" type="file" name="user_img">
    </div>
    <div class="form-group">
        <label for="user_role">Select User Role</label>
        <select name="user_role" id="user_role">
            <option selected="selected" value="Subscriber">Select Role</option>
            <option value="Subscriber">Subscriber</option>
            <option value="Admin">Admin</option>
        </select>
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" name="add_user">Add User</button>
    </div>
</form>