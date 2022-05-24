<?php
namespace Primetime;
require __DIR__ . '/functions.php';
ob_start();
if (isset($_SESSION['username'])) {
    flush();
    redirect_to('/../home.php');
    die;
}

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    if (empty($_POST["username"])) {
        $user_error = "username is required";
    } 
    else {
    $username = clean_text($_POST["username"]);
    $password = $_POST['password'];
    if (login($username,$password)){
        if($_SESSION['is_admin']==0){
            flush();
            redirect_to('/../home.php');
            die;
        }
        else if ($_SESSION['is_admin']==1){
            flush();
            redirect_to('/../admin_home.php');
            die;
        } 
    }
    else {
        flash('login', 'login');
        flush();
        header('refresh: 5');
    }
    }
}
