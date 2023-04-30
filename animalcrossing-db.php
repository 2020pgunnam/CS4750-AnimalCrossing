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

function addUser($userID, $userName) {
    global $db;
    $query = "insert into Users values (:userID, :userName)";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $statement->closeCursor();
}

function selectUser($userID) {
    global $db;
    $query = "select * from Users where $userID=:userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
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

function selectInventory($name) {
    // db
    global $db;
    // query
    $query = "select * from User natural join Inventory natural join Items where userName=:name";
    // prepare

    $statement = $db->prepare($query);

    $statement->bindValue(':name', $name);
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
    return $results;
    // return results
}

function clearInventory($userID) {
    // db
    global $db;
    // query
    $query = "delete from Inventory where (userID=:userID)";
    // prepare

    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    // execute
    $results = $statement->execute();
    // close cursor
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
    return $result['itemSellingPrice'];
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


?>
