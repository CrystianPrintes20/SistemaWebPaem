
<?php
 session_start();
 /* sessions.php

 if (isset($_SESSION['usuario'])) {
     echo "Bem vindo {$_SESSION['usuario']}!";
 } else {
     echo 'Você NUNCA passou por aqui.';
     $_SESSION['usuario'] = 'João';
 }
 
     // cookies.php

     if (isset($_COOKIE['cookie_teste'])) {
        echo 'Você JÁ passou por aqui!';
    } else {
        echo 'Você NUNCA passou por aqui.';
        setcookie('cookie_teste', 'Algum valor...', time() + 3600);
    }*/
    
//verifica se clicou no botão
if(isset($_POST['login']))
{
    $login = addslashes($_POST['login']);
    $password = addslashes($_POST['senha']);

    if(!empty($login) && !empty($password))
    {


        //chamada da função CURL para o login

        /*$url = "http://localhost:5000/api.paem/auth";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt ($ch, CURLOPT_COOKIEFILE, '../tmp/cookie.txt');
        curl_setopt ($ch, CURLOPT_COOKIEJAR, '../tmp/cookie.txt');

        $result = curl_exec($ch);
       
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        print "error:" . curl_error($ch) . "<br />";
        print "output:" . $result . "<br /><br />";

        curl_close($ch);


        die();*/
        
        $url = 'http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/auth';
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
        print_r($response);
        
        
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(curl_errno($ch)){
        // throw the an Exception.
        throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        session_start();
        $_SESSION['token'] = $response;
        /*$a = $_SESSION['token'];

        print_r($a);
        die();*/

       if($httpcode == 200)
        {   
            header("location: ../../View/tecnico/home_tecnico.php");
            exit();
        }
        elseif($httpcode == 401)
        {
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            login e/ou senha incorretos!
          </div>";
            header("Location: ../../View/tecnico/login_tec.php");
            exit();
            
        }
        else{
            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
            Erro no Servidor!</div>";
            header("Location: ../../View/tecnico/login_tec.php");
            exit();
        } 
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
      </div>";
        header("Location: ../../View/tecnico/login_tec.php");
        exit();
    }
    
}

?>