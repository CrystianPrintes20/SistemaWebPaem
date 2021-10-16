<?php
 session_start();
    
//verifica se clicou no botão
if(isset($_POST['login']))
{   
    include_once('../../JSON/rota_api.php');

    $login = addslashes($_POST['login']);
    $password = addslashes($_POST['senha']);

    if(!empty($login) && !empty($password))
    {
        
        $url = $rotaApi.'/api.paem/auth';
        $ch = curl_init($url);

        $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode("$login:$password")
        );

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $response = curl_exec($ch);
               
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch)){
        // throw the an Exception.
        throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        session_start();
        $_SESSION['token'] = $response;
 

       if($httpcode == 200)
        {   
            header("location: ../../View/discente/home_discente.php");
            exit();
        }
        elseif($httpcode == 401)
        {
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            login e/ou senha incorretos!
          </div>";
            header("Location: ../../View/discente/login_discente.php");
            exit();
            
        }
        else{
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            Erro no Servidor!</div>";
            header("Location: ../../View/discente/login_discente.php");
            exit();
        } 
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/discente/login_discente.php");
        exit();
    }
    
}

?>