<?php
require("connect-db.php");
//include("connect-db.php)

require("animalcrossing-db.php");
//include("friend-db")

$friends = selectAllListings();
// //var_dump($friends);

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Friend"))
//     {
//         addFriend($_POST['friendname'], $_POST['major'], $_POST['year']);
//     }
// }

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
  <h1>FriendBook</h1>

  <form name="mainForm" action="listings.php" method="post">
    <div class="row mb-3 mx-3">
      Name:
      <input type="text" class="form-control" name="friendname" required />
    </div>
    <div class="row mb-3 mx-3">
      Major:
      <input type="text" class="form-control" name="major" required />
    </div>
    <div class="row mb-3 mx-3">
      Year:
      <input type="text" class="form-control" name="year" required />
    </div>
    <div class ="row mb-3 mx-3">
    <input type = "submit" class = "btn btn-primary" name ="actionBtn" value = "Add Friend" title = "Click to Insert Friend" >
    </div>
  </form>
</div>
</body>
</html>
