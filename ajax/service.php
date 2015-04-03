<?php

require_once '../prdNonce.php';
session_start();

try {

	//instanciate class and check it didn't fail'
	$n = new prdNonce;
	if(!$n) {
		throw new Exception("No session ID was available");
	}

	//check the posted value against the session
	$data = array();
	if($n->checkNonce($_POST['nonce'])) {
		//success. set header and data values
		$header = 'HTTP/1.1 200 OK';
		$data = array( 'nonce' => $n->getNonce()['token'], 'expiry' => date('r', $n->getNonce()['expiry'])  );
	} else {
		//bad token. send appropriate header
		$header = 'HTTP/1.1 403 Unauthorized';
		$data = $_SESSION;
	}

	//send headers as appropriate, plus data if any
	header($header);
	if($data) {
		header('Content-type: application/json');
		die( json_encode($data) );
	}

} catch(Exception $e) {
	echo "EXCEPTION: " . $e->getMessage();
	die();
}
?>