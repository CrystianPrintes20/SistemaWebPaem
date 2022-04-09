<?php
 session_start();

//verifica se clicou no botão
if(isset($_POST['inicio_sintomas']))
{   

  include_once('../../JSON/rota_api.php');
  include_once "./buscardados_discuser.php";

   //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
   $inicio_sintomas = explode('-', addslashes($_POST['inicio_sintomas']));
   $inicio_sintomas_new = $inicio_sintomas[2].'-'.$inicio_sintomas[1].'-'.$inicio_sintomas[0];
  
  $noti_covid = array(
    'data' => $inicio_sintomas_new,
    'nivel_sintomas' => intval(addslashes($_POST['nivel_sintomas'])),
    'observacoes' => addslashes($_POST['descricao']),
    'matricula_discente' => $dados_discuser['matricula'],
    'campus_instituto_id_campus_instituto' => $dados_discuser['campus_instituto_id_campus_instituto']

  );


  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false, $noti_covid, false));
    
  if($validacao == true)
  { 
    $noti_teste = addslashes($_POST['SelectOptions']);

    if($noti_teste == -1){
      $noti_covid['teste'] = false;
    }else{
      $noti_covid['teste'] = true;
    }

    //pegando data do exame de covidd
    $noti_data_diag = addslashes($_POST['data_exame']);

    if(!empty($noti_data_diag)){
      //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
      $data_diagnostico = explode('-',$noti_data_diag);
      $data_diagnostico_new = $data_diagnostico[2].'-'.$data_diagnostico[1].'-'.$data_diagnostico[0];

      $noti_covid['data_diagnostico'] = $data_diagnostico_new;
    }


    //transformando array em json
    $arquivotec_json = json_encode($noti_covid);

    // Pegando o token
    $token = implode(",",json_decode( $_SESSION['token'],true));

 
    $url = $rotaApi.'/api.paem/notificacoes_covid/notificacao_covid';
    $ch = curl_init($url);

    $curl = curl_init();
    $headers = array(
      'content-Type: application/json',
      'Authorization: Bearer '.$token,
    );

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivotec_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
           
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if(curl_errno($ch)){
    // throw the an Exception.
    throw new Exception(curl_error($ch));
    }

    curl_close($ch);
    
    switch($httpcode){
        case 201:
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
            Obrigado por nos notificar sobre sua situação.
            </div>";
            header("Location: ../../View/discente/notificacao_covid.php");
            exit();
            break;

        default:
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
            ocorreu um erro ao enviar notificação.
            </div>";
            header("Location: ../../View/discente/notificacao_covid.php");
            exit();
            break;
    }


  }
  else
  {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Preencha todos os campos!!
    </div>";
    header("Location: ../../View/discente/notificacao_covid.php");
    exit();
  }
    
}

?>