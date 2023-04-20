
<?php
require("connect-db.php");
// include("connect-db.php");

require("animalcrossing-db.php");

$listings = selectAllListings();
// var_dump($listings)


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

  <title>Listings</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

</head>

<body>
  <div class="container">
    <h1>Listings</h1>
  <div class="row justify-content-center">
    <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
      <thead>
        <tr style="background-color:#B0B0B0">
          <th>Item ID</th>
          <th>Item Selling Price</th>
        </tr>
      </thead>
      <?php foreach ($listings as $item): ?>
        <tr>
          <td><?php echo $item['itemID']; ?></td>
          <td><?php echo $item['itemSellingPrice']; ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
