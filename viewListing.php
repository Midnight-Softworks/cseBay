<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit listing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="logo.png"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>




</head>
<body>
<?php include "header.php"?>

<?php
    include 'User.php';
    if (isset($_GET['bid']) && isset($_GET['listingID'])){
        $biddingUser = new User($_SESSION['username']);
        if ($biddingUser->bid($_GET['listingID'], $_GET['bid'])) echo "<script>alert('Bid placed successfully');</script>";
        else echo "<script>alert('Please bid more than the current bid');</script>";
        header("index.php");
    }
    include 'login.php';
    $sql = "SELECT * FROM cseBay_Listings WHERE listingID = ".$_GET['listingID'];
    $conn = mysqli_connect($hn, $un, $pw, $db);
    $result = mysqli_query($conn, $sql);
    if(!$result) echo mysqli_error($conn);
    $data = mysqli_fetch_row($result);

    echo "
    Item Name: $data[7] <br>
    Item Description: $data[1] <br>
    Starting Bid: $data[2] <br>
    Buyout Price: $data[3] <br>
    End Date: $data[4] <br>
    Creator: $data[8] <br>";

    mysqli_close($conn);

    if ($_SESSION['username'] == $data[8] || $_SESSION['type'] == 'admin') echo "<a href=\"http://pluto.cse.msstate.edu/~sfs111/cseBay/editListing.php?&listingID=".$_GET['listingID']."\">Edit this listing</a>";
    else if (isset($_SESSION['username'])){
        echo "
    <form action=\"viewListing.php\" method='get'>
    Bid amount:
        <input type=\"text\" name=\"bid\"  placeholder=\"" . ($data[9] + 1) . "\"><br>
        <input type=\"hidden\" name=\"listingID\" value=\"".$_GET['listingID']."\">
    
         <input type=\"submit\" value=\"Bid\">
    </form>
    ";
    }


    ?>
</body>
