<?php

require_once __DIR__."/../yxzps/yxzps.php";

if($_POST["secret"] !== "Wmfv3899gc9")
die("-1");

echo Account::login($_POST["userName"] ?? "", $_POST["gjp2"] ?? "");

?>