<?php
session_start();
include_once "./buscardados_docuser.php";

//verifica se clicou no botão
if(isset($_POST['nome']))
{
  include_once('../../JSON/rota_api.php');

  $confirma_siape = addslashes(($_POST['confirma_siape']));

  if($confirma_siape == $dados_docuser['siape']){

    $updatedoc = array(
      'nome' => addslashes($_POST['nome']),
      'data_nascimento' => addslashes($_POST['data_nascimento']),
      'status_afastamento' =>  addslashes($_POST['afastamento_status']),
      'quantidade_vacinas' => addslashes($_POST['quantidade_vacinas']),
      'id_docente' => $dados_docuser['id_docente']
    );
    
    switch($updatedoc['quantidade_vacinas']){
      //Verifica se a quantidades de vacinas for igual a nenhuma, o discente é obrigado a dar uma justificativa
      case 'nenhuma':
        $updatedoc['justificativa'] = addslashes($_POST['justificativa']);
        $updatedoc['fabricante'] = 'Null';
        break;
      //Verifica se a quantidades de vacinas for igual a 1 ou 2, o discente é obrigado informar o fabricante da vacina  
      case 1:
        $updatedoc['fabricante'] = addslashes($_POST['fabricante_doses1']);
        $updatedoc['justificativa'] = 'Null';
        break;
      case 2:
        $updatedoc['fabricante'] = addslashes($_POST['fabricante_doses2']);
        $updatedoc['justificativa'] = 'Null';
        break;
      case 3:
        $updatedoc['fabricante'] = addslashes($_POST['fabricante_dose3']).'/'. addslashes($_POST['fabricante_reforco']);
        break;
    }

    $updatedocuser = array(
      'email' => addslashes($_POST['email']),
      'tipo' => $dados_docuser['usuario']['tipo'],
      'id_usuario' => $dados_docuser['usuario_id_usuario']
    );

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $updatedoc, false));
    $validacao1 = (false === array_search(false , $updatedocuser, false));

    if($validacao == true && $validacao1 == true)
    {
      //transformando array em json
      $arquivodoc_json = json_encode($updatedoc);
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
      $ch = curl_init($rotaApi.'/api.paem/docentes/docente');
      
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivodoc_json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
      
      $result = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);

      // Iniciando o curl para a rota "usuarios/usuario"

      $ch = curl_init($rotaApi.'/api.paem/usuarios/usuario');
    
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivouser_json);
      curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST,true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      curl_close($ch);


      if($updatedocuser['email'] != $dados_docuser['usuario']['email']){
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
      Siape incorreto!
      </div>";
        header("Location: ../../View/docente/update_docente.php");
  }
}
?>