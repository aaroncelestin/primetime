<?php
require_once __DIR__ . '/../config/database.php';
require __DIR__. '/clean.php';
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
const FLASH = 'FLASH_MESSAGES';
const FLASH_ERROR = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO = 'info';
const FLASH_SUCCESS = 'success';
const HOME_URL = 'https://primetimephysicaltherapy.net';
const APP_URL = 'https://primetimephysicaltherapy.net/config';
const SENDER_EMAIL_ADDRESS = 'DONOTREPLY@primetimephysicaltherapy.net';
const FILTERS = [
    'string' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'string[]' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'email' => FILTER_SANITIZE_EMAIL,
    'int' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_SCALAR
    ],
    'int[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'float' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_FLAG_ALLOW_FRACTION
    ],
    'float[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'url' => FILTER_SANITIZE_URL,
];


/**
 * Connect to the database and returns an instance of PDO class
 * or false if the connection fails
 *
 * @return PDO
 */
function db(): PDO
{
    try {
        $db_interface = new PDO(DB_DSN, DB_USER, DB_PASSWORD, DB_OPTIONS, DB_CHARSET);
        }
    catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return $db_interface;
}



/**
 * Login function if user exists in db and has email activated
 * @param string $username
 * @param string $password
 * @return bool
 */
function login(string $username, string $password): bool
{
    $user = find_user_by_username($username);
    if ($user && is_user_active($username) && password_verify($password, $user['password'])) {
        // prevent session fixation attack
        session_regenerate_id();
        // set username in the session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION["email"] = $user['email'];
        $_SESSION["is_activated"] = $user['is_activated'];
        $_SESSION["is_admin"] = $user['is_admin'];
        return true;
    }
    else {
        return false;
    }
}

/**
 * Takes either an email or username, checks if either exists
 * 
 * @param string $username
 * @param string $email
 * @return bool
 */
function is_user (string $username ="", string $email =""):bool
{
    $db = db();
    $stmt = $db->prepare("SELECT username,email FROM ptusers WHERE email =:email 
        or username =:username");
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    if((isset($row['email']) == $email) or (find_user_by_username($username)))
        return true;
    else {
        return false;
    }
}

/**
 * Checks if email has proper formatting
 * 
 * @param string $email
 * @pram return bool 
 */
function is_email (string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


/**
* Register a user if no errors
*
* @param string $email
* @param string $username
* @param string $password
* @return bool
*/
function register_user(string $email, string $username, string $password): bool 
{
    $db_interface = db();
	$rowsql = "SELECT COUNT(*) as total_rows from ptusers";//count total rows of table
	$count_stmt = $db_interface->prepare($rowsql);//prepare count query for submission
	$count_stmt->execute();//execute count query
	$tablerows = $count_stmt->fetch(PDO::FETCH_ASSOC);//fetch associative array returned by query
	$total_rows = $tablerows['total_rows'];//get rows at index total_rows
	//countdown user id's from number of rows e.g.: total_rows===3, id 999999999999-3
    $user_id = 9999999999;//set upper limit of ID numbers
	$user_id = $user_id - $total_rows;
    $valid_code = "";//unique codes for password resets and account recovery
    $activation_expiry = 24  * 60 * 60; //code expires after 24 hours
    $is_admin = false; //not an admin user, admin users will be assigned by webadmin
    $is_activated = 0; //create and add user not yet activated    
    $sql = 'INSERT INTO ptusers(username, email, password, is_admin, is_activated, activation_expiry)
            VALUES(:username, :email, :password, :is_admin, :is_activated,:activation_expiry)';
    $statement = db()->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', password_hash($password, PASSWORD_BCRYPT));
    $statement->bindValue(':is_admin', (int)$is_admin, PDO::PARAM_INT);
    $statement->bindValue(':is_activated', (int)$is_activated, PDO::PARAM_INT);
    $statement->bindValue(':valid_code', $valid_code);
    $statement->bindValue(':activation_expiry', date('Y-m-d H:i:s',  time() + $activation_expiry));
    return $statement->execute();
}

/**
 * Change users password of email with new password and delete validation code sent from reset password routine
 * 
 * @param string $email
 * @param string $new_password
 * @return bool
 */
function change_password (string $email, string $new_password) :bool {
    $user = find_user_by_email($email);
    if($user == null){
        return false;
    }
    else {
        $deleted_code = "";
        $sql = 'UPDATE ptusers SET password = :new_password, valid_code = :deleted_code WHERE username =:username';
        $chpw_sql = db()->prepare($sql);
        $chpw_sql->bindValue(':password', password_hash($new_password, PASSWORD_BCRYPT));
        $chpw_sql->bindValue(':valid_code', $deleted_code);
        return $chpw_sql->execute();
    }
}


/**
 * For password resets, get valid code if user had password reset requested, returns empty string if not set
 * 
 * @param string $email
 * @return string
 */
function get_valid_code (string $email):string
{
    $codesql = "SELECT valid_code FROM ptusers WHERE email=:email";
    $codedb = db()->prepare($codesql);
    $codedb->bindValue(':username', $email);
    $codedb->execute();
    $user = $codedb->fetch(PDO::FETCH_ASSOC);
    return $user['valid_code'];
}


/**
 * Get user from table by username
 * 
 * @param string $username
 * @return array $user
 */
function find_user_by_username(string $username)
{
    $sql = 'SELECT username, password, is_activated, email
            FROM ptusers
            WHERE username=:username';
    $statement = db()->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}


/** Get user from table by user_id
 * 
 * @param int $user_id
 * @return array $user
 */
function find_user_by_id(int $user_id)
{
    $sql = 'SELECT user_id, password, is_activated, email
            FROM ptusers
            WHERE user_id=:user_id';

    $statement = db()->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}


/** Get user from table by email
 * 
 * @param string $email
 * @return array $user
 */
function find_user_by_email(string $email)
{
    $sql = 'SELECT email, password, is_activated, email
            FROM ptusers
            WHERE email=:email';

    $statement = db()->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}


/**
 * Find if user is_activated is set to ON or 1
 * 
 * @param array $user
 * @return int $is_activated
 */
function is_user_active(string $username)
{
    $user = find_user_by_username($username);
    return (int)$user['is_activated'] === 1;
}




/**
 * Delete user by id number if not active
 * 
 * @param int $id
 * @param int $active
 * @return bool 
 */
function delete_user_by_id(int $user_id, int $is_activated=0)
{  
    $sql = 'DELETE FROM ptusers
            WHERE user_id =:user_id and is_activated=:is_activated';
    $statement = db()->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindValue(':is_activated', $is_activated, PDO::PARAM_INT);
    return $statement->execute();
}


/**
 * Find and delete inactivated user, return true if succesful, false if failed
 * 
 * @param string $activation_code
 * @param string $email
 * @return bool
 */
function find_unverified_user(string $activation_code, string $email):bool
{
    $sql = 'SELECT user_id, activation_code, activation_expiry < now() as expired
            FROM ptusers
            WHERE is_activated = 0 AND email=:email';
    $statement = db()->prepare($sql);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ($user['is_activated'] === 0) {
            return delete_user_by_id($user['user_id']);  
        }
       else {
           return false;
       }
    }   
}


/**
 * Display a view of HTML page sections for reuse
 *
 * @param string $filename
 * @param array $data
 * @return void
 */
function view(string $filename, array $data = []): void
{
    // create variables from the associative array
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require_once __DIR__ . '/inc/' . $filename . '.php';
}


/**
 * Return the error class if error is found in the array $errors
 *
 * @param array $errors
 * @param string $field
 * @return string
 */
function error_class(array $errors, string $field): string
{
    return isset($errors[$field]) ? 'error' : '';
}




/**
 * Return true if the request method is POST
 *
 * @return boolean
 */
function is_post_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

/**
 * Return true if the request method is GET
 *
 * @return boolean
 */
function is_get_request(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'GET';
}

/**
 * Redirect to another URL
 *
 * @param string $url
 * @return void
 */
function redirect_to(string $url): void
{
    
    flush();
    header("Location: <?$url ?>");
    die('should have redirected by now');
    
}


/**
 * Redirect to a URL with data stored in the items array
 * @param string $url
 * @param array $items
 */
function redirect_with(string $url, array $items): void
{
    foreach ($items as $key => $value) {
        $_SESSION[$key] = $value;
    }

    redirect_to($url);
}



/**
 * Generate a psuedo random code for activation
 */
function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

/**
 * Setup reset password email, generate reset code for user and then refresh the page after 30 seconds
 * 
 * @param array $user
 * @return void
 */
function setup_reset (array $user): void
{
    $username = $user['username'];
    $new_code = generate_activation_code();
    $codesql = 'UPDATE ptusers SET valid_code = :new_code WHERE username =:username';
    $stpw_sql = db()->prepare($codesql);
    $stpw_sql->bindValue(':username', $username);
    $stpw_sql->bindValue(':valid_code', $new_code);
    $stpw_sql->execute();
    send_reset_email($user['email'], $new_code);
    echo ("Click the link in your email to reset your password");
    flush();
    header("refresh:30;url=login.php",302);
}



function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/activate.php?email=$email&activation_code=$activation_code";
    // set email subject & body
    $subject = 'Please Activate Your Primetime Physical Therapy Account';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_link
            MESSAGE;
    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;
    // send the email
    mail($email, $subject, nl2br($message), $header);
}



function send_reset_email(string $email, string $validation_code): void
{
    // create the activation link
    $validation_link = APP_URL . "/reset_pass.php?email=$email&activation_code=$validation_code";

    // set email subject & body
    $subject = 'Reset Your Primetime Physical Therapy Account Password';
    $message = <<<MESSAGE
            Hi, 
            Please click the following link to reset your password:
            $validation_link
            If you did not request a password reset or have received this message in error, please contact the office.
            MESSAGE;
    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;

    // send the email
    mail($email, $subject, nl2br($message), $header);

}



