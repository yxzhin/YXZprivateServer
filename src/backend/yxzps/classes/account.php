<?php

class Account{

    public ?int $insertID;
    public int $accountID;
    public string $userName;
    public string $gjp2;
    public string $email;
    public string $ip;
    public ?int $clanID;
    public int $time;
    public bool $is_active;
    public array $stats;
    public array $icons;
    public array $settings;
    public array $roles;

    public function load(int $accountID): string {

        $data = DBManager::baseSelect(["*"], "accounts", "accountID", $accountID);

        if(empty($data))
        return ERROR_NOT_FOUND;

        $this->insertID = $data["insertID"];
        $this->accountID = $accountID;
        $this->userName = $data["userName"];
        $this->gjp2 = $data["gjp2"];
        $this->email = $data["email"];
        $this->ip = $data["ip"];
        $this->clanID = $data["clanID"];
        $this->time = $data["time"];
        $this->is_active = $data["is_active"];
        $this->stats = json_decode($data["stats"], true);
        $this->icons = json_decode($data["icons"], true);
        $this->settings = json_decode($data["settings"], true);
        $this->roles = json_decode($data["roles"], true);

        return SUCCESS;

    }

    public static function register(?string $userName, ?string $password, ?string $email): string|int {

        if(MAX_ACCOUNTS_PER_IP > 0
        && DBManager::baseSelect(["count(*)"], "accounts", "ip", IP) > MAX_ACCOUNTS_PER_IP)
        return ERROR_ACCOUNT_LIMIT_PER_IP_REACHED;

        if(!Filter::FilterUserName($userName)
        || !Filter::FilterPassword($password)
        || !Filter::FilterEmail($email))
        return ERROR_GENERIC;

        if(DBManager::baseSelect(["count(*)"], "accounts", "userName", $userName) > 0)
        return ERROR_USERNAME_ALREADY_TAKEN;

        if(DBManager::baseSelect(["count(*)"], "accounts", "email", $email) > 0)
        return ERROR_EMAIL_ALREADY_TAKEN;

        $accountID = random_int(100000000, 999999999);
        $gjp2 = password_hash(Encryptor::generateGJP2($password), PASSWORD_BCRYPT);
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
            "ip"=>IP,
            "time"=>$time,
            "stats"=>$stats,
            "icons"=>$icons,
            "settings"=>$settings,
            "roles"=>$roles,
        ], "accounts");

        $insertID = CONN->lastInsertId();

        $attrs = [
            "insertID"=>$insertID,
            "accountID"=>$accountID,
            "userName"=>$userName,
        ];

        Protector::log_(LOG_ACCOUNT_REGISTERED, $attrs);

        return $accountID;

    }

    public static function login(?string $gjp2, ?string $userName=null,
        ?int $accountID=null, bool $return_success=false): string|array|bool {

        [$userName_passed, $accountID_passed] = [!empty($userName), !empty($accountID)];

        if(!$userName_passed
        && !$accountID_passed)
        return ERROR_GENERIC;

        if($userName_passed
        && !Filter::FilterUserName($userName))
        return ERROR_GENERIC;

        if($accountID_passed
        && !Filter::filterAccountID($accountID))
        return ERROR_GENERIC;

        if(!$accountID_passed)
        $accountID = DBManager::baseSelect(["accountID"], "accounts", "userName", $userName);

        $target_userName = DBManager::baseSelect(["userName"], "accounts", "accountID", $accountID);

        if(!Encryptor::checkGJP2($accountID, $gjp2)
        || $userName_passed
        && $target_userName != $userName){

            Protector::log_(LOG_FAILED_LOGIN_ATTEMPT_FROM_IP);
            
            $login_attempts = Protector::getFailedLoginAttempts();

            return array(ERROR_INVALID_CREDENTIALS, $login_attempts);

        }

        $ban = Protector::checkIfBanned(accountID:$accountID);

        if($ban)
        return array(ERROR_ACCOUNT_BANNED, $ban[0], $ban[1]);

        $is_active = DBManager::baseSelect(["is_active"], "accounts", "accountID", $accountID);
        
        if(!$is_active)
        return ERROR_ACCOUNT_NOT_ACTIVE;

        if(DEBUG_MODE){

            $attrs = [
                "accountID"=>$accountID,
                "userName"=>$userName,
            ];

            Protector::log_(LOG_ACCOUNT_LOGIN, $attrs);

        }

        if($return_success)
        return SUCCESS;

        return $userName_passed ? $accountID : $userName;

    }

    public static function activate(string $userName, string $password, int $verification_code): string {

        // @TODO



        return SUCCESS;

    }

    public function updateAccountInfo(array $new_stats=array(), array $new_icons=array(),
        array $new_settings=array()): int {

        $accountID = $this->accountID;
        [$stats, $icons, $settings] = [$this->stats, $this->icons, $this->settings];

        foreach($new_stats as $k=>$v)
        $stats[$k] = $v;

        foreach($new_icons as $k=>$v)
        $icons[$k] = $v;

        foreach($new_settings as $k=>$v)
        $settings[$k] = $v;

        [$stats, $icons, $settings] = [json_encode($stats), json_encode($icons), json_encode($settings)];

        $query = CONN->prepare("UPDATE accounts
        SET stats = :stats, icons = :icons, settings = :settings
        WHERE accountID = :accountID");
        
        $query->execute([":stats"=>$stats, ":icons"=>$icons, ":settings"=>$settings,
        ":accountID"=>$accountID]);

        return $accountID;

    }

    public function backupAccount(string $save_data): string|bool {

        if(empty($save_data))
        return ERROR_GENERIC;

        $accountID = $this->accountID;

        switch(ACCOUNTS_SAVE_TYPE){

            case 1:
                
                $path = __DIR__."/../data/accounts/{$accountID}";
                file_put_contents($path, $save_data);
                break;

            case 2:

                $time = time();

                if(DBManager::baseSelect(["count(*)"], "save_data", "account_or_levelID", $accountID)){

                    $query = CONN->prepare("UPDATE save_data SET
                    save_data = :save_data,
                    time = :time
                    WHERE account_or_levelID = :account_or_levelID");
                    $query->execute([":save_data"=>$save_data, ":time"=>$time, ":account_or_levelID"=>$accountID]);
                
                } else {

                    $data=[
                        "account_or_levelID"=>$accountID,
                        "save_data"=>$save_data,
                        "time"=>$time,
                    ];

                    DBManager::baseInsert($data, "save_data");

                }

                break;

            default: return ERROR_GENERIC;

        }

        $save_data_size = $path ? filesize($path) : mb_strlen($save_data, "UTF-8");;

        $attrs = [
            "accountID"=>$accountID,
            "save_data_size"=>$save_data_size,
        ];

        Protector::log_(LOG_ACCOUNT_BACKUP, $attrs);

        return $save_data_size;

    }

    public function syncAccount(): string|bool {

        $accountID = $this->accountID;

        switch(ACCOUNTS_SAVE_TYPE){

            case 1:
                
                $path = __DIR__."/../data/accounts/{$accountID}";

                if(!file_exists($path))
                return ERROR_GENERIC;

                $save_data = file_get_contents($path);

                break;

            case 2:

                $save_data = DBManager::baseSelect(["save_data"], "save_data", "account_or_levelID", $accountID);

                if(empty($save_data))
                return ERROR_GENERIC;

                break;

            default: return ERROR_GENERIC;

        }

        $game_version = $_POST["gameVersion"];
        $binary_version = $_POST["binaryVersion"];

        $rated_levels = "aa"; //@TODO //gzdeflate(join(",", $rated_levels));
        $map_packs = "aa"; //@TODO //gzdeflate(join(",", $map_packs));

        $save_data = $save_data.";".$game_version.";".$binary_version.";".$rated_levels.";".$map_packs;

        $attrs = [
            "accountID"=>$accountID,
        ];

        Protector::log_(LOG_ACCOUNT_SYNC, $attrs);

        return $save_data;

    }

    public function getRank(int $type=1 //1=global/top100, 2=friends, 3=creators
        ): int {

        if($type == 1){

            [$stars, $moons] = [$this->stats["stars"], $this->stats["moons"]];

            $ranking_type_stars = "JSON_EXTRACT(stats, \"$.stars\")";
            $ranking_type_moons = "JSON_EXTRACT(stats, \"$.moons\")";

            switch(LEADERBOARD_RANKING_TYPE){

                case 2: $ranking_type = $ranking_type_stars; $value = $stars; break;
                case 3: $ranking_type = $ranking_type_moons; $value = $moons; break;
                default: $ranking_type = $ranking_type_stars." + ".$ranking_type_moons;
                $value = $stars + $moons; break;
        
            }

            $sql = "SELECT count(*) FROM accounts
            WHERE {$ranking_type} > :value
            AND is_active = 1";

        }

        $query = CONN->prepare($sql);
        $query->execute([":value"=>$value]);
        $rank = $query->fetchColumn()+1;

        return $rank;

    }

    public function getHighestRole(): Role {
        
        $highest_role = new Role();
        $highest_role->load(DEFAULT_ROLE_ID);

        if(!in_array(DEFAULT_ROLE_ID, $this->roles)){

            $roles = json_encode($this->roles);
            $accountID = $this->accountID;

            array_unshift($this->roles, DEFAULT_ROLE_ID);

            $query = CONN->prepare("UPDATE accounts SET roles = :roles WHERE accountID = :accountID");
            $query->execute([":roles"=>$roles, ":accountID"=>$accountID]);

        };

        foreach($this->roles as $roleID){

            if($roleID == DEFAULT_ROLE_ID)
            continue;

            $role = new Role();
            if($role->load($roleID) < 0)
            continue;

            if($role->priority > $highest_role->priority)
            $highest_role->load($roleID);

        }

        return $highest_role;

    }

    public function getPrefixedUserName(): string {

        $highest_role = $this->getHighestRole();
        $role_prefix = !empty($highest_role->display_name) ? " [".$highest_role->display_name."]" : "";

        $clan = new Clan();
        $clan->load($this->clanID);
        $clan_prefix = isset($clan->clan_tag) ? "[".$clan->clan_tag."] " : "";

        $userName = $this->userName;
        $prefixedUserName = $clan_prefix.$userName.$role_prefix;

        return $prefixedUserName;

    }

    public function getNewNotificationsCounts(): array {

        $query = CONN->prepare("SELECT
        IFNULL((SELECT count(*) FROM messages
        WHERE is_new = 1
        AND target_accountID = :target_accountID), 0)
        AS new_messages_count,
        IFNULL((SELECT count(*) FROM friend_requests
        WHERE is_new = 1
        AND target_accountID = :target_accountID), 0)
        AS new_friend_requests_count,
        IFNULL((SELECT count(*) FROM friends
        WHERE is_new = 1
        AND target_accountID = :target_accountID
        OR accountID = :target_accountID), 0)
        AS new_friends_count");

        $query->execute(["target_accountID"=>$this->accountID]);
        $counts = $query->fetch(PDO::FETCH_ASSOC);

        return $counts;

    }

    public function getAccountComments(int $page): array {

        $empty = array(array(), 0);

        if($page < 0)
        return $empty;

        $account_comments = array();
        $accountID = $this->accountID;
        $offset = $page*10;

        $query = CONN->prepare("SELECT count(*) FROM comments
        WHERE accountID = :accountID
        AND level_or_listID IS NULL");

        $query->execute([":accountID"=>$accountID]);
        $total_account_comments_count = $query->fetchColumn();

        if($total_account_comments_count == 0)
        return $empty;

        $query = CONN->prepare("SELECT insertID FROM comments
        WHERE accountID = :accountID
        AND level_or_listID IS NULL
        ORDER BY time DESC
        LIMIT {$offset}, 10");

        $query->execute([":accountID"=>$accountID]);
        $raw_account_comments_ids = $query->fetchAll();

        foreach($raw_account_comments_ids as $raw_account_comment_id){

            $account_comment_id = $raw_account_comment_id["insertID"]; 
            $account_comment = new Comment();
            $account_comment->load($account_comment_id);

            array_push($account_comments, $account_comment);

        }

        return array($account_comments, $total_account_comments_count);

    }

}

?>