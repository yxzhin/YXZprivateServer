<?php

// ~~спизжено~~ вдохновлено https://github.com/FruitSpace/GDPSGhostCore/blob/master/src/core/connectors/JSONConnector.go

class JSONConnector{

    public static function accountLogin(int $accountID): string {

        return json_encode([
            "code"=>1,
            "message"=>"success",
            "data"=>[
                "accountID"=>$accountID,
            ],
        ]);

    }

}

?>