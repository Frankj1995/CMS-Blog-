<?php include "includes/db.php"; ?>
<?php include "includes/markup/header.php"; ?>

<!-- Navigation -->

<?php include "includes/markup/nav.php"; ?> 

<?php 

if(isset($_POST['submit'])) {

    $to = "frankj1995@hotmail.co.uk";
    $email = $_POST['email'];
    $subject = wordwrap($_POST['subject'], 70);
    $msg = $_POST['body'];
    $header = "from: " . $_POST['email'];

    if(!empty($email) && !empty($msg)) {
        mail($to, $subject, $msg, $header);
        $message = "Message Sent";
    } else {
        $message = "email and message fields can't be empty.";
    }
    
} else {
    $message = "";
}

?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                            <h5 class="text-center"><?php echo $message ?></h5>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <label for="body" class="sr-only">Message</label>
                                <textarea class="form-control" name="body" id="body" cols="30" rows="5" placeholder="Enter desired message"></textarea>
                            </div>
                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="submit">
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
    <?php include "includes/markup/footer.php";?>