<?
$server = "localhost:/var/run/mysql/mysql.sock";
$user = "xnodza00";
$pass = "ucicum6a";
$name = "xnodza00";

$conn= mysql_connect($server, $user, $pass) or die("Nelze se pøipojit");

if(!mysql_select_db($name, $conn)){
	echo "chyba pøi pøipojení k databázi";
	exit();
}

?>