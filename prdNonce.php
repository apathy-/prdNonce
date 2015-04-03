<?php

#namespace prd;

//TODO DB integration

class prdNonce {

	public $expiry = 600;

	public function __construct() {
		//check session is created
		if("" == session_id()) {
			return false;
		}
		$this->setExpiry();
		return true;
	}

	//generate nonce
	public function generateNonce() {
		return md5(uniqid());
	}

	// expiry in seconds
	public function setExpiry($expiry=false) {
		//if we set an expiry on one page, and not on another when we check the nonce
		//then the expiry will revert to default, hence this:
		if(isset($_SESSION['prd_nonce']['expiryInterval'])) {
			$this->expiry = $_SESSION['prd_nonce']['expiryInterval'];
		}

		//override with a user-defined value
		if($expiry && is_numeric($expiry)) {
			$this->expiry = $expiry;
		}
	}

	//set nonce
	public function setNonce($nonce) {
		$_SESSION['prd_nonce'] = array ( 
			'token' => $nonce, 
			'expiry' => time() + $this->expiry, 
			'expiryInterval' => $this->expiry
		);
	}

	//fetch nonce data
	public function getNonce() {
		if(empty($_SESSION['prd_nonce']['token'])) {
			$this->setNonce($this->generateNonce());
		} else {
			$this->setNonce($_SESSION['prd_nonce']['token']);
		}

		return $_SESSION['prd_nonce'];
	}


	//check nonce
	public function checkNonce($nonce) {
		//token matches and is within allowed expiry timeframe
		if($nonce == $_SESSION['prd_nonce']['token'] && time() < $_SESSION['prd_nonce']['expiry']) {
			$this->setNonce($this->generateNonce());
			return true;
		}
		return false;
	}

}