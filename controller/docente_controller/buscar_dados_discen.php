<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ../View/docente/login_docente.php");
    exit();
};

include_once('../../JSON/rota_api.php');

$token = implode(",",json_decode( $_SESSION['token'],true));
$url = $rotaApi.'/api.paem/discentes';
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

if(curl_errno($ch)){
// throw the an Exception.
throw new Exception(curl_error($ch));
}

curl_close($ch);

function retorna_nome($matri, $response){
    
    $dados = json_decode($response, true);

    //$id = array_search($matri, array_column($dados, 'matricula'));
   
    //print_r($id);
    $valores = [];

    foreach ($dados as &$value) {

        if($matri == $value['matricula']){
            $valores['nome'] = $value['nome'];
            $valores['id_disc'] = $value['id'];
            // return json_encode($valores);
        }/* else{
            $valores['nome'] = 'Aluno não encontrado';
          
        } */
    }
    return json_encode($valores);
   
}



if(isset($_GET['matricula'])){
    echo retorna_nome($_GET['matricula'], $response);
}


function retorna_matricula($nome, $response){
    //trasformando o json response em uma array
    $dados = json_decode($response, true);
    $valores = [];
   foreach($dados as &$value){
       if(strtoupper($nome) == $value['nome']){
           $valores['matricula'] = $value['matricula'];
           $valores['id_disc'] = $value['id'];
        //    return json_encode($valores);
       }/* else{
           $valores['matricula'] = 'Matricula não encontrada';
       } */
   }
   return json_encode($valores);
}

if(isset($_GET['nome'])){
    echo retorna_matricula($_GET['nome'], $response);
}

?>

