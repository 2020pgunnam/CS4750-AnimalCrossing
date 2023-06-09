<?php
require_once "config.php";
require('connect-db.php');
require('animalcrossing-db.php');
session_start();
?>
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
  <link rel="icon" type="image/png" href="assets/leaf.png" />

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
          <a href="index.php"> <img src="assets/leaf.png" class="d-inline-block ms-5 pb-2" style="width:30px; height:40px;" alt="Nookazaon 2.0"/>
          <a href="index.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Nookazon 2.0</a>
          <?php if(isset($_SESSION['token'])) {
                      ?><a href="show_inventory.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Inventory</a><?php
                  }
              ?>
          <?php if(isset($_SESSION['token'])) {
                      ?><a href="show_listings.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Listings</a><?php
                  }
              ?>
          <a href="show_items.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Items</a>
          <?php if(isset($_SESSION['token'])) {
                      ?><a href="Profile.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Profile</a><?php
                  }
              ?>
          <?php if(isset($_SESSION['token'])) {
                      ?><a href="logout.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Logout</a><?php
                  }
              ?>
          <?php if(!isset($_SESSION['token'])) {
                      ?><a href="redirect.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Login</a><?php
                  }
              ?>
          <div class="header_moon" style= "margin-left: 0px;" onclick="setDarkMode()" aria-label="Toggle Dark Mode">
              <i class='bx bx-moon'></i>
            </div>
          </header>
          <body>
            <div class="page_intro intro">
                <div class="intro_container container">
                  <div class="intro_body">
                    <div class="intro_content" style= "margin-top: 10%;">
                      <h1 class="intro_title"> <b style="color: #ad8751;">Welcome<span2>_</span2>to</b>
                      <h1 class="intro_title" style="font-family: 'AC', Arial; color:#51AD66;"> <span>Nookazon</span><span2>_</span2><span>2.0</span></h1>
                      <h1 class="intro_position" style="color: #ad8751;"> The Best Animal Crossing Database</h1>
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
