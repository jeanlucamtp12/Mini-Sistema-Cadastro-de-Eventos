<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Cadastrados</title>
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
//chama o arquivo de conexão com o banco de dados
include("conectabanco.php");
//pega o id atual da pagina
$pagina = filter_input( INPUT_GET, "pagina" , FILTER_SANITIZE_NUMBER_INT);

//estabelece quantos itens serão exibidos por pagina
$itens_pagina = 2;

//Caso o id da pagina esteja vazio, ele recebe 1, caso contrario recebe o id atual
if (!$pagina) {
$page_cont = "1";
} else {
$page_cont = $pagina;
}
//estabelece o numero de itens que serão exibidos e realiza a consulta ao banco utilizando LIMIT
$inicio = $page_cont - 1;
$inicio = $inicio * $itens_pagina;
$sql = mysqli_query($conn, "SELECT * FROM infos LIMIT $inicio, $itens_pagina ");

$num_paginas = mysqli_query($conn,"SELECT * FROM infos")->num_rows;  //pega o numero de eventos na tabela
$num_final = ceil($num_paginas/$itens_pagina );       //arrendoda o valor 




// Printa as informações da tabela
while ($tabela = mysqli_fetch_object($sql)) {

    echo "<br><p><br>Descrição: $tabela->descricao</p>";
    // Exibi a foto
    echo "<p  id='circle'>  <img src='../img/" . $tabela->imagem . "' alt='Foto de exibição ' /><br /></p>";
    echo "<p>Data de Inicio: $tabela->dataInicio</p>";

    echo "<p><a id='meio' href='informacoes.php?id=$tabela->id'>Ver Mais</a></p><br><br><br><br>";

}
//Procedimentos para realizar a paginação
$tp = $num_paginas / $itens_pagina ; // verifica o número total de páginas

$anterior = $page_cont -1;
$proximo = $page_cont +1;
$qnts_antes = 2;

if($page_cont != 1){        //printa o link para direcionar a primeira pagina
    echo "<a id='estilo'href='cadastros.php?pagina=1'> <- Primeira </a>";
}

for ($page_ant = $page_cont - $qnts_antes; $page_ant <= $page_cont - 1;  $page_ant++ ){   //printa o link das paginas anteriores a atual

    if ($page_ant >= 1){
        echo "<a id='estilo'href='?pagina=$page_ant'> $page_ant  </a>";
    }
}

echo " <a id='num_centro' <font face=\"Verdana\" \">$page_cont</font> </a>";   //identifica ao usuario a pagina em que ele se encontra


for ($page_prox = $page_cont + 1; $page_prox <= $page_cont + $qnts_antes ;  $page_prox++ ){ //printa o link das paginas posteriores a atual

    if ($page_prox <= $num_final){
        echo "<a id='estilo'href='?pagina=$page_prox'> $page_prox  </a>";
    }
}

if($page_cont !=$num_final){   //printa o caminho para direcionar a ultima pagina
    echo " <a id='estilo' href='cadastros.php?pagina=$num_final'> Ultima -> </a> ";
}

?>