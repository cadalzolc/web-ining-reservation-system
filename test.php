<?php

    $amount = 10000000;

    $body = 'Hi Renato' .  nl2br(', we would like to have your confirmation with the reservation details.');
    $body = $body . nl2br('Date Arrival:  . 0 . \n');
    $body = $body . nl2br('Name of Aminity: 0 \n');
    $body = $body . nl2br('No. of Units: 0 \n');
    $body = $body . nl2br('Amount: ₱ ' . number_format($amount, 2, '.',  ','). '\n\n');
    $body = $body . nl2br('If your are still interested with your reservation please reply "RESERVATION CONFIRMED". And there is a problem just call "09778299069" to reach out with our staff. Thank you');

    echo $body;
    
?>