
<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['id_notificacao']))
{   
  include_once('../../JSON/rota_api.php');


  $delete_notificacaoCOVID = addslashes($_POST['id_notificacao']);

  if($delete_notificacaoCOVID)
  {

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $headers = array(
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init($rotaApi.'/api.paem/notificacoes_covid/notificacao_covid?id_notificacao_covid='.$delete_notificacaoCOVID);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if($httpcode1 == 200)
    {
            
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Notificação foi excluida com sucesso!!
      </div>";
        header("Location: ../../View/tecnico/notificacoes_covid.php");             
        exit();
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Ocorreu um erro ao excluir essa Notificação!!
      </div>";
        header("Location: ../../View/tecnico/notificacoes_covid.php");
        exit();
    }

      
  }
  else
  {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
    </div>";
      header("Location: ../../View/tecnico/notificacoes_covid.php");
      exit();
  }
}
?>