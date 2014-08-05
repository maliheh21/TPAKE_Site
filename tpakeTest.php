<link rel="stylesheet" type="text/css" href="css/style.css" media="screen,projection">

<?php

$message = randomR();
$message = json_encode($message);

function RandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//generate a random 128, return a 20-character Hex-string
function randomR() {
    $seed = RandomString(16); 
    return md5($seed);
}


$tpakeTest = '
<html>
	<head></head>
	<body>
	<div id="container" class="clearfix">
		<h1>Send Random Number to Extension</h1>
				<h2>Send Random Number to Extension</h2>				
		<div id="content">
			<form action = "tpakeTest.php" method ="post">
				<label>Press Start: </label>
				<input type = "submit" name = "submit" id = "submit" value ="submit"  />
				<br/><br/>
				<label>Share is: </label>
				<input type = "text" name = "response" id = "response"/>
			</form>
			
			<script type="text/javascript">	
			// The ID of the extension we want to talk to.
			var editorExtensionId = "dcabpgeddgajfemobjcmoceobjjnpbcm";
			
			// Make a simple request:
			chrome.runtime.sendMessage(editorExtensionId, {message1: '.$message.'}, function(response) {
					console.log(response.share);
					document.getElementById("response").value = response.share;
			});
			</script>

		</div>
	</div>
	</body>
</html>';

echo $tpakeTest;

if (!extension_loaded('sockets')) {
    die('The sockets extension is not loaded.');
}
// create udp socket
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (!$socket)
        die('Unable to create AF_INIT socket');

// same socket will be later used in recv_from
// no binding is required if you wish only send and never receive



if (!socket_bind($socket, '127.0.0.1', 25002))
        die("Unable to bind to webserver socket");
		
		
$msg = "Message";
$len = strlen($msg);
// at this point 'server' process must be running and bound to receive from serv.sock
$bytes_sent = socket_sendto($socket, $msg, $len, 0, '127.0.0.1', 25004);
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
echo "Client exits\n";
?>