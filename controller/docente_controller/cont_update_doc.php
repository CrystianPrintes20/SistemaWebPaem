<?php
session_start();
include_once "./buscardados_docuser.php";

//verifica se clicou no botão
if(isset($_POST['nome']))
{
  
  $confirma_siape = addslashes(($_POST['confirma_siape']));

  if($confirma_siape == $dados_docuser['siape']){

    $updatedoc = [];

    $updatedoc['siape'] =addslashes($_POST['siape']);
    $updatedoc['nome'] =  addslashes($_POST['nome']);
    $updatedoc['data_nascimento'] = addslashes($_POST['data_nascimento']);
    //$updatedoc['cargo'] = addslashes($_POST['cargo']);
    //$updatedoc['campus_instituto_id_campus_instituto'] = addslashes($_POST['campus']);
    $updatedoc['id_docente'] =  $dados_docuser['id_docente'];

    
    $updatedocuser = [];

    $updatedocuser['email'] =addslashes($_POST['email']);
    $updatedocuser['login'] = addslashes($_POST['username']);
    $updatedocuser['cpf'] = addslashes($_POST['cpf']);
    $updatedocuser['tipo'] = $dados_docuser['usuario']['tipo'];
    $updatedocuser['id_usuario'] = $dados_docuser['usuario_id_usuario'];


    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $updatedoc, false));
    $validacao1 = (false === array_search(false , $updatedocuser, false));



    if($validacao == true && $validacao1 == true)
    {
      //transformando array em json
      $arquivotec_json = json_encode($updatedoc);
      $arquivouser_json = json_encode($updatedocuser);


      //Pegando o token
      $token = implode(",",json_decode( $_SESSION['token'],true));

      //Criando o cabeçalho com o token
      $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
      );

      // Iniciando o curl para a rota "docentes/docente"
      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/docentes/docente');
      
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


      if($updatedocuser['login'] != $dados_docuser['usuario']['login']){
        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/docente/login_docente.php");
          exit();             
        }

      }else{

        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/docente/update_docente.php");
          exit();             
        }
        elseif($httpcode == 500 && $httpcode1 == 500)
        {
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Erro ao atualizar os dados.
          </div>";
            header("Location: ../../View/docente/update_docente.php");
          exit(); 
        }
        else{
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Erro no Servidor, Erro ao atualizar!!
          </div>";
            header("Location: ../../View/docente/update_docente.php");
          exit(); 
        }

      }
      
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/docente/update_docente.php");
    }
    
  }else{
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
     Seu SIAPE não são iguais!!
      </div>";
        header("Location: ../../View/docente/update_docente.php");
  }
}
?>