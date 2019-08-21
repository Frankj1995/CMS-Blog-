<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>

<!-- Navigation -->

<?php include "includes/markup/nav.php"; ?>

<?php 

require "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$app_cluster = 'eu';
$pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), array('cluster' => $app_cluster) );

if(isset($_POST['submit'])) {
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    
    $error = ['username' => '', 'email' => '', 'password' => ''];
  
    if(empty($username)) {
        $error['username'] = "Username field cannot be empty";
    } else if(strlen($username) < 5) {
        $error['username'] = "Username must be 5 characters or more";
    } else if(details_exists('username', 'users', $username)) {
        $error['username'] = "Username already exists";    
    }
    
    if(empty($password)) {
        $error['password'] = "Password field cannot be empty";    
    } else if(strlen($password) < 5) {
        $error['password'] = "Password must be 5 characters or more";
    }
    
    if(empty($email)) {
        $error['email'] = "Email field cannot be empty";       
    } else if(details_exists('user_email', 'users', $email)) {
        $error['email'] = "Email already exists";    
    }
    
    foreach($error as $key => $value) {
        if(empty($value)) {
            unset($error[$key]);
        }
    }
    
    if(empty($error)) {
        register_user($username, $password, $email);
        $data['message'] = $username;
        $pusher->trigger('notifications', 'new_user', $data);
    }
        
}
?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input autocomplete="on" type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''  ?>">
                                <p class="text-center"> <?php echo isset($error['username'])? $error['username'] : " " ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input autocomplete="on"  type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                                <p class="text-center"> <?php echo isset($error['email'])? $error['email'] : " " ?></p> 
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password" >
                                 <p class="text-center"> <?php echo isset($error['password'])? $error['password'] : " " ?></p>
                            </div> 
                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div>
                <!-- /.col-xs-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/markup/footer.php"; ?>