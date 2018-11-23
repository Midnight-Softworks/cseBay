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
    //This is all old code. Still needs to be updated

if (isset($_SESSION['username'])) {
    if (isset($_GET['listingID'])) {
        include 'login.php';
        $sql = "SELECT * FROM cseBay_Listings WHERE listingID = " . $_GET['listingID'];
        $conn = mysqli_connect($hn, $un, $pw, $db);
        $result = mysqli_query($conn, $sql);
        $description = "";
        if (!$data) echo mysqli_error($conn);
        $data = mysqli_fetch_row($result);

        if ($_SESSION['username'] == $data[8] || $_SESSION['type'] == 'admin') {
            echo "
    <form action=\"editListing.php\" method='post'>
    Item Name:
        <input type=\"text\" name=\"itemName\"  value=\"" . $data[7] . "\"><br>
    Item Description:
        <input type=\"textarea\" name=\"itemDescription\" value=\"" . $data[1] . "\"><br>
    Starting Bid:
        <input type=\"text\" name=\"startingBid\" value=\"" . $data[2] . "\"><br>
    Buyout Price:
        <input type=\"text\" name=\"buyoutPrice\" value=\"" . $data[3] . "\"><br>
    End Date:
        <input type=\"text\" name=\"endDate\" value=\"" . $data[4] . "\"><br>";
            if ($_SESSION['type'] == 'admin') {
                echo "
    Creator:
        <input type=\"text\" name=\"creator\" value=\"" . $data[8] . "\"><br> ";
            } else {
                echo "
        <input type=\"hidden\" name=\"creator\" value=\"" . $data[8] . "\"><br> ";
            }
            echo "
        <br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";}

    else echo "You do not have permission to edit this listing.";

        mysqli_close($conn);

    }

    if (isset($_POST['listingID'])) {
        include 'login.php';
        $sql = "UPDATE cseBay_Listings SET itemName = \"" . $_POST['itemName'] . "\", itemDescription = \"" . $_POST['itemDescription'] . "\", startingBid = " . $_POST['console'] . ", buyoutPrice = " . $_POST['buyoutPrice'] . ", endDate = \"" . $_POST['endDate'] . "\", creator = \"" . $_POST['creator'] . "\"" . " WHERE listingID = " . $_POST['listingID'];
        $conn = mysqli_connect($hn, $un, $pw, $db);
        mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        if (!mysqli_error($conn)) {
            echo "<script>
    alert(\"Listing updated successfully\");
   window.location = 'index.php';
</script>";
        }

    }
}
else echo "Only users may view this page. <br> Please, <a href = \"signUp.php\">create an account</a> or <a href = \"signIn.php\">sign in</a> to view this page.";
?>
</body>
