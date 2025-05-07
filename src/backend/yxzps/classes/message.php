<?php

class Message{

    public int $insertID;
    public int $accountID;
    public int $target_accountID;
    public string $title;
    public string $content;
    public int $time;
    public bool $is_new;

    public function load(int $insertID): string {

        $data = DBManager::baseSelect(["*"], "messages", "insertID", $insertID);
        
        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $insertID;
        $this->accountID = $data["accountID"];
        $this->target_accountID = $data["target_accountID"];
        $this->title = $data["title"];
        $this->content = $data["content"];
        $this->time = $data["time"];
        $this->is_new = $data["is_new"];

        return SUCCESS;

    }

}

?>