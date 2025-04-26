<?php

class Filter{

    public function baseNotIssetOrEmptyCheck(array $vars, array $empty_check_exceptions=array()): bool {

        foreach($vars as $k){
            if(!isset($_POST[$k])
            || empty($_POST[$k])
            && !in_array($k, $empty_check_exceptions))
            return 0;
        }
        
        return 1;

    }

    public function containsSpecialChars(string $var, string $exceptions=""): int|bool {

        return preg_match("/[^A-Za-z0-9{$exceptions} ]/", $var);

    }

    public function checkSecret(string $secret, string $endpoint_name): bool {

        $secrets = array(
            "registerGJAccount.php"=>"Wmfv3899gc9",
        );

        $target_secret = Utils::array_get($secrets, $endpoint_name);

        if(empty($target_secret))
        return 1;

        return $secret === $target_secret;

    }

}

?>