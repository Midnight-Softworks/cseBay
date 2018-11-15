<?php
/**
 * Created by PhpStorm.
 * User: Mid
 * Date: 11/14/2018
 * Time: 6:41 PM
 */

class User
{
    private $username = "";

    function __construct($username){
        $this->username = $username;
    }

    //Returns true if the user is an administrator. False otherwise
    function IsAdmin(){
        include 'login.php';
        global $hn, $pw, $un, $db;
        $conn = mysqli_connect($hn, $un, $pw, $db);

        //Got an error? Scream it out
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $result = mysqli_query($conn, "SELECT isAdmin FROM cseBay_Users WHERE userName = ".'"'."$this->username".'"');
        $row = mysqli_fetch_assoc($result);
        if ($row == true) return true;
        return false;
    }

    function passwordNeedsReset(){
        include 'login.php';
        global $hn, $pw, $un, $db;
        $conn = mysqli_connect($hn, $un, $pw, $db);

        //Got an error? Scream it out
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $result = mysqli_query($conn, "SELECT passwordIsSet FROM cseBay_Users WHERE userName = ".'"'."$this->username".'"');
        $row = mysqli_fetch_assoc($result);
        if ($row == true) return true;
        return false;
    }
}