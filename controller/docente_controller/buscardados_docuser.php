<?php

if(!isset($_SESSION['token']))
{
    header("location: ../../View/docente/login_docente.php");
    exit();
}

$token = implode(",",json_decode( $_SESSION['token'],true));


$url = 'http://127.0.0.1:5000/api.paem/docentes/docente';
$ch = curl_init($url);

$headers = array(
    'content-Type: application/json',
    'Authorization: Bearer '.$token,
);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if(curl_errno($ch)){
    // throw the an Exception.
    throw new Exception(curl_error($ch));
    }

    curl_close($ch);

$dados_docuser = json_decode($response, true);

?>