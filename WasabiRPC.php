<?php
/*
 * Wasabi Wallet RPC Library written in PHP
 * Reference: https://docs.wasabiwallet.io/using-wasabi/RPC.html
*/

class WasabiRPC {
    private $url;
    private $username;
    private $password;

    public function __construct($url, $username, $password) {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    public function labelHash() {
        // Use this to create a random label when getting a new address
        return hash("sha256", bin2hex(openssl_random_pseudo_bytes(16)));
    }

    public function selectWallet($wallet) {
        return $this->call("selectwallet", array($wallet));
    }

    public function getWalletInfo() {
        return $this->call("getwalletinfo", null);
    }

    public function getNewAddress($label) {
        return $this->call("getnewaddress", array($label));
    }

    public function getUnspentCoins() {
        return $this->call("listunspentcoins", null);
    }

    public function getHistory() {
        return $this->call("gethistory", null);
    }

    public function getListKeys() {
        return $this->call("listkeys", null);
    }

    private function call($method, $params) {
        $request = array(
            'jsonrpc' => '2.0',
            'id' => '1',
            'method' => $method,
            'params' => $params
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => array(
                    'Content-type: application/json',
                    'Authorization: Basic ' . base64_encode("$this->username:$this->password")
                ),
                'content' => json_encode($request)
            )
        );

        $context  = stream_context_create($options);

        set_error_handler(function($errno, $errstr) {
            error_log("file_get_contents failed: " . $errstr, 0);
        });

        $result = file_get_contents($this->url, false, $context);

        restore_error_handler();

        return json_decode($result, true);
    }
}
