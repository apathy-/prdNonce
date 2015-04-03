# prdNonce
NONCE token class for PHP

Usage:

Get:
```
$n = new prdNonce;
//$n->setExpiry(30); //optional
$n->getNonce();
```

Test:
```
$n = new prdNonce;
$n->checkToken($token);
```

See examples in directory for different implementations
