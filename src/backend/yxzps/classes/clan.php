<?php

class Clan{

    public int $insertID;
    public int $clanID;
    public string $clan_name;
    public string $clan_tag;
    public int $ownerID;
    public ?array $levels;
    public int $time;

    public function load(?int $clanID): string {
        
        $data = DBManager::baseSelect(["*"], "clans", "clanID", $clanID);

        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $data["insertID"];
        $this->clanID = $clanID;
        $this->clan_name = $data["clan_name"];
        $this->clan_tag = $data["clan_tag"];
        $this->ownerID = $data["ownerID"];
        $this->levels = $data["levels"];
        $this->time = $data["time"];

        return SUCCESS;

    }

}

?>