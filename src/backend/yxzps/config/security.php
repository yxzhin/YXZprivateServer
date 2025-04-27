<?php

// 1=save into the yxzps\data folder, 2=save into the database
define("ACCOUNTS_SAVE_TYPE", 1);
define("LEVELS_SAVE_TYPE", 1);

// change this if needed
// currently only 2.2 (22) is supported
define("GD_VERSIONS", [22]);
// binary versions example: 2.207=44, 2.206=43, 2.205=42 etc.
define("GD_BINARY_VERSIONS", [44, 43, 42, 41, 40, 39, 38, 37, 36]);

// will run cron once in given time in seconds (3600=one hour)
define("CRON_COOLDOWN", 3600);

?>