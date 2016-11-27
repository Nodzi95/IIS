
<?
if(isset($_POST['ukaz_zakazniky'])){
	$res = mysql_query("select jmeno, prijmeni from cestujici", $conn);
	echo "<table border='0'>";
	echo "<tbody>";
	while ($data = mysql_fetch_array($res)) {
		echo "<tr>";
		echo "<td>{$data["jmeno"]}</td>";
		echo "<td>{$data["prijmeni"]}</td>";
		echo "</tr>\n";
	}
	echo "</tbody>";
	echo "</table>";
}
if(isset($_GET['storno'])){
	if(isset($_GET['hidden_lID'])){
		$query = "DELETE FROM letenka WHERE ID='".$_GET["hidden_lID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 2;
}


if(isset($_POST["rlogin"]) and $_POST["rlogin"] != "" and 
	isset($_POST["rpass"]) and $_POST["rpass"] != "" and 
	isset($_POST["rjmeno"]) and $_POST["rjmeno"] != "" and 
	isset($_POST["rprijmeni"]) and $_POST["rprijmeni"] != "" and 
	isset($_POST["rpas"]) and isset($_POST["rnaroz"])){
$query = "SELECT * FROM cestujici where login = '".$_POST["rlogin"]."'";
$res = mysql_query($query, $conn);
$data = mysql_fetch_array($res);
if($data["login"] == $_POST["rlogin"]) echo "tento login jiz existuje";
else{
$query = "INSERT INTO cestujici (jmeno, prijmeni, login, pass, datum_narozeni,cislo_pasu, pozice) VALUES ('"
	.mysql_real_escape_string($_POST["rjmeno"])."','"
	.mysql_real_escape_string($_POST["rprijmeni"])."','"
	.mysql_real_escape_string($_POST["rlogin"])."','"
	.mysql_real_escape_string($_POST["rpass"])."','"
	.mysql_real_escape_string($_POST["rnaroz"])."','"
	.mysql_real_escape_string($_POST["rpas"])."', 0);";

$result = mysql_query($query, $conn);
if(!($result)) echo "chyba";
else echo "Registrace probehla uspesne.";
?>
		<script>
			window.location.href="index.php";
		</script>
<?

}}

if(isset($_GET["objednat"])){
	$query="INSERT INTO letenka (cestujici_ID, let_ID) VALUES ('"
		.mysql_real_escape_string($_SESSION['login'])."','"
		.mysql_real_escape_string($_GET["hidden_ID"])."');";
	$i = 0;
	if(is_numeric($_GET["mnozstvi"])){
		$quant = (int)$_GET["mnozstvi"];
		if($quant <= 10){
			while($i < $quant){
				$result=mysql_query($query,$conn);
				if(!($result)) echo "chyba";
				$i = $i + 1;
			}
			
		}
		else{
			?><script>alert("To bys chtel co!");</script><?
		}
	}
	else{
		?><script>alert("Ani to nezkousej!");</script><?	
	}
	$_GET["menu"] = 3;
	
}



if(isset($_POST["zlogin"]) and $_POST["zlogin"] != "" and 
	isset($_POST["zpass"]) and $_POST["zpass"] != "" and 
	isset($_POST["zjmeno"]) and $_POST["zjmeno"] != "" and 
	isset($_POST["zprijmeni"]) and $_POST["zprijmeni"] != ""){
$query = "SELECT * FROM cestujici where login = '".$_POST["zlogin"]."'";
$res = mysql_query($query, $conn);
$data = mysql_fetch_array($res);
if($data["login"] == $_POST["zlogin"]) echo "tento login jiz existuje";
else{
$query = "INSERT INTO cestujici (jmeno, prijmeni, login, pass, pozice) VALUES ('"
	.mysql_real_escape_string($_POST["zjmeno"])."','"
	.mysql_real_escape_string($_POST["zprijmeni"])."','"
	.mysql_real_escape_string($_POST["zlogin"])."','"
	.mysql_real_escape_string($_POST["zpass"])."', 1);";

$result = mysql_query($query, $conn);
if(!($result)) echo "chyba";
else echo "Registrace probehla uspesne.";
?>
		<script>
			window.location.href="index.php";
		</script>
<?

}
}

if(isset($_GET["removeZ"])){
	if(isset($_GET['hidden_ID'])){
		$query = "DELETE FROM cestujici WHERE ID='".$_GET["hidden_ID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 2;
}

if(isset($_POST["tnazev"]) && $_POST["tnazev"]!= ""){
	
	$query = "SELECT * FROM terminal where nazev = '".$_POST["tnazev"]."'";
	$res = mysql_query($query, $conn);
	$data = mysql_fetch_array($res);
	if($data["nazev"] == $_POST["tnazev"]) echo "tento terminal jiz existuje";
	else{
		$query = "INSERT INTO terminal (nazev) VALUES ('"
			.mysql_real_escape_string($_POST["tnazev"])."');";

	}
	$result = mysql_query($query, $conn);
	$_GET["menu"] = 4;
}

if(isset($_GET["removeT"])){
	if(isset($_GET['hidden_tID'])){
		$query = "DELETE FROM terminal WHERE ID='".$_GET["hidden_tID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 5;
}

if(isset($_POST["goznaceni"]) && $_POST["goznaceni"]!= ""){
	$query = "SELECT * FROM gate where oznaceni = '".$_POST["goznaceni"]."'";
	$res = mysql_query($query, $conn);
	$data = mysql_fetch_array($res);
	if($data["oznaceni"] == $_POST["goznaceni"]) echo "tato brana jiz existuje";
	else{
		$query = "INSERT INTO gate (oznaceni, terminal_ID) VALUES ('"
			.mysql_real_escape_string($_POST["goznaceni"])."','"
			.mysql_real_escape_string($_POST["terminal"])."');";

	}
	$result = mysql_query($query, $conn);
	$_GET["menu"] = 6;
}


if(isset($_GET["removeG"])){
	if(isset($_GET['hidden_gID'])){
		$query = "DELETE FROM gate WHERE ID='".$_GET["hidden_gID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 7;
}

if(isset($_POST["loznaceni"]) && $_POST["loznaceni"]!= "" && isset($_POST["lvyrobce"]) && $_POST["lvyrobce"]!= ""){
	$query = "SELECT * FROM letadlo where oznaceni = '".$_POST["loznaceni"]."'";
	$res = mysql_query($query, $conn);
	$data = mysql_fetch_array($res);
	if($data["oznaceni"] == $_POST["loznaceni"]) echo "tato brana jiz existuje";
	else{
		$query = "INSERT INTO letadlo (oznaceni, typ_ID, vyrobce) VALUES ('"
			.mysql_real_escape_string($_POST["loznaceni"])."','"
			.mysql_real_escape_string($_POST["typ"])."','"
			.mysql_real_escape_string($_POST["lvyrobce"])."');";

	}
	$result = mysql_query($query, $conn);
	$_GET["menu"] = 8;
}

if(isset($_GET["removeL"])){
	if(isset($_GET['hidden_lID'])){
		$query = "DELETE FROM letadlo WHERE ID='".$_GET["hidden_lID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 9;
}

if(isset($_POST["LEz"]) && $_POST["LEz"]!= "" && isset($_POST["LEkam"]) && $_POST["LEkam"]!= "" && isset($_POST["LEdelka"])){
	$query = "INSERT INTO let (letadlo_ID, misto_odletu, misto_pristani, gate_ID, delka_letu, datum) VALUES ('"
		.mysql_real_escape_string($_POST["letadlo"])."','"
		.mysql_real_escape_string($_POST["LEz"])."','"
		.mysql_real_escape_string($_POST["LEkam"])."','"
		.mysql_real_escape_string($_POST["gate"])."','"
		.mysql_real_escape_string($_POST["LEdelka"])."','"
		.mysql_real_escape_string($_POST["LEdate"])."');";

	$result = mysql_query($query, $conn);
	$_GET["menu"] = 2;
}

if(isset($_GET["removeLE"])){
	if(isset($_GET['hidden_LEID'])){
		$query = "DELETE FROM let WHERE ID='".$_GET["hidden_LEID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 3;
}
?>


