<?php

class Cron{

    public static function createDefaultRoleIfNotExists(): string {
        
        return Role::create(DEFAULT_ROLE_ID, "Player");

    }

    public static function createReuploadAccountIfNotExists(): string|int {

        $password = (string)random_int(100000,999999);
        $email = $password."@reupload.yxzps";
        $accountID = Account::register("Reupload", $password, $email);

        if($accountID > 0) Account::activate("Reupload", $password, 123456);

        return $accountID;

    }

    public static function perform(): bool {

        $path = __DIR__."/../data/cronlastrun.txt";
        if(!file_exists($path)) file_put_contents($path, "0");
        $last_run_time = file_get_contents($path);

        if(time() - $last_run_time < CRON_COOLDOWN)
        return 0;

        $createDefaultRoleIfNotExists = self::createDefaultRoleIfNotExists();
        $createReuploadAccountIfNotExists = self::createReuploadAccountIfNotExists();

        $last_run_time = time();
        file_put_contents($path, $last_run_time);

        $attrs = json_encode([
            "createDefaultRoleIfNotExists"=>$createDefaultRoleIfNotExists,
            "createReuploadAccountIfNotExists"=>$createReuploadAccountIfNotExists,
        ]);

        PROTECTOR::log_(LOG_CRON_DONE, $attrs, $last_run_time);

        return 1;

    }

}

?>