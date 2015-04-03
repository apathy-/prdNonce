<?php

require_once '../prdNonce.php';
session_start();

$n = new prdNonce;

if($n->checkNonce($_POST['nonce'])) {
	echo "It worked";
} else {
	echo "It failed";
}