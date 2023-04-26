<?php
require("connect-db.php");
// include("connect-db.php");

require("animalcrossing-db.php");

$inventory = selectInventory('7aceOfSpades');
$userID = getUserIDByUserName('7aceOfSpades');

// var_dump($userID);
// $inventory = null
// $sellingPrices = null
// $name = null
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update Listing"))
    {
      updateListing($_POST['item_listing_to_update'], $userID, $_POST['price_listing_to_update']);
      $inventory = selectInventory('7aceOfSpades');
    }
    else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Create Listing"))
    {
      addListing($_POST['item_listing_to_create'], $userID, $_POST['price_listing_to_create']);
      $inventory = selectInventory('7aceOfSpades');
    }
    else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete Listing"))
    {
      deleteListing($_POST['listing_to_delete'], $userID);
      $inventory = selectInventory('7aceOfSpades');
    }
}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Inventory</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

</head>

<body>
<div class="container">
  <h1>Inventory</h1>

  <form name="mainForm" action="simpleform.php" method="get">
  <div class="row mb-3 mx-3">
    7aceOfSpades
    <!-- echo $name -->
  </div>

  </form>

<div class="row justify-content-center">
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
    <tr style="background-color:#B0B0B0">
      <th>Item Name</th>
      <th>Item Type</th>
      <th>Item Average Price</th>
      <th>Item Count</th>
      <th>Number of Listings Available</th>
      <th>Your Listing Price</th>
      <th>Edit Listing</th>
    </tr>
  </thead>
  <!-- If the user doesn't have anything in the inventory, show message "Seems like you don't have anything in your inventory" -->
  <!-- Otherwise, list inventory items -->
  <?php
    if($inventory == null){
      echo "Seems like you don't have any items.";}
  ?>
  <?php foreach ($inventory as $item): ?>
    <?php $itemID = getItemIDByItemName($item['itemName']);?>
    <!-- <?php var_dump($itemID); ?> -->
    <?php $listingPrice = getListingPriceByUserItem($userID, $itemID); ?>
    <!-- <?php var_dump($listingPrice); ?> -->
    <tr>
      <td><?php echo $item['itemName']; ?></td>
      <td><?php echo $item['itemType']; ?></td>
      <td><?php echo $item['itemAveragePrice']; ?></td>
      <td><?php echo $item['itemCount']; ?></td>
      <td><?php echo $item['numListingsAvailable']; ?></td>
      <td>
        <!-- If the user is a seller of the item, show the current listing price -->
        <!-- Regardless, the user can set a new price for their new/existing listing -->
          <form name="mainForm" action="show_inventory.php" method="post">
            <input type="text" class="form-control" name="sellingPrice" required
              value="<?php if($listingPrice != null){ echo $listingPrice; } ?>"
            />
          </form>
      </td>
      <!-- If the user is a seller of the item, have the option to update the price or delete the listing -->
      <!-- If the user doesn't have a listing for the item, have the option to create a listing -->
      <?php if($listingPrice == null) { ?>
        <td>
            <form action="show_inventory.php" method=post>
              <input type="submit" name="actionBtn" value="Create Listing" class="btn btn-dark"/>
              <input type="hidden" name="item_listing_to_create" value="<?php echo $itemID; ?>"/>
              <input type="hidden" name="price_listing_to_create" value="<?php echo $listingPrice; ?>"/>
            </form>
        </td>
      <?php } else { ?>
        <td>
          <form action="show_inventory.php" method=post>
            <input type="submit" name="actionBtn" value="Update Listing" class="btn btn-dark"/>
            <input type="hidden" name="item_listing_to_update" value="<?php echo $itemID; ?>"/>
            <input type="hidden" name="price_listing_to_update" value="<?php echo $listingPrice; ?>"/>
          </form>
          <form action="show_inventory.php" method=post>
            <input type="submit" name="actionBtn" value="Delete Listing" class="btn btn-dark"/>
            <input type="hidden" name="listing_to_delete" value="<?php echo $itemID; ?>"/>
          </form>
        </td>
      <?php } ?>
    </tr>
  
  <?php endforeach; ?>
</table>
</div>
</body>
</html>