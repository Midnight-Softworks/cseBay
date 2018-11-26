<?php
    /**
     * Created by PhpStorm.
     * User: Mid
     * Date: 11/15/2018
     * Time: 9:32 AM
     */
    session_start();?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create an account</title>
    <style>
        input {
            margin-bottom: 0.5em;
        }
    </style>
</head>
<body>
<?php
    //THIS IS NOT FINISHED. I made this file just so that I could add test items to the database.
    include 'login.php';
    include 'User.php';

    //If submit is not set, the form hasn't been filled yet. Default to empty fields and no errors
    if (isset($_POST['submit'])){

        //For the following, set the entered values if they exist. Otherwise, default to blank
        if (isset($_POST['username']))$name = $_POST['username'];
        else $name = "";
        if (isset($_POST['password']))$password = $_POST['password'];
        else $password = "";

        $newUser = new User($name);
        if($newUser->registerUser($password)) {
            $_SESSION['type'] = "user";
            $_SESSION['username'] = $name;
        }
        else {
            $credentialError = "The username is not available.";
        }

        //PLEASE DO NOT FORGET TO FINISH

    }

    //This is the case mentioned above, where the form hasn't been filled
    else{
        $name = "";
        $password = "";
        $credentialError = "";
    }
    if(isset($_SESSION['type'])){
        if($_SESSION['type'] == "user") header('Location: index.php');
        if($_SESSION['type'] == "admin") header('Location: index.php');
    }
?>
<h1>Welcome to <span style="font-style:italic; font-weight:bold; color: #2B7A78">
                cseBay</span>!</h1>

<p style="color: red">
    <?php echo $credentialError; ?>
</p>

<form method="post" action="signUp.php">
    <label>Username: </label>
    <input type="text" name="username" value = "<?php echo $name;?>"> <br>
    <label>Password: </label>
    <input type="password" name="password" value = "<?php echo $password;?>"> <br>
    <input type="submit" name ="submit" value="Create Account">
</form>

<p style="font-style:italic">
    Placeholder for "forgot password" link<br><br>
</p>
</html>
<?php
    // place useful functions here
    // examples: salt and hash a string
    //           check to see if a username/password combination is valid
    //           forward user or admin to the correct page


?>
