<?php
session_start();

//verifica se clicou no butão
if(isset($_POST['nome']))
{
  //$endereco = addslashes($_POST['rua_travessa']).','. addslashes($_POST['numero_end']).','.addslashes($_POST['bairro']);
  $cadastro_disc = array(
    //Array dados do tecnico para tabela tecnico
    "discente" => array(
      "nome" => addslashes( $_POST['nome']),
      "matricula" => addslashes($_POST['matricula']),
      /**/"data_nascimento" => addslashes($_POST['data_nascimento']),
      /**/"sexo" => addslashes($_POST['sexo']),
      "campus_id_campus" => addslashes($_POST['campus']),
      "curso_id_curso" => addslashes($_POST['curso']),
      "entrada" => addslashes($_POST['entrada']),
      "semestre" => addslashes($_POST['semestre']),
      "endereco" => addslashes($_POST['rua_travessa']).','. addslashes($_POST['numero_end']).','.addslashes($_POST['bairro']),
      /**/ "quantidade_pessoas" => addslashes($_POST['qtde_moradores']),
      "grupo_risco" => addslashes($_POST['grupo_risco']),
      "status_covid" => addslashes($_POST['status_covid']),
      /**/"quantidade_vacinas" => addslashes($_POST['quantidade_vacinas']),
      
    ),
    //Array dados do tecnico para tabela usuario
    "usuario" => array(
      'email' => addslashes($_POST['email']),
      'senha' => addslashes($_POST['senha']),
      'login' => addslashes($_POST['username']),
      'cpf' =>  addslashes($_POST['cpf']),
      'tipo' => addslashes('3'),
    ),
  );
  
  //Verifica se a quantidades de vacinas for igual a nenhuma, o discente é obrigado a dar uma justificativa
  if($cadastro_disc['discente']['quantidade_vacinas'] == 'nenhuma'){
    $cadastro_disc['discente']['justificativa'] = addslashes($_POST['justificativa']);

  //Verifica se a quantidades de vacinas for igual a 1 ou 2, o discente é obrigado informar o fabricante da vanica  
  }elseif($cadastro_disc['discente']['quantidade_vacinas'] == 1 || $cadastro_disc['discente']['quantidade_vacinas'] == 2){
    $cadastro_disc['discente']['fabricante'] = addslashes($_POST['fabricante']);

  }
  

  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $cadastro_disc['discente'], false));
  $validacao1 = (false === array_search(false , $cadastro_disc['usuario'], false));

  if($validacao === true && $validacao1 === true)
  { 
    //transformando array em json
      $cadastro_disc_json = json_encode($cadastro_disc);
      echo '<pre>';
      print_r($cadastro_disc_json);
      echo '/<pre>';

      //chamada da função CURL para o tecnico
      
      $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/discentes/discente');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastro_disc_json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=UTF-8',)
      );
      
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
      curl_close($ch);

    //Resposta para o usuario
    switch ($httpcode1) {

      case 201:
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Usuário cadastrado com sucesso!!
        </div>";
        header("Location: ../../View/discente/login_discente.php");
        exit();
        break;
      
      case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Email e/ou Matricula já cadastrados!!
        </div>";
        header("Location: ../../View/discente/cadastrar_disc.php");
        exit();
        break;

      default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro no Servidor, Erro ao Cadastrar!!
        </div>";
        header("Location: ../../View/discente/cadastrar_disc.php");
        exit();
    }
      
  }
  else
  {
      $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Preencha todos os campos!!
    </div>";
      header("Location: ../../View/discente/cadastrar_disc.php");
  }
}
?>