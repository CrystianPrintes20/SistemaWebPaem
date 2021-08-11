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
        "campus_id_campus" => addslashes($_POST['campus']),
        "curso_id_curso" => addslashes($_POST['curso']),
        "entrada" => addslashes($_POST['entrada']),
        "semestre" => addslashes($_POST['semestre']),
        "endereco" => addslashes($_POST['rua_travessa']).','. addslashes($_POST['numero_end']).','.addslashes($_POST['bairro']),
        "grupo_risco" => addslashes($_POST['grupo_risco']),
        "status_covid" => addslashes($_POST['status_covid'])
        
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

    print_r($cadastro_disc);
    

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $cadastro_disc['discente'], false));
    $validacao1 = (false === array_search(false , $cadastro_disc['usuario'], false));

    if($validacao === true && $validacao1 === true)
    { 
      //transformando array em json
       $cadastro_disc_json = json_encode($cadastro_disc);
 
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