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

}

?>