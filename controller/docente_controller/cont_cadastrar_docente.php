<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['nome']))
{
  include_once('../../JSON/rota_api.php');

  //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
  // $data_nascimento = explode('-', addslashes($_POST['data_nascimento']));
  // $newdata = $data_nascimento[2].'-'.$data_nascimento[1].'-'.$data_nascimento[0];

  $cadastro_docente = array(
    //Array dados do docente para tabela docente
    "docente" => array(
      "siape" => addslashes($_POST['siape']),
      "nome" => strtoupper(addslashes( $_POST['nome'])),
      "data_nascimento" => addslashes($_POST['data_nascimento']),
      "situacao" => strtoupper(addslashes($_POST['situacao'])),
      "escolaridade" => strtoupper(addslashes($_POST['escolaridade'])),
      "campus_instituto_id_campus_instituto" => addslashes($_POST['campus']),
      "status_covid" => addslashes($_POST['status_covid']),
      "status_afastamento" => strtoupper(addslashes($_POST['afastamento_status'])),
      'curso_id_curso' => addslashes($_POST['curso']),
      "quantidade_vacinas" => addslashes($_POST['quantidade_vacinas']),
      //'coordenador' => addslashes($_POST['cargo'])
      
    ),

    //Array dados do docente para tabela usuario
    "usuario" => array(
      'email' => addslashes($_POST['email']),
      'senha' => addslashes($_POST['senha']),
      'login' => addslashes($_POST['username']),
      'cpf' =>  addslashes($_POST['cpf']),
      'tipo' => addslashes('2'),
      "campus_instituto_id_campus_instituto" => addslashes($_POST['campus']),
    ),
  );
 
 //Verifica se a quantidades de vacinas for igual a nenhuma, o docente é obrigado a dar uma justificativa
 switch ($cadastro_docente['docente']['quantidade_vacinas']) {
  case 'nenhuma':
    $cadastro_docente['docente']['justificativa'] = addslashes($_POST['justificativa']);
    break;

  case 1:
    //Verifica se a quantidades de vacinas for igual a 1 
    $cadastro_docente['docente']['fabricante'] = addslashes($_POST['fabricante_dose1']);
    break;
  
  case 2:
    //Verifica se a quantidades de vacinas for igual a 2
    $cadastro_docente['docente']['fabricante'] = addslashes($_POST['fabricante_dose2']);
    break;
  
  case 3:
     //Verifica se a quantidades de vacinas for igual a 3
    $cadastro_docente['docente']['fabricante'] = addslashes($_POST['fabricante_dose3']).'/'. addslashes($_POST['fabricante_reforco']);
    break;

  default:
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
    Preencha os campos sobre a vacina!!
    </div>";
    header("Location: ../../View/docente/cadastrar_docente.php");
    break;
}

  //vereficar se esta tudo preenchido no array
  $validacao = (false === array_search(false , $cadastro_docente['docente'], false));
  $validacao1 = (false === array_search(false , $cadastro_docente['usuario'], false));
  

  if($validacao === true && $validacao1 === true )
  { 
    //transformando array em json
    $cadastro_docente_json = json_encode($cadastro_docente);
  
    //chamada da função CURL para o docente
    
    $ch = curl_init($rotaApi.'/api.paem/docentes/docente');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastro_docente_json);
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
      Usuário/Docente cadastrado com sucesso!!
      </div>";
      header("Location: ../../View/docente/login_docente.php");
      exit();
      break;
    
    case 500:
      $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
      Usuario/Docente já cadastrado!
      </div>";
      header("Location: ../../View/docente/cadastrar_docente.php");
      exit();
      break;

    default:
      $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
      Erro no Servidor, Erro ao Cadastrar! Verifique os seus dados e tente novamente.
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