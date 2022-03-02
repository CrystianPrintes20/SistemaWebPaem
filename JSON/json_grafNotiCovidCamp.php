<?php
session_start();

$dados = $_SESSION['notiCovid_camp'];
echo json_encode($dados);
?>