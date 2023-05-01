<?php
session_start();
?>
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
  <meta name="author" content="Edmund Chen, Emily Yao, Eevie Chon, Prateek Gunnam, Yejung Jeong">
  <meta name="description" content="include some description about your page">

  <title>Nookazon 2.0</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="assets/leaf.png" />
</head>
    <script>
        if (localStorage.darkMode) document.documentElement.setAttribute("darkMode", localStorage.darkMode)
    </script>

    <header class = "headBlock">
        <div>
            <!-- <a href="/main/" -->
            <a href="./"> <img src="assets/leaf.png" class="d-inline-block ms-5 pb-2" style="width:30px; height:40px;" alt="Nookazaon 2.0" />
            <a href="./" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Nookazon 2.0</a>
            <a href="show_inventory.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Inventory</a>
            <a href="show_listings.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Listings</a>
            <a href="show_items.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Items</a>
            <a href="profile.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Profile</a>
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

<div class="profileBorder">
    <h1 class="text-center" style="margin-top: 10px;"> Aloha
    <?php if(isset($_SESSION['login_id'])); {
        // echo $_SESSION["hello"];
        //THIS PLACE HOLDER TEXT TO SEE IF IT WORKS, REPLACE WITH THE CODE ABOVE AT THE END
        echo "hello";
    }
    ?>
</h1>

<form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
  <fieldset>
                    <!-- Form Name -->
      <legend>Form Name</legend>
      <!-- File Button -->
      <div class="form-group">
          <label class="col-md-4 control-label" for="filebutton">Select File</label>
          <div class="col-md-4">
              <input type="file" name="file" id="file" class="input-large">
          </div>
      </div>
      <!-- Button -->
      <div class="form-group">
          <label class="col-md-4 control-label" for="singlebutton">Import data</label>
          <div class="col-md-4">
              <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
          </div>
      </div>
  </fieldset>
  <!-- <div class="btn btn-success"  style= "left: 52%; margin-top: 10px;">
      Import
  </div> -->
  <div class="btn btn-success"  style= "left: 42%; margin-top: 10px; margin-bottom: 50px;">
        <input type="submit" name="Export" value="Export"/>
  </div>
</form>
    <br>
    <br>
    <br>
    <br>
    <p class='my-1 fw-bold d-inline-block'>Email: Placeholder</a> </p>
    <br>
    <p class='my-1 fw-bold d-inline-block'> <b>Listings: </b> the goods</p>
    <br>
    <p class='my-1 d-inline-block'> <b> Wishlist: </b> i want</p>
    </div>

            </div>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

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
