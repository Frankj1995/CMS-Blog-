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
                    <h1 class="page-header">Categories <small>Frank</small></h1>
                    <div class="col-xs-6">
                       <?php insert_categories(); ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input id="cat-title" class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="submit">Add Category</button>
                            </div>
                        </form><!-- Add Category Form End -->  
                    <?php update_categories(); ?>    
                    </div><!-- Form end -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                select_all();
                                delete_cat();
                                ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
</div>

<?php include "includes/footer.php"; ?>