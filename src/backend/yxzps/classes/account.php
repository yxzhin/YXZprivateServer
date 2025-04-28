<?php

class Account{

    public int $insertID;
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

        $this->insertID = $data["insertID"];
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

        if(!FILTER::filterUserName($userName)
        || !FILTER::filterPassword($password)
        || !FILTER::filterEmail($email))
        return ERROR_GENERIC;

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

        $insertID = CONN->lastInsertId();

        $attrs = json_encode([
            "insertID"=>$insertID,
            "accountID"=>$accountID,
            "userName"=>$userName,
        ]);

        PROTECTOR->log_($ip, LOG_ACCOUNT_REGISTERED, $attrs);

        return $accountID;

    }

    public static function login(string $userName, string $gjp2): string|array {

        if(!FILTER->filterUserName($userName))
        return ERROR_GENERIC;

        $ip = PROTECTOR->getIP();

        $accountID = self::getAccountIDFromUserName($userName);

        if(!PROTECTOR->checkGJP2($accountID, $gjp2)){

            PROTECTOR->log_($ip, LOG_FAILED_LOGIN_ATTEMPT_FROM_IP);
            
            $login_attempts = PROTECTOR->getFailedLoginAttemptsFromIP($ip);

            return array(ERROR_INVALID_CREDENTIALS, $login_attempts);

        }

        $ban = PROTECTOR->checkIfBanned(accountID:$accountID);

        if($ban)
        return array(ERROR_ACCOUNT_BANNED, $ban[0], $ban[1]);

        if(!self::isActive($accountID))
        return ERROR_ACCOUNT_NOT_ACTIVE;

        $attrs = json_encode([
            "accountID"=>$accountID,
            "userName"=>$userName,
        ]);

        PROTECTOR->log_($ip, LOG_ACCOUNT_LOGIN, $attrs);

        return $accountID;

    }

    public static function activate(string $userName, string $password, int $verification_code): string|bool {

        // @TODO

        return 1;

    }

    public static function getAccountIDFromUserName(string $userName): int {

        return DBManager::baseSelect(["accountID"], "accounts", "userName", $userName);

    }

    public static function isActive(int $accountID): bool {

        return DBManager::baseSelect(["is_active"], "accounts", "accountID", $accountID);

    }

}

?>