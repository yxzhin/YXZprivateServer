<?php

require_once __DIR__."/yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die(JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC);

$accountID = $_POST["accountID"] ?? null;
$target_accountID = $_POST["targetAccountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$me = $accountID == $target_accountID;
$account->load($target_accountID);

echo JSON ?
JSONConnector::getAccountInfo($account, $me) :
GDConnector::getAccountInfo($account, $me);

?>