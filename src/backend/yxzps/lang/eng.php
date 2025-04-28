<?php

define("MESSAGE_ERROR_GENERIC", "An unknown error occurred");
define("MESSAGE_ERROR_USERNAME_ALREADY_TAKEN", "Username is already taken");
define("MESSAGE_ERROR_EMAIL_ALREADY_TAKEN", "Email is already taken");
define("MESSAGE_ERROR_INVALID_CREDENTIALS", "Invalid credentials");
define("MESSAGE_ERROR_ACCOUNT_BANNED", "Your account has been banned");
define("MESSAGE_ERROR_NOT_FOUND", "An instance with the given data: '{1}': '{2}' hasn't been found");
define("MESSAGE_ERROR_ALREADY_TAKEN", "'{1}': '{2}' is already taken");
define("MESSAGE_ERROR_ACCOUNT_NOT_ACTIVE", "Account isn't active!! Activate it using dashboard");

define("MESSAGES", [
    ERROR_GENERIC=>MESSAGE_ERROR_GENERIC,
    ERROR_USERNAME_ALREADY_TAKEN=>MESSAGE_ERROR_USERNAME_ALREADY_TAKEN,
    ERROR_EMAIL_ALREADY_TAKEN=>MESSAGE_ERROR_EMAIL_ALREADY_TAKEN,
    ERROR_INVALID_CREDENTIALS=>MESSAGE_ERROR_INVALID_CREDENTIALS,
    ERROR_ACCOUNT_BANNED=>MESSAGE_ERROR_ACCOUNT_BANNED,
    ERROR_NOT_FOUND=>MESSAGE_ERROR_NOT_FOUND,
    ERROR_ALREADY_TAKEN=>MESSAGE_ERROR_ALREADY_TAKEN,
    ERROR_ACCOUNT_NOT_ACTIVE=>MESSAGE_ERROR_ACCOUNT_NOT_ACTIVE,
]);

define("MESSAGE_ERROR_IP_BANNED", "Your IP has been banned from visiting this GDPS");
define("MESSAGE_FORGOT_TO_EDIT_CONNECTION", "I think you forgor to edit yxzps\config\connection.php :skull:");

?>