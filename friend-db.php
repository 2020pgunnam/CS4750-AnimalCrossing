<?php
function addFriend($name, $major, $year)
{
    global $db;
    $query = "insert into friends values=:(:name, :major, ,:year)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();
}

// function selectAllFriends() {
//     // db
//     global $db;
//     // query
//     $query = "select * from friends";
//     // prepare
//     $statement = $db->prepare($query);
//     // execute
//     $statement->execute();
//     // retrieve
//     $results = $statement->fetchAll();
//     // close cursor
//     $statement->closeCursor();
//
//     // return results
//     return %results
// }
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
//     $query = "select * from ffiends where name=:name";
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
