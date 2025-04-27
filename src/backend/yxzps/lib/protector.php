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

    public static function log_(string $ip, int $type, ?string $attrs=null, ?int $time=null){

        if(!$time) $time = time();

        DBManager::baseInsert([
            "ip"=>$ip,
            "type"=>$type,
            "attrs"=>$attrs,
            "time"=>$time,
        ], "logs");

    }

    public static function checkIfBanned(int $accountID=0, string $ip=""): bool|array {

        $query = CONN->prepare("SELECT count(*) FROM logs WHERE ip = :ip AND type = :type");
        $query->execute([":ip"=>$ip, ":type"=>LOG_FAILED_LOGIN_ATTEMPT_FROM_IP]);
        $login_attempts = $query->fetchColumn();

        if($login_attempts > MAX_LOGIN_ATTEMPTS_FROM_IP)
        // @TODO: temp bans
        return 1;

        [$var1, $var2] = ["accountID", $accountID];
        if(!empty($ip)) [$var1, $var2] = ["ip", $ip];

        $result = DBManager::baseSelect(["ban_time", "ban_ends_at"], "bans", $var1, $var2);

        if(!empty($result))
        return array($result["ban_time"], $result["ban_ends_at"]);

        return 0;

    }

    public static function checkGJP2(int $accountID, string $gjp2, string $ip): bool {

        $data = DBManager::baseSelect(["is_active", "gjp2"], "accounts", "accountID", $accountID);

        if(!$data["is_active"])
        return 0;

        $target_gjp2 = $data["gjp2"];

        if(!password_verify($gjp2, $target_gjp2)){

            self::log_($ip, LOG_FAILED_LOGIN_ATTEMPT_FROM_IP);
            return 0;

        }

        return 1;

    }

}

?>