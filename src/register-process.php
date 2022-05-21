
<?php
namespace Primetime;
//REGISTRATION LOGIC
session_start();
$errors = [];
$inputs = [];
require __DIR__ . '/functions.php';
//if user session is already set and logged in, redirect to homepage
if(isset($_SESSION['username'])){
    header("location: /../home.php");
}


if(isset($_REQUEST['register-btn'])){
    $username = filter_var($_REQUEST['username'],FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_REQUEST['email'],FILTER_SANITIZE_EMAIL);
    $password = $_REQUEST['password'];
    $confirmpassword = $_REQUEST['confirmpassword'];
    //check if email is already registered
    $email_stmt = $db->prepare("SELECT username,email FROM ptusers WHERE email =:email");
    $email_stmt->execute([':email' => $email]);
    if(isset($row['email']) == $email){
		//throw error if that email exists and redirect to login
        flash('email', );
	    redirect_to('/../login.php');
          }                

    // custom messages  
    else if (!$errors) {
        //register user
        register_user($inputs['email'], $inputs['username'], $inputs['password']);
        $activation_code = generate_activation_code(); //email activation code 
        send_activation_email($inputs['email'], $activation_code);
       
        redirect_to(
            '/../config/activate.php',
            'Please check your email and click the link to verify your email address.'
            );
        }
    }
 else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}
