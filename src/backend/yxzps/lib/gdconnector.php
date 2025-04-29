<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/GDConnector.go

// "и нормальный ответ преобразовывать в гдшный кал" (c) parturdev

class GDConnector{

    public static function accountRegister(int|string $result): int|string {

        if($result < 0)
        return $result;

        return "1";

    }

    public static function accountLogin(int|string|array $result): int|string {

        if(is_array($result))
        return $result[0];

        if($result < 0)
        return $result;

        return $result.",".$result;

    }

    public static function getAccountInfo(Account $account, bool $me): string {

        $data = [
            $account->getPrefixedUserName(),
            $account->accountID,
            $account->stats["stars"],
            $account->stats["demons"],
            "0", //5
            $account->getRank(),
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
            $account->getRank(), // @TODO: ranking
            "0", //31
            "0", //32
            "0", //33
            "0", //34
            "0", //35
            "0", //36
            "0", //37
            "0", //38
            "0", //39
            "0", //40
            "0", //41
            "0", //42
            $account->icons["accSpider"],
            $account->settings["twitter"],
            $account->settings["twitch"],
            $account->stats["diamonds"],
            "0", //47
            $account->icons["accExplosion"],
            "2", // @TODO: modLevel
            $account->settings["cS"],
            $account->icons["color3"],
            $account->stats["moons"],
            $account->icons["accSwing"],
            $account->icons["accJetpack"],
            "7,3,7,3,7,3,7,3,7,3,7,3", // @TODO: demons
            "7,3,7,3,7,3,7,3", // @TODO: classicLevels
            "7,3,7,3,7,3", // @TODO: platformerLevels
        ];

        if($me){

            $data[37] = 2147483647; // @TODO: messages
            $data[38] = 2147483647; // @TODO: friendRequests
            $data[39] = 2147483647; // @TODO: newFriends
            
        }

        $account_string = "";

        for($x = 1; $x < count($data)+1; ++$x)
        $account_string .= $x.":".$data[$x-1].":";

        $account_string = substr($account_string, 0, -1);

        return $account_string;

    }

}

?>