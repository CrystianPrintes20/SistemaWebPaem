<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ./login_discente.php");
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
            include_once "./menu_discente.php";
        ?>

         <!-- sidebar-wrapper  -->
         <main class="page-content">
            <div class="container">
                <h2>Notificação COVID-19</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Use está área para informar caso tenha suspeitas ou teste positivo para o COVID-19</p>
                        </div>
                    </div>
                <hr>
              
                <form  method="POST" action="../../controller/discente_controller/cont_notificacao_covid.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                   
                    <div class="col-md-12">

                        <div class="row">
                            <!-- Inicio dos Sintomas -->
                            <div class=" col-md-6 input-group py-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Inicio dos Sintomas</span>
                                </div>
                                <input name="inicio_sintomas" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input type="hidden" id="dtp_input2" value="" /><br/>
                            </div>
                            
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="nivel_sintomas">Nivel de Sintomas</label>
                                </div>
                                <select name="nivel_sintomas" class="custom-select" id="nivel_sintomas" required>
                                    <option value="-1">Não desejo informar</option>
                                    <option value="1">Sintomas Leve</option>
                                    <option value="2">Sintomas moderado</option>
                                    <option value="3">Sintomas grave</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="row">

                            <div class=" col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="reserva">Teste de COVID</label>
                                </div>
                                <select name="SelectOptions" class="custom-select" id="SelectOptions" required>
                                    <option >Realizou o Teste de COVID?</option>
                                    <option value="-1">Não</option>
                                    <option value="1">SIm</option>
                                </select>
                            </div>

                            <div class="DivPai col-md-6">

                                <div class="1" style="display: none;">
                                    <div class="1 row">
                                        <div class="1 col-md-12 input-group py-3">
                                            <div class="1 input-group-prepend">
                                                <label class="input-group-text" for="1">Data do teste</label>
                                            </div>
                                            <input name="data_exame" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input type="hidden" id="dtp_input2" value="" /><br/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                        <!-- Descrição -->
                        <div id="descricao" class="col-md-12 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text">Descrição</span>
                            </div>
                            <textarea id="descricao" class="form-control" name="descricao" minlength="10" rows="4" cols="20" placeholder="Escreva Aqui."></textarea>
                        </div>
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button class="btn btn-primary" type="submit">Enviar</button>
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
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script type="text/javascript">
    $('.form_date').datetimepicker({
        language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        endDate: '+0d'
        
    });
</script>

<script>
    //Funções após a leitura do documento
    $(document).ready(function() {
    //Select para mostrar e esconder divs
    $('#SelectOptions').on('change',function(){
        var SelectValue='.'+$(this).val();
        $('.DivPai div').hide();
        $(SelectValue).toggle();
    });
    });
</script>
</html>