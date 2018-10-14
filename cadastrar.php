<?php
session_start();
require 'config.php';

//Verifica se tem GET do codigo.
if(!empty($_GET['codigo'])) {
	$codigo = addslashes($_GET['codigo']);
//Faz a busca pelo codigo de quem envia.
	$sql = "SELECT codigo,contador FROM convite WHERE codigo = '$codigo'";
	$sql = $pdo->query($sql);
	$convite = $sql->fetch();

	if($sql->rowCount() == 0 || $convite['contador'] == 0) {//verifica se o cdigo é válido e se o covite é válido.
		header("Location: login.php");
		exit;
	}
} else {
	header("Location: login.php");
	exit;
}

if(!empty($_POST['email'])) {
	$email = addslashes($_POST['email']);
	$senha = md5($_POST['senha']);
//Atualiza o contatdor de quem envia a solicitaçõa.
	$sql = "UPDATE convite SET contador = contador-1 WHERE codigo = '$codigo' ";
	$sql = $pdo->query($sql);
//Verifica se tem email iqual.
	$sql = "SELECT * FROM convite WHERE email = '$email'";
	$sql = $pdo->query($sql);

	if($sql->rowCount() <= 0) {

		$codigo = md5(rand(0,99999).rand(0,99999));
		$sql = "INSERT INTO convite (email, senha, codigo) VALUES ('$email', '$senha', '$codigo')";
		$sql = $pdo->query($sql);

		unset($_SESSION['logado']);

		header("Location: index.php");
		exit;
	}
}
?>
<h3>Cadastrar</h3>

<form method="POST">
	E-mail:<br/>
	<input type="email" name="email" /><br/><br/>

	Senha:<br/>
	<input type="password" name="senha" /><br/><br/>

	<input type="submit" value="Cadastrar" />
</form>