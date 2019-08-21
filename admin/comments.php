<?php ob_start(); ?>
<?php include "includes/header.php"; ?>

<?php 

if(!is_admin()) {
    redirect("index.php");
}

?>

<div id="wrapper">
    <?php include "includes/nav.php"; ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <?php 
                    
                    if(isset($_GET['source'])) {
                        $source = escape($_GET['source']);
                    } else {
                        $source = '';
                    }
                    
                    switch($source) {
                            
                        case 'view_post_comments';
                            include "includes/view_post_comments.php";
                            break;
                        default:
                            include "includes/view_all_comments.php";
                            break;
                    }
                    
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
</div>

<?php include "includes/footer.php"; ?>