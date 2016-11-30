<?
/*TODO 	
	- zakazat stornovat lety z minulosti
*/
function main($menu, $conn){
?>	<div>
		<ul>
			<li><a href="?menu=0">Domů</a></li>
			<li><a href="?menu=1">Letenky</a></li>
			<li><a href="?menu=2">Kontakt</a></li>
			<li><a href="?menu=3">Přihlásit</a></li>
			<li><a href="?menu=4">Registrovat</a></li>		
		</ul>
	</div>

<?

switch($menu){
	case 0:?>
		<div>
			<p>
				<span>Vítejte v cestovní kancéláři "název"</span>
			</p>		
		</div>
	<?break;
	case 1:?>
		<div>
			<p>
				<span>Zobrazí se výběr letenek</span>
			</p>		
		</div>
	<?break;
	case 2:?>
		<div>
			<p>
				Božetěchova 2 <br>
				Brno, Královo Pole <br>
				email: <a href="mailto:tonechces@neco.cz">tonechces@neco.cz</a><br>
				tel: 123 456 789
			</p>		
		</div>
	<?break;
	case 3:?>
		<div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Přihlášení</div></td></tr>
				<tr><td><div><label>Login: </label></td><td><input type="text" name="name"/></div></td></tr>
				<tr><td><div><label>Heslo: </label></td><td><input type="password" name="pass"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="login"/></td></tr>
			</div></form>
			</tbody>
			</table>	
		</div>
	<?break;
	case 4:?>
		<div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Registrace</div></td></tr>
				<tr><td><div><label>*Login:</label></td><td><input type="text" name="rlogin" value="<?php if(isset($_POST["rlogin"])) echo $_POST["rlogin"];?>"/></div></td></tr>
				<tr><td><div><label>*Heslo:</label></td><td><input type="password" name="rpass" value="<?php if(isset($_POST["rpass"])) echo $_POST["rpass"];?>"/></div></td></tr>
				<tr><td><div><label>Jméno:</label></td><td><input type="text" name="rjmeno" value="<?php if(isset($_POST["rjmeno"])) echo $_POST["rjmeno"];?>"/></div></td></tr>
				<tr><td><div><label>Příjmení:</label></td><td><input type="text" name="rprijmeni" value="<?php if(isset($_POST["rprijmeni"])) echo $_POST["rprijmeni"];?>"/></div></td></tr>
				<tr><td><div><label>Narozeni:</label></td><td><input type="date" name="rnaroz" value="<?php if(isset($_POST["rnaroz"])) echo $_POST["rnaroz"];?>"/></div></td></tr>
				<tr><td><div><label>Pas:</label></td><td><input type="text" name="rpas" value="<?php if(isset($_POST["rpas"])){
						if(is_numeric($_POST["rpas"])){
							echo $_POST["rpas"];
						}
				}?>"/></div></td></tr>
				<tr><td></td><td><input type="submit" name="regZ" value="registrovat"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
	<?break;

}
}



function zakaz($menu,$conn){
	?><div>
		<ul>
			<li><a href="?menu=1">Odhlasit</a></li>
			<li><a href="?menu=0">Domu</a></li>
			<li><a href="?menu=4">Ucet</a></li>
			<li><a href="?menu=2">Moje letenky</a></li>
			<li><a href="?menu=3">Vyhledat let</a></li>	
				
		</ul>
	</div>

	<?
	switch($menu){
		case 0:?>
		<div>
			<p>
				<span>Vitejte uzivateli</span>
			</p>		
		</div>
		<?break;

		case 2:
		$query = "SELECT l.ID, le.datum, c.jmeno, c.prijmeni, le.misto_odletu as z, le.misto_pristani as do, le.mista as mista, le.ID as let_ID  
		FROM letenka l,cestujici c, let le
		WHERE c.ID = '".$_SESSION['login']."' AND c.id = l.cestujici_ID AND l.let_ID = le.ID;";

		$res = mysql_query($query, $conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while ($data = mysql_fetch_array($res)) {
			?><div>
				<form methon="post">
					<div>
						<tr><td>Z: <?echo $data["z"];?></td>
						<td>Do: <?echo $data["do"];?></td>
						<td>Datum: <?echo $data["datum"];?></td>
						<input type="hidden" name="hidden_lID" value="<?php echo $data["ID"];?>">
						<input type="hidden" name="hidden_letID" value="<?php echo $data["let_ID"];?>">
						<input type="hidden" name="hidden_mista" value="<?php echo $data["mista"];?>">
						<?if(new DateTime($data["datum"]) >= new DateTime()){?>
						<td><input type="submit" name="storno" value="Stornovat"></td>
						<?}?>
						</tr>
					</div>
				</form>
			</div><?		
		}
		echo "</tbody>";
		echo "</table>";
		break;

		case 3:
		$query="SELECT g.oznaceni as oznaceni, l.misto_odletu as misto_odletu,
		l.misto_pristani as misto_pristani, l.datum as datum, l.ID as ID, l.delka_letu as delka_letu, l.mista as mista
		FROM gate g, let l
		WHERE l.gate_ID = g.ID AND l.mista > 0 AND DATE(l.datum) >= DATE(NOW());";

		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="post">
					<div>
						<tr><td>Z: <?echo $data["misto_odletu"];?></td>
						<td>Do: <?echo $data["misto_pristani"];?></td>
						<td>Datum: <?echo $data["datum"];?></td>
						<td>Delka letu: <?echo $data["delka_letu"];?></td>
						<td>Brana: <?echo $data["oznaceni"];?></td>
						<td><input type="text" name="mnozstvi" value="1"/></td>
						<td><input type="hidden" name="hidden_ID" value="<?php echo $data["ID"];?>">
						<td><input type="hidden" name="hidden_mista" value="<?php echo $data["mista"];?>"></td>
						<td><input type="submit" name="objednat" value="Objednat"></td>
						<td>Pocet volnych mist: <?echo $data["mista"];?></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;

		case 4:
		/*if(isset($_GET["z"])){
			if($_GET["z"] == 99){
				?><script>alert("Vase udaje byly zmeneny");</script><?
			}
		}*/
		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["login"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
		echo "<table border='0'>";
		echo "<tbody>";
			?><form method="post">
				<tr><td>Jmeno: </td><td><input type="text" name="jmenoZE" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Prijmeni: </td><td><input type="text" name="prijmeniZE" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>*Login: </td><td><input type="text" name="loginZE" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>*Heslo: </td><td><input type="password" name="passZE" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td>Pas: </td><td><input type="text" name="pasZE" value="<?php echo $data["cislo_pasu"]?>"></td></tr>
				<tr><td><input type="submit" name="editZ" value="Editovat"></td>
				<td><input type="submit" name="deleteZ" value="Smazat ucet"></td></tr>
			</form><?
		echo "</tbody>";
		echo "</table>";
		break;
	}
}

function admin($menu, $conn){
	?><div>
		<ul>
			<li><a href="?menu=1">Odhlasit</a></li>	
			<li><a href="?menu=0">Domu</a></li>
			<li><a href="?menu=10">Ucet</a></li>
			<li><a href="?menu=3">Vytvorit zamestnance</a></li>
			<li><a href="?menu=2">Smazat zamestnance</a></li>
			<li><a href="?menu=4">Vytvorit terminal</a></li>
			<li><a href="?menu=5">Smazat terminal</a></li>
			<li><a href="?menu=6">Vytvorit branu</a></li>
			<li><a href="?menu=7">Smazat branu</a></li>
			<li><a href="?menu=8">Vytvorit letadlo</a></li>
			<li><a href="?menu=9">Smazat letadlo</a></li>
		</ul>
	</div>

<?
	switch($menu){
		case 3:?>
		<div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Registrace</div></td></tr>
				<tr><td><div><label>*Login:</label></td><td><input type="text" name="zlogin" value="<?php if(isset($_POST["zlogin"])) echo $_POST["zlogin"];?>"/></div></td></tr>
				<tr><td><div><label>*Heslo:</label></td><td><input type="password" name="zpass" value="<?php if(isset($_POST["zpass"])) echo $_POST["zpass"];?>"/></div></td></tr>
				<tr><td><div><label>Jméno:</label></td><td><input type="text" name="zjmeno" value="<?php if(isset($_POST["zjmeno"])) echo $_POST["zjmeno"];?>"/></div></td></tr>
				<tr><td><div><label>Příjmení:</label></td><td><input type="text" name="zprijmeni" value="<?php if(isset($_POST["zprijmeni"])) echo $_POST["zprijmeni"];?>"/></div></td></tr>
				<tr><td></td><td><input type="submit" name="regP" value="Vytvorit"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
		<?break;

		case 2:
		$query="SELECT * FROM cestujici where pozice = 1";
		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="POST">
					<div>
						<tr><td>Jmeno: <?echo $data["jmeno"];?></td>
						<td>Prijmeni: <?echo $data["prijmeni"];?></td>
						<td>Login: <?echo $data["login"];?></td>
						<td><input type="hidden" name="hidden_ID" value="<?php echo $data["ID"];?>">
						<td><input type="submit" name="removeZ" value="Odstranit"></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;
		case 0:?>
		<div>
			<p>
				<span>Vitejte pane admine</span>
			</p>		
		</div>
		<?break;

		//terminal
		case 4:?>
		<div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Vytvorit terminal</div></td></tr>
				<tr><td><div><label>*Nazev:</label></td><td><input type="text" name="tnazev"/></div></td></tr>
				<tr><td></td><td><input type="submit" name="term" value="Vytvorit"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
		<?break;

		case 5:
		$query="SELECT * FROM terminal";
		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="POST">
					<div>
						<tr><td>Nazev: <?echo $data["nazev"];?></td>
						<td><input type="hidden" name="hidden_tID" value="<?php echo $data["ID"];?>">
						<td><input type="submit" name="removeT" value="Odstranit"></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;	

		case 6:
		$query = "SELECT * FROM terminal";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt[] = $data;
		}
		?><div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Vytvorit branu</div></td></tr>
				<tr><td><div><label>*Nazev:</label></td><td><input type="text" name="goznaceni" value="<?php if(isset($_POST["goznaceni"])) echo $_POST["goznaceni"];?>"/></div></td></tr>
				<tr><td><div><label>*Terminal:</label></td><td>
				<?
				echo "<select name='terminal'>";
				foreach($opt as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				//echo $opt[0]['nazev'];
				//print_r($opt);
				?>
				</div></td></tr>
				<tr><td></td><td><input type="submit" name="gate" value="Vytvorit"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
		<?break;

		case 7:
		$query="SELECT * FROM gate";
		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="POST">
					<div>
						<tr><td>Nazev: <?echo $data["oznaceni"];?></td>
						<td><input type="hidden" name="hidden_gID" value="<?php echo $data["ID"];?>">
						<td><input type="submit" name="removeG" value="Odstranit"></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;

		case 8:
		$query = "SELECT * FROM typ";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt[] = $data;
		}
		?><div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Vytvorit letadlo</div></td></tr>
				<tr><td><div><label>*Oznaceni:</label></td><td><input type="text" name="loznaceni"/></div></td></tr>
				<tr><td><div><label>*Typ:</label></td><td>
				<?
				echo "<select name='typ'>";
				foreach($opt as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				//echo $opt[0]['nazev'];
				//print_r($opt);
				?>
				</div></td></tr>
				<tr><td><div><label>Vyrobce:</label></td><td><input type="text" name="lvyrobce" value="<?php if(isset($_POST["lvyrobce"])) echo $_POST["lvyrobce"];?>"/></div></td></tr>
				<tr><td></td><td><input type="submit" name="letadlo" value="Vytvorit"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
		<?break;

		case 9:
		$query="SELECT * FROM letadlo";
		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="POST">
					<div>
						<tr><td>Oznaceni: <?echo $data["oznaceni"];?></td>
						<td>Vyrobce: <?echo $data["vyrobce"];?></td>
						<td><input type="hidden" name="hidden_lID" value="<?php echo $data["ID"];?>">
						<td><input type="submit" name="removeL" value="Odstranit"></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;	

		case 10:

		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["admin"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
		echo "<table border='0'>";
		echo "<tbody>";
			?><form method="post">
				<tr><td>Jmeno: </td><td><input type="text" name="jmenoA" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Prijmeni: </td><td><input type="text" name="prijmeniA" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>*Login: </td><td><input type="text" name="loginA" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>*Heslo: </td><td><input type="password" name="passA" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td><input type="submit" name="editA" value="Editovat"></td>
				<td><input type="submit" name="deleteA" value="Smazat ucet"></td></tr>
			</form><?
		echo "</tbody>";
		echo "</table>";
		break;	
	}

}

function zam($menu, $conn){
	?><div>
		<ul>
			<li><a href="?menu=1">Odhlasit</a></li>	
			<li><a href="?menu=0">Domu</a></li>
			<li><a href="?menu=6">Ucet</a></li>
			<li><a href="?menu=2">Vytvorit let</a></li>
			<li><a href="?menu=3">Smazat let</a></li>

		</ul>
	</div><?
	switch($menu){	
		case 0:?>
			<div>
				<p>
					<span>Vitejte pane zamestnance</span>
				</p>		
			</div>
		<?break;

		case 2:
		$query = "SELECT * FROM letadlo";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt[] = $data;
		}
		$query = "SELECT * FROM gate";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt1[] = $data;
		}
		?><div>
			<table border='0'>
			<tbody>
			<form method="POST"><div>
				<tr><td><div>Vytvorit let</div></td></tr>
				<tr><td><div><label>*Oznaceni:</label></td><td>
				<?
				echo "<select name='letadlo1'>";
				foreach($opt as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</div></td></tr>
				<tr><td><div><label>*Z:</label></td><td><input type="text" name="LEz" value="<?php if(isset($_POST["LEz"])) echo $_POST["LEz"];?>"/></div></td></tr>
				<tr><td><div><label>*Kam:</label></td><td><input type="text" name="LEkam" value="<?php if(isset($_POST["LEkam"])) echo $_POST["LEkam"];?>"/></div></td></tr>
				<tr><td><div><label>*Gate:</label></td><td>
				<?
				echo "<select name='gate1'>";
				foreach($opt1 as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</div></td></tr>
				<tr><td><div><label>*Pocet mist:</label></td><td><input type="text" name="lmista" value="<?php if(isset($_POST["lmista"])) echo $_POST["lmista"];?>"/></div></td></tr>
				<tr><td><div><label>Delka letu:</label></td><td><input type="text" name="LEdelka" value="<?php if(isset($_POST["LEdelka"])) echo $_POST["LEdelka"];?>"/></div></td></tr>
				<tr><td><div><label>*Datum letu:</label></td><td><input type="date" name="LEdate" value ="<? echo date("Y-m-d") ?>"/></div></td></tr>
				<tr><td></td><td><input type="submit" name="letka" value="Vytvorit"/></td></tr>
			</div></form>
			</tbody>
			</table>
		</div>
		<?break;
		
		case 3:
		$query="SELECT * FROM letadlo LE, let l WHERE l.letadlo_ID = LE.ID";
		$res=mysql_query($query,$conn);
		echo "<table border='0'>";
		echo "<tbody>";
		while($data=mysql_fetch_array($res)){
			?><div>
				<form methon="POST">
					<div>
						<tr><td>Datum: <?echo $data["datum"];?></td>
						<td>Oznaceni: <?echo $data["oznaceni"];?></td>
						<td>Vyrobce: <?echo $data["vyrobce"];?></td>
						<td>Z: <?echo $data["misto_odletu"];?></td>
						<td>Kam: <?echo $data["misto_pristani"];?></td>
						<td><input type="hidden" name="hidden_LEID" value="<?php echo $data["ID"];?>">
						<td><input type="submit" name="removeLE" value="Odstranit"></td></tr>
					</div>
				</form>
			</div><?
		}
		echo "</tbody>";
		echo "</table>";
		break;	
		
		case 6:
		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["zam"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
		echo "<table border='0'>";
		echo "<tbody>";
			?><form method="post">
				<tr><td>Jmeno: </td><td><input type="text" name="jmenoE" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Prijmeni: </td><td><input type="text" name="prijmeniE" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>Login: </td><td><input type="text" name="loginE" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>Heslo: </td><td><input type="password" name="passE" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td><input type="submit" name="editP" value="Editovat"></td>
				<td><input type="submit" name="deleteP" value="Smazat ucet"></td></tr>
			</form><?
		echo "</tbody>";
		echo "</table>";
	}
}


?>
