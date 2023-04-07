<?php
require("connect-db.php");
//include("connect-db.php)

require("animalcrossing-db.php");
//include("friend-db")

// $friends = selectAllFriends();
// //var_dump($friends);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Show Inventory"))
    {
        selectInventory($_POST['username']);
    }
}

?>

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

</head>

<body>

<?php include("header.html") ?>
<div class="container">
  <h1>User Inventory</h1>

  <form name="mainForm" action="show_inventory.php" method="post">
    <div class="row mb-3 mx-3">
      Username:
      <input type="text" class="form-control" name="username" required />
    </div>
    <div class ="row mb-3 mx-3">
    <input type = "submit" class = "btn btn-primary" name ="actionBtn" value = "Show Inventory" title = "Click to Show Inventory" >
    </div>
  </form>
</div>
</body>
</html>
