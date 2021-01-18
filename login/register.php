<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title = "Register";
 
// include login checker
include_once "login_checker.php";
 
// include classes
include_once 'config/database.php';
include_once 'functions/user.php';

 
// include page header HTML
include_once "layout_header.php";
 

 
    // if else function for posting form  
if($_POST){
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // initialize User object
    $user = new User($db);
 
    // set user email to detect if it already exists
    $user->email=$_POST['email'];
 
    // determine if email already exists
    if($user->emailExists()){
        echo "<div class='alert alert-danger'>";
            echo "The email you specified is already registered. Please try again or <a href='{$home_url}login'>login.</a>";
        echo "</div>";
    }
 
    else{
       
        // set values to object properties to create user
$user->firstname=$_POST['firstname'];
$user->lastname=$_POST['lastname'];
$user->contact_number=$_POST['contact_number'];
$user->address=$_POST['address'];
$user->password=$_POST['password'];
$user->access_level='Customer';
$user->status=1;
 
// create new user
if($user->create()){
 
    echo "<div class='alert alert-info'>";
        echo "Successfully registered. <a href='{$home_url}login'>Please login</a>.";
    echo "</div>";
 
    // empty posted values
    $_POST=array();
 
}else{
    echo "<div class='alert alert-danger' role='alert'>Unable to register. Please try again.</div>";
}
    }
}
?>



// registration form 


<div class='container'>;
<div class='d-flex justify-content-center h-100'>;
<div class='form'>;
<div class='card-body'>;
<form action='register.php' method='post' id='register'>

    <table class='table table-responsive'>

        <tr>
            <td class='width-30-percent'><h5>Firstname</h5></td>
            <td><input type='text' name='firstname' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td><h5>Lastname</h5></td>
            <td><input type='text' name='lastname' class='form-control' required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td><h5>Contact Number</h5></td>
            <td><input type='text' name='contact_number' class='form-control' required value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td><h5>Address</h5></td>
            <td><textarea name='address' class='form-control' required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : "";  ?></textarea></td>
        </tr>
 
        <tr>
            <td><h5>Email</h5></td>
            <td><input type='email' name='email' class='form-control' required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td><h5>Password</h5></td>
            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
        </tr>
 
        <tr>
          
          
        </tr>
 
    </table>
    <div class='card-footer' >
    <input type='submit' value='Register' class='btn float-right register_btn'>
</div>

</form>

</div>
</div>
</div>
</div>
<?php
 
echo "</div>";
 
// include page footer HTML
include_once "layout_footer.php";
?>