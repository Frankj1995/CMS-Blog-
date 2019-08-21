<?php 

if(isset($_GET['delete'])) {
    
    $comment_id = escape($_GET['delete']);
    
    if(is_admin()) {
        $query = mysqli_query($connection, "DELETE FROM comments WHERE comment_id = $comment_id");
        show_error($query);
        
    }
}

if(isset($_GET['refuse'])) {
    
    $comment_id = escape($_GET['refuse']);
    
    if(is_admin()) {
        $query = mysqli_query($connection, "UPDATE comments SET comment_status = 'Refused' WHERE comment_id = $comment_id"); show_error($query);   
    }
}

if(isset($_GET['approve'])) {
    
    $comment_id = escape($_GET['approve']);
    
   if(is_admin()) {
        $query = mysqli_query($connection, "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $comment_id");
        show_error($query);
    }
}

if(isset($_POST['checkBoxArray'])) {
    
    $box_array = $_POST['checkBoxArray'];
    $bulk_options = escape($_POST['bulk_options']);
    
    foreach($box_array as $comments) {
        
        switch($bulk_options) {
            case 'approve':
                $comment_query = mysqli_query($connection, "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $comments");
                
                show_error($comment_query);
                break;
            case 'refuse':
                $comment_query = mysqli_query($connection, "UPDATE comments SET comment_status = 'Refused' WHERE comment_id = $comments");
                
                show_error($comment_query);
                break;
            case 'delete':
                $comment_query = mysqli_query($connection, "DELETE FROM comments WHERE comment_id = $comments");
                
                show_error($comment_query);
                header("Location: comments.php");
                break;
            default:
                echo "Please select an option";
        }   
    }
}

?>
<h1 class="page-header">Comments <small>Frank</small></h1>
  <form action="" method="post">
   <div id="bulkOptionContainer" class="col-xs-2">
        <select class="form-control post-options" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="approve">Approve</option>
            <option value="refuse">Refuse</option>
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class="col_xs_4">
        <input class="btn btn-success apply-btn" type="submit" value="Apply">
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>In Response To</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Refuse</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $comment_query = mysqli_query($connection, 'SELECT * FROM comments');

            show_error($comment_query);

            while($row = mysqli_fetch_assoc($comment_query)) {
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $author = $row['comment_author'];
                $comment = $row['comment_content'];
                $email = $row['comment_email'];
                $status = $row['comment_status'];
                $date = $row['comment_date'];
                ?>
                <tr>
                    <td>
                        <input class="checkBoxes" id="selectAllBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $comment_id ?>">   
                    </td>
                <?php
                echo 
                   "<td>$comment_id</td>
                    <td>$author</td>
                    <td>$comment</td>";

                    $post_query = mysqli_query($connection, "SELECT * FROM posts WHERE post_id = $comment_post_id");
                    $post_count = mysqli_num_rows($post_query);
                    
                    if($post_count === 0) {
                       echo "<td>Post Deleted</td>";  
                    } else {
                        while($row = mysqli_fetch_assoc($post_query)) {
                            $post_id = $comment_post_id;
                            $post_title = $row['post_title'];

                            echo "<td><a href='../post.php?post_id=$post_id'>$post_title</a></td>";
                        }         
                    }    

                echo    
                   "<td>$email</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td><a href='comments.php?approve=$comment_id'>Approve</a></td>
                    <td><a href='comments.php?refuse=$comment_id'>Refuse</a></td>
                    <td><a href='comments.php?delete=$comment_id'>Delete</a></td>
                </tr>";
            }
            ?>    
        </tbody>
    </table>
</form>