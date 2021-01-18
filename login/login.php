<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title = "Login";
 
// include login checker
$require_login=false;
include_once "login_checker.php";
 
// default to false
$access_denied=false;
 
// if the login form was submitted
if($_POST){
  // include classes
include_once "config/database.php";
include_once "functions/user.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// check if email and password are in the database
$user->email=$_POST['email'];
 
// check if email exists, also get user details using this emailExists() method
$email_exists = $user->emailExists();
 
// login validation will be here
// validate login
if ($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){
 
    // if it is, set the session value to true
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['access_level'] = $user->access_level;
    $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
    $_SESSION['lastname'] = $user->lastname;
 
    // if access level is 'Admin', redirect to admin section
    if($user->access_level=='Admin'){
        header("Location: {$home_url}admin/index.php?action=login_success");
    }
 
    // else, redirect only to 'Customer' section
    else{
        header("Location: {$home_url}user/index.php?action=login_success");
    }
}
 
// if username does not exist or password is wrong
else{
    $access_denied=true;
}
}
 
// login form html will be here
// include page header HTML
include_once "layout_header.php";
 
echo "<div class='container'>";
echo "<div class='d-flex justify-content-center h-100'>";
echo "<div class='card'>";
echo "<div class='card-header'>";
echo "<h3>Sign In</h3>";
echo "<div class='d-flex justify-content-end social_icon'>";
echo " </div> ";
echo " </div> ";



echo "<div class='card-body'>";
echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
echo "<div class='input-group form-group'>";
echo "<div class='input-group-prepend'>";
echo "<span class='input-group-text'><i class='fas fa-user'></i></span>";
echo "</div>";
echo "<input type='text' name='email' class='form-control' placeholder='email' required >";
echo "</div>";
echo "<div class='input-group form-group'>";
echo "<div class='input-group-prepend'>";
echo "<span class='input-group-text'><i class='fas fa-key'></i></span>";
echo "</div>";
echo "<input type='password' name='password' class='form-control' placeholder='password' required >";
echo "</div>";
echo"<br>";
echo "<div class='form-group'>";
echo "<div class='form-group'>
<input type='submit' value='Login' class='btn float-right login_btn'>
</div>  ";
echo "</div>";
echo "</form>";
echo "</div>";
echo "<div class='card-footer'>";
echo "<div class='d-flex justify-content-center links'>";
echo "Don't have an account?<a href='register.php'>Register</a>";
echo "</div>";
echo " </div> ";
echo " </div> ";
echo " </div> ";	
echo " </div> ";	










 
// footer HTML and JavaScript codes
include_once "layout_footer.php";
?>