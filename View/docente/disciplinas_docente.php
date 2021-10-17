<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ./login_docente.php");
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
            include_once "./menu_docente.php";
        ?>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Minhas Disciplinas.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form  method="POST" action="../../controller/docente_controller/cont_cadastrardisciplina.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h4>Crie uma disciplina</h4>

                    <div class="row">
                        <!-- Nome da disciplina -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="nome">Nome</label>
                            </div>
                            <input name="nome_disciplina" id="nome_disciplina" type="text" value="" class="form-control" placeholder="Nome da Disciplina"  aria-label="nome_disciplina" aria-describedby="basic-addon1" maxlength="40" required>
                        </div>

                        <!--cod_sigaa-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Código do SIGAA</span>
                            </div>
                            <input name="cod_sigaa" id="cod_sigaa" type="number" min='0' value="" placeholder="Codigo da disciplina" class="form-control"  aria-label="cod_sigaa" aria-describedby="basic-addon1" maxlength="40" required>
                        </div>
                    </div>

                    <div class="row">
                        
                        <!--Curso-->
                        <div class=" col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reserva">Curso</label>
                            </div>
                            <?php
                                include_once('../../JSON/rota_api.php');
                                $url = $rotaApi.'/api.paem/cursos';
                                $ch = curl_init($url);
                                
                                $headers = array(
                                    'content-Type: application/json; charset = utf-8',
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
                                //print_r($response);

                                $resultado = json_decode($response, true);
                            
                            ?>
                            <select name="curso" class="custom-select" id="curso" required>
                                <option disabled selected>Escolha...</option>
                                <?php
                                    foreach ($resultado as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                    }
                                ?>
                            </select> 
                        </div>

                        <!--Semestre-->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Semestre</span>
                            </div>
                            <input required name="semestre" id="semestre" type="text" class="form-control" placeholder="" aria-label="Nome" aria-describedby="basic-addon2" maxlength="2" onkeypress="$(this).mask('09')">
                        </div>
                        
                    </div>
        
                    <div class="row">
            
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Criar Disciplina</button>
                                </div> 
                                <!--<div class="col-md-6">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Verificar Disponibilidade e Finalizar Reserva</button>
                                </div>-->
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
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

</html>