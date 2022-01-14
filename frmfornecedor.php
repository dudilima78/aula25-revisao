<?php 
include "menu.php";

$idfornecedor = isset($_GET["idfornecedor"]) ? $_GET["idfornecedor"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdrevisao";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  tblfornecedores where idfornecedor= :idfornecedor";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idfornecedor",$idfornecedor);
            $stmt->execute();
            header("Location:fornecedores.php");
        }


        if($idfornecedor){
            
            $sql = "SELECT * FROM  tblfornecedores where idfornecedor= :idfornecedor";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idfornecedor",$idfornecedor);
            $stmt->execute();
            $fornecedor = $stmt->fetch(PDO::FETCH_OBJ);
            
        }
        if($_POST){
            if($_POST["idfornecedor"]){
                $sql = "UPDATE tblfornecedores SET fornecedor=:fornecedor, email=:email WHERE idfornecedor =:idfornecedor";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":fornecedor", $_POST["fornecedor"]);
                $stmt->bindValue(":email", $_POST["email"]);
                $stmt->bindValue(":idfornecedor", $_POST["idfornecedor"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO tblfornecedores(fornecedor,email) VALUES (:fornecedor,:email)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":fornecedor", $_POST["fornecedor"]);
                $stmt->bindValue(":email", $_POST["email"]);
                $stmt->execute(); 
            }
            header("Location:fornecedores.php");
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
    <title>Fornecedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

<div class="container">

<h1>Cadastro de fornecedores</h1>
<hr>
<form method="POST">
Fornecedor:        <input type="text" name="fornecedor"    required     value="<?php echo isset($fornecedor) ? $fornecedor->fornecedor : null ?>"><br><br>
E-mail:       <input type="text" name="email"      required     value="<?php echo isset($fornecedor) ? $fornecedor->email : null ?>"><br><br>
<input type="hidden"     name="idfornecedor"   value="<?php echo isset($fornecedor) ? $fornecedor->idfornecedor : null ?>">
<input type="submit" class="btn btn-primary" value="Cadastrar">
</form>
<hr>
<a href="fornecedores.php" class="btn btn-success">Voltar</a> 
<a href="index.php" class="btn btn-secondary">Menu Principal</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</div>
</body>
</html>