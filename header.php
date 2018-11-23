<?php session_start();?>
<body>
<div class="jumbotron" style="margin: 0; color: #351648; text-align:center">
	<h1>cseBay</h1>
</div>


		<ul class="nav">
			<li class="nav-item"><a class="nav-link" href="http://pluto.cse.msstate.edu/~sfs111/cseBay/index.php" style="color:black">Home</a></li>
			<li class="nav-item"><a class="nav-link" href="createListing.php" style="color:black">Create a Listing</a></li>
            <?php if (isset($_SESSION['username'])) echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signOut.php\" style=\"color:black\">Sign out</a></li>";
            else echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"signIn.php\" style=\"color:black\">Sign in</a></li>"; ?>
		</ul>







