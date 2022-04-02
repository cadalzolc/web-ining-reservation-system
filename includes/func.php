<?php 

function IsNullOrEmptyString($str){
    return ($str === null || trim($str) === '');
}

function ToBoolean($res){
    return $res ? 'true' : 'false';
}