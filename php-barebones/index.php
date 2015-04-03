<?php

require_once '../prdNonce.php';
session_start();

$n = new prdNonce;
$n->setExpiry(5);
$nonce = $n->getNonce()['token'];

?>


<form method='POST' action='submit.php'>
	<input type='text' name='text' value='Some form fields'><br />
	<input type='hidden' name='nonce' value='<?php echo $nonce; ?>'><br />
	<input type='submit'>
</form>