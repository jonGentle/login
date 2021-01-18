<?php
// core configuration
include_once "../config/core.php";
// include classes
include_once '../config/database.php';
include_once '../functions/user.php';
 
// check if logged in as admin
include_once "login_checker.php";

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// set page title
$page_title="Admin Index";
 
// include page header HTML
include 'layout_header.php';
 
    echo "<div class='col-md-12'>";
 
        // get parameter values, and to prevent undefined index notice
        $action = isset($_GET['action']) ? $_GET['action'] : "";
 
        // tell the user he's already logged in
        if($action=='already_logged_in'){
            echo "<div class='alert alert-info'>";
                echo "<strong>You</strong> are already logged in.";
            echo "</div>";
        }
 
        else if($action=='logged_in_as_admin'){
            echo "<div class='alert alert-info'>";
                echo "<strong>You</strong> are logged in as admin.";
            echo "</div>";
        }
 
        echo "<div class='alert alert-info'>";
            echo "Admin Landing Page.";
        echo "</div>";
 
    echo "</div>";

    echo "<div class='col-md-12'>";
 
    // read all users from the database
    $stmt = $user->readAll($from_record_num, $records_per_page);
 
    // count retrieved users
    $num = $stmt->rowCount();
 
    // to identify page for paging
    $page_url="users.php?";
 
    // include products table HTML template
    include_once "users_template.php";
 
echo "</div>";
 
// include page footer HTML
include_once 'layout_footer.php';
?>