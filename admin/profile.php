<?php ob_start(); ?>
<?php include "includes/header.php"; ?>

<div id="wrapper">
    <?php include "includes/nav.php"; ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header">Users <small><?php echo $_SESSION['first_name']; ?></small></h1>

<?php 

if(isset($_SESSION[ 'username'])) { 
    
    $username = $_SESSION[ 'username'];
    
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    
    while($row = mysqli_fetch_assoc($query)) {
        
        $user_id = $row['user_id'];
        $first_name = $row['user_first_name'];
        $last_name = $row['user_last_name'];
        $email = $row['user_email'];
        $get_password = $row['user_password'];
        $user_role = $row['role'];
    }
    
} 

if(isset($_POST['update_profile'])) {
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $post_password = $_POST['password'];
    $user_role = $_POST['user_role'];
    
    if($post_password != $get_password && !empty($post_password)) {
        $password = password_hash($post_password, PASSWORD_BCRYPT, array("cost" => 10));    
    } else {
        $password = $get_password;
    }
    

    $edit_user_query = mysqli_query($connection, "UPDATE users SET user_first_name = '$first_name', user_last_name = '$last_name', username = '$username', user_email = '$email', user_password = '$password', role = '$user_role' WHERE user_id = $user_id" );
    
    show_error($edit_user_query);   
    
    echo "<h3 class='bg-success'>Profile Updated</h3>" . " " . "<p style='margin-bottom: 15px;'><a href='index.php'>Go To Dashboard</a></p>";
}

?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input value="<?php echo $first_name ?>" id="first_name" type="text" class="form-control" name="first_name">
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
                            <label for="user_role">Select User Role</label>
                            <select name="user_role" id="user_role">
                                <option selected="selected" value="<?php echo $user_role; ?>">
                                    <?php echo $user_role; ?>
                                </option>
                                <?php 
                                if($user_role === 'admin' ) { 
                                    echo "<option value='subscriber'>subscriber</option>"; 
                                } else { 
                                    echo "<option value='admin'>admin</option>"; 
                                } 
                                ?>
                            </select>
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
                            <button class="btn btn-primary" type="submit" name="update_profile">Edit User</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
</div>

<?php include "includes/footer.php"; ?>