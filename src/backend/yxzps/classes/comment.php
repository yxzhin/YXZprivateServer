<?php

class Comment{

    public int $insertID;
    public int $accountID;
    public ?int $level_or_listID;
    public string $comment;
    public int $likes;
    public int $time;
    public ?int $percent;

    public function load(int $insertID): string {

        $data = DBManager::baseSelect(["*"], "comments", "insertID", $insertID);
        
        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $insertID;
        $this->accountID = $data["accountID"];
        $this->level_or_listID = $data["level_or_listID"];
        $this->comment = $data["comment"];
        $this->likes = $data["likes"];
        $this->time = $data["time"];
        $this->percent = $data["percent"];

        return SUCCESS;

    }

}

?>