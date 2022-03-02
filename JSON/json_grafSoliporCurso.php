<?php
session_start();

$dados = $_SESSION['solicitacaoPorCurso'];
echo json_encode($dados);
?>