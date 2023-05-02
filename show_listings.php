
<?php
require_once "config.php";
require('connect-db.php');
require('animalcrossing-db.php');
session_start();
$userID = $_SESSION['email'];
$userName = $_SESSION['f_name'];
$listings = selectAllListings();
// var_dump($listings)
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update Listing"))
  {
    updateListing($_POST['item_listing_to_update'], $userID, $_POST['sellingPrice']);
    $listings = selectAllListings();
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Buy Listing"))
  {
    //addtoBuys($userID, $userName, $_POST['item_to_buy'], $_POST['seller_buy_from'], $_POST['item_to_buy'], $_POST['price_bought']);
    if(findInventoryFromItemID($userID, $_POST['item_to_buy']) == null){
      insertIntoInventory($userID, $_POST['item_to_buy'], 1);
    }
    else
    {
      incrementItemCountInventory($userID, $_POST['item_to_buy']);
    }
    if(findInventoryFromItemID($_POST['seller_buy_from'], $_POST['item_to_buy']) != null){
      if(findInventoryFromItemID($_POST['seller_buy_from'], $_POST['item_to_buy'])['itemCount'] == 1){
        removeFromInventory($_POST['seller_buy_from'], $_POST['item_to_buy']);
      }
      else
      {
        decrementItemCountInventory($_POST['seller_buy_from'], $_POST['item_to_buy']);
      }
    }
    deleteListing($_POST['item_to_buy'], $_POST['seller_buy_from']);
   
    $listings = selectAllListings();
  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete Listing"))
  {
    deleteListing($_POST['item_listing_to_delete'], $userID);
    $listings = selectAllListings();
  }
}

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
  <link rel="icon" type="image/png" href="assets/leaf.png" />
</head>
    <script>
        if (localStorage.darkMode) document.documentElement.setAttribute("darkMode", localStorage.darkMode)
    </script>

    <header class = "headBlock">
      <div>
          <!-- <a href="/main/" -->
          <a href="index.php"> <img src="assets/leaf.png" class="d-inline-block ms-5 pb-2" style="width:30px; height:40px;" alt="Nookazaon 2.0" />
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

        <div class= "table_container">
        <table id="inventory" class="table table-striped table-bordered table-hover table-sm" cellspacing="0" width="100%">
            <thead>
              <tr>
              <th class="th-sm">Image
                </th>
                <th class="th-sm">Item Name
                </th>
                <th class="th-sm">Item Selling Price
                </th>
                <th class="th-sm">Name
                </th>
                <th class="th-sm">Rating
                </th>
                <th class="th-sm">Buy/Edit Listing
                </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listings as $item): ?>
                <?php $itemID = getItemIDByItemName($item['itemName']);?>
                <?php $sellerID = $item['userID'];?>
                <?php $listingPrice = getListingPriceByUserItem($userID, $itemID);  ?>
                <?php $listingID = getListingIDBySellerItem($sellerID, $itemID); ?>
                <tr>
                  <td><img src=<?php echo $item['itemImageURL'];?> width="150px"></td>
                  <td><?php echo $item['itemName']; ?></td>
                  <td><?php echo $item['itemSellingPrice']; ?></td>
                  <td><?php echo $item['userName']; ?></td>
                  <td><?php echo $item['userRating']; ?></td>
                <?php if($userID!=$item['userID']) { ?>
                    <td>
                      <form action="show_listings.php" method="post">
                        <input type="submit" name="actionBtn" value="Buy Listing" class="btn btn-dark"/>
                        <input type="hidden" name="listing_to_buy" value="<?php echo $listingID; ?>"/>
                        <input type="hidden" name="item_to_buy" value="<?php echo $itemID; ?>"/>
                        <input type="hidden" name="seller_buy_from" value="<?php echo $sellerID; ?>"/>
                        <input type="hidden" name="price_bought" value="<?php echo $item['itemSellingPrice']; ?>"/>
                      </form>
                    </td>
                  <?php } else { ?>
                    <td>
                      <form action="show_listings.php" method=post>
                        <input type="number" class="form-control" name="sellingPrice" value="<?php echo $listingPrice; ?>"/>
                        <input type="submit" name="actionBtn" value="Update Listing" class="btn btn-dark"/>
                        <input type="hidden" name="item_listing_to_update" value="<?php echo $itemID; ?>"/>
                      </form>
                      <form action="show_listings.php" method=post>
                        <input type="submit" name="actionBtn" value="Delete Listing" class="btn btn-dark"/>
                        <input type="hidden" name="item_listing_to_delete" value="<?php echo $itemID; ?>"/>
                      </form>
                    </td>
                  <?php } ?>
                  </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Image</th>
                <th>Item Name</th>
                <th>Item Selling Price</th>
                <th>Name</th>
                <th>Rating</th>
              </tr>
            </tfoot>
          </table>
          <script>
            $('#sortTable').DataTable();
            </script>
            </div>

            <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
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
