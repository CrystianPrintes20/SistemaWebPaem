<?php
session_start();
include_once "./buscardados_discuser.php";

//verifica se clicou no botão
if(isset($_POST['nome']))
{
  include_once('../../JSON/rota_api.php');
  $confirma_matricula = addslashes(($_POST['confirma_matricula']));

  if($confirma_matricula == $dados_discuser['matricula']){

    $updatedisc = array(
      'nome' =>  strtoupper( addslashes($_POST['nome'])),
      'data_nascimento'=> addslashes($_POST['data_nascimento']),
      'endereco' => addslashes($_POST['rua_travessa']).','.addslashes($_POST['numero_end']).','.addslashes($_POST['bairro']),
      "quantidade_pessoas" => addslashes($_POST['qtde_moradores']),
      "grupo_risco" => addslashes($_POST['grupo_risco']),
      "status_covid" => addslashes($_POST['status_covid']),
      "quantidade_vacinas" => addslashes($_POST['quantidade_vacinas']),
      'id_discente' => $dados_discuser['id_discente']
    );

    switch($updatedisc['quantidade_vacinas']){
      //Verifica se a quantidades de vacinas for igual a nenhuma, o discente é obrigado a dar uma justificativa
      case 'nenhuma':
        $updatedisc['justificativa'] = addslashes($_POST['justificativa']);
        $updatedisc['fabricante'] = 'Null';
        break;
      //Verifica se a quantidades de vacinas for igual a 1 ou 2, o discente é obrigado informar o fabricante da vacina  
      case 1:
        $updatedisc['fabricante'] = addslashes($_POST['fabricante_doses1']);
        $updatedisc['justificativa'] = 'Null';
        break;
      case 2:
        $updatedisc['fabricante'] = addslashes($_POST['fabricante_doses2']);
        $updatedisc['justificativa'] = 'Null';
        break;
      case 3:
        $updatedisc['fabricante'] = addslashes($_POST['fabricante_dose3']).'/'. addslashes($_POST['fabricante_reforco']);
        break;
    }
    
    $updateuser = array(
      'email' => addslashes($_POST['email']),
      'tipo' => $dados_discuser['usuario']['tipo'],
      'id_usuario' => $dados_discuser['usuario']['id_usuario']
    );

    print_r($updatedisc);
    print_r($updateuser);

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
      $ch = curl_init($rotaApi.'/api.paem/discentes/discente');
      
      curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivotec_json);
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


      if($updateuser['email'] != $dados_discuser['usuario']['email']){
        
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
      Matricula incorrenta!
      </div>";
        header("Location: ../../View/discente/update_discente.php");
  }
}
?>