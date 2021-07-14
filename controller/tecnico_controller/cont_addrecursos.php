<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
    $addrecurso = [];
    
    $addrecurso['nome'] = addslashes( $_POST['nome']);
    $addrecurso['capacidade'] = addslashes($_POST['capacidade']);
    $addrecurso['descricao'] =addslashes($_POST['descricao']);
    $addrecurso['inicio_horario_funcionamento'] = addslashes($_POST['hora_inicial']);
    $addrecurso['fim_horario_funcionamento'] = addslashes($_POST['hora_final']);
    $addrecurso['quantidade_horas'] = addslashes($_POST['periodo_horas']);
   // $addrecurso['campus_id_campus'] = addslashes($_POST['campus']);

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $addrecurso, false));

    if($validacao == true)
    {
      //transformando array em json
      $arquivo_json = json_encode($addrecurso);
      print_r($arquivo_json);
      
      $token = implode(",",json_decode( $_SESSION['token'],true));
      $headers = array(
        'content-Type: application/json',
        'Authorization: Bearer '.$token,
      );

      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/recursos_campus/recurso_campus');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
      curl_close($ch);
      
      if($httpcode1 == 201)
      {
              
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Novo espaço adicionado com sucesso!!
        </div>";
          header("Location: ../../View/tecnico/add_recursos.php");
          exit();             
          
      }
      elseif($httpcode1 == 500)
      {
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Esse espaço ja se encontra registrado!!
        </div>";
          header("Location: ../../View/tecnico/add_recursos.php");
          exit();

      }else{
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro no servidor, tente novamente mais tarde!!
        </div>";
          header("Location: ../../View/tecnico/add_recursos.php");
          exit();
      }

       
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/add_recursos.php");
        exit();
    }
}
?>