<?php
namespace Primetime;
//REGISTRATION LOGIC
session_start();
require __DIR__ . '/functions.php';
//if user session is already set and logged in, redirect to homepage
if(isset($_SESSION['username'])){
    header("location: /../home.php");
}


if(isset($_REQUEST['register-btn'])){
    $username = filter_var($_REQUEST['username'],FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_REQUEST['email'],FILTER_SANITIZE_EMAIL);
    $password = $_REQUEST['password'];//dont clean passwords
    $confirmpassword = $_REQUEST['confirmpassword'];
    if ((int)is_user($username, $email) === 0 && $password == $confirmpassword){
        register_user($email, $username, $password);
        $activation_code = generate_activation_code(); //email activation code 
        send_activation_email($email, $activation_code);
        redirect_to(
        '/../config/activate.php',
        'Please check your email and click the link to verify your email address.'
        );
    } 
    else if ($password != $confirmpassword) {
        flash('same', 'password');
        flush();
        header('refresh: 3');
    }
    else if ((int)is_user($username, $email) === 1){
        flash('unique', 'email');
        flush();
        redirect_to('/../register.php');
    }
    else {
        flash('generic', 'email');
        flush();
        header ('refresh: 3');
    }
}
