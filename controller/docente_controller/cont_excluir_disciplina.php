
<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['id_disciplina']))
{   

  include_once('../../JSON/rota_api.php');

  $delete_disciplina= addslashes($_POST['id_disciplina']);

  if(!empty($delete_disciplina))
  {

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $headers = array(
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init($rotaApi.'/api.paem/disciplinas/disciplina?id_disciplina='.$delete_disciplina);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    /*  print_r($result);
    print_r($httpcode1);
    die(); */
    if($httpcode1 == 200)
    {
            
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Solicitação foi excluido com sucesso!!
      </div>";
        header("Location: ../../View/docente/minhas_disciplinas.php");             
        exit();
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Ocorreu um erro ao excluir essa solicitação!!
      </div>";
        header("Location: ../../View/docente/minhas_disciplinas.php");
        exit();
    }

      
  }
  else
  {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
    </div>";
      header("Location: ../../View/docente/minhas_disciplinas.php");
      exit();
  }
}
?>