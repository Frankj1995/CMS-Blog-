<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>
<?php include "includes/markup/nav.php"; ?>

<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';  

$mail = new PHPMailer(true);

if(!isset($_GET['forgot'])) {
    redirect('index.php');
}

if(check_request('post')) {
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        
        if(details_exists('user_email', 'users', $email)) {
            $stmt = mysqli_prepare($connection, "UPDATE users SET token = '$token' WHERE user_email = ?");
            show_error($stmt);
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_execute($stmt);
            mysqli_stmt_close($stmt);
            
            $mail->SMTPDebug = 0;                                      
            $mail->isSMTP();                                            
            $mail->Host       = Config::SMTP_HOST;                      
            $mail->SMTPAuth   = true;                                 
            $mail->Username   = Config::SMTP_USER;                     
            $mail->Password   = Config::SMTP_PASSWORD;                              
            $mail->SMTPSecure = 'tls';                                  
            $mail->Port       = Config::SMTP_PORT;   
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom('funnyfrank12@hotmail.co.ukp', 'Frank');
            $mail->addAddress($email);
            $mail->Subject = 'Forgot Password';
            $mail->Body = "<p>Please click the link to reset your password
            <a href='http://localhost:8888/cms/reset.php?email=$email&token=$token'>href='http://localhost:8888/cms/reset.php?email=$email&token=$token'</a></p>";
            
            if($mail->send()) {
                echo "<h5 class='text-center margin-bottom'>Mail Sent Successfully</h5>";
            } else {
                echo "Mail Not Sent";
            }
        } else {
            echo "<h5 class='text-center margin-bottom'>Email is not associated with any accounts</h5>";
        }
    }
}

?>

<!-- Page Content -->
<div class="container forgot-container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input autocomplete="on" id="email" name="email" placeholder="email address" class="form-control" type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
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

