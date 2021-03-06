<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/25/2018
     * Time: 5:59 PM
     */
session_start();
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>cseBay</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-html5-1.5.2/b-print-1.5.2/cr-1.5.0/sl-1.2.6/datatables.min.js"></script>
        <link rel="icon" href="logo.png"/>




    </head>

    <body>
<?php include 'header.php' ?>

<?php
include 'login.php';
include  'User.php';
if (isset($_POST['submit'])){

    $thisUser = new User($_SESSION['username']);
    if (isset($_POST['deleteUserName']) && $_POST['deleteUserName'] != "") {
        if ($thisUser->forceDeleteUser($_POST['deleteUserName'])) {
            echo "User successfully removed";
        }
    }

    if (isset($_POST['deleteListing']) && $_POST['deleteListing'] != "") {
        if ($thisUser->forceDeleteList($_POST['deleteListing'])) {
            echo "Listing successfully removed";
        }
    }

    if (isset($_POST['makeAdmin']) && $_POST['makeAdmin']) {
        if ($thisUser->makeAdmin($_POST['makeAdmin'])) {
            echo "User successfully promoted to Admin";
        }
    }

    if (isset($_POST['removeAdmin']) && $_POST['removeAdmin']) {
        if ($thisUser->removeAdmin($_POST['removeAdmin'])) {
            echo "User successfully removed form Admin";
        }
    }


    echo "
    <form action=\"administrative.php\" method='post'>
    Delete User:
        <input type=\"text\" name=\"deleteUserName\"  placeholder=\"".$_POST['deleteUserName']."\"><br>
    Delete Listing:
        <input type=\"textarea\" name=\"deleteListing\" placeholder=\"".$_POST['deleteListing']."\"><br>
    Make Admin:
        <input type=\"text\" name=\"makeAdmin\" placeholder=\"".$_POST['makeAdmin']."\"><br>
    Remove Admin:
        <input type=\"text\" name=\"removeAdmin\" placeholder=\"".$_POST['removeAdmin']."\"><br>";

    echo"
        <br>
         <input type=\"submit\" name = \"submit\" value=\"Submit\">
    </form>
    ";
   // $_POST = array();
}

else{
    echo "
    <form action=\"administrative.php\" method='post'>
    Delete User:
        <input type=\"text\" name=\"deleteUserName\"><br>
    Delete Listing:
        <input type=\"text\" name=\"deleteListing\"><br>
    Make Admin:
    <input type=\"text\" name=\"makeAdmin\"><br>
    Remove Admin:
    <input type=\"text\" name=\"removeAdmin\"><br>";

    echo "
    <br>
         <input type=\"submit\" name = \"submit\" value=\"Submit\">
    </form>
    ";
}
?>
    </body>
