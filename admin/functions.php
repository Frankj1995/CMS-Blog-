<?php 

/*****************************************************INJECTION******************************************************/

function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

/*******************************************************ERRORS*******************************************************/

function show_error($query) { 
    
    global $connection;
    if(!$query) {
        die("Query Failed " . mysqli_error($connection));
    }
}

function show_stmt_error($stmt) { 
    
    global $connection;
    if(!$stmt) {
        die("Prepared Statement Failed " . mysqli_stmt_error($connection));
    }
}

/******************************************************REDIRECT******************************************************/

function redirect($location) {
    return header("Location: " . $location);
}

/*****************************************************CATEGORIES*****************************************************/


function insert_categories() {
    
    global $connection;
    
    if(isset($_POST['submit'])) {
        $title = escape($_POST['cat_title']);
        if($title === "" || empty($title)) {
           // echo "Please input some text.";
        } else {
            $user_id = logged_in_user_id();
            $stmt = mysqli_prepare($connection, "INSERT INTO categories (user_id, cat_title) VALUE (?, ?)");
            show_error($stmt);
            mysqli_stmt_bind_param($stmt, 'is', $user_id, $title);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

function update_categories() {
    
    global $connection;
     
    if(isset($_GET['edit'])) {
         $cat_id = ($_GET['edit']);
         include "includes/update_cat.php";
     } 
}

function select_all() {
    
    global $connection;
    $cat_query = mysqli_query($connection, "SELECT * FROM categories"); 
    show_error($cat_query);

    while($row = mysqli_fetch_assoc($cat_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>
              <td>$cat_id</td>
              <td>$cat_title</td>
              <td><a href='categories.php?edit=$cat_id'>Edit</a></td>
              <td><a href='categories.php?delete=$cat_id'>Delete</a></td>
              </tr>";
    }
}

function delete_cat() {
    
    global $connection;
    
    if(isset($_GET['delete'])) {
        
        $cat_id = escape($_GET['delete']);
        $cat_query = mysqli_query($connection, "DELETE FROM categories WHERE cat_id = $cat_id");
        show_error($cat_query);
        header("Location: categories.php");
    }
}

/*******************************************************USERS******************************************************/

function users_online() {

    if(isset($_GET['onlineUsers'])) {

        global $connection;
        
        if(!$connection) {
            session_start();
            include("includes/db_admin.php");
        }
        
        $session = session_id();
        $time = time();
        $time_out_in_seconds = 60;
        $time_out = $time - $time_out_in_seconds;

        $online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE session = '$session'");
        $online_count = mysqli_num_rows($online_query);

        if($online_count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session', $time)");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = $time WHERE session = '$session'");
        }

        $users_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $time_out");
        echo $users_online = mysqli_num_rows($users_query);
    }
}

users_online();

/********************************************************LOGIN********************************************************/

function login_user($username, $password) {
    global $connection;
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);
    
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    show_error($query);
    
    while($row = mysqli_fetch_assoc($query)) {
        
        $user_id = $row['user_id'];
        $db_username = $row['username'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_password = $row['user_password'];
        $user_email = $row['user_email'];
        $user_role = $row['role'];
    }
    
    if(password_verify($password, $user_password)) {
        
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['first_name'] = $user_first_name;
        $_SESSION['last_name'] = $user_last_name;
        $_SESSION['role'] = $user_role;
        
        header("Location: ../../admin/index.php");
    } else {
        header("Location: ../../index.php");
    }

}

/*************************************************SECURITY/VALIDATION***********************************************/

function is_admin() {
    if(is_logged_on()) {
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
            return true;
        } else {
            return false;  
        }    
    } else {
        return false;
    }
}

function is_logged_on() {
    if(isset($_SESSION['role'])) {
        return true;
    } else {
        return false;
    }
}

function check_request($method) {
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    } else {
        return false;
    }
}

function logged_on_redirect($location) {
    if(is_logged_on()) {
        redirect($location);
    }
}

function logged_in_user_id() {
    if(is_logged_on()) {
        return $user_id = $_SESSION['user_id'];
    } else {
        return false;
    }
}

function query($query) {
    global $connection;
    $query = mysqli_query($connection, $query);
    show_error($query);
    return $query;
}


function count_data($column, $table, $condition, $data) {
    global $connection;
    $count_query = mysqli_query($connection, "SELECT $column FROM $table WHERE $condition = '$data'");
    show_error($count_query);
    return mysqli_num_rows($count_query);
}

function get_user_post_comments() {
    global $connection;
    $post_author = $_SESSION['username'];
    $comment_query = mysqli_query($connection, "SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author = '$post_author'");
    show_error($comment_query);
    return mysqli_num_rows($comment_query);
}

?>