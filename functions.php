

<?php

require("connect-db.php");
require("animalcrossing-db.php");
session_start();
$userID = $_SESSION['email'];
$userName = $_SESSION['f_name'];

if(isset($_POST["Import"])){

  $filename=$_FILES["file"]["tmp_name"];
   if($_FILES["file"]["size"] > 0)
   {
      $file = fopen($filename, "r");
      $header = fgetcsv($file, 10000, ",");
      // $userID = getUserIDByUserName("teek");
      clearInventory($userID);
      while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
       {
         // $sql = "INSERT into employeeinfo (emp_id,firstname,lastname,email,reg_date)
         //       values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."')";
         //       $result = mysqli_query($con, $sql);



         $itemID = getItemIDByItemName($getData[0]);

         if($itemID==0){
           echo "<script type=\"text/javascript\">
               alert(\"Invalid Item Name Found\");
               window.location = \"./\"
               </script>";
         }
         $result = insertIntoInventory($userID, (int)$itemID, (int)$getData[1]);
        if(!isset($result))
        {
          echo "<script type=\"text/javascript\">
              alert(\"Invalid File:Please Upload CSV File.\");
              window.location = \"./\"
              </script>";
        }
        else {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"./\"
          </script>";
        }
       }

         fclose($file);
   }
}

  if(isset($_POST["Export"])){
      //$filename = "7aceOfSpades_inventory_" . date('Y-m-d') . ".csv"
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename=data.csv');
      // header('Content-Disposition: attachment; filename="' . $filename . '"');
      $output = fopen("php://output", "w");
      $delimiter = ",";
      $fields = array('ITEM NAME', 'ITEM TYPE', 'ITEM AVERAGE PRICE', 'ITEM COUNT', 'ITEM IMAGE URL', 'NUMBER OF LISTINGS AVAILABLE');
      fputcsv($output, $fields, $delimiter);
      // $username = '7aceOfSpades';
      // $query = "select * from User natural join Inventory natural join Items where userName='teek'";
      // $result = mysqli_query($query);

      $result = selectInventory($userID);
      // foreach ($result as $row):
      foreach ($result as $row) {

          $lineData = array($row['itemName'], $row['itemType'], $row['itemAveragePrice'], $row['itemCount'], $row['itemImageURL'], $row['numListingsAvailable']);
          fputcsv($output, $lineData);

      }
      // fputcsv($output, "END");
      fclose($output);
 }

 ?>
