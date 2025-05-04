<?php

require_once __DIR__."/yxzps/yxzps.php";

$error_generic = JSON ?
JSONConnector::errorGeneric() :
ERROR_GENERIC;

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfd2893gb7"
|| !Protector::checkGameAndBinaryVersion())
die($error_generic);

$stats_keys = [
    "stars", "moons", "demons", "diamonds", "coins", "userCoins",
];

$icons_keys = [
    "icon", "color1", "color2", "color3", "iconType", "special",
    "accIcon", "accShip", "accBall", "accBird", "accDart", "accRobot",
    "accGlow", "accSpider", "accExplosion", "accSwing", "accJetpack",
];

[$stats, $icons] = [array(), array()];

$postfields = array_merge($stats_keys, $icons_keys);

foreach($postfields as $postfield){

    $check = $postfield == "color3" ?
    Filter::baseFilterInt($_POST[$postfield], -1) :
    Filter::baseFilterInt($_POST[$postfield]);

    if(!isset($_POST[$postfield])
    || !$check)
    die($error_generic);

    if(in_array($postfield, $stats_keys))
    $stats[$postfield] = $_POST[$postfield];

    elseif(in_array($postfield, $icons_keys))
    $icons[$postfield] = $_POST[$postfield];

}

$gjp2 = $_POST["gjp2"] ?? "";
$userName = $_POST["userName"] ?? "";
$accountID = $_POST["accountID"] ?? null;

$account = new Account();

$result = $account->login($gjp2, $userName, $accountID, true);

if($result != SUCCESS)
die(JSON ?
JSONConnector::accountLogin($result) :
GDConnector::accountLogin($result));

$account->load($accountID);

$result = $account->updateAccountInfo(new_stats:$stats, new_icons:$icons);

echo JSON ?
JSONConnector::success() :
$result;

?>