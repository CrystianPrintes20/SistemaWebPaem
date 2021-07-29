<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
    $cadastro_tec = array(
      //Array dados do tecnico para tabela tecnico
      "tecnico" => array(
        "siape" => addslashes($_POST['siape']),
        "nome" => strtoupper(addslashes( $_POST['nome'])),
        "data_nascimento" => addslashes($_POST['data_nascimento']),
        "cargo" => strtoupper(addslashes($_POST['cargo'])),
        "campus_id_campus" => addslashes($_POST['campus']),
        "status_covid" => addslashes($_POST['status_covid']),
        "status_afastamento" => addslashes($_POST['afastamento_status']),
        
        
      ),
      //Array dados do tecnico para tabela usuario
      "usuario" => array(
        'email' => addslashes($_POST['email']),
        'senha' => addslashes($_POST['senha']),
        'login' => addslashes($_POST['username']),
        'cpf' =>  addslashes($_POST['cpf']),
        'tipo' => addslashes('1'),
      ),
    );
    

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $cadastro_tec['tecnico'], false));
    $validacao1 = (false === array_search(false , $cadastro_tec['usuario'], false));
    

    if($validacao === true && $validacao1 === true )
    { 
      //transformando array em json
       $cadastro_tec_json = json_encode($cadastro_tec);
       print_r($cadastro_tec_json);
       //chamada da função CURL para o tecnico
       
       $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/tecnicos/tecnico');
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastro_tec_json);
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
        header("Location: ../../View/tecnico/login_tec.php");
        exit();             
      }
     elseif($httpcode1 == 500)
      {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Tecnico já cadastrado!!
        </div>";
         header("Location: ../../View/tecnico/cadastrar_tec.php");
         exit(); 
      }
      else{
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro no Servidor, Erro ao Cadastrar!!
        </div>";
         header("Location: ../../View/tecnico/cadastrar_tec.php");
        exit(); 
      }
       
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/cadastrar_tec.php");
    }
}
?>