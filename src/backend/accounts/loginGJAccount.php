<?php

require_once __DIR__."/../yxzps/yxzps.php";

if(!isset($_POST["secret"])
|| $_POST["secret"] !== "Wmfv3899gc9")
die("-1");

$result = Account::login($_POST["userName"] ?? "", $_POST["gjp2"] ?? "");

if(isset($_GET["json"]))
die(JSONConnector::accountLogin($result));

echo GDConnector::accountLogin($result);

?>