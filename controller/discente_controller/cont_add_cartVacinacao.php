<?php
session_start();

if(isset($_FILES['comprovante_card_vac']))
{    
    include_once ('./buscardados_discuser.php');
    include_once ('../../JSON/rota_api.php');

    $matricula = $dados_discuser['matricula']; 
    $id_discente = $dados_discuser['id_discente'];

    $card_vacina = $_FILES['comprovante_card_vac'];
    print_r($card_vacina);
 
    //Pegando o token
    $token = implode(",",json_decode( $_SESSION['token'],true));
    //Criando o cabeçalho com o token
    $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
    );
    
    // Cria um manipulador cURL
    $ch = curl_init($rotaApi.'/api.paem/discentes/discente');  

    // Cria um objeto CURLFile
    $cfile = new CURLFile($card_vacina['tmp_name'], $card_vacina['type'], $card_vacina['name']);

    // Atribui dados ao POST
    $data = array('carteirinha_vacinacao' => $cfile, 'id_discente' => $id_discente);
    $arquivo_json = json_encode($data, JSON_UNESCAPED_SLASHES);
    print_r($arquivo_json);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');

    // Executa o manipulador
    curl_exec($ch);
    die();
    /* $ext = strtolower(substr($_FILES['comprovante_card_vac']['name'],-4)); //Pegando extensão do arquivo
    $card_vacina['name'] = $matricula . $ext; //Definindo um novo nome para o arquivodate("Y.m.d-H.i.s")
    $card_vacina['type'] = 'application/pdf';
    $card_vacina['tmp_name'] = realpath($_FILES['comprovante_card_vac']['tmp_name']);
   
    // $card_vacina = $_FILES['comprovante_card_vac'];
    print_r($card_vacina);

    //Pegando o token
    $token = implode(",",json_decode( $_SESSION['token'],true));

    //Criando o cabeçalho com o token
    $headers = array(
        'content-Type: application/json',
        'charset=UTF-8',
        'Authorization: Bearer '.$token,
    );

    // Cria um manipulador cURL
    $ch = curl_init($rotaApi.'/api.paem/discentes/discente');  
    // Cria um objeto CURLFile
    $cfile = new CURLFile( $card_vacina['tmp_name'],$card_vacina['type'], $card_vacina['name']);
    echo'<pre>';
    print_r($cfile);
    echo'<br>';
    echo'<br>';
    // Atribui dados ao POST
    $data = array('carteirinha_vacinacao' => $cfile, 'id_discente' => $id_discente);
   
    print_r($data);
    echo'<br>';
    // echo str_replace('\/','/',json_encode($data)); 
    $arquivo_json = str_replace('\/', '/',json_encode($data, JSON_UNESCAPED_SLASHES));
    print_r($arquivo_json);
    die();
    curl_setopt($ch, CURLOPT_POST, 1);
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
            header("Location: ../../View/discente/cart_vacinacao_discente.php");
            exit();
            break;
        
        default:
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            Erro ao enviar, tente novamente mais tarde!
            </div>";
            header("Location: ../../View/discente/cart_vacinacao_discente.php");
            exit();
            break;
    } */
/*     // $ext = strtolower(substr($_FILES['imagem']['name'],-4)); //Pegando extensão do arquivo
    // $new_name = $matricula . $ext; //Definindo um novo nome para o arquivodate("Y.m.d-H.i.s")

    if(!empty($new_name)){

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

        $cfile = new CURLFile($new_name,'image/jpg');
        $data = array('carteirinha_vacinacao' => $cfile, 'id_discente' => $id_discente);
          
        //transformando array em json
        $arquivo_json = json_encode($data);
        print_r($arquivo_json);
 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
        
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
    }
 */



} 
?>