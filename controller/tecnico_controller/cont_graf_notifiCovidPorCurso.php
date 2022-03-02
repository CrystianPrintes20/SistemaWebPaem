<?php
/*
/notificacoes_covid/quantidade_por_curso : Para Ver, a quantidade de notificações de covid efetuadas pelos alunos por curso e de acordo com campus_insituto(id_campus_instituto) e o ano(2021, 2021,...).

    Metodo disponíveis: GET.
    rota completa:
        /quantidade_por_curso?id_campus_instituto=5&ano=2021
    Resposta:

{
  "SISTEMAS DE INFORMAÇÃO": 10,
  "CIÊNCIAS BIOLÓGICAS": 14
}  */

session_start();
if(isset($_POST['campus_covid_curso']))
{
    include_once('../../JSON/rota_api.php');

    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Pegandos os dados
    $id_campus_instituto = addslashes($_POST['campus_covid_curso']);
    $ano = addslashes($_POST['ano_covid_curso']);

    $url = $rotaApi.'/api.paem/notificacoes_covid/quantidade_por_curso?id_campus_instituto='.$id_campus_instituto.'&ano='.$ano;
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

    $notiCovid_curso = [];

    foreach ($resultado as $chave => $valor){
        $notiCovid_curso[] = [(string)$chave, (int)$valor];
    }
    
    $_SESSION['notiCovid_curso'] = $notiCovid_curso;
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