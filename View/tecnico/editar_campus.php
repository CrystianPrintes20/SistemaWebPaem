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
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
   
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
                            <select name="campus" class="custom-select" id="campus" required>
                                <option disabled selected>Escolha...</option>
                                <?php
                                    foreach ($resultado as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                        }
                                ?>
                            </select>

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
                    
                    //Busca as informções do campus
                    if(isset($_POST['campus'])){
                        
                        $id_campus = addslashes($_POST['campus']);

                        foreach($resultado as $value){
                            if($value['id'] == $id_campus){
                                $nome = $value['nome'];
                            }
                        }

                    }
                ?>
            
                <form  method="POST" action="../../controller/tecnico_controller/editar_campus.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Informações do campus</h5>
                    <div class="row">
                       
                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100" required="" value="<?php if(isset($id_campus)){ echo $nome; }?>">
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Editar</button>
                                </div> 
                            </div>
                        </div>
                            
                    </div>
    
                </form>

            </div>
        </main>
    </div>

</body>

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


</html>