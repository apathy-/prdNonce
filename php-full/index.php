<?php

require_once '../prdNonce.php';
session_start();

try {

	$n = new prdNonce;
	if(!$n) {
		throw new Exception("No session ID was available");
	}
	$n->setExpiry(5);

	$nonce = $n->getNonce()['token'];

} catch(Exception $e) {
	echo "EXCEPTION: " . $e->getMessage();
	die();
}
?>


<form method='POST' action='submit.php'>
	<input type='text' name='text' value='Some form fields'><br />
	<input type='text' name='nonce' value='<?php echo $nonce; ?>'><br />
	<input type='submit'>
</form>