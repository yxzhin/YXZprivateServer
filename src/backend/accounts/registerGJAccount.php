<?php

require_once __DIR__."/../yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9")
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$result = Account::register($_POST["userName"] ?? "", $_POST["password"] ?? "", $_POST["email"] ?? "");

die(JSON ?
JSONConnector::accountRegister($result) :
GDConnector::accountRegister($result));

?>