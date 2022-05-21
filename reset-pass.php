<?php
namespace Primetime;
require __DIR__ . '/src/functions.php';
view('login-header');
view('primetime-logo');

session_start();
if (is_get_request()){
    [$inputs, $errors] = filter($_GET, [
        'email' => 'string | required | email',
        'validation_code' => 'string | required'
    ]);
    $u_email = $_REQUEST['email'];
    if(isset($_POST['reset-pass-btn'])){
        $new_password = $_REQUEST['password'];
        $confirm_password = $_REQUEST['password2'];
        if($new_password === $confirm_password) {
            change_password($u_email, $password);
            echo ("Your password has been reset. You will be redirected to login page.");
            header("refresh:5;url=login.php");
            session_destroy();
        }
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


