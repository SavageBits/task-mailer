<?php

if (strpos($_SERVER['HTTP_HOST'],'localhost') !== false) {
	$usr = "root";
	$pwd = "root";
	$db = "daily_checklist";
	$host = "localhost";
} else {
	$usr = "savageb3";
	$pwd = "asdfBlue1!";
	$db = "savageb3_daily-checklist";
	$host = "localhost";
}

?>