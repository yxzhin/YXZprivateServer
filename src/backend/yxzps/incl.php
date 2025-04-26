<?php

require_once __DIR__."/const.php";

require_once __DIR__."/config/chests.php";
require_once __DIR__."/config/connection.php";
require_once __DIR__."/config/dashboard.php";
require_once __DIR__."/config/discord.php";
require_once __DIR__."/config/mail.php";
require_once __DIR__."/config/security.php";

require_once __DIR__."/lang/".LANG.".php";

require_once __DIR__."/lib/cron.php";
require_once __DIR__."/lib/dbmanager.php";
require_once __DIR__."/lib/encryptor.php";
require_once __DIR__."/lib/filter.php";
require_once __DIR__."/lib/gdconnector.php";
require_once __DIR__."/lib/jsonconnector.php";
require_once __DIR__."/lib/protector.php";
require_once __DIR__."/lib/utils.php";

require_once __DIR__."/classes/account.php";
require_once __DIR__."/classes/role.php";

?>