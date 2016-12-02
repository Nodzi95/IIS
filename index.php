<?
	if (!isset($_SESSION)) 
	session_start();
	include "stranky.php";
	include "inicializace_db.php";
	include "select.php";
	$now = time();
	if(isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']){
		session_unset();
		session_destroy();
		session_start();
		?><script>window.location.href="index.php";</script><?
	}
?>
<!DOCTYPE html>
<head>
<title>Cestovní kancelář</title>
<link href="styly.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
  <div id="header">
		<h1>Letiště</h1>
	</div>
	<?
	if(!isset($_GET["menu"])){
		$_GET["menu"] = 0;	
	}
	if(!isset($_GET["z"])){
		$_GET["z"] = 0;	
	}
	/*$var = "2016-11-23";
	if(new DateTime() >= new DateTime($var)) echo $var;*/
	if(isset($_POST["name"]) and isset($_POST["pass"]) and $_POST["name"]!= ""){
		$query="SELECT * FROM cestujici WHERE login='".$_POST["name"]."'";
		$result = mysql_query($query,$conn) or die("nelze se dotazat");
		while($data = mysql_fetch_array($result)){
			if($data["pass"] == $_POST["pass"]){
				if($data["pozice"] == 0){
					$_SESSION['login'] = $data["ID"];
					//$_SESSION['last_activity'] = time();
					$_SESSION['discard_after'] = $now + 3600;
				}
				else if($data["pozice"] == 2){
					$_SESSION['admin'] = $data["ID"];
					$_SESSION['discard_after'] = $now + 3600;
				}
				else if($data["pozice"] == 1){
					
					$_SESSION['zam'] = $data["ID"];
					$_SESSION['discard_after'] = $now + 3600;
				}
				$_GET["menu"] = 0;
			}
			else{
				?><script>alert("Spatne zadany login nebo heslo");</script><?
			}
		}
	}
	if(!isset($_SESSION['login']) && !isset($_SESSION['admin']) && !isset($_SESSION['zam'])){
		main($_GET["menu"], $conn);
	}
	else{
		if(isset($_SESSION['login'])){
			$_SESSION['discard_after'] = $now + 3600;
			zakaz($_GET["menu"],$conn);		
		}
		else if(isset($_SESSION['admin'])){
			$_SESSION['discard_after'] = $now + 3600;
			admin($_GET["menu"], $conn);
		}
		else if(isset($_SESSION['zam'])){
			$_SESSION['discard_after'] = $now + 3600;
			zam($_GET["menu"], $conn);
		}
		if(isset($_GET["menu"])){
			if($_GET["menu"] == 1){
				if(isset($_SESSION['login'])) unset($_SESSION['login']);
				if(isset($_SESSION['admin'])) unset($_SESSION['admin']);
				if(isset($_SESSION['zam'])) unset($_SESSION['zam']);

				?><script>
					window.location.href="index.php";
				</script><?
			}
		}
	}

	
?>
  </div>
  <div id="footer">
    Petr Nodžák, Martin Molek, Robin Vysloužil <br />
    Projket do předmětu IIS na VUT Brno v akademickém roce 2016/2017 <br>
  </div>
</div>
</BODY>
</HTML>
