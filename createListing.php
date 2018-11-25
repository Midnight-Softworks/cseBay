<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create a Listing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <link rel="icon" href="icon.png"/>



</head>
<body>
<?php include "header.php"?>

<?php
if (isset($_POST['itemName'])){
include 'login.php';
$conn = mysqli_connect($hn, $un, $pw, $db);
$sql = "INSERT INTO cseBay_Listings (itemName, itemDescription, startingBid, buyoutPrice, endDate, creator) VALUES ( \"".trim($_POST['itemName'])."\", \"".trim($_POST['itemDescription'])."\", ".trim($_POST['startingBid']).", ".trim($_POST['buyoutPrice']).", \"".trim($_POST['endDate'])."\", \"".trim($_POST['creator'])."\")";
if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

echo "
    <form action=\"createListing.php\" method='post'>
    Item Name:
        <input type=\"text\" name=\"itemName\"  placeholder=\"".$_POST['itemName']."\"><br>
    Item Description:
        <input type=\"textarea\" name=\"itemDescription\" placeholder=\"".$_POST['itemDescription']."\"><br>
    Starting Bid:
        <input type=\"text\" name=\"startingBid\" placeholder=\"".$_POST['startingBid']."\"><br>
    Buyout Price:
        <input type=\"text\" name=\"buyoutPrice\" placeholder=\"".$_POST['buyoutPrice']."\"><br>
    End Date:
        <input type=\"datetime-local\" name=\"endDate\" placeholder=\"".$_POST['endDate']."\"><br>";
    if ($_SESSION['type'] == 'admin') {
        echo "
    Creator:
        <input type=\"text\" name=\"creator\" placeholder=\"" . $_POST['creator'] . "\"><br> ";
    }
    else {
        echo"
        <input type=\"hidden\" name=\"creator\" value=\"" . $_SESSION['username'] . "\"><br> ";
    }
    echo"
        <br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";
$_POST = array();
}

else{
    echo "
    <form action=\"createListing.php\" method='post'>
    Item Name:
        <input type=\"text\" name=\"itemName\"><br>
    Item Description:
        <input type=\"textarea\" name=\"itemDescription\"><br>
    Starting Bid:
    <input type=\"text\" name=\"startingBid\"><br>
    Buyout Price:
    <input type=\"text\" name=\"buyoutPrice\"><br>
    End Date:
    <input type=\"datetime-local\" name=\"endDate\"><br>";
    if ($_SESSION['type'] == 'admin') {
        echo "
    Creator:
    <input type=\"text\" name=\"creator\"><br>";
    }
    else {
        echo"
        <input type=\"hidden\" name=\"creator\" value=\"" . $_SESSION['username'] . "\"><br> ";
    }
    echo "
    <br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";
}
?>
</body>
