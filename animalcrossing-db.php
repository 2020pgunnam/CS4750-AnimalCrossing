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
    $query = "select userName, itemName, itemSellingPrice, userRating from Listings L natural join Seller S natural join Items I where sellerID=userID ORDER BY itemName";
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
    $query = "select * from User natural join Inventory natural join Items where userName=:(:name)";
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
//
// function deleteFriend($friend_to_delete)
// {
//     global $db;
//     $query = "delete from friends where name=:friend_to_delete";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':friend_to_delete', $friend_to_delete);
//     $statement->execute();
//     $statement->closeCursor();
// }
//
// function getFriendByName($name)
// {
//     global $db;
//     $query = "select * from friends where name=:name";
//     $statement = $db->prepare($query);
//     $statement->bindValue(':name', $name);
//     $statement->execute();
//     $statement->closeCursor();
//     return $result;
// }
//
// function updateFriend($name, $major, $year)
// {
//     echo "in updateFriend";
//     global $db;
//     $query = "update friends set major=:major, year=:year, where name=:name";
//     $statement = $db->query($query);
//     $statement->bindValue(':name', $name);
//     $statement->bindValue(':major', $major);
//     $statement->bindValue(':year', $year);
//     $statement->execute();
//     $statement->closeCursor();
// }

?>
