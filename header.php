<?php session_start(); ?>
<body>
<div class="jumbotron" style="margin: 0; color: #4F4A41; background-image: linear-gradient(to bottom right, #DEF2F1, #3AAFA9); text-align:center">
    <div class= "container-fluid">
    <h1>cseBay</h1>
    <p>A Community Market for Computer Science Students</p>
    </div>
</div>


<ul class="nav">
    <li class="nav-item"><a class="nav-link" href="http://pluto.cse.msstate.edu/~sfs111/cseBay/index.php"
                            style="color:#17252A">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="createListing.php" style="color:#17252A">Create a Listing</a></li>
    <?php if (isset($_SESSION['username'])) echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signOut.php\" style=\"color:#17252A\">Sign out</a></li>";
    else echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signIn.php\" style=\"color:#17252A\">Sign in</a></li>";
        if (isset($_SESSION['username'])) echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"profile.php\" style=\"color:#17252A\">" . ($_SESSION['username']) . "</a></li>";
        if (isset($_SESSION['type'])) {
            if ($_SESSION['type'] == "admin") {
                echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"administrative.php\" style=\"color:#17252A\">Administrative</a></li>";
            }
        }
    ?>

</ul>
