<?php
session_start();

if(isset($_FILES['comprovante_card_vac']))
{    

    include_once ('./buscardados_docuser.php');
    include_once ('../../JSON/rota_api.php');

    //Importando a siape e ID do usuario/aluno
    $siape = $dados_docuser['siape']; 
    $id_docente = $dados_docuser['id_docente'];

    $ext = strtolower(substr($_FILES['comprovante_card_vac']['name'],-4)); //Pegando extensão do arquivo
    $card_vacina['name'] = $siape . $ext; //Definindo um novo nome 
    $card_vacina['type'] = $_FILES['comprovante_card_vac']['type'];
    $card_vacina['tmp_name'] = realpath($_FILES['comprovante_card_vac']['tmp_name']);
   

    //Pegando o token
    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Criando o cabeçalho com o token
    $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
    );

    // Cria um manipulador cURL
    $ch = curl_init($rotaApi.'/api.paem/docentes/docente');

    $b64Doc = base64_encode(file_get_contents($card_vacina['tmp_name']));

    // Atribui dados ao POST
    $data = array('carteirinha_vacinacao' =>  $b64Doc, 'id_docente' => $id_docente);   
 
    // echo str_replace('\/','/',json_encode($data)); 
    $arquivo_json = json_encode($data, JSON_UNESCAPED_SLASHES);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
    
    $result = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //Resposta para o usuario
    switch ($httpcode) {

        case 200:
        
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
            Comprovante de vacinação enviada com sucesso!
            </div>";
            header("Location: ../../View/docente/cart_vacinacao_docente.php");
            exit();
            break;
        
        default:
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            Erro ao enviar, tente novamente mais tarde!
            </div>";
            header("Location: ../../View/docente/cart_vacinacao_docente.php");
            exit();
            break;
    }
} 
?>