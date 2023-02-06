<img src="https://wasabiwallet.io/img/logo.svg">

# wasabi-wallet-php

This PHP library provides a straightforward solution for integrating the Wasabi Wallet into your projects. The library enables you to utilize various RPC methods, and if you require additional methods, they can be found in the RPC reference available at https://docs.wasabiwallet.io/using-wasabi/RPC.html.

It should be noted that while I did come across a repository on GitHub named "Javascript Wasabi wallet API", it was incomplete, thus this PHP version offers a comprehensive solution.


# Usage Example
```php
<?php
$rpc = new WasabiRPC('http://127.0.0.1:37128', 'user', 'pass');
$rpc->selectWallet('test');
echo $rpc->getNewAddress('label');
?>
```
