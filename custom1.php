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
 *  $password : SMSC connection password (used as API token for SMSEagle APIv2)
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
// SMSEagle SMSC connector using APIv2 (JSON POST)
//

function smshub_custom1 ($msg, $mobile, $flash, $sender, $username, $password, $account, $url, $proxy, &$error) {
    $apiUrl = rtrim($url, '/') . '/api/v2/messages/sms';

    $payload = json_encode([
        'to' => [$mobile],
        'text' => $msg
    ]);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'access-token: ' . $password
    ]);
    curl_setopt($ch, CURLOPT_FAILONERROR, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $ret = curl_exec($ch);
    curl_close($ch);

    if (!$ret) {
	$error = "Invalid HTTP response";
	return false;
    }
    return true;
}

?>
