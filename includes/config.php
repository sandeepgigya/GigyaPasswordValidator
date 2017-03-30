<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("algorithms/algorithm.php");

$algorithms = array();

foreach(glob("algorithms/*.algorithm.php") as $file) 
{
   include($file);
   preg_match("/algorithms\/(.*).algorithm.php/", $file, $out);
   $obj = new $out[1]();
   $algorithms[$obj->getDisplayName()] = $obj;
}