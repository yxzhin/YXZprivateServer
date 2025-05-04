<?php

class Filter{

    public static function baseFilterString(?string $var, ?array $exceptions=null): bool {

        $exceptions = $exceptions ? join("", $exceptions) : "";

        return !preg_match("/[^A-Za-z0-9{$exceptions}]/", $var);
     
    }

    public static function baseFilterInt(?int $var, int $min_range=0, int $max_range=2147483647): bool {

        $options = [ 
            "options"=>[
                "min_range"=>$min_range,
                "max_range"=>$max_range,
            ],
        ];

        return filter_var($var, FILTER_VALIDATE_INT, $options) !== false;

    }

    public static function filterAccountID(?int $accountID): bool {

        if($accountID == 71)
        return 1; // robtop's ID, you can setup an account with his ID for colored acc comments lol

        return self::baseFilterInt($accountID, 100000000, 999999999);

    }

    public static function filterUserName(?string $userName): bool {

        if(!self::baseFilterString($userName))
        return 0;

        return strlen($userName) >= 3
        && strlen($userName) <= 15;

    }

    public static function filterPassword(?string $password): bool {

        $password = strip_tags(trim($password), );

        return strlen($password) >= 6
        && strlen($password) <= 20;

    }

    public static function filterEmail(?string $email): bool {

        if(!self::baseFilterString($email, ["@", ".", "_", "\-"]))
        return 0;

        return strlen($email) >= 5
        && strlen($email) <= 50
        && filter_var($email, FILTER_VALIDATE_EMAIL);

    }

}

?>