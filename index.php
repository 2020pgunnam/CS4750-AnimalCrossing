<?php 
// Include configuration file 
require_once 'config.php'; 
 
// Include User library file 
require_once 'User.class.php'; 
 
if(isset($_GET['code'])){ 
    $gClient->authenticate($_GET['code']); 
    $_SESSION['token'] = $gClient->getAccessToken(); 
    header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL)); 
} 
 
if(isset($_SESSION['token'])){ 
    $gClient->setAccessToken($_SESSION['token']); 
} 
 
if($gClient->getAccessToken()){ 
    // Get user profile data from google 
    $gpUserProfile = $google_oauthV2->userinfo->get(); 
     
    // Initialize User class 
    $user = new User(); 
     
    // Getting user profile info 
    $gpUserData = array(); 
    $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:''; 
    $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:''; 
    $gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:''; 
    $gpUserData['email']       = !empty($gpUserProfile['email'])?$gpUserProfile['email']:''; 
    $gpUserData['gender']       = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:''; 
    $gpUserData['locale']       = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:''; 
    $gpUserData['picture']       = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:''; 
     
    // Insert or update user data to the database 
    $gpUserData['oauth_provider'] = 'google'; 
    $userData = $user->checkUser($gpUserData); 
     
    // Storing user data in the session 
    $_SESSION['userData'] = $userData; 
     
    // Render user profile data 
    if(!empty($userData)){ 
        $output     = '<h2>Google Account Details</h2>'; 
        $output .= '<div class="ac-data">'; 
        $output .= '<img src="'.$userData['picture'].'">'; 
        $output .= '<p><b>Google ID:</b> '.$userData['oauth_uid'].'</p>'; 
        $output .= '<p><b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'</p>'; 
        $output .= '<p><b>Email:</b> '.$userData['email'].'</p>'; 
        $output .= '<p><b>Gender:</b> '.$userData['gender'].'</p>'; 
        $output .= '<p><b>Locale:</b> '.$userData['locale'].'</p>'; 
        $output .= '<p><b>Logged in with:</b> Google Account</p>'; 
        $output .= '<p>Logout from <a href="logout.php">Google</a></p>'; 
        $output .= '</div>'; 
    }else{ 
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>'; 
    } 
}else{ 
    // Get login url 
    $authUrl = $gClient->createAuthUrl(); 
     
    // Render google login button 
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>'; 
} 
?>

<div class="container">
    <!-- Display login button / Google profile information -->
    <?php echo $output; ?>
</div>



<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href='css/style.css'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<html lang = "en">
<head>
  <meta charset="UTF-8">

  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--
  Bootstrap is designed to be responsive to mobile.
  Mobile-first styles are part of the core framework.

  width=device-width sets the width of the page to follow the screen-width
  initial-scale=1 sets the initial zoom level when the page is first loaded
  -->

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Nookazon 2.0</title>

<!-- 3. link bootstrap -->
  <!-- if you choose to use CDN for CSS bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- you may also use W3's formats -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->

  <!--
  Use a link tag to link an external resource.
  A rel (relationship) specifies relationship between the current document and the linked resource.
  -->

  <!-- If you choose to use a favicon, specify the destination of the resource in href -->
  <link rel="icon" type="image/png" href="/assets/leaf.png" />

  <!-- if you choose to download bootstrap and host it locally -->
  <!-- <link rel="stylesheet" href="path-to-your-file/bootstrap.min.css" /> -->

  <!-- include your CSS -->
  <!-- <link rel="stylesheet" href="custom.css" />  -->

</head>

<body>

<script>
    if (localStorage.darkMode) document.documentElement.setAttribute("darkMode", localStorage.darkMode)
</script>

<header class = "headBlock">
      <div>
          <!-- <a href="/main/" -->
          <a href=""> <img src="assets/leaf.png" class="d-inline-block ms-5 pb-2" style="width:30px; height:40px;" alt="Nookazaon 2.0" />
          <a href="" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Nookazon 2.0</a>
          <a href="show_inventory.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Inventory</a>
          <a href="show_listings.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Listings</a>
          <a href="show_items.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Items</a>
          <a href="profile.html" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Profile</a>
          
          <?php if(!isset($_SESSION['login_id'])); ?>
            <a href="logout.php" class= "a_links" style = "margin-top: 3px; margin-right: 5px;"></i> Logout</a>
          <?php
            if(isset($_SESSION['login_id']));?>
            <a href="redirect.php" class= "a_links" style = "margin-top: 3px; margin-right: 5px;"></i> Login</a>

          

          <div class="header_moon" style= "margin-left: 0px;" onclick="setDarkMode()" aria-label="Toggle Dark Mode">

              <i class='bx bx-moon'></i>
            </div>
          </header>
          <body>
            <div class="page_intro intro">
                <div class="intro_container container">
                  <div class="intro_body">
                    <div class="intro_content" style= "margin-top: 10%;">
                      <h1 class="intro_title"> <b>Welcome to </b> <span>Nookazon<span2>_</span2>2.0<span></h1>
                      <h1 class="intro_position"> The Best Animal Crossing Database</h1>
                      <br1>
                      <div class="typewriter">
                        <div class = "static"> Look for </div>
                        <ul class="types">
                            <li><span>Buyers</span></li>
                            <li><span>Sellers</span></li>
                            <li><span>Items</span></li>
                            <li><span>Listings</span></li>
                            <li><span>Users</span></li>
                        </ul>
                    </div>
                </div>
                  <!-- <a href="show_listings.php">Click to view listings</a>
                  <a href="show_inventory.php">Click to view inventory</a>
                  <a href ="redirect.php">Log in/Sign up!</a> {% endcomment %} -->
            </div>
            <div class = "intro_img">
              <img src="assets/AC.png">
          </div>
            </div>
            </div>
          </div>
          </body>
        </div>
      </div>

      <body>
        <h1> errr </h1>
        <?php echo $id ?>
        <?php echo $aaa ?>
</body>

<!-- <div class="container">
  <h1>Animal Crossing</h1>

  <a href="show_listings.php">Click to view listings</a>
  <a href="show_inventory.php">Click to view inventory</a>
  <a href ="redirect.php">Log in/Sign up!</a> -->





  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->

</div>
<script>
  let darkMode = localStorage.getItem('darkMode');
  let darkToggle = document.querySelector('.header_moon');
  let bodyToggle = document.querySelector('body');

  if (darkMode && darkMode === '1') {
      bodyToggle.classList.add('night');
      darkToggle.classList.add('is-active');
  }

      darkToggle.onclick = function() {
      bodyToggle.classList.toggle('night');
      darkToggle.classList.toggle('is-active');
      if (darkMode) {
          if (darkMode === '1') {
              localStorage.setItem('darkMode', '0');
          } else {
              localStorage.setItem('darkMode', '1');
          }
      } else {
          localStorage.setItem('darkMode', '1');
      }
};

</script>

</body>
</html>
