<?php

class Filter{

    public static function filterUserName(string $userName): bool {

        $userName = strip_tags(trim($userName));

        return !empty($userName)
        && strlen($userName) >= 3
        && strlen($userName) <= 15;

    }

    public static function filterPassword(string $password): bool {

        $password = strip_tags(trim($password), ["_", "-"]);

        return !empty($password)
        && strlen($password) >= 6
        && strlen($password) <= 20;

    }

    public static function filterEmail(string $email): bool {

        $email = strip_tags(trim($email), ["@", ".", "_", "-"]);

        return !empty($email)
        && strlen($email) >= 5
        && strlen($email) <= 50
        && filter_var($email, FILTER_VALIDATE_EMAIL);

    }

}

?>