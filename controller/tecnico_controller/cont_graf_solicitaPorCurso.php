<?php
/*/solicitacoes_acessos/quantidade_por_curso : Para Ver, a quantidade de agendamentos solicitados por curso da universidade de acordo com o mês requisitado na query string(1, para Janeiro; 2, para Fevereiro;...;12, para Dezembro) e o ano(2020, 2021,...).

    Metodo disponíveis: GET.
    rota completa:
        /solicitacoes_acessos/quantidade_por_curso?id_campus_instituto=5&ano=2021&mes=11
    Resposta:

{
  "CIÊNCIAS BIOLÓGICAS": 48,
  "SISTEMAS DE INFORMAÇÃO": 15
}  
 */
session_start();

if(isset($_POST['campus']))
{
    include_once('../../JSON/rota_api.php');

    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Pegandos os dados
    $id_campus_instituto = addslashes($_POST['campus']);
    $d_ano_mes = addslashes($_POST['ano_mes']);
    $ano_mes = explode("-", $d_ano_mes);

    $url = $rotaApi.'/api.paem/solicitacoes_acessos/quantidade_por_curso?id_campus_instituto='.$id_campus_instituto.'&ano='.$ano_mes[1].'&mes='.$ano_mes[0];
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

    $solicitacaoPorCurso = [  
    ];

   
    foreach ($resultado as $chave => $valor){
        $solicitacaoPorCurso[] = [(string)$chave, (int)$valor];
    }
    echo "<pre>";
    print_r($solicitacaoPorCurso);
     //die();

    $_SESSION['solicitacaoPorCurso'] = [$ano_mes,$solicitacaoPorCurso];
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