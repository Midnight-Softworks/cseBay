<?php
session_start();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Edit game</title>
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
if (isset($_GET['GameID'])){
    include 'db.php';
    $sql = "SELECT * FROM cseBay_Listings WHERE listingID = ".$_GET['listingID'];
    $data = mysqli_query($conn, $sql);
    $description = "";
    if(!$data) echo mysqli_error($conn);
    $data = ( mysqli_fetch_row($data));



    echo "
    <form action=\"/edit_game.php\" method='post'>
    <input value=".$_GET['GameID']." name=\"GameID\" type=\"hidden\">
    Game name:
        <input type=\"text\" name=\"gamename\"  value=\"".$data[1]."\"><br>
    Console:
        <input type=\"text\" name=\"console\" value=\"".$data[3]."\"><br>
    Players:
        <input type=\"text\" name=\"players\" value=\"".$data[2]."\"><br>
    Description:
        <textarea name=\"description\">".$description."</textarea><br><br>
         <input type=\"submit\" value=\"Submit\">
    </form>
    ";


    mysqli_close($conn);


}

if (isset($_POST['GameID'])){
    include 'db.php';
    $file = fopen("Descriptions/".$_POST['GameID'].".txt", 'w', true);
    fwrite($file, $_POST['description']);
    fclose($file);
    $sql = "UPDATE gamesdb.game SET Game_Name = \"".$_POST['gamename']."\", Players = ".$_POST['players'].", Console = \"".$_POST['console']."\" WHERE GameID = ".$_POST['GameID'];
    mysqli_query($conn, $sql);
    echo mysqli_error($conn);
    if(!mysqli_error($conn)){
        echo "<script>
    alert(\"Game updated successfully\");
   window.location = '/';
</script>";
    }

}

?>
</body>
