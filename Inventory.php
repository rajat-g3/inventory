<?php

class Inventory
{
    /**
     * Function for DB connection
     *
     */
    public function connectDb() {
        $dbcon=mysqli_connect("mysql-server","root","secret");
        mysqli_select_db($dbcon,"inventorydb");
        return $dbcon;
    }

    /**
     * Function To get all items on Inventory
     *
     */
    public function getAllItems()
    {
        $items = "SELECT req_id, requested_by, concat(item, ',','Pen') AS item, value FROM items INNER JOIN itemType ON itemType.id = items.item_type INNER join requests ON SUBSTR(requests.items,3,1) = items.id;";
        $data = [];
        $dbcon=mysqli_connect("mysql-server","root","secret");
        mysqli_select_db($dbcon,"inventorydb");
        mysqli_set_charset($dbcon, "utf8");
        $result = mysqli_query($dbcon, $items);
        while($row = mysqli_fetch_assoc($result))
        {
            $data[] = $row;
        }
        echo  json_encode(array('data' => $data));
        return;
    }
}

$inventory = new Inventory();

$inventory->getAllItems();

/*
 * Logic to Add an Item Request
 */
if (isset($_POST['add']))
{
    $user = $_POST['user'];

    if (isset($_POST['items'])) {
        $items = [];

        foreach ($_POST['items'] as $item)
            $items[] = $item;

    }
    $items = implode("','", $items);

    $dbcon = $inventory->connectDb();

    $type = [];

    // Sql to Find the id of an item
    $item = "SELECT id, item_type FROM items WHERE item IN ('$items');";
    $itemId = "[";

    $result = mysqli_query($dbcon, $item);

    while($row = mysqli_fetch_assoc($result))
    {
        $type[] = $row['item_type'];
        $itemId .= "{" .$row['id'] .  ",".$row['item_type']."},";
    }

    $isSameType = (count(array_unique($type, SORT_REGULAR)) === 1);

    $itemId = substr($itemId, 0, -1);
    $itemId .= "]";

    if ($isSameType === false) {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Please select Items of same type');</script>";
        return false;
    }

     // Sql to Update the id of an item
     $query = "INSERT INTO requests(requested_by, requested_on, ordered_on, items) VALUES ('$user', CURRENT_DATE(), CURRENT_DATE(), '$itemId');";

     $querySummary = "INSERT INTO summary(requested_by, ordered_on, items) VALUES ('$user', CURRENT_DATE(), '$itemId');";

     if ($dbcon->query($query) === true && $dbcon->query($querySummary) === true)
     {
         echo "<script type='text/javascript'>window.location ='index.html'; alert('Record Added Successfully');</script>";
     }
     else
     {
         echo "<script type='text/javascript'>window.location ='index.html';alert('Error Inserting Data');</script>";
         return false;
     }
}

/*
 * Logic to Edit an Item Request
 */
if (isset($_POST['edit']))
{
    $user = $_POST['user1'];
    $id = $_POST['updateId'];
    if (isset($_POST['items1'])) {
        $items = [];

        foreach ($_POST['items1'] as $item)
            $items[] = $item;

    }
    $items = implode("','", $items);

    $dbcon = $inventory->connectDb();

    $type = [];

    // Sql to Find the id of an item
    $item = "SELECT id, item_type FROM items WHERE item IN ('$items');";
    $itemId = "[";

    $result = mysqli_query($dbcon, $item);

    while($row = mysqli_fetch_assoc($result))
    {
        $type[] = $row['item_type'];
        $itemId .= "{" .$row['id'] .  ",".$row['item_type']."},";
    }

    $isSameType = (count(array_unique($type, SORT_REGULAR)) === 1);

    $itemId = substr($itemId, 0, -1);
    $itemId .= "]";

    if ($isSameType === false) {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Please select Items of same type.');</script>";
        return false;
    }

    // Sql to Update the id of an item
    $queryRequest="UPDATE requests SET requested_by = '$user', items= '$itemId' WHERE req_id = $id;";

    $querySummary="UPDATE summary SET requested_by = '$user', items= '$itemId' WHERE req_id = $id;";

    if ($dbcon->query($queryRequest) === true && $dbcon->query($querySummary) === true)
    {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Record Updated Successfully');</script>";
    }
    else
    {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Error Updating Data');</script>";
        return false;
    }
}

/*
 * Logic to Delete an Item Request
 */
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $dbcon = $inventory->connectDb();

    // sql to delete a record
    $queryRequest = "DELETE FROM requests WHERE req_id='$id'";
    $querySummary = "DELETE FROM summary WHERE req_id='$id'";

    if (mysqli_query($dbcon, $queryRequest) === true && $dbcon->query($querySummary) === true) {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Record Deleted Successfully');</script>";
    }
    else {
        echo "<script type='text/javascript'>window.location ='index.html';alert('Error Deleting Data');</script>";
    }
}