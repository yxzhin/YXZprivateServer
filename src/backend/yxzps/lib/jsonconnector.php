<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/JSONConnector.go

class JSONConnector{

    public static function accountRegister(int|string $result): string {

        $message = Utils::array_get(MESSAGES, $result);

        if(!$message)
        return json_encode([
            "code"=>1,
            "message"=>"success",
        ]);

        return json_encode([
            "code"=>(int)$result,
            "message"=>$message,
        ]);

    }

    public static function accountLogin(int|string|array $result): string {

        if(is_array($result)){

            if($result[0] == ERROR_ACCOUNT_BANNED)
            return json_encode([
                "code"=>$result[0],
                "message"=>MESSAGE_ERROR_ACCOUNT_BANNED,
                "data"=>[
                    "ban_time"=>$result[1],
                    "ban_ends_at"=>$result[2],
                ],
            ]);

            if($result[0] == ERROR_INVALID_CREDENTIALS)
            return json_encode([
                "code"=>$result[0],
                "message"=>MESSAGE_ERROR_INVALID_CREDENTIALS,
                "data"=>[
                    "login_attempts_from_ip_left"=>MAX_LOGIN_ATTEMPTS_FROM_IP-$result[1]+1,
                ],
            ]);

        }

        $message = Utils::array_get(MESSAGES, $result);

        if(!$message)
        return json_encode([
            "code"=>1,
            "message"=>"success",
            "data"=>[
                "accountID"=>$result,
            ],
        ]);

        return json_encode([
            "code"=>(int)$result,
            "message"=>$message,
        ]);

    }

}

?>