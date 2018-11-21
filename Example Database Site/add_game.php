<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add a game</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>
    <link rel="icon" href="icon.png"/>



</head>
<body>
<?php include "Inventory/header.php"?>

<?php
if (isset($_POST['gamename'])){
include 'db.php';
$sql = "INSERT INTO gamesdb.game (Game_Name, Players, Console) VALUES ( \"".trim($_POST['gamename'])."\", ".trim($_POST['players']).", \"".trim($_POST['console'])."\")";
if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

echo "
    <form action=\"/add_game.php\" method='post'>
    Game name:
        <input type=\"text\" name=\"gamename\"  placeholder=\"".$_POST['gamename']."\"><br>
    Console:
        <input type=\"text\" name=\"console\" placeholder=\"".$_POST['console']."\"><br>
    Players:
        <input type=\"text\" name=\"players\" placeholder=\"".$_POST['players']."\"><br><br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";
$_POST = array();
}

else{
    echo "
    <form action=\"/add_game.php\" method='post'>
    Game name:
        <input type=\"text\" name=\"gamename\"><br>
    Console:
        <input type=\"text\" name=\"console\"><br>
    Players:
        <input type=\"text\" name=\"players\"><br><br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";
}
?>
</body>
