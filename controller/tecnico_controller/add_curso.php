<?php 
session_start();
//verifica se clicou no botão
if(isset($_POST['campus']))
    {
    
        $add_curso = array(
            'campus_id_campus' => addslashes($_POST['campus']),
            'nome' => addslashes($_POST['nome_curso'])
           
        );
      
    
        //transformando array em json
        $arquivo_json = json_encode($add_curso, JSON_UNESCAPED_UNICODE);
        print_r($arquivo_json);
      

        // Pegando o token
        $token = implode(",",json_decode( $_SESSION['token'],true));


        $headers = array(
        'content-Type: application/json',
        'Authorization: Bearer '.$token,
        );

        $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/cursos/curso');
        
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
        Curso adicionado com sucesso!!
        </div>";
        header("Location:  ../../View/tecnico/add_curso.php"); 
        exit();
        break; 

        case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Curso ja adicionado!!
        </div>";
        header("Location:  ../../View/tecnico/add_curso.php");
        exit();
        break;

        default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ERRO NO SERVIDOR!!
        </div>";
        header("Location: ../../View/tecnico/add_curso.php");
        exit();
        break;
    }
    }
?>