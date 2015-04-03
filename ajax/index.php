<?php

require_once '../prdNonce.php';
session_start();

try {

	//instanciate class, check for failure and set token
	$n = new prdNonce;
	if(!$n) {
		throw new Exception("No session ID was available");
	}
	$n->setExpiry(5);

	$nonce = $n->getNonce()['token'];
	$expiry = date('r', $n->getNonce()['expiry']);

} catch(Exception $e) {
	echo "EXCEPTION: " . $e->getMessage();
	die();
}
?>


<script src='//code.jquery.com/jquery-1.11.2.min.js'></script>

<script>
	$(document).ready(function() {
		$('#prd-form').submit(function(e) {
			e.preventDefault();

			//the form data we wish to send, in this example only the token
			var data = { nonce : $('#nonce').val() }

			//ajax post
			var jqxhr = $.post( "service.php", data, function(retval) {
			  //it worked. update the token and perform any business logic your frontend requires
			  $('#nonce').val(retval.nonce);
			  $('#expiry').html(retval.expiry);
			  alert( "Token accepted" );
			})
			  .fail(function() {
			  	//bad token, implement your failure case (reload dynamically | error message | redirect)
			    alert( "There was a problem verifying the token" );
			  });
		});
	});
</script>

<form method='POST' id='prd-form'>
	<input type='text' name='text' value='Some form fields' id='text'><br />
	<input type='text' name='nonce' value='<?php echo $nonce; ?>' id='nonce'><br />
	Expires: <span id='expiry'><?php echo $expiry; ?></span><br />
	<input type='submit'>
</form>