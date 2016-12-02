<?
//zobrazeni vsech lidi v db
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
//smazani letenky
if(isset($_GET['storno'])){
	$mista = (int)$_GET["hidden_mista"];
	if(isset($_GET['hidden_lID'])){
		$query = "DELETE FROM letenka WHERE ID='".$_GET["hidden_lID"]."'";
		$res = mysql_query($query, $conn);
		$query="UPDATE let SET
			mista='".mysql_real_escape_string($mista + 1)."'
			WHERE ID='".$_GET["hidden_letID"]."';";
		$result=mysql_query($query, $conn);
	}
	$_GET["menu"] = 2;
}
//vytvoreni zakaznika
if(isset($_POST["regZ"])){
	if(isset($_POST["rlogin"]) and $_POST["rlogin"] != "" and 
		isset($_POST["rpass"]) and $_POST["rpass"] != "" and 
		isset($_POST["rjmeno"]) and 
		isset($_POST["rprijmeni"]) and 
		isset($_POST["rpas"]) and isset($_POST["rnaroz"])){

		$query = "SELECT * FROM cestujici where login = '".$_POST["rlogin"]."'";
		$res = mysql_query($query, $conn);
		$data = mysql_fetch_array($res);
		if($data["login"] == $_POST["rlogin"]){
			?><script>alert("Tento login jiz nekdo pouziva");</script><?
		}
		else{
		$query = "INSERT INTO cestujici (jmeno, prijmeni, login, pass, datum_narozeni,cislo_pasu, pozice) VALUES ('"
			.mysql_real_escape_string($_POST["rjmeno"])."','"
			.mysql_real_escape_string($_POST["rprijmeni"])."','"
			.mysql_real_escape_string($_POST["rlogin"])."','"
			.mysql_real_escape_string($_POST["rpass"])."','"
			.mysql_real_escape_string($_POST["rnaroz"])."','"
			.mysql_real_escape_string($_POST["rpas"])."', 0);";

		$result = mysql_query($query, $conn);
		if(!($result)){?><script>alert("Udaje se nepodarilo pridat do db");</script><?}
		?>
				<script>
					window.location.href="index.php";
				</script>
		<?

		}
	}else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
		$_GET["menu"]=4;
	}
}
//vytvoreni letenky
if(isset($_GET["objednat"])){
	$quant = (int)$_GET["mnozstvi"];
	$mist = (int)$_GET["hidden_mista"];
	$res = $mist - $quant;
	if($res >= 0){
		$query="INSERT INTO letenka (cestujici_ID, let_ID) VALUES ('"
			.mysql_real_escape_string($_SESSION['login'])."','"
			.mysql_real_escape_string($_GET["hidden_ID"])."');";
		$i = 0;
		if(is_numeric($_GET["mnozstvi"])){
			global $quant, $res;
			if($quant <= 10){
				while($i < $quant){
					$result=mysql_query($query,$conn);
					if(!($result)) echo "chyba";
					$i = $i + 1;
				}
				$query="UPDATE let SET
					mista='".mysql_real_escape_string($res)."'
					WHERE ID='".$_GET["hidden_ID"]."';";
				$result=mysql_query($query, $conn);
			
			}
			else{
				?><script>alert("Maximalne lze objednat 10 letenek");</script><?
			}
		}
		else{
			?><script>alert("Ciselna hodnota je vyzadovana");</script><?	
		}
	}
	else{
		?><script>alert("Prekrocena maximalni kapacita letadla");</script><?
	}
	$_GET["menu"] = 3;
	
}
//vytvoreni zamestnance
if(isset($_POST["regP"])){
	if(isset($_POST["zlogin"]) and $_POST["zlogin"] != "" and 
		isset($_POST["zpass"]) and $_POST["zpass"] != "" and 
		isset($_POST["zjmeno"]) and isset($_POST["zprijmeni"])){
		$query = "SELECT * FROM cestujici where login = '".$_POST["zlogin"]."'";
		$res = mysql_query($query, $conn);
		$data = mysql_fetch_array($res);
		if($data["login"] == $_POST["zlogin"]){
			?><script>alert("Tento login jiz nekdo pouziva");</script><?
		}
		else{
			$query = "INSERT INTO cestujici (jmeno, prijmeni, login, pass, pozice) VALUES ('"
				.mysql_real_escape_string($_POST["zjmeno"])."','"
				.mysql_real_escape_string($_POST["zprijmeni"])."','"
				.mysql_real_escape_string($_POST["zlogin"])."','"
				.mysql_real_escape_string($_POST["zpass"])."', 1);";

			$result = mysql_query($query, $conn);
			if(!($result)){
				?><script>alert("Udaje se nepodarilo pridat do db");</script><?
			}
			?>
					<script>
						window.location.href="index.php";
					</script>
			<?
		}
	}
	else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
	}
}
//smazani zamestnance
if(isset($_GET["removeZ"])){
	if(isset($_GET['hidden_ID'])){
		$query = "DELETE FROM cestujici WHERE ID='".$_GET["hidden_ID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 2;
}
//vytvoreni terminalu
if(isset($_POST["term"])){
	if(isset($_POST["tnazev"]) && $_POST["tnazev"]!= ""){
	
		$query = "SELECT * FROM terminal where nazev = '".$_POST["tnazev"]."'";
		$res = mysql_query($query, $conn);
		$data = mysql_fetch_array($res);
		if($data["nazev"] == $_POST["tnazev"]){
			?><script>alert("Tento terminal jiz existuje");</script><?
		}
		else{
			$query = "INSERT INTO terminal (nazev) VALUES ('"
				.mysql_real_escape_string($_POST["tnazev"])."');";

		}
		$result = mysql_query($query, $conn);
		unset($_POST["tnazev"]);
	}
	else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
	}
	$_GET["menu"] = 4;
}
//smazani terminalu
if(isset($_GET["removeT"])){
	if(isset($_GET['hidden_tID'])){
		$query = "DELETE FROM terminal WHERE ID='".$_GET["hidden_tID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 5;
}
//vytvoreni brany
if(isset($_POST["gate"])){
	if(isset($_POST["goznaceni"]) && $_POST["goznaceni"]!= "" && isset($_POST["terminal"])){
		$query = "SELECT * FROM gate where oznaceni = '".$_POST["goznaceni"]."'";
		$res = mysql_query($query, $conn);
		$data = mysql_fetch_array($res);
		if($data["oznaceni"] == $_POST["goznaceni"]){
			?><script>alert("Tato brana jiz existuje");</script><?
		}
		else{
			$query = "INSERT INTO gate (oznaceni, terminal_ID) VALUES ('"
				.mysql_real_escape_string($_POST["goznaceni"])."','"
				.mysql_real_escape_string($_POST["terminal"])."');";

		}
		$result = mysql_query($query, $conn);
		unset($_POST["goznaceni"]);
	}
	else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
	}
	$_GET["menu"] = 6;
}
//smazani brany
if(isset($_GET["removeG"])){
	if(isset($_GET['hidden_gID'])){
		$query = "DELETE FROM gate WHERE ID='".$_GET["hidden_gID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 7;
}
//vytvoreni letadla
if(isset($_POST["letadlo"])){
	if(isset($_POST["loznaceni"]) && $_POST["loznaceni"]!= "" && isset($_POST["lvyrobce"])){
		$query = "SELECT * FROM letadlo where oznaceni = '".$_POST["loznaceni"]."'";
		$res = mysql_query($query, $conn);
		$data = mysql_fetch_array($res);
		if($data["oznaceni"] == $_POST["loznaceni"]){
			?><script>alert("Letadlo s timto oznacenim jiz existuje");</script><?
		}
		else{
			$query = "INSERT INTO letadlo (oznaceni, typ_ID, vyrobce) VALUES ('"
				.mysql_real_escape_string($_POST["loznaceni"])."','"
				.mysql_real_escape_string($_POST["typ"])."','"
				.mysql_real_escape_string($_POST["lvyrobce"])."');";
			unset($_POST["loznaceni"]);
			unset($_POST["lvyrobce"]);
		}
		$result = mysql_query($query, $conn);
	}
	else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
	}
	$_GET["menu"] = 8;
}
//smazani letadla
if(isset($_GET["removeL"])){
	if(isset($_GET['hidden_lID'])){
		$query = "DELETE FROM letadlo WHERE ID='".$_GET["hidden_lID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 9;
}
//vytvoreni letu
if(isset($_POST["letka"])){
	if(isset($_POST["lmista"]) && $_POST["lmista"] != "" && isset($_POST["LEz"]) && $_POST["LEz"] != "" && 
	isset($_POST["LEkam"]) && $_POST["LEkam"] != "" && isset($_POST["LEdelka"]) && isset($_POST["gate1"]) && 
	isset($_POST["LEdate"]) && isset($_POST["letadlo1"])){
		if(new DateTime() <= new DateTime($_POST["LEdate"])){
			$query = "INSERT INTO let (mista, letadlo_ID, misto_odletu, misto_pristani,
				gate_ID, delka_letu, datum) VALUES ('"
				.mysql_real_escape_string($_POST["lmista"])."','"
				.mysql_real_escape_string($_POST["letadlo1"])."','"
				.mysql_real_escape_string($_POST["LEz"])."','"
				.mysql_real_escape_string($_POST["LEkam"])."','"
				.mysql_real_escape_string($_POST["gate1"])."','"
				.mysql_real_escape_string($_POST["LEdelka"])."','"
				.mysql_real_escape_string($_POST["LEdate"])."');";
			unset($_POST["LEz"]);
			unset($_POST["LEkam"]);
			unset($_POST["LEdelka"]);
			unset($_POST["LEdate"]);
			unset($_POST["lmista"]);
			$result = mysql_query($query, $conn);
		}
		else{
			?><script>alert("Lety muzete planovat jen do budoucnosti");</script><?
		}
		
	}
	else{
		?><script>alert("Nevyplneny povinne udaje");</script><?
	}
	unset($_POST["let"]);
	$_GET["menu"] = 2;
}
//smazani letu
if(isset($_GET["removeLE"])){
	if(isset($_GET['hidden_LEID'])){
		$query = "DELETE FROM let WHERE ID='".$_GET["hidden_LEID"]."'";
		$res = mysql_query($query, $conn);
	}
	$_GET["menu"] = 3;
}
//smazani zakaznika
if(isset($_POST["deleteZ"])){
	$query = "DELETE FROM cestujici WHERE ID='".$_SESSION["login"]."'";
	$res = mysql_query($query, $conn);
	$_GET["menu"] = 1;
}
//smazani zamestnance
if(isset($_POST["deleteP"])){
	$query = "DELETE FROM cestujici WHERE ID='".$_SESSION["zam"]."'";
	$res = mysql_query($query, $conn);
	$_GET["menu"] = 1;
}
//smazani admina
/*
if(isset($_POST["deleteA"])){
	$query = "DELETE FROM cestujici WHERE ID='".$_SESSION["admin"]."'";
	$res = mysql_query($query, $conn);
	$_GET["menu"] = 1;
}*/
//editace zakaznika
if(isset($_POST["editZ"])){
	if($_POST["loginZE"] == ""){ ?><script>alert("Nemuzete smazat login");</script><?;}
	else if($_POST["passZE"] == ""){ ?><script>alert("Nemuzete smazat heslo");</script><?;}
	else{
		$query = "UPDATE cestujici SET
			jmeno='".mysql_real_escape_string($_POST["jmenoZE"])."',
			prijmeni='".mysql_real_escape_string($_POST["prijmeniZE"])."',
			login='".mysql_real_escape_string($_POST["loginZE"])."',
			pass='".mysql_real_escape_string($_POST["passZE"])."',
			cislo_pasu='".mysql_real_escape_string($_POST["pasZE"])."'
			WHERE ID='".$_SESSION["login"]."';";
		$res = mysql_query($query, $conn);
		?><script>alert("Vase udaje byly zmeneny");</script><?
		$_GET["menu"]=4;
	}
	
}
//editace zamestnance
if(isset($_POST["editP"])){
	if($_POST["loginE"] == ""){ ?><script>alert("Nemuzete smazat login");</script><?;}
	else if($_POST["passE"] == ""){ ?><script>alert("Nemuzete smazat heslo");</script><?;}
	else{
		$query = "UPDATE cestujici SET
			jmeno='".mysql_real_escape_string($_POST["jmenoE"])."',
			prijmeni='".mysql_real_escape_string($_POST["prijmeniE"])."',
			login='".mysql_real_escape_string($_POST["loginE"])."',
			pass='".mysql_real_escape_string($_POST["passE"])."'
			WHERE ID='".$_SESSION["zam"]."';";
		$res = mysql_query($query, $conn);
		?><script>alert("Vase udaje byly zmeneny");</script><?
		$_GET["menu"]=6;
	}
	
}
//editace admina
if(isset($_POST["editA"])){
	if($_POST["loginA"] == ""){ ?><script>alert("Nemuzete smazat login");</script><?;}
	else if($_POST["passA"] == ""){ ?><script>alert("Nemuzete smazat heslo");</script><?;}
	else{
		$query = "UPDATE cestujici SET
			jmeno='".mysql_real_escape_string($_POST["jmenoA"])."',
			prijmeni='".mysql_real_escape_string($_POST["prijmeniA"])."',
			login='".mysql_real_escape_string($_POST["loginA"])."',
			pass='".mysql_real_escape_string($_POST["passA"])."'
			WHERE ID='".$_SESSION["admin"]."';";
		$res = mysql_query($query, $conn);
		?><script>alert("Vase udaje byly zmeneny");</script><?
		$_GET["menu"]=10;
	}
	
}
?>