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

function selectAllListings() {
    // db
    global $db;
    // query
    $query = "select userName, itemName, itemSellingPrice, userRating from Listings L natural join Seller S natural join Items I where sellerID=userID";
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

function getUserIDByUserName($userName)
{
    global $db;
    $query = "select userID from User where $userName=:userName";
    $statement = $db->prepare($query);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
}

function getItemIDByItemName($itemName)
{
    global $db;
    $query = "select itemID from Items where $itemName=:itemName";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemName', $itemName);
    $statement->execute();
    $result = $statement->fetch();
    $statement->closeCursor();
    return $result;
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
function updateListing($itemID, $userID, $sellingPrice)
{
    global $db;
    $query = "update Listings set itemSellingPrice=:sellingPrice where (itemID=:itemID and sellerID=:userID)";
    $statement = $db->query($query);
    $statement->bindValue(':sellingPrice', $sellingPrice);
    $statement->bindValue(':itemID', $itemID);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $statement->closeCursor();
}

function addListing($itemID, $userID, $sellingPrice)
{
    global $db;
    $query = "insert into Listings values (:sellerID, :itemID, :itemSellingPrice)";
    $statement = $db->prepare($query);
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
    $query = "delete from Listings where (itemID=:itemID and sellerID=:userID)";
    $statement = $db->prepare($query);
    $statement->bindValue(':sellerID', $userID);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $statement->closeCursor();
    echo 'deleted itemID';
    // When deleting listing, should update for item numListingsAvailable
    $query = "update Items set numListingsAvailable=(numListingsAvailable-1) where itemID=:itemID";
    $statement = $db->prepare($query);
    $statement->bindValue(':itemID', $itemID);
    $statement->execute();
    $statement->closeCursor();
}

?>
