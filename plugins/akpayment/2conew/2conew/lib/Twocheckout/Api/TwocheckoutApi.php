<?php

class Twocheckout_Api_Requester
{
    public $apiBaseUrl;
    public $environment;
    private $user;
    private $pass;

	function __construct() {
            $this->user = Twocheckout::$user;
            $this->pass = Twocheckout::$pass;
            $this->apiBaseUrl = Twocheckout::$apiBaseUrl;
            $this->environment = Twocheckout::$environment;
    }

	function do_call($urlSuffix, $data=array())
    {
        $url = $this->apiBaseUrl . $urlSuffix;
        $ch = curl_init($url);
        if ($this->environment === "development") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json"));
        curl_setopt($ch, CURLOPT_USERAGENT, "2Checkout PHP/0.1.0%s");
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->user}:{$this->pass}");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $resp = curl_exec($ch);
        curl_close($ch);
        if ($resp === FALSE) {
            throw new Twocheckout_Error("cURL call failed", "403");
        } else {
            return $resp;
        }
	}

}
