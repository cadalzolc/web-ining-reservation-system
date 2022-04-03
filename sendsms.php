<?php 

include('./includes/sms.php');

$sms = new SmsRenato();
$sms->to = '9978473320';

$body = nl2br('Hi, your reservation is not available.');

$sms->message = $body;
$sms_response = $sms->Send();

?>