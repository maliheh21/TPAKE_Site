<link rel="stylesheet" type="text/css" href="css/style.css" media="screen,projection">

<?php

$mainpage = 
    '<html>
	<head></head>

	<body>
		<div id="container" class="clearfix">          
			<h1>TPake</h1>
			<h2>TPake</h2>

			<div id="content">
			<form action = "main.php" method ="post">
				<input type = "submit" name = "Login" id = "Login" value ="Login" />
				<input type = "submit" name = "Signup" id = "Signup" value = "Signup"/>
				<br/><br/>
			</form>
			</div>
		</div>
	</body>
</html>';
	
if(!isset($_POST['Signup']) && !isset($_POST['Login']) ){
	echo($mainpage);
}
else{
    if (isset($_POST['Signup'])) {
		echo "<form action='signup.php' method='post' name='frm'>";
        echo '</form>';
        echo '<script language="JavaScript">
        document.frm.submit();
        </script>';
    }
    else if (isset ($_POST['Login'])){
		echo "<form action='login.php' method='post' name='frm'>";
        echo '</form>';
        echo '<script language="JavaScript">
        document.frm.submit();
        </script>';
      }
}

?>