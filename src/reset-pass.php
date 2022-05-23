<?php
namespace Primetime;
require __DIR__ . '/src/functions.php';
view('login-header');
view('primetime-logo');

session_start();
if (is_get_request()){
    //save get request info for checking 
    $code =$_GET['validation_code'];
    $email =$_GET['email'];
}    
if(isset($_POST['reset-pass-btn'])){
    $new_password = $_REQUEST['password'];
    $confirm_password = $_REQUEST['password2'];
    //check if user email exists in db and the code from get matches one found in db
    if (is_user($email) && get_valid_code($email) === $code){
        //check if passwords same        
        if($new_password === $confirm_password) {
            //change password which resets valid_code in db back to empty string
            change_password($email, $password);
            echo ("Your password has been reset. You will be redirected to login page.");
            session_destroy();//wipe all session variables
            flush();//flush output buffer
            header("refresh:5;url=login.php");//wait 5 seconds and redirect to login
            }
        else {//passwords don't match, refresh page
            echo ("Passwords do not match. Please check your entries and try again.");
            flush();
            header("refresh:5;url=reset-pass.php");            
        }
    }    
    else {//email or valid code from get request doesnt match records in db, show generic error and halt
        echo ("There was an error processing your request. Please check your email and try again.");
        session_destroy();
        flush();
        header("refresh:5;url=send-reset.php");
    }    
} 


?>
    <form action="reset_pass.php" method="post">
        <h1>Please enter a new password.</h1>
        <div>
        <label for="password">Enter your password:</label>
        <input type="password" name="password" id="password" value="<?= $inputs['password'] ?? '' ?>"
               class="<?= error_class($errors, 'password') ?>">
        <small><?= $errors['password'] ?? '' ?></small>
    </div>

    <div>
        <label for="password2">Confirm Password:</label>
        <input type="password" name="password2" id="password2" value="<?= $inputs['password2'] ?? '' ?>"
               class="<?= error_class($errors, 'password2') ?>">
        <small><?= $errors['password2'] ?? '' ?></small>
    </div>

        <button type="submit" id ="reset-pass-btn">Submit</button>
    </form>
