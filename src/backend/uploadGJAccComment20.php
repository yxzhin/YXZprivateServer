<?php

require_once __DIR__."/yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";
$userName = $_POST["userName"] ?? "";
$comment = $_POST["comment"] ?? "";

$account = new Account();

$result = $account->login($gjp2, $userName, $accountID, true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$account->load($accountID);

$result = $account->uploadAccountComment($comment);

echo JSON ?
JSONConnector::uploadAccountComment($result) :
$result;

?>