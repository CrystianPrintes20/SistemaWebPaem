<?php
session_start();
include_once "./buscardados_discuser.php";

//verifica se clicou no botão
if(isset($_POST['nome']))
{
  
  $confirma_matricula = addslashes(($_POST['confirma_matricula']));

  if($confirma_matricula == $dados_discuser['matricula']){

    $updatedisc = [];

    
    $updatedisc['nome'] =  strtoupper(addslashes($_POST['nome']));
    $updatedisc['matricula'] = addslashes($_POST['matricula']);
    $updatedisc['endereco'] = addslashes($_POST['rua_travessa']).','.addslashes($_POST['numero_end']).','.addslashes($_POST['bairro']);
    $updatedisc['id_discente'] =  $dados_discuser['id_discente'];

    
    $updateuser = [];

    $updateuser['email'] =addslashes($_POST['email']);
    $updateuser['login'] = addslashes($_POST['username']);
    $updateuser['cpf'] = addslashes($_POST['cpf']);
    $updateuser['tipo'] = $dados_discuser['usuario']['tipo'];
    $updateuser['id_usuario'] = $dados_discuser['usuario']['id_usuario'];

/*     print_r($updatedisc);
    print_r($updateuser);
    die(); */

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $updatedisc, false));
    $validacao1 = (false === array_search(false , $updateuser, false));

   


    if($validacao == true && $validacao1 == true)
    {
      //transformando array em json
      $arquivotec_json = json_encode($updatedisc);
      $arquivouser_json = json_encode($updateuser);


      //Pegando o token
      $token = implode(",",json_decode( $_SESSION['token'],true));

      //Criando o cabeçalho com o token
      $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
      );

      // Iniciando o curl para a rota "discentes/discente"
      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/discentes/discente');
      
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivotec_json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
      
      $result = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      // Iniciando o curl para a rota "usuarios/usuario"

      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/usuarios/usuario');
    
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivouser_json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);


      if($updateuser['login'] != $dados_discuser['usuario']['login']){
        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/discente/login_discente.php");
          exit();             
        }

      }else{

        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/discente/update_discente.php");
          exit();             
        }
        elseif($httpcode == 500 && $httpcode1 == 500)
        {
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Erro ao atualizar os dados.
          </div>";
            header("Location: ../../View/discente/update_discente.php");
          exit(); 
        }
        else{
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Erro no Servidor, Erro ao atualizar!!
          </div>";
            header("Location: ../../View/discente/update_discente.php");
          exit(); 
        }

      }
      
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/discente/update_discente.php");
    }
    
  }else{
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
     Seu SIAPE não são iguais!!
      </div>";
        header("Location: ../../View/discente/update_discente.php");
  }
}
?>