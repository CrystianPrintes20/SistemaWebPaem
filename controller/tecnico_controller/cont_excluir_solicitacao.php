
<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['id_solicitacao1']))
{   

    $delete_solicitacao= addslashes($_POST['id_solicitacao1']);

    if(!empty($delete_solicitacao))
    {

      $token = implode(",",json_decode( $_SESSION['token'],true));
      $headers = array(
        'Authorization: Bearer '.$token,
      );

      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/solicitacoes_acessos/solicitacao_acesso?id_solicitacao_acesso='.$delete_solicitacao);
      
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
      curl_close($ch);

      if($httpcode1 == 200)
      {
              
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Solicitação foi excluido com sucesso!!
        </div>";
          header("Location: ../../View/tecnico/salas_reservadas.php");             
          exit();
      }
      else
      {
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Ocorreu um erro ao excluir essa solicitação!!
        </div>";
          header("Location: ../../View/tecnico/salas_reservadas.php");
          exit();
      }

       
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/salas_reservadas.php");
        exit();
    }
}
?>