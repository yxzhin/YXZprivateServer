<?php

require_once __DIR__."/yxzps/yxzps.php";

$error_generic = JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC;

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die($error_generic);

if(!isset($_POST["rewardType"])
|| !filter::baseFilterInt($_POST["rewardType"], 0, 2))
die($error_generic);

$reward_type = $_POST["rewardType"];

if(!isset($_POST["chk"])
|| empty($_POST["chk"]))
die($error_generic);

$chk_decoded = Encryptor::decodeCHK(substr($_POST["chk"], 5), CHK_KEY_REWARDS);

if(!Filter::baseFilterInt($chk_decoded, 100000, 999999))
die($error_generic);

if(!isset($_POST["udid"])
|| empty($_POST["udid"]))
die($error_generic);

$udid = $_POST["udid"];

$accountID = $_POST["accountID"] ?? null;
$gjp2 = $_POST["gjp2"] ?? "";

$account = new Account();

$result = $account->login(accountID:$accountID, gjp2:$gjp2, return_success:true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$account->load($accountID);

$time = time();

$chest1_time = $account->stats["chest1_time"];
$chest1_time_remaining = CHEST1_COOLDOWN - ($time - $chest1_time);
if($chest1_time_remaining < 0) $chest1_time_remaining = 0;

$chest2_time = $account->stats["chest2_time"];
$chest2_time_remaining = CHEST2_COOLDOWN - ($time - $chest2_time);
if($chest2_time_remaining < 0) $chest2_time_remaining = 0;

$chest1_count = $account->stats["chest1_count"];
$chest2_count = $account->stats["chest2_count"];

$chest1_rewards = [
    "orbs"=>random_int(CHEST1_MIN_ORBS, CHEST1_MAX_ORBS),
    "diamonds"=>random_int(CHEST1_MIN_DIAMONDS, CHEST1_MAX_DIAMONDS),
    "items"=>CHEST1_ITEMS[array_rand(CHEST1_ITEMS)],
    "keys"=>random_int(CHEST1_MIN_KEYS, CHEST1_MAX_KEYS),
];

$chest2_rewards = [
    "orbs"=>random_int(CHEST2_MIN_ORBS, CHEST2_MAX_ORBS),
    "diamonds"=>random_int(CHEST2_MIN_DIAMONDS, CHEST2_MAX_DIAMONDS),
    "items"=>CHEST2_ITEMS[array_rand(CHEST2_ITEMS)],
    "keys"=>random_int(CHEST2_MIN_KEYS, CHEST2_MAX_KEYS),
];

switch($reward_type){

    case 1:

        if($chest1_time_remaining != 0)
        break;
        
        ++$chest1_count;
        $account->updateAccountInfo(["chest1_count"=>$chest1_count, "chest1_time"=>$time]);
    
        break;
    
    case 2:

        if($chest2_time_remaining != 0)
        break;
        
        ++$chest2_count;
        $account->updateAccountInfo(["chest2_count"=>$chest2_count, "chest2_time"=>$time]);
        
        break;

    default: break;

}

$values = [
    $accountID,
    $chk_decoded,
    $udid,
    $accountID,
    $chest1_time_remaining,
    $chest1_rewards,
    $chest1_count,
    $chest2_time_remaining,
    $chest2_rewards,
    $chest2_count,
    $reward_type,
];

echo JSON ?
JSONConnector::getChestsRewards($values) :
GDConnector::getChestsRewards($values);

?>