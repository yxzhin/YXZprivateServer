<?php

class Encryptor{

    public function generateGJP2(string $password): string {

        return sha1($password."mI29fmAnxgTs");

    }

}

?>