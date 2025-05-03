<?php

define("SUCCESS", 1);

// errors
define("ERROR_GENERIC", "-1");
define("ERROR_USERNAME_ALREADY_TAKEN", "-2");
define("ERROR_EMAIL_ALREADY_TAKEN", "-3");
define("ERROR_INVALID_CREDENTIALS", "-11");
define("ERROR_ACCOUNT_BANNED", "-12");
define("ERROR_NOT_FOUND", "-404");
define("ERROR_ALREADY_TAKEN", "-100");
define("ERROR_ACCOUNT_NOT_ACTIVE", "-101");
define("ERROR_IP_BANNED", "-102");
define("ERROR_ACCOUNT_LIMIT_PER_IP_REACHED", "-103");

// logs
define("LOG_ACCOUNT_REGISTERED", 100000);
define("LOG_ACCOUNT_LOGIN", 100001);
define("LOG_FAILED_LOGIN_ATTEMPT_FROM_IP", 100002);
define("LOG_ACCOUNT_TEMP_BANNED", 100003);
define("LOG_ACCOUNT_PERM_BANNED", 100004);
define("LOG_ACCOUNT_BACKUP", 100005);
define("LOG_ACCOUNT_SYNC", 100006);
define("LOG_ROLE_CREATED", 101000);
define("LOG_ROLE_GRANTED", 101001);
define("LOG_CRON_DONE", 102000);

// defaults
define("DEFAULT_STATS", [
    "stars"=>0, "moons"=>0, "demons"=>0, "coins"=>0,
    "userCoins"=>0, "diamonds"=>0, "creatorpoints"=>0,
    "chest1_time"=>0, "chest2_time"=>0, "chest1_count"=>0, "chest2_count"=>0,
]);
define("DEFAULT_ICONS", [
    "icon"=>0, "iconType"=>0, "color1"=>0, "color2"=>3, "color3"=>0, "special"=>0,
    "accIcon"=>0, "accShip"=>0, "accBall"=>0, "accBird"=>0, "accDart"=>0, "accRobot"=>0,
    "accSpider"=>0, "accSwing"=>0, "accJetpack"=>0, "accGlow"=>0, "accExplosion"=>0,
]);
define("DEFAULT_SETTINGS", [ // straight people left the default settings :skull:
    "mS"=>0, "frS"=>0, "cS"=>0,
    "yt"=>"", "twitter"=>"", "twitch"=>"",
]);

define("DEFAULT_ROLE_ID", 1);

// @TODO
define("DEFAULT_PERMS_COMMANDS", [
    "1"=>1,
]);
define("DEFAULT_PERMS_ACTIONS", [
    "2"=>2,
]);
define("DEFAULT_PERMS_DASHBOARD", [
    "3"=>3,
]);

// do not change these
define("YXZPS_BACKEND_VERSION", "0.1.0_beta");
define("YXZPS_DB_VERSION", "0.1.0_beta");

?>