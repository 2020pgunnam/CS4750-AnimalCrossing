<?php
// function addTo($name, $major, $year)
// {
//     global $db;
//     $query = "insert into friends values=:(:name, :major, ,:year)";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':name', $name);
//     $statement->bindValue(':major', $major);
//     $statement->bindValue(':year', $year);
//     $statement->execute();
//     $statement->closeCursor();
// }

function checkEmail($userID) {
    global $db;
    $query = "select userID from User where userID=:userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function addUser($userID, $userName) {
    global $db;
    $query = "insert into User values (:userID, :userName)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $statement->closeCursor();
}

function addBuyer($userID, $userName) {
    global $db;
    $query = "insert into Buyer values (:userID, :userName)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $statement->closeCursor();
}

function selectAllListings() {
    // db
    global $db;
    // query
    $query = "select userName, itemName, itemSellingPrice, itemImageURL, userRating from Listings L natural join Seller S natural join Items I where sellerID=userID";
    // prepare
    $statement = $db->prepare($query);
    // execute
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll();
    // close cursor
    $statement->closeCursor();

    // return results
    return $results;
}

function selectAllItems() {
    // db
    global $db;
    // query
    $query = "select itemName, itemType, itemAveragePrice, itemImageURL, numListingsAvailable from Items I";
    // prepare
    $statement = $db->prepare($query);
    // execute
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll();
    // close cursor
    $statement->closeCursor();

    // return results
    return $results;
}

function selectInventory($userID) {
    // db
    global $db;
    // query
    $query = "call selectInventory(:userID)";
    // prepare

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll();
    // close cursor
    $statement->closeCursor();

    // return results
    return $results;
}
function filterInventory($userID, $value) {
    // db
    global $db;
    // query
    $query = "call selectInventory(:userID) where (itemimageurl like :value or itemname like :value or itemtype like :value or itemaverageprice like :value or itemcount like :value or numlistingsavailable like :value)";
    // prepare

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':value', $value);
    // execute
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll();
    // close cursor
    $statement->closeCursor();

    // return results
    return $results;
}
function sortInventory($userID, $value, $order) {
    // db
    global $db;
    // query
    if ($value == "itemName") {
        $query = "select * from User natural join Inventory natural join Items where userID=:userID order by itemName $order";
    } elseif ($value == "itemType") {
        $query = "select * from User natural join Inventory natural join Items where userID=:userID order by itemType $order";
    } elseif ($value == "itemAveragePrice") {
        $query = "select * from User natural join Inventory natural join Items where userID=:userID order by itemAveragePrice $order";
    } elseif ($value == "itemCount") {
        $query = "select * from User natural join Inventory natural join Items where userID=:userID order by itemCount $order";
    } elseif ($value == "numListingsAvailable") {
        $query = "select * from User natural join Inventory natural join Items where userID=:userID order by numListingsAvailable $order";
    }
    // prepare

    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    // execute
    $statement->execute();
    // retrieve
    $results = $statement->fetchAll();
    // close cursor
    $statement->closeCursor();

    // return results
    return $results;
}


function insertIntoInventory($userID, $itemID, $itemCount) {
    // db
    global $db;
    // query
    $query = "insert into Inventory values (:userID, :itemID, :itemCount)";
    // prepare

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':itemCount', $itemCount);
    // execute
    $results = $statement->execute();
    // close cursor
    $statement->closeCursor();

    addInventoryToContainsTable($userID);
    addInventoryToHasTable($userID);
    return $results;
    // return results
}

function clearInventory($userID) {
    // db
    global $db;
    // query
    $query = "delete from Inventory where (userID=:userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $results = $statement->execute();
    $statement->closeCursor();

    $query = "delete from Has where (userID=:userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $results = $statement->execute();
    $statement->closeCursor();

    $query = "delete from Contains where (userID=:userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $results = $statement->execute();
    $statement->closeCursor();

    return $results;
    // return results
}

function getUserIDByUserName($userName)
{
    global $db;
    $query = "select userID from User where userName=:userName";
    $statement = $db->prepare($query);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result['userID'];
}

function getItemIDByItemName($itemName)
{
    global $db;
    $query = "select itemID from Items where itemName=:itemName";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemName', $itemName);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result['itemID'];
}

function getListingPriceByUserItem($userID, $itemID)
{
    global $db;
    $query = "select itemSellingPrice from (User join Listings on sellerID=userID) where (userID=:userID and itemID=:itemID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function getHighestListingID()
{
    global $db;
    $query = "select MAX(listingID) AS highestListingID from Listings";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result['highestListingID'];
}
function updateListing($itemID, $userID, $sellingPrice)
{
    global $db;
    $query = "update Listings set itemSellingPrice=:sellingPrice where (itemID=:itemID and sellerID=:sellerID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':sellerID', $userID);
    $statement->bindValue(':sellingPrice', $sellingPrice);
    $statement->execute();
    $statement->closeCursor();
}

function addListing($listingID, $userID, $itemID, $sellingPrice)
{
    global $db;
    $query = "insert into Listings values (:listingID, :sellerID, :itemID, :itemSellingPrice)";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->bindValue(':sellerID', $userID);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':itemSellingPrice', $sellingPrice);
    $statement->execute();
    $statement->closeCursor();
    // When creating new listing, should update for item numListingsAvailable
    $query = "update Items set numListingsAvailable=(numListingsAvailable+1) where itemID=:itemID";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $statement->closeCursor();
    // When creating a new listing, a seller adds a listing (Adds table)
    // When creating a new listing, if a user is not already a seller, they become a seller
}

function checkAdds($listingID){
    global $db;
    $query = "select listingID from Adds where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function addtoAdds($userID, $userName, $listingID, $userRating, $itemID, $sellingPrice){
    global $db;
    $query = "insert into Adds values (:userID, :userName, :listingID, :userRating, :itemID, :itemSellingPrice)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':listingID', $listingID);
    $statement->bindValue(':userRating', $userRating);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':itemSellingPrice', $sellingPrice);
    $statement->execute();
    $statement->closeCursor();
}

function sellerOfListing($listingID){
    global $db;
    $query = "select userID from Listings where listingID=:listingID";
    $statement = $db->prepare($query);
    $statement->bindValue(':listingID', $listingID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function addtoBuys(){
    global $db;
    $query = "insert into Buys values (:userID, :userName, :listingID, :sellerID, :itemID, :itemSellingPrice)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':listingID', $listingID);
    $statement->bindValue(':userRating', $userRating);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':itemSellingPrice', $sellingPrice);
    $statement->execute();
    $statement->closeCursor();
}

function getUserRating($userID) {
    global $db;
    $query = "select userRating from Seller where userID=:userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function addSeller($userID, $userName) {
    global $db;
    $query = "insert into Seller values (:userID, :userName)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
}

function deleteListing($itemID, $userID)
{
    global $db;
    $query = "delete from Listings where (itemID=:itemID and sellerID=:sellerID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':sellerID', $userID);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $statement->closeCursor();
    //echo 'deleted itemID';
    // When deleting listing, should update for item numListingsAvailable
    $query = "update Items set numListingsAvailable=(numListingsAvailable-1) where itemID=:itemID";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $statement->closeCursor();
}

function generateRandomizedInventory($userID)
{
    global $db;
    $inventory = array();
    for ($i = 0; $i < 10; $i++) {
        $itemID = rand(1, 20); // select a random item ID
        // check if inventory item already exists
        $query = "select count(*) from Inventory where userID=:userID and itemID=:itemID";
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':itemID', $itemID);
        $statement->execute();
        $count = $statement->fetchColumn();

        if ($count == 0) {
            $itemCount = rand(1, 10);
            $query = "insert into Inventory values (:userID, :itemID, :itemCount)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID);
            $statement->bindValue(':itemID', $itemID);
            $statement->bindValue(':itemCount', $itemCount);
            $statement->execute();

            $inventory[] = array(
                'itemID' => $itemID,
                'itemCount' => $itemCount
            );
        }
    }
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function addInventoryToHasTable($userID) {
    global $db;
    $userName = $_SESSION['f_name'];

    $query = "SELECT * FROM Inventory WHERE userID = :userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $inventory = $statement->fetchAll();
    $statement->closeCursor();

    // loop through the inventory and add to the Has table
    foreach ($inventory as $item) {
        $itemID = $item['itemID'];

        // check if item already exists in Has table
        $query = "SELECT COUNT(*) FROM Has WHERE userID = :userID AND itemID = :itemID";
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':itemID', $itemID);
        $statement->execute();
        $count = $statement->fetchColumn();
        $statement->closeCursor();

        if ($count == 0) {
            $query = "INSERT INTO Has (userID, itemID, userName, itemCount) VALUES (:userID, :itemID, :userName, :itemCount)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID);
            $statement->bindValue(':itemID', $itemID);
            $statement->bindValue(':userName', $userName);
            $statement->bindValue(':itemCount', $item['itemCount']);
            $statement->execute();
            $statement->closeCursor();
        }
    }
}

function addInventoryToContainsTable($userID)
{
    global $db;

    $query = "SELECT * FROM Inventory WHERE userID=:userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $inventory = $statement->fetchAll();
    $statement->closeCursor();

    // loop through and add
    foreach ($inventory as $item) {
        $itemID = $item['itemID'];
        $query = "SELECT * FROM Items WHERE itemID=:itemID";
        $statement = $db->prepare($query);
        $statement->bindValue(':itemID', $itemID);
        $statement->execute();
        $itemData = $statement->fetch();
        $statement->closeCursor();

        // check if already exists
        $query = "SELECT COUNT(*) FROM Contains WHERE userID=:userID AND itemID=:itemID";
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->bindValue(':itemID', $itemID);
        $statement->execute();
        $count = $statement->fetchColumn();
        $statement->closeCursor();

        if ($count == 0) {
            $query = "INSERT INTO Contains (userID, itemID, itemCount, itemName, itemType, itemAveragePrice, itemImageURL, numListingsAvailable) VALUES (:userID, :itemID, :itemCount, :itemName, :itemType, :itemAveragePrice, :itemImageURL, :numListingsAvailable)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $userID);
            $statement->bindValue(':itemID', $itemID);
            $statement->bindValue(':itemCount', $item['itemCount']);
            $statement->bindValue(':itemName', $itemData['itemName']);
            $statement->bindValue(':itemType', $itemData['itemType']);
            $statement->bindValue(':itemAveragePrice', $itemData['itemAveragePrice']);
            $statement->bindValue(':itemImageURL', $itemData['itemImageURL']);
            $statement->bindValue(':numListingsAvailable', $itemData['numListingsAvailable']);
            $statement->execute();
            $statement->closeCursor();
        }
    }
}

?>