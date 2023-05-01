<!--HAMBURGER BELOW -->
<link rel="stylesheet" href="css/hamburger.css">
	<nav role="navigation">
	  <div id="menuToggle">
	    <!--
	    A fake / hidden checkbox is used as click reciever,
	    so you can use the :checked selector on it.
	    -->
	    <input type="checkbox" />
	    
	    <!--
	    Some spans to act as a hamburger.
	    
	    They are acting like a real hamburger,
	    not that McDonalds stuff.
	    -->
	    <span></span>
	    <span></span>
	    <span></span>
	    
	    <!--
	    Too bad the menu has to be inside of the button
	    but hey, it's pure CSS magic.
	    -->
	    <ul id="menu">
	      <a href="projects.php"><li>Projects</li></a>
	      <a href="payments.php"><li>Payments</li></a>
	      <a href="profile.php?id="<?php $_SESSION['UserID']?>><li>Profile</li></a>
	      <a href="technicians.php"><li>View Technicians</li></a>
	      <a href="contact-loggedin.php" id="contact"><li>Contact</li></a>
	    </ul>
	  </div>
	</nav>