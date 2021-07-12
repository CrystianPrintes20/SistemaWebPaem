<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
  
  $update = array(
    //Array dados do tecnico para tabela tecnico
    "tecnico" => array(
      "siape" => addslashes($_POST['siape']),
      "nome" => strtoupper(addslashes( $_POST['nome'])),
      "data_nascimento" => addslashes($_POST['data_nascimento']),
      "cargo" => strtoupper(addslashes($_POST['cargo'])),
      "campus_id_campus" => addslashes($_POST['campus']),
      "id_tecnico" => addslashes($_POST['tec_id'])

    ),
    //Array dados do tecnico para tabela usuario
    "usuario" => array(
      'email' => addslashes($_POST['email']),
      'senha' => addslashes($_POST['senha']),
      'login' => addslashes($_POST['username']),
      'cpf' =>  addslashes($_POST['cpf']),
      'tipo' => addslashes('1'),
      "id_usuario" => addslashes($_POST['user_id'])

    ),
  );
  print_r($update);
  die();
    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $update['tecnico'], false));
    $validacao1 = (false === array_search(false , $update['usuario'], false));


    if($validacao == true && $validacao1 == true)
    {
      //transformando array em json
      $aquivo_json = json_encode($update);

      $token = implode(",",json_decode( $_SESSION['token'],true));
      $headers = array(
        'content-Type: application/json',
        'Authorization: Bearer '.$token,
      );

      $ch = curl_init('http://localhost:5000/api.paem/tecnicos/tecnico');
      
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
      curl_close($ch);

    
      if($httpcode1 == 201)
      {
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Seus dados foram atualizados com sucesso.
        </div>";
        header("Location: ../../View/tecnico/update.php");
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
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/update.php");
    }
}
?>