<link rel="stylesheet" type="text/css" href="css/style.css" media="screen,projection">

<?php


$login = '
<html>
	<head>
	</head>
	<body>
	<div id="container" class="clearfix">
		<h1>TPAKE</h1>
		<h2>TPAKE</h2>
		
		<div id="content">
			<div align = "center" id="qrcode"></div> 
			<form action = "login.php" method ="post">
				<br/><br/>
				<label>Username: </label>							
				<input type = "text" name = "username" id = "username" value = "abcdefghijklmno"/>
				<br/><br/>
				<label>Password: </label>
				<input type = "password" name = "password" id = "password" value = "abcdefghijklmno"/>
				<br/><br/>
				<label>random: </label>
				<input type = "text" name = "random" id = "random" />
				<br/><br/>
	
				<input type = "submit" name = "login" id = "login" value ="login" />
			</form>
			
		</div>
	</div>
	</body>
</html>';

if (!isset($_POST['login'])) {
	echo $login;	
}
else {
	echo $login;
	
	$password = json_encode($_POST['password']);
	
	
	$SERVERIP = "192.168.1.153";
	$SERVERPORT = 25012;
	$WEBSERVERIP = "192.168.1.153";
	$WEBSERVERPORT = 25006;
	$CLIENTIP = "192.168.1.153";
	$CLIENTPORT = 25008;
	$DEVICEIP = "192.168.1.253";
	$DEVICEPORT = 25010;
	
	/*
	$SERVERIP = "164.111.225.176";
	$SERVERPORT = 25012;
	$WEBSERVERIP = "164.111.225.176";
	$WEBSERVERPORT = 25006;
	$CLIENTIP = "164.111.225.176";
	$CLIENTPORT = 25008;
	$DEVICEIP = "164.111.197.158";
	$DEVICEPORT = 25010; */
	
	//send start command to application servers
	if (!extension_loaded('sockets')) {
	    die('The sockets extension is not loaded.');
	}
	// create udp socket
	$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	if (!$socket)
	        die('Unable to create AF_INIT socket');
	
	// same socket will be later used in recv_from
	// no binding is required if you wish only send and never receive	
	if (!socket_bind($socket, $WEBSERVERIP, $WEBSERVERPORT))
	        die("Unable to bind to webserver socket");
			
	$msg = "KeyExchange"; 
	$len = strlen($msg);
	// at this point 'server' process must be running and bound to receive from serv.sock
	$bytes_sent = socket_sendto($socket, $msg, $len, 0, $SERVERIP, $SERVERPORT);
	if ($bytes_sent == -1)
	        die('An error occured while sending to the socket');
	else if ($bytes_sent != $len)
	        die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
	
	/*
	// use socket to receive data
	if (!socket_set_block($socket))
	        die('Unable to set blocking mode for socket');
	$buf = '';
	$from = '';
	// will block to wait server response
	$bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
	if ($bytes_received == -1)
	        die('An error occured while receiving from the socket');
	echo "Received $buf from $from\n";
	*/
	
	// close socket and delete own .sock file
	socket_close($socket);
	
		echo '	<script type="text/javascript">	
		// The ID of the extension we want to talk to.
		var editorExtensionId = "pcgdajlpaongdlncklnkoaomfkmebdnc";
		
		// Make a simple request:
		chrome.runtime.sendMessage(editorExtensionId, {message1: '.$password.'}, function(response) {
				console.log(response.secretR);
				document.getElementById("random").value = response.secretR;
		});
		</script>';

}

?>