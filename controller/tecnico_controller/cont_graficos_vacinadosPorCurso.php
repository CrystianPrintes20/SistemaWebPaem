<?php
/*/discentes/quantidade_vacinados_por_curso : Para Ver, a quantidade de alunos vacinados por curso e a quantidade total de alunos por curso.

    Metodo disponíveis: GET.
    rota completa:
        /discentes/quantidade_vacinados_por_curso?id_campus_intituto=<INTEIRO>
    Resposta:

{
  "total_vacinados": {
      "SISTEMAS DE INFORMAÇÃO": 33,
      "CIÊNCIAS BIOLÓGICAS": 82,
      "INTERDISCIPLINAR EM CIÊNCIAS BIOLÓGICAS E CONSERVAÇÃO": 1
  },
  "total_alunos": {
      "SISTEMAS DE INFORMAÇÃO": 34,
      "CIÊNCIAS BIOLÓGICAS": 84,
      "INTERDISCIPLINAR EM CIÊNCIAS BIOLÓGICAS E CONSERVAÇÃO": 1
  }
} */
session_start();

if(isset($_POST['campus']))
{
    include_once('../../JSON/rota_api.php');
    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Pegandos os dados
    $id_campus_instituto = addslashes($_POST['campus']);

    /*Bucando o nome do campus intituto para colocar no grafico */
        $url = $rotaApi.'/api.paem/campus_institutos';
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

        $campus = json_decode($response, true);
       
        $campi_insti = $campus[$id_campus_instituto-1]; 

    $url = $rotaApi.'/api.paem/discentes/quantidade_vacinados_por_curso?id_campus_instituto='.$id_campus_instituto;
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

    //print_r($resultado);
  
    $tt_vacinados = $resultado['total_vacinados'];
 
    $total_vacinados = [];
    foreach ($tt_vacinados as $chave => $valor){
        $total_vacinados[] = [(string)$chave, (int)$valor];
    }

    $tt_alunos = $resultado['total_alunos'];

    $total_alunos = [];
    foreach ($tt_alunos as $chave => $valor){
        $total_alunos[] = [(string)$chave, (int)$valor];
    }
    $dados = [
        $total_alunos,
        $total_vacinados
    ];

    $_SESSION['vac_curso'] = [ $campi_insti['nome'], $dados];
    
    //echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    //Resposta para o usuario
    switch ($httpcode) {

        case 200:

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Sala reservada com sucesso!!
        </div>";
       
        header("Location: ../../View/tecnico/estatistica_e_diag.php"); 
        exit();
        break; 

        case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro ao reservar!!
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
    
    //echo json_encode($total_alunos, JSON_UNESCAPED_UNICODE);
   
}else{

    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Escolha um campus/Instituto!!
  </div>";
    header("Location: ../../View/tecnico/estatistica_e_diag.php");
    exit();
}

?>