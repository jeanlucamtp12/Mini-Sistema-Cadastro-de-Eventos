<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacoes</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">
</head>

<body>
<div class="fundo">
    <nav>
        <div class="caminhos">
            <a href="index.html">Cadastro de Eventos</a>
            <a href="cadastros.php">Eventos Cadastrados</a>
        </div>
    </nav>
</div>
</body>
</html>

<?php
include("conectabanco.php"); //chama o arquivo de conexão com o banco de dados

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT); //captura o id do evento passado pelo href

$sql = mysqli_query($conn, "SELECT * FROM infos WHERE id=$id"); //realiza uma consulta a partir do id 


// Printa as informações da tabela
while ($tabela = mysqli_fetch_object($sql)) {

    echo "<p><br></br>Nome do Evento: $tabela->nome</p><br>";
    echo "<p>Descrição: $tabela->descricao</p><br>";
    // Exibi a foto
    echo "<p id='circle'><img src='../img/" . $tabela->imagem . "' alt='Foto de exibição ' /><br /></p>";
    echo "<br><p>Data de inicio: $tabela->dataInicio</p>";
    echo "<p>Data de Encerramento: $tabela->dataFim</p>";
    echo "<p>Tipo: $tabela->tipo</p>";


    echo "<br><p>Possui:</p> "; 
    //Verifica e printa se o evento possui wifi, estacionamento e bebida gratis
    if (is_bool(strpos($tabela->possui, 'w'))) {
        echo "<p>Wifi Liberado: Não</p> "; 
    } else {
        echo "<p>Wifi Liberado: Sim</p> "; 
    }

    if (is_bool(strpos($tabela->possui, 'e'))) {
        echo "<p>Estacionamento: Não</p> ";
    } else {
        echo "<p>Estacionamento: Sim</p> ";
    }

    if (is_bool(strpos($tabela->possui, 'b'))) {
        echo "<p>Bebida Grátis: Não</p> ";
    } else {
        echo "<p>Bebida Grátis: Sim</p> ";
    }

} 
echo "<p><a id='meio' href='cadastros.php'>Voltar</a></p>";

?>