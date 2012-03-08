<?php
/*error_reporting(E_ALL);
ini_set('php_flag display_errors','on'); 
ini_set('php_value error_reporting', E_ALL);
*/
$ip = array(
  '127.0.0.1' => "password",
  '::1' => "password2"
);

echo $_SERVER['REMOTE_ADDR'];
echo $ip;

if (!in_array(@$_SERVER['REMOTE_ADDR'], $ip))
{
   echo $ip["$_SERVER['REMOTE_ADDR']"];
}
else
{
  //header('HTTP/1.1 403 Forbidden');
}
