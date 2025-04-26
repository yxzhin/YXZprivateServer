<?php

require_once __DIR__."/../yxzps/yxzps.php";

if(!FILTER->baseNotIssetOrEmptyCheck(["userName", "password", "email", "secret"]))
die("-1");

if(!FILTER->checkSecret($_POST["secret"], basename(__FILE__)))
die("-1");

$result = Account::register($_POST["userName"], $_POST["password"], $_POST["email"]);
if($result < 0) die($result);
echo "1";

?>