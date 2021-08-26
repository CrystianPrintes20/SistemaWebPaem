<?php
session_start();

if(isset($_POST['nome_rec']))
{
    $rastreio = [];

    $rastreio['nome_recurso'] = addslashes($_POST['nome_rec']);
    $rastreio['data_rec'] = addslashes($_POST['data_rec']);
    $rastreio['horario_inicial'] = addslashes($_POST['horario_inicial']);
    $rastreio['horario_final'] = addslashes($_POST['horario_final']);

    print_r($rastreio);
    echo ('<br>');
    echo ('<br>');

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $url = "http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/solicitacoes_acessos";
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
    
    $resultado = json_decode($response,true);

    print_r($resultado);
  

    foreach($resultado as $value){
        if($rastreio['nome_recurso'] == $value['recurso_campus']){

            // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
            $data = explode('-', $value['data']);
            $newdata = $data[2].'-'.$data[1].'-'.$data[0];

            if($rastreio['data_rec'] == $newdata && $rastreio['horario_inicial'] == $value['hora_inicio']){
                echo ('<br>');
                print_r($value['nome']);
            }
            
        }
    }
            
            die();

}

/// Estou fazendo a verificação pra ver se o nome_rec enviado está presente na lista de reservas
?>