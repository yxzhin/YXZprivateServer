<?php

class Account{

    public int $accountID;
    public string $userName;
    public string $gjp2;
    public string $email;
    public string $ip;
    public int $time;
    public bool $is_active;
    public string $stats;
    public string $icons;
    public string $settings;
    public string $roles;

    function __construct(int $accountID){

        $data = DBManager::baseSelect(["*"], "accounts", "accountID", $accountID);

        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->accountID = $accountID;
        $this->userName = $data["userName"];
        $this->gjp2 = $data["gjp2"];
        $this->email = $data["email"];
        $this->ip = $data["ip"];
        $this->time = $data["time"];
        $this->is_active = $data["is_active"];
        $this->stats = json_decode($data["stats"], true);
        $this->icons = json_decode($data["icons"], true);
        $this->settings = json_decode($data["settings"], true);
        $this->roles = json_decode($data["roles"], true);

    }

    public static function register(string $userName, string $password, string $email): string|int {

        if(strlen($userName) > 20)
        return ERROR_USERNAME_TOO_LONG;

        if(strlen($userName) < 3)
        return ERROR_USERNAME_TOO_SHORT;

        if(FILTER->containsSpecialChars($userName, "_\-"))
        return ERROR_GENERIC;

        if(strlen($password) < 6)
        return ERROR_PASSWORD_TOO_SHORT;

        if(strlen($password) > 255)
        return ERROR_PASSWORD_TOO_LONG;

        if(strlen($email) < 5
        || strlen($email) > 255
        || !filter_var($email, FILTER_VALIDATE_EMAIL))
        return ERROR_INVALID_EMAIL;

        if(DBManager::baseSelect(["count(*)"], "accounts", "userName", $userName) > 0)
        return ERROR_USERNAME_ALREADY_TAKEN;

        if(DBManager::baseSelect(["count(*)"], "accounts", "email", $email) > 0)
        return ERROR_EMAIL_ALREADY_TAKEN;

        while(true){
            $accountID = rand(1000000, 9999999);
            if(empty(DBManager::baseSelect(["count(*)"], "accounts", "accountID", $accountID)))
            break;
        }

        $gjp2 = password_hash(ENCRYPTOR->generateGJP2($password), PASSWORD_BCRYPT);
        $ip = PROTECTOR->getIP();
        $time = time();

        $stats = json_encode(DEFAULT_STATS);
        $icons = json_encode(DEFAULT_ICONS);
        $settings = json_encode(DEFAULT_SETTINGS);
        $roles = json_encode([DEFAULT_ROLE_ID]);

        $attrs = json_encode([
            "accountID"=>$accountID,
            "userName"=>$userName,
        ]);

        //боже как же это красиво, я выйду за эту функцию
        DBManager::baseInsert([
            "accountID"=>$accountID,
            "userName"=>$userName,
            "gjp2"=>$gjp2,
            "email"=>$email,
            "ip"=>$ip,
            "time"=>$time,
            "stats"=>$stats,
            "icons"=>$icons,
            "settings"=>$settings,
            "roles"=>$roles,
        ], "accounts");

        DBManager::baseInsert([
            "ip"=>$ip,
            "type"=>LOG_ACCOUNT_REGISTERED,
            "attrs"=>$attrs,
            "time"=>$time,
        ], "logs");

        return $accountID;

    }

    public static function activate(string $userName, string $password, int $verification_code): string|bool {

        // @TODO

        return 1;

    }

}

?>