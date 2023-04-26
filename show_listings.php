
<?php
require("connect-db.php");
// include("connect-db.php");

require("animalcrossing-db.php");

$listings = selectAllListings();
// var_dump($listings)


?>
<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<link href ="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link href ="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script defer src ="https://code.jquery.com/jquery-3.5.1.js"></script>
<script defer src ="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src ="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src ="js/script.js"></script>

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
  <link rel="icon" type="image/png" href="/assets/leaf.png" />
</head>
    <script>
        if (localStorage.darkMode) document.documentElement.setAttribute("darkMode", localStorage.darkMode)
    </script>

    <header class = "headBlock">
        <div>
            <!-- <a href="/main/" -->
            <a href="index.html"> <img src="assets/leaf.png" class="d-inline-block ms-5 pb-2" style="width:30px; height:40px;" alt="Nookazaon 2.0" />
            <a href="index.html" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Nookazon 2.0</a>
            <a href="show_inventory.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Inventory</a>
            <a href="show_listings.html" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Listings</a>
            <a href="show_items.php" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Items</a>
            <a href="profile.html" class="a_links" style= "margin-top: 3px; margin-right: 5px;"></i>Profile</a>
            <a href="" class= "a_links" style = "margin-top: 3px; margin-right: 5px;"></i> Login/Sign Up</a>
            <div class="header_moon" style= "margin-left: 0px;" onclick="setDarkMode()" aria-label="Toggle Dark Mode">
                <i class='bx bx-moon'></i>
              </div>
            </header>
    <body>
        <!-- https://datatables.net/examples/styling/bootstrap5.html-->
        <div class = "table_container">
            <table id="listings" class="table-table-responsive table-striped table-bordered table-hover table-sm" style="width:100%;">
    </div>

            <thead>
              <tr>
                <th class="th-sm">Item ID
                </th>
                <th class="th-sm">Item Selling Price
                </th>
                <th class="th-sm">Name
                </th>
                <th class="th-sm">Rating
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listings as $item): ?>
                <tr>
                  <td><?php echo $item['itemID']; ?></td>
                  <td><?php echo $item['itemSellingPrice']; ?></td>
                  <td><?php echo $item['userName']; ?></td>
                  <td><?php echo $item['userRating']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Item Name</th>
                <th>Item Selling Price</th>
                <th>Name</th>
                <th>Rating</th>
              </tr>
            </tfoot>
          </table>
          <script>
            $(document).ready(function(){
                $('#listings').dataTable();
            });
            </script>
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
