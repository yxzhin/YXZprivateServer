<?php

require_once __DIR__."/yxzps/yxzps.php";

$error_generic = JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC;

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die($error_generic);

if(!isset($_POST["page"])
|| !Filter::baseFilterInt($_POST["page"]))
die($error_generic);

$page = $_POST["page"];
$sent_only = isset($_POST["getSent"]) ? true : false;

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$account->load($accountID);

echo JSON ?
JSONConnector::getMessages($account, $page, $sent_only) :
GDConnector::getMessages($account, $page, $sent_only);

?>