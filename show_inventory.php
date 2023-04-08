<?php
require("connect-db.php");
// include("connect-db.php");

require("animalcrossing-db.php");
// include("friend-db.php")

// $friends = selectAllFriends();
// var_dump($friends)

$friend_info_to_update = null;

// var_dump($friends)
$inventory  = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if ((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Show Inventory"))
  {
    $inventory() = getFriendByName($_POST['username']);
    var_dump($inventory);
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

  <title>Bootstrap example</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

</head>

<body>
<div class="container">
  <h1>Inventory</h1>

  <form name="mainForm" action="simpleform.php" method="get">
  <div class="row mb-3 mx-3">
    Username:
    <input type="text" class="form-control" name="friendname" required
    value="<?php if ($inventory!=null) echo $friend_info_to_update['userName'];?>"/>
  </div>


  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Show Inventory" title="click to show inventory" />
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
    <th>numListingsAvailable</th>
  </tr>
  </thead>
<?php foreach ($inventory as $item): ?>
  <tr>
     <td><?php echo $item['itemName']; ?></td>
     <td><?php echo $item['itemType']; ?></td>
     <td><?php echo $item['itemAveragePrice']; ?></td>
     <td><?php echo $item['itemCount']; ?></td>
     <td><?php echo $item['numListingsAvailable']; ?></td>
     <td>
        <form action="show_inventory.php" method="post">
            <input type ="submit" name="actionBtn" value="Update" class="btn btn-dark"/>
            <input type ="hidden" name="friend_to_update" value="<?php echo $item['userName'];?>" />
        </form>
     </td>
     <td>
        <form action="show_inventory.php" method="post">
            <input type ="submit" name="actionBtn" value="Delete" class="btn btn-danger"/>
            <input type ="hidden" name="friend_to_delete" value="<?php echo $item['userName'];?>" />
            </form>
     </td>
  </tr>
<?php endforeach; ?>
</table>
</div>
</body>
</html>
