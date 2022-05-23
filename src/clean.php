<?php
namespace Primetime;
const REQUIRED_ERROR = "This field is required.";
const FORMATTED_ERRORS = [
    'login' => 'Invalid username or password',
    'required' => 'The %s is required',
    'email' => 'This is not a valid email address',
    'min' => 'The %s must have at least %d characters',
    'max' => 'The %s must have at most %d characters',
    'between' => 'The %s must have between %d and %u characters',
    'same' => 'The %s must match with %s',
    'alphanumeric' => 'The %s should have only letters and numbers',
    'secure' => 'The %s must have between 8 and 64 characters and contain at least one number, one upper case letter, one lower case letter and one special character',
    'unique' => 'The %s already exists',
    'numbers' => 'The %s can only contain numbers, no letters',
    'generic' =>  'There was an error processing your request'
];


/**
*
* Cleans text input and returns string without slashes, htmlchars and whitespaces
* @param string $data
* @return string
*/
function clean_text(string $data):string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/**
 * 
 * Removes any English alphabet chars from an input string and returns an int
 * @param string $data
 * return int
 */
function clean_number(string $data):int {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //declare output number array
    $num_array =[];
    $i = 0;
    $num = 0;
    //while $data has alpha text
    while (ctype_alpha($data)){
        //convert input string to array
        $string_array = str_split ($data);
        //walk through each char
        foreach ($string_array as $char){
            //check if each char is a letter or number
            if (!ctype_alpha($char)){
                //if number, put it at the end of the numarray
                array_push($num_array,$char);
                //convert $num_array to int using math
                $num = (int)$num_array[$i]*pow(10,$i);
            }
            else {//if letter, remove it from $data array and move on to next
                unset($data[$char]);
            }
        }
    }
    return $num;
}


/**
 * Show flash message of DEFAULT_ERRORS with given $particular_error index
 * returns HTML string with div alert
 */
function flash (string $particular_error, string $field ="", int $scalar1 =null, int $scalar2 =null, int $scalar3 =null): string  {
        $msg = format_flash(FORMATTED_ERRORS, $particular_error, $field, $scalar1, $scalar2, $scalar3);
        return '<div class="alert alert-warning alert-dismissible fade show"><?.$msg.?></div>';
}



/**
 * Format and fill flash message of given type with field and scalar using sprintf
 * For example: This $field must be $scalar long
 * 
 * @param array $errmsg_array global array of msgs
 * @param string $error_type index of array of msgs
 * @param string $field given by caller
 * @param int $scalars... numerical values for placeholders in error messages
 * @return string formatted
 */
function format_flash (array $errmsg_array, string $error_type, string $field ="", int $scalar1 =null, int $scalar2 =null, int $scalar3 =null) {
    $temp_message = $errmsg_array[$error_type];
    if ($scalar1 != null){ 
        return sprintf($temp_message, $field, $scalar1); 
    }
    else if ($scalar1 && $scalar2 != null) {
        return sprintf($temp_message, $field, $scalar1, $scalar2); 
    }
    else if ($scalar1 && $scalar2 && $scalar3 != null) {
        return sprintf($temp_message, $field, $scalar1, $scalar2, $scalar3); 
    }
    else
        return sprintf($temp_message, $field);
} 



/**
* Return true if a password is secure
* @param array $data
* @param string $field
* @return bool
*/
function is_secure(array $data, string $field): bool
{
    if (!isset($data[$field])) {
        return false;
    }
    $pattern = "#.*^(?=.{8,64})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";
    return preg_match($pattern, $data[$field]);
}

/**
* Return true if the $value is unique in the column of a table
* @param array $data
* @param string $field
* @param string $table
* @param string $column
* @return bool
*/
function is_unique(array $data, string $field, string $table, string $column): bool
{
    if (!isset($data[$field])) {
        return true;
    }
    $sql = "SELECT $column FROM $table WHERE $column = :value";
    $stmt = db()->prepare($sql);
    $stmt->bindValue(":value", $data[$field]);
    $stmt->execute();
    return $stmt->fetchColumn() === false;
}
