<?php
function escape($string){
	$string = filter_var($string, FILTER_SANITIZE_STRING);
	$string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    return $string;
}

