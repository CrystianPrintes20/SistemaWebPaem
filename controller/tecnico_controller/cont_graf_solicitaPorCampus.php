<?php
session_start();

    include_once('../../JSON/rota_api.php');
    $token = implode(",",json_decode( $_SESSION['token'],true));

    $url = $rotaApi.'/api.paem/solicitacoes_acessos/quantidade_por_campus';
    $ch = curl_init($url);

    $headers = array(
        'content-Type: application/json; charset = utf-8',
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
    //print_r($response);

    $resultado = json_decode($response, true);

    $tqde_campus = [];

    foreach ($resultado as $chave => $valor){
        $tqde_campus[] = [(string)$chave, (int)$valor];
    }
    
    
    echo json_encode($tqde_campus, JSON_UNESCAPED_UNICODE);
    
    

?>