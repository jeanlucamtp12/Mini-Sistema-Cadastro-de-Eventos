<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
   
</head>

<body>
    <title>Resultado do Cadastro</title>
    <nav>
    <div class="link">
        <a href="index.html">Cadastro de Eventos</a><br></br>
        <a href="cadastros.php">Eventos Cadastrados</a>
    </div>
</nav>

    
</body>
</html>

<?php

//chama o arquivo de conexão com o banco de dados
include("conectabanco.php");

//pega as variaveis do formulario via POST
$nome = $_POST['nome'];
$descricao = $_POST['descrição'];
$dataI = $_POST['dataI'];
$dataE = $_POST['dataE'];
$tipo = $_POST['tipo'];

$possui = "";

//Verifica quais das informações do iten 'possui' foram marcadas no checkbox
if (isset($_POST['wifi'])) {
    $possui = 'w';
}
if (isset($_POST['estacionamento'])) {
    $possui .=  "e";
}
if (isset($_POST['bebida'])) {
    $possui .= "b";
}
if ($possui == "") {
    $possui = "nulo";
}

//realiza a atribuição da imagem informada no formulario
$imagem = $_FILES['img'];

if (!empty($imagem["name"])) {

    
    $larg = 1280;    // Largura máxima em pixels
    $alt = 720;    // Altura máxima em pixels
    $tam = 1000000;   // Tamanho máximo do arquivo em bytes


    $erros = array();
    // Verifica se o arquivo é uma imagem
    if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])) {
        $erros[1] = "Isso não é uma imagem.";
    }

    $dimensoes = getimagesize($imagem["tmp_name"]);


    try { 
        if (is_bool($dimensoes)){
            throw new Exception('');
           
        }else{
             // Verifica se a imagem ultrapassa a largura exigida
            if($dimensoes[0] > $larg) {
                $erros[2] = "A largura da imagem não deve ultrapassar ".$larg." pixels";
            }
            // Verifica se a imagem ultrapassa a altura exigida
            if($dimensoes[1] > $alt) {
                $erros[3] = "Altura da imagem não deve ultrapassar ".$alt." pixels";
            }
            
            // Verifica se a imagem possui o tamanho exigido
            if($imagem["size"] > $tam) {
                    $erros[4] = "A imagem deve ter no máximo ".$tam." bytes";
            }
        }
    } catch (Exception $ex) {
        $erros[1] = "Isso não é uma imagem.";
    }


    // caso não haja erros
    if (count($erros) == 0) {

        // Pega extensão da imagem
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
        // atribui um nome para a imagem
        $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
        // especifica o caminho onde a imagem será armazenada
        $caminho_imagem = "../img/" . $nome_imagem;
        // Realiza o upload para o caminho especificado
        move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
    }


    // Caso haja erros, os mesmos são exibidos na tela 
    if (count($erros) != 0) {
        foreach ($erros as $err) {
            echo "<p><font face=\"Verdana\"  color=\"#FFF\">$err</font></p>";
        }
    } else {
        //Caso não hajam erros, realiza a inserção da imagem/dados no banco  
        $operacao = mysqli_query($conn, "INSERT INTO infos (nome, descricao, dataInicio, dataFim, tipo, possui, imagem) VALUES ('$nome', '$descricao', '$dataI', '$dataE', '$tipo', '$possui', '$caminho_imagem')");
        echo "<p><font face=\"Verdana\"  color=\"#FFF\">Inserção realizada com sucesso</font></p>";

    }
}


