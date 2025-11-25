<?php

    require_once '../includes/topo.php';
    require_once '../includes/menu.php';

    // verifica se a solicitação do usuario via get estiver vazia ele abre por padrão a página da variável pg
    if (empty($_SERVER["QUERY_STRING"])) {
        $pg = "principal";
        include_once("$pg.php");
    } else { // se a solicitação não estiver vazia a pg recebe o valor da solicitação do usuário 
        $pg = $_GET['pg'];
        include_once("$pg.php");
    }

?>

<?php require_once '../includes/rodape.php'; ?>