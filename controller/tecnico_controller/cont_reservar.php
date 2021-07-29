<?php
session_start();

//verifica se clicou no botão
if(isset($_POST['reserva']))
{
    $contreservar = [];
    $contreservar['recurso_campus_id_recurso_campus'] = addslashes($_POST['reserva']);
    $contreservar['data'] = addslashes($_POST['data_reserva']);

    // Transformando array em string
    $hi_hf = implode(array_map(function ($item) {
        return sprintf('%s', $item);
    }, $_POST['hi_hf']));

    $hi_hf = str_split($hi_hf, 8);

    $contreservar['hora_inicio'] = $hi_hf[0];
    $contreservar['hora_fim'] = $hi_hf[1];

    $contreservar['nome'] = strtoupper(addslashes($_POST['nome']));
    $contreservar['discente_id_discente'] = strval( addslashes($_POST['id_disc']));

    print_r($contreservar);
    
    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false, $contreservar, false));
    

    if($validacao == true)
    { 

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
      CURLOPT_URL => 'http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/recursos_campus/recurso_campus?id_recurso_campus='.$contreservar['recurso_campus_id_recurso_campus'],
      ]);

      // Envio e armazenamento da resposta
      $response = curl_exec($curl);

      // Fecha e limpa recursos
      curl_close($curl);

      $resultado = json_decode($response,true);

      // Pega a capacidade do recurso escolhido
      $capacidade_recurso = $resultado['capacidade'];
     
      $hora_inicial_recurso =  strtotime($resultado['inicio_horario_funcionamento']);
      $hora_fim_recurso = strtotime($resultado['fim_horario_funcionamento']);

      $hora_inicial_agendamento = strtotime($contreservar['hora_inicio']);
      $hora_fim_agendamento = strtotime($contreservar['hora_fim']);


      if($hora_inicial_agendamento >= $hora_inicial_recurso  && $hora_fim_agendamento <= $hora_fim_recurso){

        // Enviando os dados para a API
        $contreservar['para_si'] = '-1';
        $contreservar['status_acesso'] = '1';

        //transformando array em json
        $solicitacao = json_encode($contreservar);

        $headers = array(
          'content-Type: application/json',
          'Authorization: Bearer '.$token,
        );

        $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/solicitacoes_acessos/solicitacao_acesso');
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
            $vagas += 1;
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
            Sala reservado com sucesso!!
            </div>";
            header("Location: ../../View/tecnico/home_tecnico.php"); 
            exit(); 

          case 500:
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            ESSE DISCENTE JÁ RESERVOU ESSA SALA!!
            </div>";
            header("Location: ../../View/tecnico/home_tecnico.php");
            exit();
            break;

          default:
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            ERRO NO SERVIDOR!!
            </div>";
            header("Location: ../../View/tecnico/home_tecnico.php");
            exit();
        }

      }else{
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        O recurso solicitado não tem Horario disponivel, tente outro periodo!!
        </div>";
        header("Location: ../../View/tecnico/home_tecnico.php");
        exit();
      }
  
    }
    else
    {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
      </div>";
      header("Location: ../../View/tecnico/home_tecnico.php");
      exit();
    }
}

?>

http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem