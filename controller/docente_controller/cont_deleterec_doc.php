
<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['valor_id']))
{   
  include_once('../../JSON/rota_api.php');

  $delete_rec = [];

  $delete_rec['id_recuso_campus'] = addslashes($_POST['valor_id']);

  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $delete_rec, false));

  if($validacao == true)
  {

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $headers = array(
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init($rotaApi.'/api.paem/recursos_campus/recurso_campus?id_recurso_campus='.$delete_rec['id_recuso_campus']);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if($httpcode1 == 200)
    {
            
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Recurso foi excluido com sucesso!!
      </div>";
        header("Location: ../../View/docente/delete_recursos_docente.php");             
        exit();
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Ocorreu um erro ao excluir esse recurso!!
      </div>";
        header("Location: ../../View/docente/delete_recursos_docente.php");
        exit();
    }

      
  }
  else
  {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
    </div>";
      header("Location: ../../View/docente/delete_recursos_docente.php");
      exit();
  }
}
?>