<?php

    $conexao = mysqli_connect('127.0.0.1', 'root', '');

    $db = mysqli_select_db($conexao, 'delta_vistoria');

    if(!$conexao){
        echo "<h2>Erro ao conectar o banco de dados</h2>";
    }