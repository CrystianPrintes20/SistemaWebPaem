<?php
session_start();
/* $array = [
    ['Abacate', 200],
    ['Azeitona', 600]
];

echo json_encode($array); */

    include_once('../../JSON/rota_api.php');
    $token = implode(",",json_decode( $_SESSION['token'],true));

    $url = $rotaApi.'/api.paem/solicitacoes_acessos';
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
  
        date_default_timezone_set('America/Sao_Paulo');
        $hagora = date("Y-m-d"); // Pega o momento atual

        // Separando ao mes atual
        $mes= explode('-', $hagora);
        $mes_atual = $mes[1];
        // Array que vai pegar todas as reservas do mes atual
        $reserva_mes_atual = [];
        
        foreach($resultado as &$value){
            // Separando ao mes dos agendamentos
            $mes_agen= explode('-',  $value['data']);
            $mes_agendamentos = $mes_agen[1];
            
            if($mes_agendamentos == $mes_atual){
                $reserva_mes_atual[] =  $value['recurso_campus'];
            }
        }
        // pega a quantas reservar foram feitas por recurso
        $qtde_de_reser_por_recurso = array_count_values($reserva_mes_atual);

        //Array que vai receber os dados para ficar assim: [['recurso', qtde de reservas]]
        $dados_unic = [];
        foreach ($qtde_de_reser_por_recurso as $chave => $valor){
            $dados_unic[] = [(string)$chave, (int)$valor];
        }
        
        
        echo json_encode($dados_unic, JSON_UNESCAPED_UNICODE);
    

?>