<?php

class Clan{

    public int $insertID;
    public int $clanID;
    public string $clanName;
    public string $clanTag;
    public ?array $members;
    public int $ownerID;
    public ?array $levels;
    public int $time;

    public function load(int $clanID){
        
        $data = DBManager::baseSelect(["*"], "clans", "clanID", $clanID);

        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $data["insertID"];
        $this->clanID = $clanID;
        $this->clanName = $data["clanName"];
        $this->clanTag = $data["clanTag"];
        $this->members = $data["members"];
        $this->ownerID = $data["ownerID"];
        $this->levels = $data["levels"];
        $this->time = $data["time"];

        return SUCCESS;

    }

}

?>