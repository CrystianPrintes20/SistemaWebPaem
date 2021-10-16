<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
  
  include_once('../../JSON/rota_api.php');
  
  $id_campus_instituto = addslashes($_POST['campus']);
  $siape = addslashes($_POST['siape']);
  $nome = strtoupper(addslashes( $_POST['nome']));

  $cadastro_tec = array(
    //Array dados do tecnico para tabela tecnico
    "tecnico" => array(
      "siape" => $siape,
      "nome" => $nome,
      "data_nascimento" => addslashes($_POST['data_nascimento']),
      "cargo" => addslashes($_POST['cargo']),
      //"campus_id_campus" => $id_campus,
      "campus_instituto_id_campus_instituto" =>$id_campus_instituto,
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
      "campus_instituto_id_campus_instituto" =>$id_campus_instituto,
    ),
  );
  
  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $cadastro_tec['tecnico'], false));
  $validacao1 = (false === array_search(false , $cadastro_tec['usuario'], false));


  if($validacao === true && $validacao1 === true )
  { 

    $retorno = busca_tecnico($id_campus_instituto,$siape,$nome);
      

    if($retorno === false){
      throw new Exception(  $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
      Infelizmente não encontramos você. Verifique se os seguintes dados foram
      digitados corretamente: Campus/Instituto, Siape e Nome.
      </div>",
      header("Location: ../../View/tecnico/cadastrar_tec.php"),
      exit());
    
    }else{
      //transformando array em json
      $cadastro_tec_json = json_encode($cadastro_tec);
      print_r($cadastro_tec_json);
      //chamada da função CURL para o tecnico
      
      $ch = curl_init($rotaApi.'/api.paem/tecnicos/tecnico');
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastro_tec_json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=UTF-8',)
      );
          
      $result = curl_exec($ch);
      $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
      curl_close($ch);

      print_r($httpcode1);

      //Resposta para o usuario
      switch ($httpcode1) {

        case 201:
        
          $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
          Usuário cadastrado com sucesso!!
          </div>";
          header("Location: ../../View/tecnico/login_tec.php");
          exit(); 
          break;
        
        case 500:
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Tecnico já cadastrado!!
          </div>";
          header("Location: ../../View/tecnico/cadastrar_tec.php");
          exit(); 
          break;

        default:
          $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
          Erro no Servidor, Erro ao Cadastrar!!
          </div>";
          header("Location: ../../View/tecnico/cadastrar_tec.php");
          exit();
          break;
      }

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

//Função buscar tecnico
function busca_tecnico($id_campus_instituto,$siape,$nome){
  //Pegando o JSON de todos os tecnico da ufopa
  $url = file_get_contents("../../JSON/tecnicos.json");

  $resultado = json_decode($url,true);

  if (!$resultado) {
    switch (json_last_error()) {
        case JSON_ERROR_DEPTH:
            echo 'A profundidade máxima da pilha foi excedida';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo 'JSON malformado ou inválido';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
        break;
        case JSON_ERROR_SYNTAX:
            echo 'Erro de sintaxe';
        break;
        case JSON_ERROR_UTF8:
            echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
        break;
        default:
            echo 'Erro desconhecido';
        break;
    }
    exit;
  }

  //Pegando os dados do discente
  foreach($resultado as &$value){
    echo'<pre>';
    print_r($value);
    echo '<pre>';
    $nome_tecnico = $value[$id_campus_instituto][$siape];
    print_r($nome_tecnico);

  }

  if(!empty($nome_tecnico)){
 
    if($nome_tecnico == $nome){
      //esta tudo okay, discente encontrado 
      return true;
    }else{
      //Discente não encontrado
      return false;
    }
    
  }else{
    return false;
  }
}
?>