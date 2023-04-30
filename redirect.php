<?php
require_once 'vendor/autoload.php';
require("animalcrossing-db.php");

//tutorial used
//https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214
 
// init configuration 
$clientID = '1030996000799-v7rf1j4npmoe45s4pt2kmnapumpdiid5.apps.googleusercontent.com';
$clientSecret = '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';

$redirectUri = 'http://localhost/CS4750-AnimalCrossing/';
  
// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow 
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info 
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  if(selectUser($email) == null){
    addUser($email, $name);
  }
 
  // now you can use this profile info to create account in your website and make user logged in. 
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>