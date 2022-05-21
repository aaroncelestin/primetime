<?php
namespace Primetime;
require __DIR__ . '/src/register-process.php';

 view('login-header');

 view('primetime-logo');
?>
<div class="text-center">
<form action="register.php" method="post" class="form-floating mx-auto mb-3">
    <h1>Sign Up</h1>

    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>"
               class="<?= error_class($errors, 'username') ?>">
        <small><?= $errors['username'] ?? '' ?></small>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= $inputs['email'] ?? '' ?>"
               class="<?= error_class($errors, 'email') ?>">
        <small><?= $errors['email'] ?? '' ?></small>
    </div>

    <div>
        <label for="password">Password:</label>
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

    <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="checked" <?= $inputs['agree'] ?? '' ?> /> I
            agree
            with the
            <a href="#" title="term of services">term of services</a>
        </label>
        <small><?= $errors['agree'] ?? '' ?></small>
    </div>

    <button type="submit">Register</button>

    <p class="mt-5 mb-1 text-muted text-center">Already a member? <a href="login.php">Login here</a></p>
    <p class="mt-5 mb-1 text-muted text-center">Forgot password? <a href="send-reset.php">Click here to reset.</a></p>

</form>

<?php view('footer') ?>
