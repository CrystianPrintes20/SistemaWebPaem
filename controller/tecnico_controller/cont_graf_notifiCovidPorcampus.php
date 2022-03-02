<?php
/*
/notificacoes_covid/quantidade_por_campus : Para Ver, a quantidade de notificações de covid efetuadas pelos alunos de acordo com o campus(id_campus_intituto) e o ano(2021, 2021,...).

    Metodo disponíveis: GET.
    rota completa:
        /notificacoes_covid/quantidade_por_campus?id_campus_instituto=5&ano=2021
    Resposta:

{
  "JAN": 3,
  "FEV": 4,
  "MAR": 2,
  "ABR": 2,
  "MAI": 1,
  "JUN": 1,
  "JUL": 1,
  "AGO": 0,
  "SET": 0,
  "OUT": 0,
  "NOV": 1,
  "DEZ": 9
}  

*/
session_start();
if(isset($_POST['campus_covid']))
{
    include_once('../../JSON/rota_api.php');

    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Pegandos os dados
    $id_campus_instituto = addslashes($_POST['campus_covid']);
    $ano = addslashes($_POST['ano_mes_covid']);

    $url = $rotaApi.'/api.paem/notificacoes_covid/quantidade_por_campus?id_campus_instituto='.$id_campus_instituto.'&ano='.$ano;
    $ch = curl_init($url);

    $headers = array(
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

    $notiCovid_camp = [];

    foreach ($resultado as $chave => $valor){
        $notiCovid_camp[] = [(string)$chave, (int)$valor];
    }
    
    $_SESSION['notiCovid_camp'] = $notiCovid_camp;
     //Resposta para o usuario
     switch ($httpcode) {

        case 200:

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Consulta realizada com sucesso!!
        </div>";
       
        header("Location: ../../View/tecnico/estatistica_e_diag.php"); 
        exit();
        break; 

        case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro ao consultar!!
        </div>";
        header("Location: ../../View/tecnico/estatistica_e_diag.php");
        exit();
        break;

        default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ERRO NO SERVIDOR!!
        </div>";
        header("Location: ../../View/tecnico/estatistica_e_diag.php");
        exit();
        break;
    }
    

}else{

    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Escolha um campus/Instituto!!
  </div>";
    header("Location: ../../View/tecnico/estatistica_e_diag.php");
    exit();
}

?>