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

        $rank = $account->getRank();
        $userName = $account->getPrefixedUserName();
        $registration_time = Utils::getReadableTimeDifferenceFromUnixTimestamp($account->time);

        $data = [
            "rank"=>$rank,
            "userName"=>$userName,
            "registration_time"=>$registration_time,
            "stats"=>$account->stats,
            "icons"=>$account->icons,
            "settings"=>$account->settings,
            "roles"=>$account->roles,
        ];

        $counts = $account->getNewNotificationsCounts();
        // okay this doesn't look that bad in comparison to the gdconnector one :sob:
        if($me)
        foreach($counts as $k=>$v)
        $data[$k] = $v;

        return self::success($data);

    }

    public static function getAccountComments(Account $account, int $page): string {

        if(!isset($account->accountID))
        return self::notFound(["accountID"=>null]);
        
        if($page < 0)
        return self::errorGeneric();

        $account_comments_array = $account->getAccountComments($page);

        $account_comments = $account_comments_array[0];
        $total_account_comments_count = $account_comments_array[1];

        $data = [
            "total_account_comments_count"=>$total_account_comments_count,
            "page"=>$page,
            "account_comments"=>array(),
        ];

        foreach($account_comments as $account_comment){

            $comment = $account_comment->comment;
            $likes = $account_comment->likes;
            $upload_time = Utils::getReadableTimeDifferenceFromUnixTimestamp($account_comment->time);
            $insertID = $account_comment->insertID;

            $account_comment_data = [
                "comment"=>$comment,
                "likes"=>$likes,
                "upload_time"=>$upload_time,
            ];

            $data["account_comments"][$insertID] = $account_comment_data;

        }

        return self::success($data);

    }

}

?>