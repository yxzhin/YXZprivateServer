<?php

class FriendRequest{

    public int $insertID;
    public int $accountID;
    public int $target_accountID;
    public string $message;
    public int $time;
    public bool $is_new;

    public function load(int $insertID): string {

        $data = DBManager::baseSelect(["*"], "friend_requests", "insertID", $insertID);
        
        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $insertID;
        $this->accountID = $data["accountID"];
        $this->target_accountID = $data["target_accountID"];
        $this->message = $data["message"];
        $this->time = $data["time"];
        $this->is_new = $data["is_new"];

        return SUCCESS;

    }

}

?>