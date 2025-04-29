<?php

require_once __DIR__."/../yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9")
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$account = new Account();
$result = $account->login(userName:$_POST["userName"] ?? "", gjp2:$_POST["gjp2"] ?? "");

die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

?>