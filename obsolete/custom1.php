<?php

/*
 * Custom SMS 1
 * 
 * Input Variables:
 *  $msg : Text message
 *  $mobile : User mobile number
 *  $flash : true for flash SMS, false for normal SMS 
 *  $sender : Sender mobile number
 *  $username : SMSC connection username
 *  $password : SMSC connection password
 *  $account : SMSC account ID
 *  $url : SMSC SOAP service url
 *  $proxy : proxy server connection data
 *  &$error : error message
 * 
 * Return values:
 *  true for success
 *  false for error
 */

//
// SMSEagle SMSC connector using HTTP-GET
//

function smshub_custom1 ($msg, $mobile, $flash, $sender, $username, $password, $account, $url, $proxy, &$error) {
    $msg = urlencode($msg);

    $url = $url.'/index.php/http_api/send_sms?login='.$username.'&pass='.$password.'&to='.$mobile.'&message='.$msg;
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $ret = curl_exec($ch);    
    curl_close($ch);
    
    if (!$ret) {
	$error = "Invalid HTTP response";
	return false;
    }
    return true;
}

?>