<?php

class Cron{

    public function createDefaultRoleIfNotExists(): bool {

        return Role::create(DEFAULT_ROLE_ID, "Player");

    }

    public function createReuploadAccountIfNotExists(): int|bool {

        $password = (string)rand(100000,999999);
        $email = $password."@reupload.yxzps";
        $accountID = Account::register("Reupload", $password, $email);

        if($accountID > 0) Account::activate("Reupload", $password, 123456);

        return $accountID;

    }

    public function perform(): bool {

        $path = __DIR__."/../data/cronlastrun.txt";
        if(!file_exists($path)) file_put_contents($path, "0");
        $last_run_time = file_get_contents($path);

        if(time() - $last_run_time < CRON_COOLDOWN)
        return 0;

        $this->createDefaultRoleIfNotExists();
        $this->createReuploadAccountIfNotExists();

        $last_run_time = time();
        file_put_contents($path, $last_run_time);

        return 1;

    }

}

?>