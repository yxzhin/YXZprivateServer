<?php

class Encryptor{

    public static function generateGJP2(string $password): string {

        return sha1($password."mI29fmAnxgTs");

    }

    public static function checkGJP2(int $accountID, string $gjp2): bool {

        $target_gjp2 = DBManager::baseSelect(["gjp2"], "accounts", "accountID", $accountID);

        if(!password_verify($gjp2, $target_gjp2))
        return 0;

        return 1;

    }

}

?>