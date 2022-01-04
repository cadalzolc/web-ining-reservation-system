<?php

class SmsRenato {

    public $to = '';
    public $message = '';

    function Send() {
        $data = array(
            'provider' => 'GLOBE',
            'token' => 'qnrTMGro8JtxtUlTKgd16x5RSWfgvbnImkvQ6mgUv_U',
            'sender' => '21660843',
            'to' => $this->to,
            'body' => $this->message,
        );   
        $payload = json_encode($data);   
        $crl = curl_init('https://gsm.niftyappmakers.com/globe/outbound');
    
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $payload);
          
        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
          
        curl_exec($crl);
        curl_close($crl);
    }

}

?>