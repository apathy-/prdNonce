<?php

require_once '../prdNonce.php';
session_start();

try{
	$n = new prdNonce;
	if(!$n) {
		throw new Exception("No session ID was available");
	}

	if($n->checkNonce($_POST['nonce'])) {
		echo "It worked";
	} else {
		throw new Exception("Nonce token failure");
	}

} catch(Exception $e) {

	echo "EXCEPTION: " . $e->getMessage();
	die();
}

