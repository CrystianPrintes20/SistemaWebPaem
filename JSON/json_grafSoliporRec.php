<?php
session_start();

$dados = $_SESSION['solicitacaoPorRec'];
echo json_encode($dados);
?>