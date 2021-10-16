<?php 
session_start();
//verifica se clicou no botão
if(isset($_POST['nome_campus']))
    {
        $data = explode('-', addslashes($_POST['ano_fundacao']));
        $newdata = $data[2].'-'.$data[1].'-'.$data[0];
       
        $add_campus = [];
        
        //$add_campus['id_campus'] = 5;
        $add_campus['ano_fundacao'] = $newdata;
        $add_campus['nome'] = addslashes($_POST['nome_campus']);

        //transformando array em json
        $arquivo_json = json_encode($add_campus);
        echo'<pre>';
        print_r($arquivo_json);

        // Pegando o token
        $token = implode(",",json_decode( $_SESSION['token'],true));


        $headers = array(
        'content-Type: application/json',
        'Authorization: Bearer '.$token,
        );

        $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/campus_institutos/campus_instituto');
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        
        
        $result = curl_exec($ch);
        $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

    //Resposta para o usuario
    switch ($httpcode1) {

        case 201:

        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Campus adicionado com sucesso!!
        </div>";
        header("Location:  ../../View/tecnico/add_campus.php"); 
        exit();
        break; 

        case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Campus ja adicionado!!
        </div>";
        header("Location:  ../../View/tecnico/add_campus.php");
        exit();
        break;

        default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ERRO NO SERVIDOR!!
        </div>";
        header("Location: ../../View/tecnico/add_campus.php");
        exit();
        break;
    }
    }
?>