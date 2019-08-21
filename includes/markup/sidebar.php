<!-- Blog Sidebar Widgets Column -->

<?php 

if(check_request('post')) {
    if(isset($_POST['login'])) {
        
        $message = "";
        
        if(isset($_POST['username']) && isset($_POST['password'])) {
            
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            $error = ['username' => '', 'password' => ''];

            if(empty($password)) {
                $error['password'] = "Password field cannot be empty"; 
            } 
        
            if(empty($username)) {
                $error['username'] = "Username field cannot be empty";
            } else if(!details_exists('username', 'users', $username)) {
                $error['username'] = "Incorrect Username";    
            }
            
            foreach($error as $key => $value) {
                if(empty($value)) {
                    unset($error[$key]);
                }
            }
    
            if(empty($error)) {
                login_user($username, $password);
            }
            
      
        } else {
            redirect('index.php');
        }    
    }
}

?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-default" >
                <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
        </form> <!-- form end -->
        <!-- /.input-group -->
    </div>
    
    <!-- Login  -->
    <?php if(is_logged_on()): ?>
    <div class="well">
        <h4>Welcome <?php echo $_SESSION['username']; ?></h4>
    </div>
    <?php else: ?>
    <div class="well">
        <h4>Login</h4>
        <form action="" method="post">
        <div class="form-group">
            <?php 
            
            if (isset($message)) { echo $message; };
            
            if(isset($_GET['username'])) {
                $username = $_GET['username'];
                echo "<input type='text' value='$username' name='username' class='form-control' placeholder='Username'>";
            } else {
                isset($error['username'])? $placeholder = $error['username'] : $placeholder = "Username";
                echo "<input type='text' name='username' class='form-control' placeholder='$placeholder'>";
                
            } 
            
            ?>
            
        </div>
        <div class="input-group">
           <?php isset($error['password'])? $placeholder = $error['password'] : $placeholder = "Password"; ?>
            <input type="password" name="password" class="form-control" placeholder="<?php echo $placeholder ?>">
            <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">Login</button>
            </span>
        </div>
        <div class="form-group forgot-pass">
            <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
        </div>
        </form> <!-- form end -->
        <!-- /.input-group -->
    </div>
    <?php endif; ?>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <ul class="list-unstyled">
        
                    <?php 
                
                    $cat_query = mysqli_query($connection, "SELECT * FROM categories");
                    show_error($cat_query);
                    
                    while($row = mysqli_fetch_assoc($cat_query)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                    }
                    ?> 
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
</div>