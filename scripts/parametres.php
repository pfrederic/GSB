<?
//$hote="172.16.51.15";
$hote="127.0.0.1";//Penser à virer cette ligne lorsque le taff sera fait
$user="technicien";
$mdp="ini01";
$base="db_gestionCR";

mysql_connect($hote,$user,$mdp);
mysql_select_db($base);

?>
