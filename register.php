<?php
namespace Primetime;
require __DIR__ . '/src/register-process.php';

 view('login-header');

 view('primetime-logo');
?>
<div class="text-center">
<form name="register" id="register" action="register.php" method="post" class="form-floating mx-auto mb-3 needs-vali>    <h1>Sign Up</h1>

    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" class="form-control">
        <div class ="invalid-feedback">Please enter a username</div>
        <small></small>

    </div>

    <div>
    <label for="email">Email:</label>
        <input type="text" name="email" id="email" class="form-control" required>
        <div class ="invalid-feedback">Please enter a valid email</div>
        <small></small>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="text" name="email" id="password" class="form-control" required>
        <div class ="invalid-feedback">Please enter a valid password</div>
        <small></small>
    </div>

    <div>
        <label for="password2">Confirm Password:</label>
        <input type="text" name="password2" id="password2" class="form-control" required>
        <div class ="invalid-feedback">Please enter your password again</div>
        <small></small>
    </div>

    <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="checked" required>
           I agree with the <a href="#" title="term of services">term of services</a>
        </label><small></small>
    <button class="btn btn-primary" type="submit">Register</button>
</div>
    <p class="mt-1 mb-1 text-muted text-center">Already a member? <a href="login.php">Login here</a></p>
    <p class="mt-1 mb-1 text-muted text-center">Forgot password? <a href="send-reset.php">Click here to reset.</a></>
</form>

<?php view('footer') ?>

