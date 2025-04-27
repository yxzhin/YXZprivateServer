<?php

require_once __DIR__."/../yxzps/yxzps.php";

if($_POST["secret"] !== "Wmfv3899gc9")
die("-1");

$result = Account::register($_POST["userName"] ?? "", $_POST["password"] ?? "", $_POST["email"] ?? "");
if($result < 0) die($result);
echo "1";

?>