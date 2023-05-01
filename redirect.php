<?php
require('./config.php');
# the createAuthUrl() method generates the login URL.
$login_url = $client->createAuthUrl();
/* 
 * After obtaining permission from the user,
 * Google will redirect to the login.php with the "code" query parameter.
*/
if (isset($_GET['code'])):

  session_start();
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  if(isset($token['error'])){
    header('Location: redirect.php');
    exit;
  }
  $_SESSION['token'] = $token;

  /* -- Inserting the user data into the database -- */

  # Fetching the user data from the google account
  $client->setAccessToken($token);
  $google_oauth = new Google_Service_Oauth2($client);
  $user_info = $google_oauth->userinfo->get();

  $google_id = trim($user_info['id']);
  $f_name = trim($user_info['given_name']);
  $l_name = trim($user_info['family_name']);
  $email = trim($user_info['email']);
  $gender = trim($user_info['gender']);
  $local = trim($user_info['local']);
  $picture = trim($user_info['picture']);

  $_SESSION['email'] = $email;
  $_SESSION['f_name'] = $f_name;
  $_SESSION['l_name'] = $l_name;

  require('connect-db.php');
  require('animalcrossing-db.php');

  if(checkEmail($email) == null){
    addUser($email, $f_name);
  }
  header('Location: index.php');
  exit;
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login with Google account</title>
  <style>
    .btn{
      display: flex;
      justify-content: center;
      padding: 50px;
    }
    a{
      all: unset;
      cursor: pointer;
      padding: 10px;
      display: flex;
      width: 250px;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      background-color: 
#f9f9f9;
      border: 1px solid 
rgba(0, 0, 0, .2);
      border-radius: 3px;
    }
    a:hover{
      background-color: 
#ffffff;
    }
    img{
      width: 50px;
      margin-right: 5px;
    
    }
  </style>
</head>
    <body>
      <?php
      require_once 'vendor/autoload.php';
      require("animalcrossing-db.php");

      //tutorial used
      //https://code.tutsplus.com/tutorials/create-a-google-login-page-in-php--cms-33214
      
      // init configuration 
      $clientID = '1030996000799-v7rf1j4npmoe45s4pt2kmnapumpdiid5.apps.googleusercontent.com';
      $clientSecret = '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';

      $redirectUri = 'http://localhost/cs4750/CS4750-AnimalCrossing/redirect.php';
        
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
        echo "<div style='margin-top:20%; margin-left: 38.5%;'><button style='height: 100px; width:300px; border-color: #51AD66; font-size: 32px; font-family: 'AC', Arial;'> <a style=''href='".$client->createAuthUrl()."'>Google Login</a></button></div>";
      }
      ?>
    </body>
</html>