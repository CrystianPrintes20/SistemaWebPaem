<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['senha_new']))
{
  include_once('../../JSON/rota_api.php');

  $newsenha = addslashes($_POST['senha_new']);
  $confirma_senha = addslashes($_POST['confirmar_senha']);

  $password_update = array(
    'senha' => $confirma_senha,
    "id_usuario" => addslashes($_POST['user_id'])
  );
  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $password_update, false));

  
  if($validacao == true)
  {
    
    if($newsenha == $confirma_senha){

      //transformando array em json
      $aquivo_json = json_encode($password_update);

      $token = implode(",",json_decode( $_SESSION['token'],true));
      $headers = array(
        'content-Type: application/json',
        'Authorization: Bearer '.$token,
      );
    
      // Iniciando o curl para a rota "usuarios/usuario"

      $ch = curl_init($rotaApi.'/api.paem/usuarios/usuario');
    
      curl_setopt($ch, CURLOPT_POSTFIELDS, $aquivo_json);
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
        Seus dados foram atualizados com sucesso.
        </div>";
        header("Location: ../../View/tecnico/login_tec.php");
        exit();             
      }
      elseif($httpcode1 == 500)
      {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro ao atualizar os dados.
        </div>";
          header("Location: ../../View/tecnico/update.php");
          exit(); 
      }
      else{
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro no Servidor, Erro ao atualizar!!
        </div>";
          header("Location: ../../View/tecnico/update.php");
        exit(); 
      }
            
    }
    else{

      $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
      Suas senhas não são iguais!!
      </div>";
        header("Location: ../../View/tecnico/update.php");
      exit(); 
      

    }
  
  }
  else{
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Preencha todos os campos!!
    </div>";
    header("Location: ../../View/tecnico/update.php");
  }


}

?>