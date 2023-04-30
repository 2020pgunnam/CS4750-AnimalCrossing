<?php
require_once 'vendor/autoload.php';
require("animalcrossing-db.php");

// Database configuration
define('DB_HOST', 'MySQL_Database_Host');
define('DB_USERNAME', 'MySQL_Database_Username');
define('DB_PASSWORD', 'MySQL_Database_Password');
define('DB_NAME', 'MySQL_Database_Name');
define('DB_USER_TBL', 'users');

if(!session_id()){
  session_start();
}
$id = session_id();


//tutorial used
//https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214
 
// init configuration 
$clientID = '1030996000799-v7rf1j4npmoe45s4pt2kmnapumpdiid5.apps.googleusercontent.com';
$clientSecret = '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';

$redirectUri = 'http://localhost/CS4750-AnimalCrossing/index.php';
  
// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow 
if (isset($_GET['code'])) {
  print('aaaa');
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $_SESSION["token"] = $client->setAccessToken($token['access_token']);
  
  // get profile info 
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  if(selectUser($email) == null){
    addUser($email, $name);
  }
  $_SESSION["test"] = "something else";
    
  
 
  // now you can use this profile info to create account in your website and make user logged in. 
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>