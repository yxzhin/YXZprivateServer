<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/GDConnector.go

// "и нормальный ответ преобразовывать в гдшный кал" (c) parturdev

class GDConnector{

    public static function accountLogin(int $accountID): string {

        return $accountID.",".$accountID;

    }

}

?>