<?
/*TODO 	
	- zakazat stornovat lety z minulosti
*/
function main($menu, $conn){
?>	<div id="menu">
		<ul>
			<li><a href="?menu=0">Domů</a></li>
			<li><a href="?menu=1">Letenky</a></li>
			<li><a href="?menu=2">Kontakt</a></li>
			<li><a href="?menu=3">Přihlášení</a></li>
			<li><a href="?menu=4">Registrace</a></li>		
		</ul>
	</div>
  <div id="content">
<?
switch($menu){
	case 0:?>
			<p>
				<span>Vítejte v cestovní kancéláři "název"</span>
			</p>		
	<?break;
	case 1:?>
			<p>
				<span>Zobrazí se výběr letenek</span>
			</p>		
	<?break;
	case 2:?>
			<p>
				Božetěchova 2 <br>
				Brno, Královo Pole <br>
				email: <a href="mailto:tonechces@neco.cz">tonechces@neco.cz</a><br>
				tel: 123 456 789
			</p>		
	<?break;
	case 3:
  echo "<h2>Přihlášení</h2>";  
    ?>
			<table>
			<form method="POST">
				<tr><td><label>Login: </label></td><td><input type="text" name="name"/></td></tr>
				<tr><td><label>Heslo: </label></td><td><input type="password" name="pass"/></td></tr>
				<tr><td></td><td><input class="button" type="submit" value="Přihlásit"/></td></tr>
			</form>
			</table>	
	<?break;
	case 4:
  echo "<h2>Registrace</h2>";  
  ?>
			<table>
			<form method="POST">
				<tr><td><label>Login:</label></td><td><input class="nice" type="text" placeholder=" " name="rlogin" value="<?php if(isset($_POST["rlogin"])) echo $_POST["rlogin"];?>"/></td></tr>
				<tr><td><label>Heslo:</label></td><td><input type="password" name="rpass" placeholder=" "  value="<?php if(isset($_POST["rpass"])) echo $_POST["rpass"];?>"/></td></tr>
				<tr><td><label>Jméno:</label></td><td><input type="text" name="rjmeno" value="<?php if(isset($_POST["rjmeno"])) echo $_POST["rjmeno"];?>"/></td></tr>
				<tr><td><label>Příjmení:</label></td><td><input type="text" name="rprijmeni" value="<?php if(isset($_POST["rprijmeni"])) echo $_POST["rprijmeni"];?>"/></td></tr>
				<tr><td><label>Narození:</label></td><td><input type="date" name="rnaroz" value="<?php if(isset($_POST["rnaroz"])) echo $_POST["rnaroz"];?>"/></td></tr>
				<tr><td><label>Pas:</label></td><td><input type="text" name="rpas" value="<?php if(isset($_POST["rpas"])){
						if(is_numeric($_POST["rpas"])){
							echo $_POST["rpas"];
						}
				}?>"/></td></tr>
				<tr><td></td><td><input class="button" type="submit" name="regZ" value="registrovat"/></td></tr>
			</form>
			</table>
	<?break;
  }
}



function zakaz($menu,$conn){
	?><div id="menu">
		<ul>
			<li><a href="?menu=0">Domů</a></li>
			<li><a href="?menu=4">Účet</a></li>
			<li><a href="?menu=2">Moje letenky</a></li>
			<li><a href="?menu=3">Vyhledat let</a></li>	
			<li><a href="?menu=1">Odhlásit</a></li>				
		</ul>
	</div>
  <div id="content">
	<?
	switch($menu){
		case 0:
    echo "<h2>Vítejte</h2>";
    ?>
			<p>
				<span>Vítejte uživateli</span>
			</p>		
		<?break;

		case 2:
    echo "<h2>Moje letenky</h2>";
		$query = "SELECT l.ID, le.datum, c.jmeno, c.prijmeni, le.misto_odletu as z, le.misto_pristani as do, le.mista as mista, le.ID as let_ID  
		FROM letenka l,cestujici c, let le
		WHERE c.ID = '".$_SESSION['login']."' AND c.id = l.cestujici_ID AND l.let_ID = le.ID;";

		$res = mysql_query($query, $conn);
		echo "<table><thead><tr><td>Odkud</td><td>Kam</td><td>Datum</td><td></td></tr></thead>";
		while ($data = mysql_fetch_array($res)) {
			?>
				<form methon="post">
						<tr><td> <?echo $data["z"];?></td>
						<td><?echo $data["do"];?></td>
						<td><?echo $data["datum"];?>
  						<input type="hidden" name="hidden_lID" value="<?php echo $data["ID"];?>">
  						<input type="hidden" name="hidden_letID" value="<?php echo $data["let_ID"];?>">
  						<input type="hidden" name="hidden_mista" value="<?php echo $data["mista"];?>">
            </td>
						<? if(new DateTime($data["datum"]) >= new DateTime()){ ?>
						<td><input type="submit" name="storno" value="Stornovat"></td>
						<?}?>
						</tr>
				</form>
			<?		
		}
		echo "</table>";
		break;

		case 3:
    echo "<h2>Vyhledat let</h2>";
		$query="SELECT g.oznaceni as oznaceni, l.misto_odletu as misto_odletu,
		l.misto_pristani as misto_pristani, l.datum as datum, l.ID as ID, l.delka_letu as delka_letu, l.mista as mista
		FROM gate g, let l
		WHERE l.gate_ID = g.ID AND l.mista > 0 AND DATE(l.datum) >= DATE(NOW());";

		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Odkud</td><td>Kam</td><td>Datum</td><td>Delka letu</td><td>Gate</td><td>Letenek</td></tr></thead>";
		while($data=mysql_fetch_array($res)){
			?>
				<form methon="post">
						<tr><td><?echo $data["misto_odletu"];?></td>
						<td><?echo $data["misto_pristani"];?></td>
						<td><?echo $data["datum"];?></td>
						<td><?echo $data["delka_letu"];?></td>
						<td><?echo $data["oznaceni"];?></td>
						<td><input type="text" class="thin" placeholder=" " name="mnozstvi" value="1"/> z <?php echo $data["mista"];?></td>
						<td><input type="hidden" name="hidden_ID" value="<?php echo $data["ID"];?>">
						<input type="hidden" name="hidden_mista" value="<?php echo $data["mista"];?>">
						<input type="submit" name="objednat" value="Objednat"></td>
						</tr>
				</form>
    <?
		}
		echo "</table>";
		break;

		case 4:
    echo "<h2>Účet</h2>";
		/*if(isset($_GET["z"])){
			if($_GET["z"] == 99){
				?><script>alert("Vase udaje byly zmeneny");</script><?
			}
		}*/
		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["login"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
			?><table><form method="post">
				<tr><td>Jméno: </td><td><input type="text" name="jmenoZE" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Příjmení: </td><td><input type="text" name="prijmeniZE" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>Login: </td><td><input type="text" placeholder=" " name="loginZE" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>Heslo: </td><td><input type="password" placeholder=" " name="passZE" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td>Pas: </td><td><input type="text" name="pasZE" value="<?php echo $data["cislo_pasu"]?>"></td></tr>
				<tr><td><input type="submit" name="editZ" value="Editovat"></td>
				<td><input type="submit" name="deleteZ" value="Smazat ucet"></td></tr>
			</form></table><?
		break;
	}
}

function admin($menu, $conn){
	?><div id="menu">
		<ul>
			<li><a href="?menu=0">Domů</a></li>
			<li><a href="?menu=10">Účet</a></li>
			<li><a href="?menu=3">Vytvořit zaměstnance</a></li>
			<li><a href="?menu=2">Odstranit zaměstnance</a></li>
			<li><a href="?menu=4">Vytvořit terminál</a></li>
			<li><a href="?menu=5">Odstranit terminál</a></li>
			<li><a href="?menu=6">Vytvořit gate</a></li>
			<li><a href="?menu=7">Odstranit gate</a></li>
			<li><a href="?menu=8">Vytvořit letadlo</a></li>
			<li><a href="?menu=9">Odstranit letadlo</a></li>
      <li><a href="?menu=1">Odhlásit</a></li>	
		</ul>
	</div>
  <div id="content">
<?
	switch($menu){
		case 3:
    echo "<h2>Vytvořit zaměstnance</h2>";
    ?>
			<table>
			<form method="POST">
				<tr><td><label>Login:</label></td><td><input type="text" placeholder=" " name="zlogin" value="<?php if(isset($_POST["zlogin"])) echo $_POST["zlogin"];?>"/></td></tr>
				<tr><td><label>Heslo:</label></td><td><input type="password" placeholder=" " name="zpass" value="<?php if(isset($_POST["zpass"])) echo $_POST["zpass"];?>"/></td></tr>
				<tr><td><label>Jméno:</label></td><td><input type="text" name="zjmeno" value="<?php if(isset($_POST["zjmeno"])) echo $_POST["zjmeno"];?>"/></td></tr>
				<tr><td><label>Příjmení:</label></td><td><input type="text" name="zprijmeni" value="<?php if(isset($_POST["zprijmeni"])) echo $_POST["zprijmeni"];?>"/></td></tr>
				<tr><td></td><td><input type="submit" name="regP" value="Vytvořit"/></td></tr>
			</form>
			</table>
		<?break;

		case 2:
    echo "<h2>Smazat zaměstnance</h2>";   
		$query="SELECT * FROM cestujici where pozice = 1";
		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Jméno</td><td>Příjmení</td><td>Login</td><td></td></tr></thead>";
		while($data=mysql_fetch_array($res)){
			?><form methon="POST">
						<tr><td><?echo $data["jmeno"];?></td>
						<td><?echo $data["prijmeni"];?></td>
						<td><?echo $data["login"];?></td>
						<td><input type="hidden" name="hidden_ID" value="<?php echo $data["ID"];?>"><input  type="submit" name="removeZ" value="Odstranit"></td></tr>
				</form>
      <?
		}
		echo "</table>";
		break;
		case 0:
    echo "<h2>Vítejte</h2>";
		?>
    <p>
			<span>Vítejte admine</span>
		</p>		
		<?break;

		case 4:
    echo "<h2>Vytvořit terminál</h2>";
    ?>
			<table>
			<form method="POST">
				<tr><td><label>Název:</label></td><td><input type="text" placeholder=" " name="tnazev"/></td></tr>
				<tr><td></td><td><input  type="submit" name="term" value="Vytvořit"/></td></tr>
			</form>
			</table>
		<?break;

		case 5:
    echo "<h2>Smazat terminál</h2>";
		$query="SELECT * FROM terminal";
		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Název</td></td></tr></thead><tbody>";
		while($data=mysql_fetch_array($res)){
			?>
				<form methon="POST">
						<tr><td><?echo $data["nazev"];?></td>
						<td><input type="hidden" name="hidden_tID" value="<?php echo $data["ID"];?>"><input  type="submit" name="removeT" value="Odstranit"></td></tr>
				</form>
			<?
		}
		echo "</tbody></table>";
		break;	

		case 6:
    echo "<h2>Vytvořit gate</h2>";
		$query = "SELECT * FROM terminal";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt[] = $data;
		}
		?>
			<table>
			<form method="POST">
				<tr><td><label>Název:</label></td><td><input type="text" placeholder=" " name="goznaceni" value="<?php if(isset($_POST["goznaceni"])) echo $_POST["goznaceni"];?>"/></td></tr>
				<tr><td><label>Terminál:</label></td><td>
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
				</td></tr>
				<tr><td></td><td><input  type="submit" name="gate" value="Vytvořit"/></td></tr>
			</form>
			</table>
		<?break;

		case 7:
    echo "<h2>Odstranit gate</h2>";
		$query="SELECT * FROM gate";
		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Název</td></td></tr></thead>";
		while($data=mysql_fetch_array($res)){
			?>
				<form methon="POST">
					<div>
						<tr><td><?echo $data["oznaceni"];?></td>
						<td><input type="hidden" name="hidden_gID" value="<?php echo $data["ID"];?>"><input  type="submit" name="removeG" value="Odstranit"></td></tr>
					</div>
				</form>
			<?
		}
		echo "</table>";
		break;

		case 8:
    echo "<h2>Vytvořit letadlo</h2>";
		$query = "SELECT * FROM typ";
		$res = mysql_query($query, $conn);
		while($data = mysql_fetch_array($res)){
			$opt[] = $data;
		}
		?><table>
			<form method="POST">
				<tr><td><div><label>Označení:</label></td><td><input type="text" placeholder=" " name="loznaceni"/></div></td></tr>
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
				</td></tr>
				<tr><td><label>Výrobce:</label></td><td><input type="text" name="lvyrobce" value="<?php if(isset($_POST["lvyrobce"])) echo $_POST["lvyrobce"];?>"/></td></tr>
				<tr><td></td><td><input  type="submit" name="letadlo" value="Vytvořit"/></td></tr>
			</form>
			</tbody>
			</table>
	
		<?break;

		case 9:
    echo "<h2>Odstranit letadlo</h2>";
		$query="SELECT * FROM letadlo";
		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Označení</td><td>Výrobce</td><td></td></tr></thead><tbody>";
		while($data=mysql_fetch_array($res)){
			?>
				<form methon="POST">
						<tr><td><?echo $data["oznaceni"];?></td>
						<td><?echo $data["vyrobce"];?></td>
						<td><input type="hidden" name="hidden_lID" value="<?php echo $data["ID"];?>"><input  type="submit" name="removeL" value="Odstranit"></td></tr>
				</form>
      <?
		}
		echo "</table>";
		break;	

		case 10:
    echo "<h2>Účet</h2>";
		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["admin"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
    ?>
		<table>
			<form method="post">
				<tr><td>Jméno: </td><td><input  type="text" name="jmenoA" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Příjmení: </td><td><input type="text" name="prijmeniA" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>Login: </td><td><input type="text" placeholder=" " name="loginA" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>Heslo: </td><td><input type="password" placeholder=" " name="passA" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td><input type="submit" name="editA" value="Editovat"></td>
				<td><input type="submit" name="deleteA" value="Smazat ucet"></td></tr>
			</form>
		</table>
    <?
		break;	
	}
}

function zam($menu, $conn){
	?><div id="menu">
		<ul>
			<li><a href="?menu=0">Domů</a></li>
			<li><a href="?menu=6">Účet</a></li>
			<li><a href="?menu=2">Vytvořit let</a></li>
			<li><a href="?menu=3">Odstranit let</a></li>
			<li><a href="?menu=1">Odhlásit</a></li>	
		</ul>
	</div>
  <div id="content">
  <?
	switch($menu){	
		case 0:
    echo "<h2>Vítejte</h2>";
    ?>
				<p>
					<span>Vítejte zaměstnanče</span>
				</p>		
		<?break;

		case 2:
    echo "<h2>Vytvořit let</h2>";
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
		?>
			<table>
			<form method="POST">
				<tr><td><label>Označení:</label></td><td>
				<?
				echo "<select name='letadlo1'>";
				foreach($opt as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</td></tr>
				<tr><td><label>Z:</label></td><td><input type="text" placeholder=" " name="LEz" value="<?php if(isset($_POST["LEz"])) echo $_POST["LEz"];?>"/></td></tr>
				<tr><td><label>Kam:</label></td><td><input type="text" placeholder=" " name="LEkam" value="<?php if(isset($_POST["LEkam"])) echo $_POST["LEkam"];?>"/></td></tr>
				<tr><td><label>Gate:</label></td><td>
				<?
				echo "<select name='gate1'>";
				foreach($opt1 as $key => $value){
					echo "<option value='$value[0]'";
					echo ">$value[1]</option>\n";
				}
				echo "</select>\n";
				?>
				</div></td></tr>
				<tr><td><label>Počet míst:</label></td><td><input type="text" placeholder=" " name="lmista" value="<?php if(isset($_POST["lmista"])) echo $_POST["lmista"];?>"/></td></tr>
				<tr><td><label>Délka letu:</label></td><td><input type="text" name="LEdelka" value="<?php if(isset($_POST["LEdelka"])) echo $_POST["LEdelka"];?>"/></td></tr>
				<tr><td><label>Datum letu:</label></td><td><input type="date" placeholder=" " name="LEdate" value ="<? echo date("Y-m-d") ?>"/></td></tr>
				<tr><td></td><td><input type="submit" name="letka" value="Vytvořit"/></td></tr>
			</form>
			</tbody>
			</table>
		
		<?break;
		
		case 3:
    echo "<h2>Odstranit let</h2>";
    $query="SELECT * FROM letadlo LE, let l WHERE l.letadlo_ID = LE.ID";
		$res=mysql_query($query,$conn);
		echo "<table><thead><tr><td>Datum</td><td>Označení</td><td>Výrobce</td><td>Z</td><td>Kam</td><td></td></tr></thead>";
		while($data=mysql_fetch_array($res)){
			?>
				<form methon="POST">
						<tr><td><?echo $data["datum"];?></td>
						<td><?echo $data["oznaceni"];?></td>
						<td><?echo $data["vyrobce"];?></td>
						<td><?echo $data["misto_odletu"];?></td>
						<td><?echo $data["misto_pristani"];?></td>
						<td><input type="hidden" name="hidden_LEID" value="<?php echo $data["ID"];?>"><input type="submit" name="removeLE" value="Odstranit"></td></tr>
				</form>
			<?
		}
		echo "</table>";
		break;	
		
		case 6:
    echo "<h2>Účet</h2>";
		$query="SELECT * FROM cestujici WHERE ID='".$_SESSION["zam"]."'";
		$res=mysql_query($query,$conn);
		$data=mysql_fetch_array($res);
			?><table><form method="post">
				<tr><td>Jméno: </td><td><input type="text" name="jmenoE" value="<?php echo $data["jmeno"]?>"></td></tr>
				<tr><td>Příjmení: </td><td><input type="text" name="prijmeniE" value="<?php echo $data["prijmeni"]?>"></td></tr>
				<tr><td>Login: </td><td><input type="text" placeholder=" " name="loginE" value="<?php echo $data["login"]?>"></td></tr>
				<tr><td>Heslo: </td><td><input type="password" placeholder=" " name="passE" value="<?php echo $data["pass"]?>"></td></tr>
				<tr><td><input type="submit" name="editP" value="Editovat"></td>
				<td><input type="submit" name="deleteP" value="Smazat ucet"></td></tr>
			</form></table><?
	}
}
?>