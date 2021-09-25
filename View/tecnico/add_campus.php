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
                <h2>Adicionar campus.</h2>
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
                    <h5>Adicionado um campus:</h5>
                    <div class="row">
                        <div class="col-md-12 input-group py-3">
                                
                            <!--nome-->
                            <div class=" col-md-6 input-group py-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Nome</span>
                                </div>
                                <input name="nome_campus" id="nome_campus" type="text" class="form-control" placeholder="Nome_campus"  aria-label="nome_campus" aria-describedby="basic-addon1" maxlength="50">
                            </div>

                            <!--descrição-->
                            <div class=" col-md-6 input-group py-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Ano de fundação</span>
                                </div>
                                <input name="ano_fundacao" id="ano_fundacao" type="date"  class="form-control" placeholder="Ex: vinculado ao curso XXXX"  aria-label="nome_campus" aria-describedby="basic-addon1" maxlength="100" >
                            </div>
                           

                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button  class="btn btn-primary" type="submit">Add campus</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>
                <?php 
                    //verifica se clicou no botão
                    if(isset($_POST['nome_campus']))
                    {
                        $data = explode('-', addslashes($_POST['ano_fundacao']));
                        $newdata = $data[2].'-'.$data[1].'-'.$data[0];
                        print_r($newdata);
                        

                        $add_campus = [];
                        
                        $add_campus['id_campus'] = 5;
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

                        $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/campus/campi');
                        
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

            </div>
        </main>
    </div>

</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


</html>