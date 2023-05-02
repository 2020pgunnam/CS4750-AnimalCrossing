<?php
require('./vendor/autoload.php');

# Add your client ID and Secret
$client_id = "1030996000799-v7rf1j4npmoe45s4pt2kmnapumpdiid5.apps.googleusercontent.com";
$client_secret = "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";

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);

# redirection location is the path to login.php
$redirect_uri = 'http://localhost:81/CS4750-AnimalCrossing/redirect.php';
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
?>