<?php
include "fonction.php";

if(isset($_POST['btActionFormAuthentification']))
{
	authentification($_POST['inputLog'], $_POST['inputMdp']);	
}
?>
<form name="formAuthentification" method="POST" action="">
 <p>Login : <input type="text" name="inputLog" placeholder="Votre login" /></p>
 <p>Mot de passe : <input type="password" name="inputMdp" placeholder="Votre mot de passe" /></p>
 <p><input type="submit" name="btActionFormAuthentification" value="Se connecter" /></p>
</form>
<?
 //fin script
?>
