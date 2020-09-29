<?php
$ip = $_SERVER['REMOTE_ADDR'];
$mac = shell_exec('arp -a'. escapeshellarg($ip));
$findme = "Physical";
$pos = strpos($mac, $findme);
$macp = substr($mac,($pos+42),26);

if(empty($mac))
{
die("No mac address for $ip not found");
}
echo "mac address for $ip: $macp";

?>
