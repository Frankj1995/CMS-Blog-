<?php include "includes/header.php"; ?>

<div id="wrapper">
    <?php include "includes/nav.php"; ?>
    
    <div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome to your Dashboard <small><?php echo $_SESSION['first_name']; ?></small></h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Blank Page
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class='huge'>
                                <?php 
                                    echo $post_count = count_data('*', 'posts', 'post_author', $_SESSION['username']); 
                                ?>
                                </div>
                                <div>Posts</div>
                            </div>
                        </div>
                    </div>
                    <a href="posts.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Posts</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class='huge'><?php echo $comment_count = get_user_post_comments(); ?></div>
                                <div>Comments</div>
                            </div>
                        </div>
                    </div>
                    <a href="comments.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Comments</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-list fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class='huge'><?php echo $category_count = count_data('*', 'categories', 'user_id', logged_in_user_id()); ?></div>
                                <div>Categories</div>
                            </div>
                        </div>
                    </div>
                    <a href="categories.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Categories</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <?php 
        $post_author = $_SESSION['username'];
        
        $draft_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_status = 'Draft' AND post_author = '$post_author'");                           
        $draft_count = mysqli_num_rows($draft_query);
                                    
        $publish_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_status = 'Published' AND post_author = '$post_author'");                    
        $publish_count = mysqli_num_rows($publish_query);
        
        $comment_refused_query = mysqli_query($connection, "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author = '$post_author' AND comment_status = 'Refused'");        
        $comment_refused_count = mysqli_num_rows($comment_refused_query);
        
        $comment_approved_query = mysqli_query($connection, "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author = '$post_author' AND comment_status = 'Approved'");        
        $comment_approved_count = mysqli_num_rows($comment_approved_query);
                                    
        $role_query = mysqli_query($connection, "SELECT * FROM users WHERE role = 'Subscriber'");            
        $role_count = mysqli_num_rows($role_query);
        
                                    
        ?>
        
        <!-- /.row -->
        <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Data', 'Count'],               
                    <?php 
                    
                    $element_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Approved Comments', 'Refused Comments', 'Categories'];                
                    $element_count = [$post_count, $draft_count, $publish_count, $comment_count, $comment_approved_count, $comment_refused_count, $category_count];
                    
                    for($index = 0; $index < 7; $index++) {
                        
                        echo "['$element_text[$index]'" . "," . "$element_count[$index]],";
                    }
    
                    ?>
                ]);

                var options = {
                    chart: {
                        title: 'Website Statistics',
                        subtitle: 'Posts, Comments, Categories',
                    }  
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
        <div id="columnchart_material" style="width: 1100px; height: 500px;"></div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
</div>

<?php include "includes/footer.php"; ?>