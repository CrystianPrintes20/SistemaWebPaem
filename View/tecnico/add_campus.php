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
    <link rel="shortcut icon" href="../../img/Minhavidaacademica.ico">
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
                <form method="POST" class="alert alert-secondary" action="../../controller/tecnico_controller/add_campus.php">
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
            </div>
        </main>
    </div>

</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


</html>