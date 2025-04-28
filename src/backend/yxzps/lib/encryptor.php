<?php

class Encryptor{

    public static function generateGJP2(string $password): string {

        return sha1($password."mI29fmAnxgTs");

    }

}

?>