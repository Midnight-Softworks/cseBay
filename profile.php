<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/25/2018
     * Time: 5:57 PM
     */
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <link rel="icon" href="logo.png"/>
    <style>
        td {
            border: 1px solid black;
            padding: 1em 1em 1em 1em;
        }
    </style>



</head>

<body>
<?php include 'header.php' ?>

<?php
    include 'login.php';

    $sql = "SELECT * FROM cseBay_Listings WHERE creator = \"".$_SESSION['username']."\"";
    $conn = mysqli_connect($hn, $un, $pw, $db);
    $result = mysqli_query($conn, $sql);
    if(!$result) echo mysqli_error($conn);

    echo "
<p>Your currently running auctions:</p>
<table>
    <tr>
        <th><b>Listing ID</b></th>
        <th><b>Listing Name</b></th>
        <th><b>Listing Description</b></th>
        <th><b>Current Bid</b></th>
        <th><b>Buyout Price</b></th>
        <th><b>End Date</b></th>
    </tr>";
    while(($data = mysqli_fetch_row($result)) != false){
        echo "<tr><td>".$data[0]."</td><td>".$data[7]."</td><td>".$data[1]."</td><td>".$data[9]."</td><td>".$data[3]."</td><td>".$data[4]."</td></tr>";
    }
    echo "</table>";
?>
</body>
