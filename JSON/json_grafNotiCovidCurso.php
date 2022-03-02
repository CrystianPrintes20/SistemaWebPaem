<?php
session_start();

$dados = $_SESSION['notiCovid_curso'];
echo json_encode($dados);
?>