<?php

require_once __DIR__."/yxzps/yxzps.php";

$error_generic = JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC;

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9")
die($error_generic);

$states = [
    "mS", "frS", "cS",
];

$links = [
    "yt", "twitter", "twitch",
];

$settings = array();

foreach($states as $state){

    $check = $state == "frS" ?
    Filter::baseFilterInt($_POST[$state], 0, 1) :
    Filter::baseFilterInt($_POST[$state], 0, 2);
    
    if(!isset($_POST[$state])
    || !$check)
    die($error_generic);

    $settings[$state] = $_POST[$state];

}

foreach($links as $link){

    $check = $link == "twitter" ?
    strlen($_POST[$link]) <= 20 :
    strlen($_POST[$link]) <= 30;

    if(!isset($_POST[$link])
    || !$check
    || !Filter::baseFilterString($_POST[$link], ["_", "\-", "'", "."]))
    die($error_generic);

    $settings[$link] = $_POST[$link];

}

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$account->load($accountID);

$account->updateAccountInfo(new_settings:$settings);

echo JSON ?
JSONConnector::success() :
"1";

?>