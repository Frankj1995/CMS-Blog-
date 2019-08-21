<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Home</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
               
               <?php 
                $cat_query = mysqli_query($connection, "SELECT * FROM categories");
                
                show_error($cat_query);
                
                while($row = mysqli_fetch_assoc($cat_query)) {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    $category_class = "";
                    $registration_class = "";
                    $contact_class = "";
                    $login_class = "";
                    
                    $page_name = basename($_SERVER['PHP_SELF']);
                    
                    if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if($page_name == 'registration.php') {
                        $registration_class = 'active';
                    } else if($page_name == 'contact.php') {
                        $contact_class = 'active';
                    } else if($page_name == 'login.php') {
                        $login_class = 'active';
                    } 
                    
                    if($page_name !== 'forgot.php' && $page_name !== 'reset.php') {
                         echo "<li class='$category_class'><a href='category.php?category=$cat_id'>$cat_title</li>";        
                    }
                   
                }
                    
                if(!is_logged_on()) {
                    echo "<li class='$registration_class'><a href='registration.php'>Register</a></li>"; 
                    echo "<li class='$login_class'><a href='login.php'>Login</a></li>";  
                }

                echo "<li class='$contact_class'><a href='contact.php'>Contact</a></li>";

                if(is_logged_on()) {
                    echo "<li><a href='admin'>Admin</a></li>";    
                    echo "<li><a href='includes/markup/logout.php'>Log Out</a></li>";    
                }

                
                if(isset($_SESSION['username'])) {
                    if(isset($_GET['post_id'])) {
                        
                        $post_id = escape($_GET['post_id']);
                        echo "<li><a href='../cms/admin/posts.php?source=edit_post&edit=$post_id'>Edit Post</a></li>";
                    }
                }
                ?> 
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
