<?php include "includes/db.php"; ?>
<!-- Navigation -->
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>

<?php 

logged_on_redirect('index.php');

if(check_request('post')) {
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
        redirect('login.php');
    }
}

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">


                                <form id="login-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            
                                            <input autocomplete="on" name="username" type="text" class="form-control" placeholder="Enter Username">
                                            
                                        </div>
                                    </div>
                                    <p class="text-center"> <?php echo isset($error['username'])? $error['username'] : " " ?></p>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <p class="text-center"> <?php echo isset($error['password'])? $error['password'] : " " ?></p>

                                    <div class="form-group">
                                        <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                                    </div>


                                </form>

                            </div>
                            <!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/markup/footer.php";?>

</div>
<!-- /.container -->
