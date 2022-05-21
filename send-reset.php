<?php
namespace Primetime;
require __DIR__ . '/src/functions.php';
view('login-header');
view('primetime-logo');

session_start();
if(isset($_REQUEST['email-reset-btn'])){
    if(is_email($_REQUEST['email'])){
        $user = find_user_by_email($_REQUEST['email']);
        setup_reset($user);
    }
    else if(!empty(find_user_by_username($_REQUEST['username']))){
        $user = find_user_by_username($_REQUEST['username']); 
        setup_reset($user);
    }
    else {
        echo ("Email or username not found. Please register or try again.");
        header("refresh:5;url=send-reset.php");
    }
}

?>
    <form action="send-reset.php" method="request">
        <h1>Forgot your password? Enter either your username or email to reset your password.</h1>
        <div>
            <label for="username">Enter your username:</label>
            <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
           
        </div>

        <div>
            <label for="email">Enter your email:</label>
            <input type="text" name="email" id="email" value="<?= $inputs['email'] ?? '' ?>">
            
        </div>

        <button type="submit" id ="email-reset-btn">Submit</button>
    </form>

