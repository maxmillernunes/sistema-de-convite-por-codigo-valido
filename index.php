<?php
session_start(); //Inicio da seção logar.
require 'config.php';//Conexão.

if(empty($_SESSION['logado'])) { //Verircar se tem seção
	header("Location: login.php");
	exit;
}
//Armazena email e codigo.
$email = '';
$codigo = '';

$sql = "SELECT email, codigo FROM convite WHERE id = '".addslashes($_SESSION['logado'])."'";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0) {
	
	$info = $sql->fetch();

	$email = $info['email'];
	$codigo = $info['codigo'];
}
?>
<h1>Área interna do sistema</h1>
<p>Usuário: <?php echo $email; ?> - <a href="sair.php">Sair</a></p>
<p>Link: http://localhost/phpdozero/modulo-8-php-inter/projeto-convite/cadastrar.php?codigo=<?php echo $codigo; ?></p>