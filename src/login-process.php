<?php
namespace Primetime;
require __DIR__ . '/functions.php';
if (isset($_SESSION['username'])) {
    redirect_to('/../home.php');
}

$inputs = [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"]== "POST") {
    if (empty($_POST["username"])) {
        $user_error = "Name is required";
      } else {
        $username = clean_text($_POST["username"]);
      }
    // if login fails 
    if (!login($inputs['username'], $inputs['password'])) {

        $errors['login'] = 'Invalid username or password';

        redirect_with('/../login.php', [
            'errors' => $errors,
            'inputs' => $inputs
        ]);
    }
    else if (login($inputs['username'], $inputs['password'])) {
    //check if user logging in is_admin
        if ((int)$_SESSION['is_admin'] === 1){
            redirect_to('%HOME_URL/admin_home.php');}
        else {
            redirect_to('/../home.php');
        }
    }
    
} else if (is_get_request()) {
    [$errors, $inputs] = session_flash('errors', 'inputs');
}
