<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> 

<?php
session_start();
require 'config.php';

if(!empty($_POST['email']) && !empty($_POST['senha'])) {
	$email = addslashes($_POST['email']);
	$senha = md5($_POST['senha']);

	$sql = $pdo->prepare("SELECT id FROM convite WHERE email = :email AND senha = :senha");
	$sql->bindValue(":email", $email);
	$sql->bindValue(":senha", $senha);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$info = $sql->fetch();

		$_SESSION['logado'] = $info['id'];
		
	?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><center>Usuário logado com sucesso</center></strong>
			</div>
			<script>
				setTimeout(function(){
					top.location.href="index.php";
				}, 1000)
			</script>
	<?php

		//header("Location: index.php");
		exit;
	}
}
?>
<form method="POST">
	E-mail:<br/>
	<input type="email" name="email" /><br/><br/>

	Senha:<br/>
	<input type="password" name="senha" /><br/><br/>

	<input type="submit" value="Entrar" /> <a href="cadastrar.php">Cadastrar</a>
</form>