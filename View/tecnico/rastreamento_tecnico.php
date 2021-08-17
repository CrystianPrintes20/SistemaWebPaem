<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ./login_tec.php");
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
            include "./menu_tecnico.php";
        ?>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Area de Rastreamento.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Aqui você poderá fazer um buscar por um determinado discente inserindo seu nome ou matricula, que o sistema mostrará todas as salas que o mesmo esteve e resevou.</p>
                        </div>
                    </div>
                <hr>
                <form method="POST" action="../../controller/tecnico_controller/cont_rasteardiscente.php" class="alert alert-secondary">
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                
                    <h4>Preencha os campos</h4>

                    <div class="row">
                        
                        <!--Matricula-->
                        <div class=" col-md-5 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Matricula</span>
                            </div>
                            <input type="text" name="matricula" id="matricula" value="" class="form-control"  aria-label="matricula" maxlength="10" required>
                        </div>

                        <span class="py-3">ou</span>

                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" value="" class="form-control"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40" required>
                        </div>
                        <input type="hidden" name="id_disc"value="">

                    </div>
                    <!-- Data da reversa -->
                    <div class="row">

                        <!-- Data Inicial -->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data Inicial</span>
                            </div>
                            
                            <input id="data_inicial" name="data_inicial" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input1" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" id="dtp_input1" value="" /><br/>

                        </div>  
                        
                        <!-- Data Final -->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data Final</span>
                            </div>
                            
                            <input id="data_final" name="data_final" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <input type="hidden" id="dtp_input2" value="" /><br/>

                        </div> 
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 py-4">
                                <button name="rastrear" class="btn btn-primary" type="submit">Rastrear</button>
                            </div> 
                        </div>
                    </div>
                </form>

            
            </div>
        </main>
    </div>

</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../js/buscar_nome_matri.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script type="text/javascript">

/*     $('#data_inicial').datetimepicker({
        language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        startDate: new Date(),
        
    }); */
    $(document).ready(function(){
        $('#data_inicial').datetimepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0"
        
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#data_final').datetimepicker('setStartDate', minDate);
        });

        $('#data_final').datetimepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0"

        }).on('changeDate', function(selected){
            var minDate = new Date(selected.date.valueOf());
           $('#data_inicial').datetimepicker('setEndDate', minDate);
        }) ;

       /*  $("#data_inicial").on("dp.change", function (e) {
        $('#data_final').data("DateTimePicker").maxDate(e.date.add(90,'days'));
        }); */

    });

  
</script>



</html>