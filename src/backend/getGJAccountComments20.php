<?php

require_once __DIR__."/yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$accountID = $_POST["accountID"] ?? null;
$page = $_POST["page"] ?? null;

$account = new Account();
$account->load($accountID);

echo JSON ?
JSONConnector::getAccountComments($account, $page) :
GDConnector::getAccountComments($account, $page);

?>