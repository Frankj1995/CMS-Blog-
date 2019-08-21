<?php 

function query($query) {
    global $connection;
    return mysqli_query($connection, $query);
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


/*****************************************************INJECTION******************************************************/

function escape($string) {
    
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

/*******************************************************LOGIN********************************************************/

function login_user($username, $password) {
    global $connection;
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
    
        if(password_verify($password, $user_password)) {

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['first_name'] = $user_first_name;
            $_SESSION['last_name'] = $user_last_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['role'] = $user_role;

            header("Location: admin/dashboard.php");

        } else {
            return false;
        }   
    }   
}

/***********************************************SECURITY/VERIFICATION***********************************************/

function is_admin() {
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin') {
        return true;
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

function liked_post($post_id) {
    $user_id = logged_in_user_id();
    $likes_query = query("SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id");
    show_error($likes_query);
    return mysqli_num_rows($likes_query) > 0 ? true : false;
}

function get_post_likes($post_id) {
    $likes_query = query("SELECT * FROM likes WHERE post_id = $post_id");
    show_error($likes_query);
    return mysqli_num_rows($likes_query);
}

function details_exists($column, $table, $data) {
    global $connection;
    
    $stmt = mysqli_prepare($connection, "SELECT $column FROM $table WHERE $column = ?");
    show_error($stmt);
    mysqli_stmt_bind_param($stmt, "s", $data);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_store_result($stmt);
    
    if(mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
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


/****************************************************REGISTER*******************************************************/

function register_user($username, $password, $email) {
    
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 10));

    $user_query = mysqli_query($connection, "INSERT INTO users (username, user_email, user_password, role) VALUES ('$username', '$email', '$password', 'Subscriber' )"); 
    show_error($user_query);   

    echo "<h5 class='text-center'>Your Registration has been Submitted! <a style='display: inline;' href='index.php?username=$username'>Log In</a></h5>";
} 


function imagePlaceholder($image = ''){
    if(!$image) {
        return 'placeholder.png';
    } else {
        return $image;
    }
}

function profilePlaceholder($image = ''){
    if(!$image) {
        return 'http://placehold.it/64x64';
    } else {
        return $image;
    }
}

?>