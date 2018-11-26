<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/14/2018
     * Time: 6:41 PM
     */

    //Whoever did the UML diagrams, you need a strong talking to.
    class User
    {
        private $username = "";

        function __construct($username)
        {
            $this->username = $username;
        }

        //Returns true if the user is an administrator. False otherwise
        function isAdmin()
        {
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT isAdmin FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            if ($row['isAdmin'] == true) return true;
            return false;
        }

        function passwordNeedsReset()
        {
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT passwordIsSet FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            if ($row['passwordIsSet'] == false) return true;
            return false;
        }

        function isUserAvailable()
        {
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT userName FROM cseBay_Users WHERE userName = " . '"' . "$this->username" . '"');
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            if ($row['username'] != $this->username) return true;
            return false;
        }

        function registerUser($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");
            if ($this->isUserAvailable()) {
                include 'login.php';
                $conn = mysqli_connect($hn, $un, $pw, $db);

                //Got an error? Scream it out
                if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

                $result = mysqli_query($conn, "INSERT INTO cseBay_Users (userName, password) VALUES('$this->username', '$token') ");
                if (!$result) {
                    echo "Something went wrong, boss: " . mysqli_error($conn);
                    mysqli_close($conn);
                    return false;
                } else {
                    mysqli_close($conn);
                    return true;
                }

            } else return false;
        }

        //jesus CHRIST can we please stick to camelcase or underscores, using both is hurting my brain
        function registerEmail($email)
        {
            if (!checkEmail($email)) return false;
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "UPDATE cseBay_Users SET email = '$email' WHERE userName = '$this->username'");
            if (!$result) {
                mysqli_close($conn);
                return false;
            }
            mysqli_close($conn);
            return true;
        }

        function checkEmail($email)
        {
            $emailRegEx = '/^[a-zA-Z0-9]+\@[a-zA-Z0-9]+\.[a-zA-Z]+$/';
            if (!preg_match($emailRegEx, $email)) return false;

            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "SELECT email FROM cseBay_Users WHERE email = " . '"' . "$email" . '"');
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);

            //This may not work. Please test and make sure the return type is null on no matches
            if ($row['email'] != $email) return true;
            return false;
        }

        //Think this should be called set password, but that's not what the design doc says
        function changePassword($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");

            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            $result = mysqli_query($conn, "UPDATE cseBay_Users SET password = '$token' WHERE userName = '$this->username'");
            if (!$result) {
                echo "Something went wrong, boss: " . mysqli_error($conn);
                mysqli_close($conn);
            } else {
                mysqli_close($conn);
                return true;
            }

            return false;
        }

        //Can we sit down and discuss our design doc? Classes should be nouns, not verbs.
        //A lot of these "classes" should be functions in this class.

        function login($password)
        {
            $salt1 = "Salt Lake City Utah, 18475%@)";
            $salt2 = "7898uhakjhhv^!%@*HHO&*H&*";
            $token = hash('ripemd256', "$salt1$password$salt2");
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);
            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $result = mysqli_query($conn, "SELECT password FROM cseBay_Users WHERE userName = '$this->username'");
            $row = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            if ($row['password'] != $token) echo "Password was wrong, boss: " . mysqli_error($conn);
            else return true;
            return false;
        }

        function setSession()
        {
            session_start();
            if (isset($_SESSION["type"])) {
                if ($_SESSION["type"] == "admin") {
                    header('Location: admin_page.php');
                    exit();
                } else {
                    header('Location: user_page.php');
                    exit();
                }
            }
        }

        function bid($listingID, $newBidAmount)
        {
            include 'login.php';
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            $sql = "SELECT * FROM cseBay_Listings WHERE listingID = " . $listingID;
            $result = mysqli_query($conn, $sql);
            $listing = mysqli_fetch_assoc($result);

            if ($listing['currentBid'] < $newBidAmount) {
                $newNumberOfBids = $listing['numberOfBids'] + 1;
                $result = mysqli_query($conn, "UPDATE cseBay_Listings SET currentBid = " . $newBidAmount . ", numberOfBids = " . $newNumberOfBids . ", currentHighBidder = '" . $this->username . "' WHERE listingID = " . $listingID);
                mysqli_close($conn);
                return true;
            } else {
                mysqli_close($conn);
                return false;
            }
        }

        function forceDeleteUser($username)
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            if ($this->isAdmin()) {
                $result = mysqli_query($conn, "DELETE '*' FROM cseBay_Users WHERE userName = '$username'");     //deleting user
                mysqli_close($conn);
                return true;
            }
            mysqli_close($conn);
            return false;
        }

        function makeAdmin($username)
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            if ($this->isAdmin()) {
                $result = mysqli_query($conn, "UPDATE cseBay_Users SET isAdmin = 1 WHERE username = '$username'");
                return true;
            }
            return false;
        }

        function removeAdmin($username)
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            if ($this->isAdmin()) {
                $result = mysqli_query($conn, "UPDATE cseBay_Users SET isAdmin = 0 WHERE username = '$username'");
                return true;
            }
            return false;
        }

        function forceDeleteList($listingID)
        {
            include 'login.php';
            global $hn, $pw, $un, $db;
            $conn = mysqli_connect($hn, $un, $pw, $db);

            //Got an error? Scream it out
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            if ($this->isAdmin()) {
                $result = mysqli_query($conn, "DELETE '*' FROM cseBay_Users WHERE userName = '$listingID'");     //deleting user
                return true;
            } else {
                return false;
            }
        }
    }