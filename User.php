<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/14/2018
     * Time: 6:41 PM
     */

    //Whoever did the UML diagrams, you need a strong talking to.
    //Camelcase OR underscores, for the love of sweet baby jesus, not both.
    class User
    {
        private $username = "";

        function __construct($username)
        {
            $this->username = $username;
        }

        //Returns true if the user is an administrator. False otherwise
        function IsAdmin()
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT isAdmin FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            if ($row['isAdmin'] == true) return true;
            return false;
        }

        function passwordNeedsReset()
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT passwordIsSet FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            if ($row['passwordIsSet'] == false) return true;
            return false;
        }

        function isUser_available()
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT userName FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            //This may not work. Please test and make sure the return type is null on no matches
            if ($row['username'] != $this->username) return true;
            return false;
        }

        function registerUser($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");
            if ($this->isUser_available()) {
                include 'login.php';
                global $hn, $pw, $un, $db;
                $conn = mysqli_connect($hn, $un, $pw, $db);

                //Got an error? Scream it out
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $result = mysqli_query($conn, "INSERT INTO cseBay_Users (userName, password) VALUES('$this->username', '$token') ");
                if (!$result) echo "Something went wrong, boss: " . mysqli_error($conn);
                else return true;

                return false;
            } else return false;
        }

        //jesus CHRIST can we please stick to camelcase or underscores, using both is hurting my brain
        function Register_email($email)
        {
            if (!check_Email($email)) return false;
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "UPDATE cseBay_Users SET email = '$email' WHERE userName = '$this->username'");
            if (!$result) return false;
            return true;
        }

        function check_Email($email)
        {
            $emailRegEx = '/^[a-zA-Z0-9]+\@[a-zA-Z0-9]+\.[a-zA-Z]+$/';
            if (!preg_match($emailRegEx, $email)) return false;

            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT email FROM cseBay_Users WHERE email = " . '"' . "$email" . '"');
            $row = mysqli_fetch_assoc($result);

            //This may not work. Please test and make sure the return type is null on no matches
            if ($row['email'] != $email) return true;
            return false;
        }

        //Think this should be called set password, but that's not what the design doc says
        function Register_password($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");

            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "UPDATE cseBay_Users SET password = '$token' WHERE userName = '$this->username'");
            if (!$result) echo "Something went wrong, boss: " . mysqli_error($conn);
            else return true;

            return false;
        }

        //Can we sit down and discuss our design doc? Classes should be nouns, not verbs.
        //A lot of these "classes" should be functions in this class. And the inconsistent naming
        //is driving me bananas.
        function login($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");

            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT password FROM cseBay_Users WHERE userName = '$this->username'");
            $row = mysqli_fetch_assoc($result);
            if ($row['password'] != $password) echo "Password was wrong, boss: " . mysqli_error($conn);
            else return true;

            return false;
        }

        function setSession()
        {
            session_start();

            if(isset($_SESSION["type"])) {
                if ($_SESSION["type"] == "admin") {
                    header('Location: admin_page.php');
                    exit();
                } else {
                    header('Location: user_page.php');
                    exit();
                }
            }
        }

        

    }