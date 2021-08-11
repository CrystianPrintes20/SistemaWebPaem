<?php
session_start();
include_once "./buscardados_tecuser.php";

//verifica se clicou no botão
if(isset($_POST['nome']))
{
  
  $confirma_siape = addslashes(($_POST['confirma_siape']));

  if($confirma_siape == $dados_tecuser['siape']){

    $updatetec = [];

    $updatetec['siape'] =addslashes($_POST['siape']);
    $updatetec['nome'] =  addslashes($_POST['nome']);
    $updatetec['data_nascimento'] = addslashes($_POST['data_nascimento']);
    $updatetec['cargo'] = addslashes($_POST['cargo']);
    $updatetec['campus_id_campus'] = addslashes($_POST['campus']);
    $updatetec['id_tecnico'] =  $dados_tecuser['id_tecnico'];

    
    $updateuser = [];

    $updateuser['email'] =addslashes($_POST['email']);
    $updateuser['login'] = addslashes($_POST['username']);
    $updateuser['cpf'] = addslashes($_POST['cpf']);
    $updateuser['tipo'] = $dados_tecuser['usuario']['tipo'];
    $updateuser['id_usuario'] = $dados_tecuser['usuario_id_usuario'];


    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $updatetec, false));
    $validacao1 = (false === array_search(false , $updateuser, false));

   


    if($validacao == true && $validacao1 == true)
    {
      //transformando array em json
      $arquivotec_json = json_encode($updatetec);
      $arquivouser_json = json_encode($updateuser);


      //Pegando o token
      $token = implode(",",json_decode( $_SESSION['token'],true));

      //Criando o cabeçalho com o token
      $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
      );

      // Iniciando o curl para a rota "tecnicos/tecnico"
      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/tecnicos/tecnico');
      
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


      if($updateuser['login'] != $dados_tecuser['usuario']['login']){
        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/tecnico/login_tec.php");
          exit();             
        }

      }else{

        if($httpcode == 200 && $httpcode1 == 200)
        {
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Seus dados foram atualizados com sucesso.
          </div>";
          header("Location: ../../View/tecnico/update.php");
          exit();             
        }
        elseif($httpcode == 500 && $httpcode1 == 500)
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
      
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/update.php");
    }
    
  }else{
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
     Seu SIAPE não são iguais!!
      </div>";
        header("Location: ../../View/tecnico/update.php");
  }
}
?>