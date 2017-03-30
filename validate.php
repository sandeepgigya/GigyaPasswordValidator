<?php

require_once("includes/config.php");

$plainPass = $_POST['plainpass'];
$hashedPass = $_POST['hashedpass'];
$salt = $_POST['salt'];
$rounds = $_POST['rounds'];
$saltRequired = $_POST['requiredSalt'];
$urlRequired = $_POST['requiredURL'];
$url = $_POST['url'];
$algorithm = $_POST['algorithm'];
$passEncType = $_POST['passEncType'];
$saltEncType = $_POST['saltEncType'];
$passwordFormat = urldecode($_POST['passwordFormat']);
$passToHash = str_replace('$password', $plainPass, $passwordFormat);
$passToHash = str_replace('$salt', $salt, $passToHash);


if(!isset($algorithm)) { echo ""; exit; }

$validate = $algorithms[$algorithm]->validate($passToHash, $plainPass, $hashedPass, $salt, $passwordFormat, $rounds, $passEncType, $saltEncType, $url);

if($validate)
{
	$template = $algorithms[$algorithm]->getTemplate();
}

$response = array();
$response["valid"] = $validate;
if(!empty($template))
{
	$response["template"] = $template;
}
header("Content-Type: application/json");
echo json_encode($response);
exit;