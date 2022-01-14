<?php 
include "menu.php";

$idproduto = isset($_GET["idproduto"]) ? $_GET["idproduto"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdrevisao";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  tblprodutos where idproduto= :idproduto";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idproduto",$idproduto);
            $stmt->execute();
            header("Location:produtos.php");
        }


        if($idproduto){
            
            $sql = "SELECT * FROM  tblprodutos where idproduto= :idproduto";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idproduto",$idproduto);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_OBJ);
            
        }
        if($_POST){
            if($_POST["idproduto"]){
                $sql = "UPDATE tblprodutos SET produto=:produto, preco=:preco, estoque=:estoque WHERE idproduto =:idproduto";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":produto", $_POST["produto"]);
                $stmt->bindValue(":preco", $_POST["preco"]);
                $stmt->bindValue(":estoque", $_POST["estoque"]);
                $stmt->bindValue(":idproduto", $_POST["idproduto"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO tblprodutos(produto,preco,estoque) VALUES (:produto,:preco,:estoque)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":produto", $_POST["produto"]);
                $stmt->bindValue(":preco", $_POST["preco"]);
                $stmt->bindValue(":estoque", $_POST["estoque"]);
                $stmt->execute(); 
            }
            header("Location:produtos.php");
        } 
    } catch(PDOException $e){
         echo "erro".$e->getMessage;
        }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

<div class="container">

<h1>Cadastro de Produtos</h1>
<hr>
<form method="POST">
Produto:        <input type="text" name="produto"    required     value="<?php echo isset($produto) ? $produto->produto : null ?>"><br><br>
Preço R$:       <input type="text" name="preco"      required     value="<?php echo isset($produto) ? $produto->preco : null ?>"><br><br>
Estoque:        <input type="text" name="estoque"    required     value="<?php echo isset($produto) ? $produto->estoque : null ?>"><br><br>
<input type="hidden"     name="idproduto"   value="<?php echo isset($produto) ? $produto->idproduto : null ?>">
<input type="submit" class="btn btn-primary" value="Cadastrar">
</form>
<hr>
<a href="produtos.php" class="btn btn-success">Voltar</a> 
<a href="index.php" class="btn btn-secondary">Menu Principal</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</div>
</body>
</html>