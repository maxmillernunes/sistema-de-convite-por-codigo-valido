<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> 

<?php
session_start();
require 'config.php';

//Verifica se tem GET do codigo.
if(!empty($_GET['codigo'])) {
	$codigo = addslashes($_GET['codigo']);
//Faz a busca pelo codigo de quem envia.
	$sql = $pdo->prepare("SELECT codigo,contador FROM convite WHERE codigo = :codigo");
	$sql->bindValue(":codigo", $codigo);
	$sql->execute();

	$convite = $sql->fetch();

	if($sql->rowCount() == 0 || $convite['contador'] == 0) {//verifica se o cdigo é válido e se o covite é válido.
		
?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong><center>Codigo ou Contador inválido!</center></strong>
		</div>
		<script>
			setTimeout(function(){
				top.location.href="login.php";
			}, 3000)
		</script>
<?php

		//header("Location: login.php");
		exit;
	}
} else {
?>
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong><center>Você precisa ser convidado por um codígo válido!</center></strong>
	</div>
		<script>
			setTimeout(function(){
				top.location.href="login.php";
			}, 3000)
		</script>
<?php
	//header("Location: login.php");
	exit;
}

if(!empty($_POST['email'])) {
	$email = addslashes($_POST['email']);
	$senha = md5($_POST['senha']);
//Atualiza o contatdor de quem envia a solicitaçõa.
	$sql = $pdo->prepare("UPDATE convite SET contador = contador-1 WHERE codigo = :codigo");
	$sql->bindValue(":codigo", $codigo);
	$sql->execute();
//Verifica se tem email iqual.
	$sql = $pdo->prepare("SELECT * FROM convite WHERE email = :email");
	$sql->bindValue(":email", $email);
	$sql->execute();

	if($sql->rowCount() <= 0) {

		$codigo = md5(rand(0,99999).rand(0,99999));
		$sql = $pdo->prepare("INSERT INTO convite (email, senha, codigo) VALUES (:email, :senha, :codigo)");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", $senha);
		$sql->bindValue(":codigo", $codigo);
		$sql->execute();

		unset($_SESSION['logado']);

?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong><center>Usuário cadastrado com sucesso!</center></strong>
	</div>
	<script>
		setTimeout(function(){
			top.location.href="index.php";
		}, 1000)
	</script>
<?php
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