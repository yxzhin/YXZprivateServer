<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/JSONConnector.go

class JSONConnector{

    public static function baseJson(int $code, string $message, ?array $data=null): string {

        header('Content-Type: application/json; charset=utf-8');

        $json = [
            "code"=>$code,
            "message"=>$message,
        ];

        if($data) $json["data"] = $data;

        return json_encode($json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    }

    public static function success(?array $data=null): string {

        return self::baseJson(SUCCESS, MESSAGE_SUCCESS, $data);

    }

    public static function errorGeneric(): string {

        return self::baseJson(ERROR_GENERIC, MESSAGE_ERROR_GENERIC);

    }

    public static function notFound(?array $data=null): string {

        return self::baseJson(ERROR_NOT_FOUND, MESSAGE_ERROR_NOT_FOUND, $data);

    }

    public static function accountRegister(int|string $result): string {

        $message = Utils::getErrorMessageFromErrorCode($result);

        if(!$message)
        return self::success();

        return self::baseJson($result, $message);

    }

    public static function accountLogin(int|string|array $result): string {

        if(is_array($result)){

            if($result[0] == ERROR_ACCOUNT_BANNED)
            return self::baseJson($result[0], MESSAGE_ERROR_ACCOUNT_BANNED, [
                "ban_time"=>$result[1],
                "ban_ends_at"=>$result[2],
            ]);

            if($result[0] == ERROR_INVALID_CREDENTIALS)
            return self::baseJson($result[0], MESSAGE_ERROR_INVALID_CREDENTIALS, [
                "login_attempts_from_ip_left"=>MAX_LOGIN_ATTEMPTS_FROM_IP-$result[1]+1,
            ]);

        }

        $message = Utils::getErrorMessageFromErrorCode($result);

        if(!$message)
        return self::success([
            "accountID"=>$result,
        ]);

        return self::baseJson($result, $message);

    }

    public static function getAccountInfo(Account $account, bool $me): string {

        if(!isset($account->accountID))
        return self::notFound(["accountID"=>null]);

        $data = [
            "rank"=>$account->getRank(),
            "userName"=>$account->getPrefixedUserName(),
            "registration_time"=>Utils::getReadableTimeDifferenceFromUnixTimestamp($account->time),
            "stats"=>$account->stats,
            "icons"=>$account->icons,
            "settings"=>$account->settings,
            "roles"=>$account->roles,
        ];

        if($me){

            $data["new_messages_count"] = 2147483647; // @TODO: messages
            $data["new_friend_requests_count"] = 2147483647; // @TODO: friendRequests
            $data["new_friends_count"] = 2147483647; // @TODO: newFriends

        }

        return self::success($data);

    }

}

?>