<?php
session_start();

//verifica se clicou no botão
if(isset($_POST['reserva']))
{
  include_once('../../JSON/rota_api.php');
  include_once ('./buscardados_discuser.php');

  // Transformando array em string
  $hi_hf = implode(array_map(function ($item) {
      return sprintf('%s', $item);
  }, $_POST['hi_hf']));

  $hi_hf = str_split($hi_hf, 8);

  //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
  $data_reserva = explode('-', addslashes($_POST['data_reserva']));
  $newdata = $data_reserva[2].'-'.$data_reserva[1].'-'.$data_reserva[0];

  $contreservar = array(
    'recurso_campus_id_recurso_campus' => addslashes($_POST['reserva']),
    'data' =>  $newdata,
    'hora_inicio' => $hi_hf[0],
    'hora_fim' => $hi_hf[1],
    'nome' =>  strtoupper(addslashes($_POST['nome'])),
    'usuario_id_usuario'=> $dados_discuser['usuario']['id_usuario'],
    'discente_id_discente' => strval( addslashes($_POST['id_disc'])),
    'para_si' => 1,
    'status_acesso' => 1
  );
 
  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false, $contreservar, false));
    
  if($validacao == true)
  { 
    //Pegando a observação
    $contreservar['observacao'] = addslashes($_POST['observacao']);

    // Pegando o token
    $token = implode(",",json_decode( $_SESSION['token'],true));

    //*** INICIO  Verificando se o horario ta disponivel ***

    $curl = curl_init();
    $headers = array(
        'Authorization: Bearer '.$token,
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $rotaApi.'/api.paem/recursos_campus/recurso_campus?id_recurso_campus='.$contreservar['recurso_campus_id_recurso_campus'],
    ]);

    // Envio e armazenamento da resposta
    $response = curl_exec($curl);

    // Fecha e limpa recursos
    curl_close($curl);

    $resultado = json_decode($response,true);
    
    // Pega a capacidade do recurso escolhido
    $capacidade_recurso = intval( $resultado['capacidade']);
    
    $hora_inicial_recurso =  strtotime($resultado['inicio_horario_funcionamento']);
    $hora_fim_recurso = strtotime($resultado['fim_horario_funcionamento']);

    $hora_inicial_agendamento = strtotime($contreservar['hora_inicio']);
    $hora_fim_agendamento = strtotime($contreservar['hora_fim']);

    if($hora_inicial_agendamento >= $hora_inicial_recurso  && $hora_fim_agendamento <= $hora_fim_recurso){

      switch($capacidade_recurso){
        case -1:
          enviar_reserva($token,$contreservar,$rotaApi);
          break;

        default:
          $url = $rotaApi."/api.paem/solicitacoes_acessos";
          $ch = curl_init($url);
          $headers = array(
          'Authorization: Bearer '.$token,
          );

          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

          $response = curl_exec($ch);

          $resultado1 = json_decode($response,true);
  
          // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
          $data = explode('-', $contreservar['data']);
          $newdata = $data[2].'-'.$data[1].'-'.$data[0];

        //Perrcorrendo o resultado1 que foi feita na rota de solicitações buscando todas as datas de reservas já feitas
        foreach ($resultado1 as &$value) {
          $valores['recurso'] = $value['recurso_campus_id_recurso_campus'];
          if($valores['recurso'] != null){
          
            
            if($valores['recurso'] == $contreservar['recurso_campus_id_recurso_campus']){
              $valores['data'] = $value['data'];

              if($valores['data'] == $newdata){

                $valores['hora_inicio'] = $value['hora_inicio'];
                $valores['hora_fim'] = $value['hora_fim'];

                if($valores['hora_inicio'] == $contreservar['hora_inicio'] && $valores['hora_fim'] == $contreservar['hora_fim'] ){
                  $capacidade_recurso -= 1;
                  /*          
                  echo  $capacidade_recurso;
                  print_r($valores);
                  echo '<br>'; */
                  
                }
              }
            }
          }
        }
      
        if($capacidade_recurso > 0){
          enviar_reserva($token,$contreservar,$rotaApi);
        }else{
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          O recurso encontra-se lotado nesse horario e data!
          </div>";
          header("Location: ../../View/discente/home_discente.php");
          exit();
        } 
      }
      
    }else{
      $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
      O recurso solicitado não tem Horario disponivel, tente outro periodo!!
      </div>";
      header("Location: ../../View/discente/home_discente.php");
      exit();
    }

  }
  else
  {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Preencha todos os campos!!
    </div>";
    header("Location: ../../View/discente/home_discente.php");
    exit();
  }
}
function enviar_reserva($token,$contreservar,$rotaApi){

    //transformando array em json
    $solicitacao = json_encode($contreservar);

    $headers = array(
      'content-Type: application/json',
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init($rotaApi.'/api.paem/solicitacoes_acessos/solicitacao_acesso');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $solicitacao);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //Resposta para o usuario
    switch ($httpcode1) {

      case 201:

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Sala reservado com sucesso!!
        </div>";
        header("Location: ../../View/discente/home_discente.php"); 
        exit();
        break; 

      case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ESSE DISCENTE JÁ RESERVOU ESSA SALA!!
        </div>";
        header("Location: ../../View/discente/home_discente.php");
        exit();
        break;

      default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ERRO NO SERVIDOR!!
        </div>";
        header("Location: ../../View/discente/home_discente.php");
        exit();
        break;
    }
}
?>