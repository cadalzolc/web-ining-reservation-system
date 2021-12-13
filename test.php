<?php

    $access_token = "S59g3YXzr2DthQyepBxjf5l2hFoWhfVIF9epQAXOwfY";
    $url = "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/21666274/requests?access_token=" . $access_token;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        CURLOPT_POSTFIELDS => json_encode('{ "outboundSMSMessageRequest": { "address": "9055576257", "clientCorrelator": "21666274", "senderAddress": "6274", "outboundSMSTextMessage": {"message": "From Resort"} } }'),
    ));

    $response = curl_exec($curl);
    $results = json_decode($response, true);

    echo json_encode($results);
    
?>