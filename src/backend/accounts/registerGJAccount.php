<?php

require_once __DIR__."/../yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9")
die("-1");

$result = Account::register($_POST["userName"] ?? "", $_POST["password"] ?? "", $_POST["email"] ?? "");

if(isset($_GET["json"]))
die(JSONConnector::accountRegister($result));

echo GDConnector::accountRegister($result);

?>