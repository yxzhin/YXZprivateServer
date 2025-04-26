<?php

class Protector{

    public static function getIP(): string {

        // thx to https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor

        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;

    }

    public static function checkIfBanned(int $accountID=0, string $ip=""): bool|array {

        [$var1, $var2] = ["accountID", $accountID];
        if(!empty($ip)) [$var1, $var2] = ["ip", $ip];

        $result = DBManager::baseSelect(["ban_time", "ban_ends_at"], "bans", $var1, $var2);

        if(!empty($result))
        return array($result["ban_time"], $result["ban_ends_at"]);

        return 0;

    }

}

?>