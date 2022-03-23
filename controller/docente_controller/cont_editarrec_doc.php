
<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
  include_once('../../JSON/rota_api.php');

  $editrecurso = array(
    'nome' => addslashes( $_POST['nome']),
   'capacidade' => addslashes($_POST['capacidade']),
   'descricao' => addslashes($_POST['descricao']),
   'inicio_horario_funcionamento' => addslashes($_POST['hora_inicial']),
   'fim_horario_funcionamento' => addslashes($_POST['hora_final']),
   'quantidade_horas' => addslashes($_POST['periodo_horas']),
   'id_recuso_campus' => addslashes($_POST['valor_id'])
  );
  

  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $editrecurso, false));

  if($validacao == true)
  {
    //Pegando a restrição
    $editrecurso['tipo_restricao'] = addslashes($_POST['tipo_de_restricao']);

    //transformando array em json
    $arquivo_json = json_encode($editrecurso);

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $headers = array(
      'content-Type: application/json',
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init($rotaApi.'/api.paem/recursos_campus/recurso_campus');
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
    curl_close($ch);

    if($httpcode1 == 200)
    {
            
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Recurso editado e adicionado com sucesso!!
      </div>";
        header("Location: ../../View/docente/editar_recursos_docente.php");             
        exit();
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Ocorreu um erro ao editar esse recurso!!
      </div>";
        header("Location: ../../View/docente/editar_recursos_docente.php");
        exit();
    }

      
  }
  else
  {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
    </div>";
      header("Location: ../../View/docente/editar_recursos_docente.php");
      exit();
  }
}
?>