<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome to admin <small><?php echo $_SESSION['first_name']; ?></small></h1>
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
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php 
                                
                                $post_query = mysqli_query($connection, "SELECT * FROM posts");
                                
                                show_error($post_query);
                                
                                $post_count = mysqli_num_rows($post_query);
                                
                                ?>
                                <div class='huge'><?php echo $post_count ?></div>
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
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                               <?php 
                                
                                $comment_query = mysqli_query($connection, "SELECT * FROM comments");
                                
                                show_error($comment_query);
                                
                                $comment_count = mysqli_num_rows($comment_query);
                                
                                ?>
                                <div class='huge'><?php echo $comment_count ?></div>
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
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php 
                                
                                $user_query = mysqli_query($connection, "SELECT * FROM users");
                                
                                show_error($user_query);
                                
                                $user_count = mysqli_num_rows($user_query);
                                
                                ?>
                                <div class='huge'><?php echo $user_count ?></div>
                                <div>Users</div>
                            </div>
                        </div>
                    </div>
                    <a href="users.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Users</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-list fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <?php 
                                
                                $category_query = mysqli_query($connection, "SELECT * FROM categories");
                                
                                show_error($category_query);
                                
                                $category_count = mysqli_num_rows($category_query);
                                
                                ?>
                                <div class='huge'><?php echo $category_count ?></div>
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
    
        $draft_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_status = 'Draft'");                           
        $draft_count = mysqli_num_rows($draft_query);
                                    
        $publish_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_status = 'Published'");                    
        $publish_count = mysqli_num_rows($publish_query);
        
        $comment_status_query = mysqli_query($connection, "SELECT * FROM comments WHERE comment_status = 'Refused'");            
        $comment_status_count = mysqli_num_rows($comment_status_query);
                                    
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
                    
                    $element_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Refused Comments', 'Users', 'Subscribed Users', 'Categories'];                
                    $element_count = [$post_count, $draft_count, $publish_count, $comment_count, $comment_status_count, $user_count, $role_count, $category_count];
                    
                    for($index = 0; $index < 8; $index++) {
                        
                        echo "['$element_text[$index]'" . "," . "$element_count[$index]],";
                    }
    
                    ?>
                ]);

                var options = {
                    chart: {
                        title: 'Website Statistics',
                        subtitle: 'Posts, Comments, Users, Categories',
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