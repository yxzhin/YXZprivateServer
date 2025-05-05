<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/GDConnector.go

// "и нормальный ответ преобразовывать в гдшный кал" (c) parturdev

class GDConnector{

    public static function accountRegister(string|int $result): int|string {

        if($result < 0)
        return $result;

        return "1";

    }

    public static function accountLogin(string|array|bool $result): int|string {

        if(is_array($result))
        return $result[0];

        if($result < 0)
        return $result;

        return $result.",".$result;

    }

    public static function getAccountInfo(Account $account, bool $me): string {

        $userName = $account->getPrefixedUserName();
        $rank = $account->getRank();
        $highest_role = $account->getHighestRole();
        $mod_badge_level = $highest_role->mod_badge_level;

        $data = [
            $userName,
            $account->accountID,
            $account->stats["stars"],
            $account->stats["demons"],
            "0", //5
            $rank,
            $account->accountID,
            $account->stats["creatorpoints"],
            $account->icons["icon"],
            $account->icons["color1"],
            $account->icons["color2"],
            "0", //12
            $account->stats["coins"],
            $account->icons["iconType"],
            $account->icons["special"],
            $account->accountID,
            $account->stats["userCoins"],
            $account->settings["mS"],
            $account->settings["frS"],
            $account->settings["yt"],
            $account->icons["accIcon"],
            $account->icons["accShip"],
            $account->icons["accBall"],
            $account->icons["accBird"],
            $account->icons["accDart"],
            $account->icons["accRobot"],
            "0", //27
            $account->icons["accGlow"],
            "1", //29
            $rank,
            "0", //31
            "0", //32
            "0", //33
            "0", //34
            "0", //35
            "0", //36
            "0", //37
            "0", //38 (37 in the code, new messages count)
            "0", //39 (38 in the code, new friend requests count)
            "0", //40 (39 in the code, new friends count)
            "0", //41
            "0", //42
            $account->icons["accSpider"],
            $account->settings["twitter"],
            $account->settings["twitch"],
            $account->stats["diamonds"],
            "0", //47
            $account->icons["accExplosion"],
            $mod_badge_level,
            $account->settings["cS"],
            $account->icons["color3"],
            $account->stats["moons"],
            $account->icons["accSwing"],
            $account->icons["accJetpack"],
            "7,3,7,3,7,3,7,3,7,3,7,3", // @TODO: demons
            "7,3,7,3,7,3,7,3", // @TODO: classicLevels
            "7,3,7,3,7,3", // @TODO: platformerLevels
        ];

        // apologize me for this, it's all because of
        // huinya that robtop did with account string structure :sob:
        if($me){

            $counts = $account->getNewNotificationsCounts();

            foreach($counts as $k=>$v)
            $data[37+array_search($k, array_keys($counts))] = $v;

        }

        $account_string = "";

        for($x = 1; $x < count($data)+1; ++$x)
        $account_string .= $x.":".$data[$x-1].":";

        $account_string = substr($account_string, 0, -1);

        return $account_string;

    }

    public static function getAccountComments(Account $account, int $page): string {

        if(!isset($account->accountID))
        return ERROR_NOT_FOUND;

        if($page < 0)
        return ERROR_GENERIC;

        $account_comments_array = $account->getAccountComments($page);

        $account_comments = $account_comments_array[0];
        $total_account_comments_count = $account_comments_array[1];
        $offset = $page*10;

        $account_comments_string = "";

        foreach($account_comments as $account_comment){

            $comment = urlencode(base64_encode($account_comment->comment));
            $likes = $account_comment->likes;
            $insertID = $account_comment->insertID;
            $time = Utils::getReadableTimeDifferenceFromUnixTimestamp($account_comment->time);
            $time = str_replace(" ago", "", $time);

            $account_comment_data = "2~{$comment}~4~{$likes}~6~{$insertID}~9~{$time}";
            $account_comments_string .= $account_comment_data."|";

        }

        $account_comments_string = substr($account_comments_string, 0, -1);
        $account_comments_string .= "#{$total_account_comments_count}:{$offset}:10";

        return $account_comments_string;

    }

    public static function backupAccount(string|bool $result): string {

        if($result < 0)
        return ERROR_GENERIC;

        return "1";

    }

}

?>