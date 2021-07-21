<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
    $cadastro_docente = array(
      //Array dados do docente para tabela docente
      "docente" => array(
        "siape" => addslashes($_POST['siape']),
        "nome" => strtoupper(addslashes( $_POST['nome'])),
        "data_nascimento" => addslashes($_POST['data_nascimento']),
        "situacao" => strtoupper(addslashes($_POST['situacao'])),
        "escolaridade" => strtoupper(addslashes($_POST['escolaridade'])),
        "status_afastamento" => strtoupper(addslashes($_POST['afastamento_status'])),
        "campus_id_campus" => addslashes($_POST['campus'])
      ),
      //Array dados do docente para tabela usuario
      "usuario" => array(
        'email' => addslashes($_POST['email']),
        'senha' => addslashes($_POST['senha']),
        'login' => addslashes($_POST['username']),
        'cpf' =>  addslashes($_POST['cpf']),
        'tipo' => addslashes('1'),
      ),
    );
    

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $cadastro_docente['docente'], false));
    $validacao1 = (false === array_search(false , $cadastro_docente['usuario'], false));
    

    if($validacao === true && $validacao1 === true )
    { 
      //transformando array em json
       $cadastro_docente_json = json_encode($cadastro_docente);
       print_r($cadastro_docente_json);
       //die();
       //chamada da função CURL para o docente
       
       $ch = curl_init('http://127.0.0.1:5000/api.paem/docentes/docente');
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastro_docente_json);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
         'Content-Type: application/json;charset=UTF-8',)
       );
        
       $result = curl_exec($ch);
       $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
       curl_close($ch);

      if($httpcode1 == 201)
      {
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Usuário cadastrado com sucesso!!
        </div>";
        header("Location: ../../View/docente/login_discente.php");
        exit();             
      }
     elseif($httpcode1 == 500)
      {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        docente já cadastrado!!
        </div>";
         header("Location: ../../View/docente/cadastrar_docente.php");
         exit(); 
      }
      else{
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro no Servidor, Erro ao Cadastrar!!
        </div>";
         header("Location: ../../View/docente/cadastrar_docente.php");
        exit(); 
      }
       
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/docente/cadastrar_docente.php");
    }
}
?>