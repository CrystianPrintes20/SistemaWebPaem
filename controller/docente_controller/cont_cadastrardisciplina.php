<?php
session_start();

if(isset($_POST['nome_disciplina'])){

    //importando a rota da API
    include_once('../../JSON/rota_api.php');
    //importando dados do docente
    include_once ('./buscardados_docuser.php');

    //Pegando o cookie com as matriculas dos dicentes
    $matricula_discente = json_decode( $_COOKIE["name"]);
    
    $cadastar_disciplina = array(
        //Array dados do docente para tabela docente
        "disciplina" => array(
            'nome' => addslashes($_POST['nome_disciplina']),
            'codigo_sigaa' => addslashes($_POST['cod_sigaa']),
            'semestre' => addslashes($_POST['semestre']),
            'curso_id_curso' => $dados_docuser['curso_id_curso'],
            'docente_id_docente' => addslashes($_POST['docente_identi'])
          
        ),
    
        //Array dados do docente para tabela usuario
        "discentes" => $matricula_discente
      );
    //Criando o array com as infomações a serem cadastradas

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $cadastar_disciplina['disciplina'], false));
    $validacao1 = (false === array_search(false , $cadastar_disciplina['discentes'], false));

    if($validacao === true && $validacao1 === true){
        //Transformando array em Json
        $cadastar_disciplina_json = json_encode($cadastar_disciplina);

        //pegando o token do usuario
        $token = implode(",",json_decode($_SESSION['token'],true));
        //criando o headers
        $headers= array(
            'content-Type: application/json',
            'Authorization: Bearer '.$token
        );

        //chamada da função CURL para o docente

        $ch = curl_init($rotaApi.'/api.paem/disciplinas/disciplina');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $cadastar_disciplina_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        switch($httpcode){
            case 201:
            
                $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
                Disciplina criada com sucesso!
                </div>";
                header("Location: ../../View/docente/cadastrar_disciplinas_docente.php");
                exit();
            break;

            case 500:
                $_SESSION['msg'] = "<div class='alert alert-warning'' role='alert'>
                Erro ao cadastrar essa disciplina!
                </div>";
                header("Location: ../../View/docente/cadastrar_disciplinas_docente.php");
                exit();
            break;
            
            default:
                $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
                Erro no servidor, tente novamente mais tarde!!
                </div>";
                header("Location: ../../View/docente/cadastrar_disciplinas_docente.php");
                exit();
            break;


        }

    }else{
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!
        </div>";
        header("Location: ../../View/docente/cadastrar_disciplinas_docente.php");
        exit();
    }
}
?>