<?php

define("SALT_GJP2", "mI29fmAnxgTs");
define("SALT_HASH_REWARDS", "pC26fpYaQCtg");

define("CHK_KEY_REWARDS", 59182);

define("KEY_MESSAGE", 14251);

class Encryptor{

    public static function generateGJP2(string $password): string {

        return sha1($password.SALT_GJP2);

    }

    public static function checkGJP2(int $accountID, string $gjp2): bool {

        $target_gjp2 = DBManager::baseSelect(["gjp2"], "accounts", "accountID", $accountID);

        if(!password_verify($gjp2, $target_gjp2))
        return 0;

        return 1;

    }

    public static function generateHash(string $string, string $salt): string {

        return sha1($string.$salt);

    }

    public static function decodeCHK(string $chk, int $key): int|string {

        return XORCipher::cipher(base64_decode(urldecode($chk)), $key);

    }

    public static function randomString(int $length): string {

        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $random_string = "";
        
        for ($x = 0; $x < $length; ++$x)
        $random_string .= $characters[random_int(0, strlen($characters) - 1)];
        
        return $random_string;

    }

}

?>