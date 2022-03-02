<?php
session_start();

$dados = $_SESSION['vac_curso'];
echo json_encode($dados);
?>