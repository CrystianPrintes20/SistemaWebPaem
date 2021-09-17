<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: login_tec.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../img/icon-icons.svg">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../../css/areaprivtec.css" />
   
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    

</head>

<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <?php
            include_once "./menu_tecnico.php";
        ?>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Editar campus.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Edite os campuss cadastrados no sistema</p>
                        </div>

                    </div>
                <hr>
                <form method="POST" class="alert alert-secondary">
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Escolha o campus deseja editar:</h5>
                    <div class="row">
                        <div class="col-md-12 input-group py-3">
                                
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">campus</label>
                            </div>
                            <?php

                                 $url = 'http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/campus';
                                 $ch = curl_init($url);
                                 
                                 $headers = array(
                                     'content-Type: application/json',
                                     'Authorization: Bearer '.$token,
                                 );
                                     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                     curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                 
                                     $response = curl_exec($ch);
                                    
                                     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                 
                                     if(curl_errno($ch)){
                                     // throw the an Exception.
                                     throw new Exception(curl_error($ch));
                                     }
                                 
                                     curl_close($ch);
     
                                     $resultado = json_decode($response, true);
                                     

                            ?>
                                <?php
                                    foreach ($resultado as $value) { ?>
                                    <input name="campus" value="<?php echo $value['nome']; ?>"><?php
                                        }
                                ?>
                           

                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="buscardados" class="btn btn-primary" type="submit">Buscar dados</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
            
    
                    <?php
                    //verifica se clicou no botão
                    if(isset($_POST['campus']))
                    {
                        $editrecurso = [];
                    
                        $editrecurso['nome'] = addslashes( $_POST['campus']);
                        $editrecurso['id_campus'] = 1;
                        
                      
                        

                        //vereficar se esta tudo preenchido no array
                        $validacao = (false === array_search(false , $editrecurso, false));
                    
                        if($validacao == true)
                        {
                        //transformando array em json
                        $arquivo_json = json_encode($editrecurso, JSON_UNESCAPED_UNICODE);

                        print_r($arquivo_json);

                        $token = implode(",",json_decode( $_SESSION['token'],true));
                        $headers = array(
                            'content-Type: application/json',
                            'Authorization: Bearer '.$token,
                        );

                        $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/campus/campi');
                        
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $arquivo_json);
                        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'PUT');  
                        
                        $result = curl_exec($ch);
                        $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    
                        curl_close($ch);

                        if($httpcode1 == 200)
                        {
                                
                            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
                            Recurso editado e adicionado com sucesso!!
                            </div>";
                            header("Location: ../../View/tecnico/salas_reservadas.php");             
                            exit();
                        }
                        else
                        {
                            $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
                            Ocorreu um erro ao editar esse recurso!!
                            </div>";
                            header("Location: ../../View/tecnico/salas_reservadas.php");
                            exit();
                        }

                        
                        }
                        else
                        {
                            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
                            Preencha todos os campos!!
                        </div>";
                            header("Location: ../../View/tecnico/salas_reservadas.php");
                            exit();
                        }
                    }
                    ?>

            </div>
        </main>
    </div>

</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


</html>