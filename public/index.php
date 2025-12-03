<?php
    require_once ('../includes/menu.php');

    // Verifica se a solicitação do usuário via GET estiver vazia
    if (empty($_SERVER["QUERY_STRING"])) {
        $pg = "principal";
        include_once("$pg.php");
    } else {
        $pg = $_GET['pg'];
        include_once("$pg.php");
    }

    require_once ('../includes/rodape.php');
?>