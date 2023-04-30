
<?php
/*
session_start();
session_regenerate_id(true);
// change the information according to your database
$db_connection = mysqli_connect("localhost","root","","google_login");
// CHECK DATABASE CONNECTION
if(mysqli_connect_errno()){
    echo "Connection Failed".mysqli_connect_error();
    exit;
}
*/

// Database configuration
define('DB_HOST', 'MySQL_Database_Host');
define('DB_USERNAME', 'MySQL_Database_Username');
define('DB_PASSWORD', 'MySQL_Database_Password');
define('DB_NAME', 'MySQL_Database_Name');
define('DB_USER_TBL', 'users');

// Google API configuration
define('GOOGLE_CLIENT_ID', '1030996000799-v7rf1j4npmoe45s4pt2kmnapumpdiid5.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'http://localhost/CS4750-AnimalCrossing/index.php');

// Start session
if(!session_id()){
    session_start();
}

// Include Google API client library
//require_once 'google-api-php-client-2.4.0/Google_Client.php';
//require_once 'google-api-php-client/contrib/Google_Oauth2Service.php';

// Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId(GOOGLE_CLIENT_ID);
$gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
$gClient->setRedirectUri(GOOGLE_REDIRECT_URL);

$google_oauthV2 = new Google_Oauth2Service($gClient);

