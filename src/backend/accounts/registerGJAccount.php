<?php

require_once __DIR__."/../yxzps/yxzps.php";

Utils::debug_print_post(true);

if(!FILTER->baseNotIssetOrEmptyCheck(["userName", "password", "email", "secret"]))
die("-1");

if(!FILTER->checkSecret($_POST["secret"], basename(__FILE__)))
die("-1");

echo Account::register($_POST["userName"], $_POST["password"], $_POST["email"])

?>