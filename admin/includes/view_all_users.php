<?php 

if(isset($_GET['subscriber'])) {
    
    $user_id = escape($_GET['subscriber']);
    
    if(is_admin()) {
        $query = mysqli_query($connection, "UPDATE users SET role = 'Subscriber' WHERE user_id = $user_id"); show_error($query);
    }
}


if(isset($_GET['admin'])) {
    
    $user_id = escape($_GET['admin']);
    

    if(is_admin()) {
        $query = mysqli_query($connection, "UPDATE users SET role = 'Admin' WHERE user_id = $user_id");
        show_error($query);
    }
    
}

if(isset($_GET['delete'])) {
    
    $user_id = escape($_GET['delete']);
    
    if(is_admin()) {
        $query = mysqli_query($connection, "DELETE FROM users WHERE user_id = $user_id");
        show_error($query);       
    }
 
}


if(isset($_POST['checkBoxArray'])) {
        
    $box_array = $_POST['checkBoxArray'];
    $bulk_options = escape($_POST['bulk_options']);

    foreach($box_array as $users) {        
        switch($bulk_options) {
            case 'admin':
                $user_query = mysqli_query($connection, "UPDATE users SET role = 'Admin' WHERE user_id = $users" );
                
                show_error($user_query);
                break;
            case 'subscriber': 
                $user_query = mysqli_query($connection, "UPDATE users SET role = 'Subscriber' WHERE user_id = $users" );
                
                show_error($user_query);
                break;
            case 'delete':;
                $user_query = mysqli_query($connection, "DELETE FROM users WHERE user_id = $users" );
                
                show_error($user_query);
                
                header("Location: users.php");
                break;
            default:
                echo "Please select an option.";
        }
    }
}

?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
       <div id="bulkOptionContainer" class="col-xs-2">
            <select class="form-control post-options" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="admin">Admin</option>
                <option value="subscriber">Subscriber</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col_xs_4">
            <input class="btn btn-success apply-btn" type="submit" value="Apply">
            <a class="btn btn-primary" href="users.php?source=add_user">Add New</a>
            
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Admin</th>
                <th>Subscriber</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $user_query = mysqli_query($connection, 'SELECT * FROM users');

            show_error($user_query);

            while($row = mysqli_fetch_assoc($user_query)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                $first_name = $row['user_first_name'];
                $last_name = $row['user_last_name'];
                $email = $row['user_email'];
                $role = $row['role'];
                ?>
                
                <tr>
                    <td>
                         <input class="checkBoxes" id="selectAllBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $user_id ?>">
                    </td>
                <?php
                echo 
                   "<td>$user_id</td>
                    <td>$username</td>
                    <td>$first_name</td>
                    <td>$last_name</td>
                    <td>$email</td>
                    <td>$role</td>
                    <td><a href='users.php?admin=$user_id'>Admin</a></td>
                    <td><a href='users.php?subscriber=$user_id'>Subscriber</a></td>
                    <td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>
                    <td><a href='users.php?delete=$user_id'>Delete</a></td>
                </tr>";
            }
            ?>    
        </tbody>
    </table>
</form>