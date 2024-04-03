<?php
function conexao_db(){
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'dash_bot');
    $conexao = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    // Verificar a ligação
    if ($conexao === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    return $conexao;
}
?>