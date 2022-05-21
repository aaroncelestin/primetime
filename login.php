<?php
namespace Primetime;
require __DIR__ . '/src/login-process.php';
view('login-header', ['title' => 'Login']);
?>


<?php view('primetime-logo'); ?>
    <form action="login.php" method="post">
        <h1>Login</h1>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?= $inputs['username'] ?? '' ?>">
            <small><?= $errors['username'] ?? '' ?></small>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <small><?= $errors['password'] ?? '' ?></small>
        </div>
        <section>
            <button type="submit">Login</button>
            <p class="mt-5 mb-1 text-muted text-center">New user?<a href="register.php">Register here</a></p>
        </section>
    </form>

<?php view('footer'); ?>
