<?
function main($menu, $conn){
?>	<div>
		<ul>
			<li <?if($menu==0)?>><a href="?menu=0">Domů</a></li>
			<li <?if($menu==1)?>><a href="?menu=1">Letenky</a></li>
			<li <?if($menu==2)?>><a href="?menu=2">Kontakt</a></li>
			<li <?if($menu==3)?>><a href="?menu=3">Přihlásit</a></li>
			<li <?if($menu==4)?>><a href="?menu=4">Registrovat</a></li>		
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
				<tr><td><div><label>Login:</label></td><td><input type="text" name="rlogin"/></div></td></tr>
				<tr><td><div><label>Heslo:</label></td><td><input type="password" name="rpass"/></div></td></tr>
				<tr><td><div><label>Jméno:</label></td><td><input type="text" name="rjmeno"/></div></td></tr>
				<tr><td><div><label>Příjmení:</label></td><td><input type="text" name="rprijmeni"/></div></td></tr>
				<tr><td><div><label>Narozeni:</label></td><td><input type="date" name="rnaroz"/></div></td></tr>
				<tr><td><div><label>Pas:</label></td><td><input type="text" name="rpas"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="registrovat"/></td></tr>
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
		$query = "select l.ID, le.datum, c.jmeno, c.prijmeni, le.misto_odletu as z, le.misto_pristani as do  
		from letenka l,cestujici c, let le 
		where c.ID = '".$_SESSION['login']."' and c.id = l.cestujici_ID and l.let_ID = le.ID;";

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
						<td><input type="submit" name="storno" value="Stornovat"></td></tr>
					</div>
				</form>
			</div><?		
		}
		echo "</tbody>";
		echo "</table>";
		break;

		case 3:
		$query="SELECT * FROM gate, let WHERE let.gate_ID = gate.ID";
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
						<td><input type="submit" name="objednat" value="Objednat"></td></tr>
					</div>
				</form>
			</div><?
		}
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
				<tr><td><div><label>Login:</label></td><td><input type="text" name="zlogin"/></div></td></tr>
				<tr><td><div><label>Heslo:</label></td><td><input type="password" name="zpass"/></div></td></tr>
				<tr><td><div><label>Jméno:</label></td><td><input type="text" name="zjmeno"/></div></td></tr>
				<tr><td><div><label>Příjmení:</label></td><td><input type="text" name="zprijmeni"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="Vytvorit"/></td></tr>
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
						<td>login: <?echo $data["login"];?></td>
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
				<tr><td><div><label>Nazev:</label></td><td><input type="text" name="tnazev"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="Vytvorit"/></td></tr>
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
				<tr><td><div><label>Nazev:</label></td><td><input type="text" name="goznaceni"/></div></td></tr>
				<tr><td><div><label>Terminal:</label></td><td>
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
				<tr><td></td><td><input type="submit" value="Vytvorit"/></td></tr>
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
				<tr><td><div><label>Oznaceni:</label></td><td><input type="text" name="loznaceni"/></div></td></tr>
				<tr><td><div><label>Typ:</label></td><td>
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
				<tr><td><div><label>Vyrobce:</label></td><td><input type="text" name="lvyrobce"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="Vytvorit"/></td></tr>
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

			
	}

}

function zam($menu, $conn){
	?><div>
		<ul>
			<li><a href="?menu=1">Odhlasit</a></li>	
			<li><a href="?menu=0">Domu</a></li>
			<li><a href="?menu=2">Vytvorit let</a></li>
			<li><a href="?menu=3">Smazat let</a></li>
			<li><a href="?menu=4">Vytvorit letenky</a></li>
			<li><a href="?menu=5">Smazat letenky</a></li>

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
				<tr><td><div><label>Oznaceni:</label></td><td>
				<?
				echo "<select name='letadlo'>";
				foreach($opt as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</div></td></tr>
				<tr><td><div><label>Z:</label></td><td><input type="text" name="LEz"/></div></td></tr>
				<tr><td><div><label>Kam:</label></td><td><input type="text" name="LEkam"/></div></td></tr>
				<tr><td><div><label>Gate:</label></td><td>
				<?
				echo "<select name='gate'>";
				foreach($opt1 as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</div></td></tr>
				<tr><td><div><label>Delka letu:</label></td><td><input type="text" name="LEdelka"/></div></td></tr>
				<tr><td><div><label>Datum letu:</label></td><td><input type="date" name="LEdate" value ="<? echo date("Y-m-d") ?>"/></div></td></tr>
				<tr><td></td><td><input type="submit" value="Vytvorit"/></td></tr>
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
	}
}


?>
