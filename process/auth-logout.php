<?php

function BaseURL()
{
    return "http://localhost/thesis/reservation/";
}

session_start();
session_destroy();

header('Location:' . BaseURL());