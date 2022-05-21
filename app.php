<?php
if (is_get_request()) {

    // sanitize the email & activation code
    [$inputs, $errors] = filter($_GET, [
        'email' => 'string | required | email',
        'activation_code' => 'string | required'
    ]);

    if (!$errors) {

        $user = find_unverified_user($inputs['activation_code'], $inputs['email']);

        // if user exists and activate_user completes successfully redirect to login page
        if ($user && activate_user($user['user_id'])) {
            redirect_with_message(
                'login.php',
                'Your account has been activated successfully. Please login here.'
            );
        }
    }
}

// redirect to the register page in other cases
redirect_with_message(
    'register.php',
    'The activation link is not valid, please register again.',
    FLASH_ERROR
);



function activate_user(int $user_id): bool
{
    $sql = 'UPDATE ptusers
            SET is_activated = 1,
                activated_at = CURRENT_TIMESTAMP
            WHERE user_id=:user_id';

    $statement = db()->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    return $statement->execute();
}