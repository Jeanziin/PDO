<?php
require_once './App/Model/pdo.php';
$p = new Pessoa("crudpdo","localhost","root","");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./css/style.css">
	<title>Document</title>
</head>
<body>
	<?php 
	if(isset($_POST['nome']))
	{   
		if(isset($_GET['id_up']) && !empty($_GET['id_up']))
		{
			$id_upd = addslashes($_GET['id_up']);
			$nome     = addslashes($_POST['nome']);         
			$email    = addslashes($_POST['email']);
			$telefone = addslashes($_POST['telefone']);
			if (!empty($nome) && !empty($telefone) && !empty($email) )
			{
				$p->atualizarDados($id_upd, $nome, $telefone, $email); 
				header("location: index.php");         
			}
			else
			{
				print_r($nome);
				print_r($telefone);
				print_r($email);
				echo "Preencha todos os campos";
			}

		}

		else
		{
			$nome     = addslashes($_POST['nome']);         
			$email    = addslashes($_POST['email']);
			$telefone = addslashes($_POST['telefone']);
			if (!empty($nome) && !empty($telefone) && !empty($email) )
			{
				if(!$p->cadastrarPessoa($nome, $telefone, $email))
				{
					echo"email ja esta cadstrado";
				}
			}
			else
			{
				print_r($nome);
				print_r($telefone);
				print_r($email);
				echo "Preencha todos os campos";
			}

		} 
	}
	?>
	<?php
	if(isset($_GET['id_up']))
	{
		$id_update = addslashes($_GET['id_up']);
		$res = $p->buscarDadosPessoa($id_update);
	}
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>Cadastrar Pessoa</h2>
			<label for="nome">Nome</label>
			<input type="text" name="nome" id="nome"
			value="<?php if(isset($res)) {echo $res['nome'];} ?>">
			<label for="telefone">Nome</label>
			<input type="text" name="telefone" id="telefone"
			value="<?php if(isset($res)) {echo $res['telefone'];} ?>">           
			<label for="email">Email</label>
			<input type="email" name="email" id="email"
			value="<?php if(isset($res)) {echo $res['email'];} ?>">
			<input type="submit" 
			value="<?php if(isset($res)) {echo "Atualizar";}else{echo "Cadastrar";} ?>">
		</form>       
	</section>
	<section id="direita">
		<table>
			<tr id="titulo">
				<td>Nome</td>
				<td>Telefone</td>
				<td colspam="2">Email</td>
			</tr>
			<?php
			$dados = $p->buscarDados();
			if(count($dados) > 0) 
			{
				for ($i=0; $i < count($dados); $i++)
				{
					echo "<tr>";
					foreach($dados[$i] as $k => $v){
						if($k != "id")
						{
							echo "<td>".$v."</td>";
						}
					}
					?>
					<td>
						<a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
						<a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
					</td>
					<?php
					echo "</tr>";
				}
			}
			else
			{
				echo " ainda não há pessoas cadastradas";
			}
			?>
		</table>
	</section> 
</body>
</html>
<?php
if(isset($_GET['id']))
{
	$id_pessoa = addslashes($_GET['id']);
	$p->excluirPessoa($id_pessoa);
	header("location: index.php");
}

?>