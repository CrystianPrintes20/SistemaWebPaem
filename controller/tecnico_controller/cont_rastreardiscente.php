<?php
session_start();

if(!isset($_SESSION['token'])){
    header("location: ../View/tecnico/login_tec.php");
    exit();
};

if(isset($_POST['nome_rec']))
{
    $rastreio = [];

    $rastreio['nome_rec'] = addslashes($_POST['nome_rec']);
    $rastreio['data_rec'] = addslashes($_POST['data_rec']);
    $rastreio['horario_inicial'] = addslashes($_POST['horario_inicial']);
    $rastreio['horario_final'] = addslashes($_POST['horario_final']);

    print_r($rastreio);
    die();

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
    "<br>";
    $msg = '';
    $sala_usadas = [];

    foreach($resultado as $value){
        if($rastreio['nome_rec'] == $value['nome_rec']){

            // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
            $data = explode('-', $value['data']);
            $newdata = strtotime($data[2].'-'.$data[1].'-'.$data[0]);

            $data_rec = strtotime($rastreio['data_rec']);
            $horario_inicial = strtotime($rastreio['horario_inicial']);
            echo "<br>";
            print_r($value['data']);
            print_r($newdata);

            if($newdata >= $data_rec && $newdata <= $horario_inicial){
                $sala_usadas = $value['recurso_campus'];
                print_r($sala_usadas);
            }
        }
    }

/*     foreach($resultado as &$value){
       
        print_r($rastreio['nome_rec']);
        "<br>";
        if($rastreio['nome_rec']  == $value['nome_rec']){
            $msg = true;
            echo "<br>";
            echo 'kkfkldg';
           
        }else{
           $msg = false;
        }
    }

   if($msg == false){
        echo "Sem registros";
   } */
}

/// Estou fazendo a verificação pra ver se o nome_rec enviado está presente na lista de reservas
?>