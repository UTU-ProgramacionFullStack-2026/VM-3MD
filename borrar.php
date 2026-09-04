<?php

require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (isset($_GET['id'])) {
        $idUsuario = $_GET['id'];
        $sqlUsuario = "DELETE FROM usuario WHERE usuario_id ='$idUsuario';";
        $resultadoUsuario = $conn->execute_query($sqlUsuario);
        header("Location: index.php");
        exit;
    }
}
