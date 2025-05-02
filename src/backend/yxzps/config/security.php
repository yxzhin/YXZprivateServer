<?php

// 1=save into the yxzps\data folder, 2=save into the database
define("ACCOUNTS_SAVE_TYPE", 1);
define("LEVELS_SAVE_TYPE", 1);

// change this if needed
// currently only 2.2 (22) is supported
define("GMD_VERSION", 22);
// binary versions example: 2.2074=45, 2.207=44, 2.206=43, 2.205=42 etc.
define("GMD_BINARY_VERSIONS", [45, 44, 43, 42, 41, 40, 39, 38, 37, 36]);

// will run cron once in given time in seconds (3600=one hour)
define("CRON_COOLDOWN", 3600);

// 0=infinite
define("MAX_ACCOUNTS_PER_IP", 2);

define("MAX_LOGIN_ATTEMPTS_FROM_IP", 5);

?>