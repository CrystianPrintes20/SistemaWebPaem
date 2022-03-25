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
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">

    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
    
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

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
                <h2>Área administrativa.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta página você podera realizar o agendamento para todos os discentes cadastrados no campus, de acordo com a disponibilidade de cada recurso.</p>
                        </div>
                    </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    

                ?>

                <div class="row">
                    <div class="col-sm">
                        <!-- Para Ver, a quantidade de alunos vacinados por curso e a quantidade total de alunos por curso. -->
                        <form  method="POST" action="../../controller/tecnico_controller/cont_graficos_vacinadosPorCurso.php" class="alert alert-secondary">
                            <h6>Quantidade de pessoas vacinadas por curso.</h6>
                            <div class="col-md-12 input-group py-3">
                                
                                <!--Campus -->
                                <?php
                                    $url = "../../JSON/campus.json";
                                    //var_dump($url);
                                    //$url = "https://swapi.dev/api/people/?page=1";
                                    $resultado = json_decode(file_get_contents($url));

                                    if (!$resultado) {
                                        switch (json_last_error()) {
                                            case JSON_ERROR_DEPTH:
                                                echo 'A profundidade máxima da pilha foi excedida';
                                            break;
                                            case JSON_ERROR_STATE_MISMATCH:
                                                    echo 'JSON malformado ou inválido';
                                            break;
                                            case JSON_ERROR_CTRL_CHAR:
                                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                            break;
                                            case JSON_ERROR_SYNTAX:
                                                echo 'Erro de sintaxe';
                                            break;
                                            case JSON_ERROR_UTF8:
                                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                            break;
                                            default:
                                                echo 'Erro desconhecido';
                                            break;
                                        }
                                        exit;
                                    }
                                
                                ?>

                                <div class="col-md-12 input-group py-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus" class="custom-select" id="campus">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>

                                    </select>
                                </div>

                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="pesqdispo" class="btn btn-success" type="submit">Consultar</button>
                                    </div> 
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-sm">
                        <!-- Para Ver, a quantidade de agendamentos solicitados por curso da universidade de acordo com o mês requisitado na query string(1, para Janeiro; 2, para Fevereiro;...;12, para Dezembro) e o ano(2020, 2021,...) -->
                        <form  method="POST" action="../../controller/tecnico_controller/cont_graf_solicitaPorCurso.php" class="alert alert-secondary">
                            <h6>Quantidade de Agendamentos por curso.</h6>
                            <div class="col-md-12 input-group py-3">
                                
                                <!--Campus -->
                                <?php
                                    $url = "../../JSON/campus.json";
                                    //var_dump($url);
                                    //$url = "https://swapi.dev/api/people/?page=1";
                                    $resultado = json_decode(file_get_contents($url));

                                    if (!$resultado) {
                                        switch (json_last_error()) {
                                            case JSON_ERROR_DEPTH:
                                                echo 'A profundidade máxima da pilha foi excedida';
                                            break;
                                            case JSON_ERROR_STATE_MISMATCH:
                                                    echo 'JSON malformado ou inválido';
                                            break;
                                            case JSON_ERROR_CTRL_CHAR:
                                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                            break;
                                            case JSON_ERROR_SYNTAX:
                                                echo 'Erro de sintaxe';
                                            break;
                                            case JSON_ERROR_UTF8:
                                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                            break;
                                            default:
                                                echo 'Erro desconhecido';
                                            break;
                                        }
                                        exit;
                                    }
                                
                                ?>

                                <div class="col-md-6 input-group py-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus" class="custom-select" id="campus">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>

                                    </select>
                                </div>
                                
                                <div class=" col-md-6 input-group py-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Ano e Mês</span>
                                    </div>
                                    <input name="ano_mes" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input type="hidden" id="dtp_input2" value="" /><br/>
                                </div>

                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="pesqdispo" class="btn btn-success" type="submit">Consultar</button>
                                    </div> 
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div id="container"  class=" col-md-6 input-group py-3" ></div>
                            <div id="container2" class=" col-md-6 input-group py-3" ></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm">
                        <!-- Para Ver, a quantidade de agendamentos solicitados por recurso do campus da universidade de acordo com o mês requisitado na query string(1, para Janeiro; 2, para Fevereiro;...;12, para Dezembro) e o ano(2020, 2021,...) -->
                        <form  method="POST" action="../../controller/tecnico_controller/cont_graf_solicitaPorRecurso.php" class="alert alert-secondary">
                            <h6>Quantidade de Agendamentos por recursos do campus.</h6>
                            <div class="col-md-12 input-group py-3">
                                
                                <!--Campus -->
                                <?php
                                    $url = "../../JSON/campus.json";
                                    //var_dump($url);
                                    //$url = "https://swapi.dev/api/people/?page=1";
                                    $resultado = json_decode(file_get_contents($url));

                                    if (!$resultado) {
                                        switch (json_last_error()) {
                                            case JSON_ERROR_DEPTH:
                                                echo 'A profundidade máxima da pilha foi excedida';
                                            break;
                                            case JSON_ERROR_STATE_MISMATCH:
                                                    echo 'JSON malformado ou inválido';
                                            break;
                                            case JSON_ERROR_CTRL_CHAR:
                                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                            break;
                                            case JSON_ERROR_SYNTAX:
                                                echo 'Erro de sintaxe';
                                            break;
                                            case JSON_ERROR_UTF8:
                                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                            break;
                                            default:
                                                echo 'Erro desconhecido';
                                            break;
                                        }
                                        exit;
                                    }
                                
                                ?>

                                <div class="col-md-6 input-group py-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus_rec" class="custom-select" id="campus_rec">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>

                                    </select>
                                </div>
                                
                                <div class=" col-md-6 input-group py-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Ano e Mês</span>
                                    </div>
                                    <input name="ano_mes_rec" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    <input type="hidden" id="dtp_input2" value="" /><br/>
                                </div>

                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="pesqdispo" class="btn btn-success" type="submit">Consultar</button>
                                    </div> 
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm">
                        <!-- Para Ver, a quantidade de notificações de covid efetuadas pelos alunos de acordo com o campus(id_campus_intituto) e o ano(2021, 2021,...) -->
                        <form  method="POST" action="../../controller/tecnico_controller/cont_graf_notifiCovidPorcampus.php" class="alert alert-secondary">
                            <h6>Notificações de COVID pelo campus.</h6>
                            <div class="col-md-12 input-group py-3">
                                
                                <!--Campus -->
                                <?php
                                    $url = "../../JSON/campus.json";
                                    //var_dump($url);
                                    //$url = "https://swapi.dev/api/people/?page=1";
                                    $resultado = json_decode(file_get_contents($url));

                                    if (!$resultado) {
                                        switch (json_last_error()) {
                                            case JSON_ERROR_DEPTH:
                                                echo 'A profundidade máxima da pilha foi excedida';
                                            break;
                                            case JSON_ERROR_STATE_MISMATCH:
                                                    echo 'JSON malformado ou inválido';
                                            break;
                                            case JSON_ERROR_CTRL_CHAR:
                                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                            break;
                                            case JSON_ERROR_SYNTAX:
                                                echo 'Erro de sintaxe';
                                            break;
                                            case JSON_ERROR_UTF8:
                                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                            break;
                                            default:
                                                echo 'Erro desconhecido';
                                            break;
                                        }
                                        exit;
                                    }
                                
                                ?>

                                <div class="col-md-6 input-group py-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus_covid" class="custom-select" id="campus_covid">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>

                                    </select>
                                </div>
                                
                                <div class=" col-md-6 input-group py-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Ano e Mês</span>
                                    </div>
                                    <input name="ano_mes_covid" class="form-control" type="number" min="2021" max="2022" value="2022" step="1" required>
                                </div>

                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="pesqdispo" class="btn btn-success" type="submit">Consultar</button>
                                    </div> 
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div  id="container3" class=" col-md-6 input-group py-3" ></div>
                            <div  id="container4" class=" col-md-6 input-group py-3" ></div>
                        </div>
                    </div>
                   
                </div>

                <!-- Para Ver, a quantidade de notificações de covid efetuadas pelos alunos por curso e de acordo com campus_insituto(id_campus_instituto) e o ano(2021, 2021,...) -->
                <form  method="POST" action="../../controller/tecnico_controller/cont_graf_notifiCovidPorCurso.php" class="alert alert-secondary">
                    <h6>Notificações de COVID por curso do campus/instituto.</h6>
                    <div class="col-md-12 input-group py-3">
                        
                        <!--Campus -->
                        <?php
                            $url = "../../JSON/campus.json";
                            //var_dump($url);
                            //$url = "https://swapi.dev/api/people/?page=1";
                            $resultado = json_decode(file_get_contents($url));

                            if (!$resultado) {
                                switch (json_last_error()) {
                                    case JSON_ERROR_DEPTH:
                                        echo 'A profundidade máxima da pilha foi excedida';
                                    break;
                                    case JSON_ERROR_STATE_MISMATCH:
                                            echo 'JSON malformado ou inválido';
                                    break;
                                    case JSON_ERROR_CTRL_CHAR:
                                        echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                    break;
                                    case JSON_ERROR_SYNTAX:
                                        echo 'Erro de sintaxe';
                                    break;
                                    case JSON_ERROR_UTF8:
                                        echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                    break;
                                    default:
                                        echo 'Erro desconhecido';
                                    break;
                                }
                                exit;
                            }
                        
                        ?>

                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">Campus</label>
                            </div>
                            <select required name="campus_covid_curso" class="custom-select" id="campus_covid_curso">
                            <option disabled selected></option>
                                <?php
                                    foreach ($resultado->data as $value) { ?>
                                    <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                        }
                                ?>

                            </select>
                        </div>
                        
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Ano</span>
                            </div>
                            <input name="ano_covid_curso" class="form-control" type="number" min="2021" max="2022" value="2022" step="1" required>
                        </div>

                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 py-4">
                                <button name="pesqdispo" class="btn btn-success" type="submit">Consultar</button>
                            </div> 
                            
                        </div>
                    </div>
                </form>
                 
                <div class="row">
                    <div  id="container5" class=" col-md-6 input-group py-3" ></div>
                    <div  id="container6" class=" col-md-6 input-group py-3" ></div>
                </div>
            </div>
        </main>
    </div>

</body>

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../Assets/js/buscar_nome_matri.js"></script>
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
        daysOfWeekDisabled: "0",
        startView: 2,
        minView: 2,
        forceParse: 0,
        startDate: new Date('2021'),
        endDate: new Date(),
        format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
                
        
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

<script type="text/javascript">

	$(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },

            xAxis: {
                categories: [
                
                ], 
            },
           /*  
           
            crosshair: true
            }, */
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade'
                }
            },

            series: [
                {
                    name: "Total de Vacinados"
                },
                {
                    name: "Total de Alunos"
                }
            ]
        };
        
        $.getJSON('../../JSON/json_grafVacporCurso.php', function(data){
            var nome_camp = data[0];
            var dados = data[1];
            console.log(dados);

            var curso = [];
            dados[1].forEach(function(objeto) {
                for ( var chave in objeto )
                    curso += objeto[chave];
            });
            resultado = curso.split(/\d+/);
            //console.log( resultado);
            //console.log(dados[0]);

            //console.log(Object.keys(curso));
            options.title.text = "Quantidade de alunos vacinados por curso no "+ nome_camp
            options.series[0].data = dados[0];
            options.series[1].data = dados[1];
            options.xAxis.categories = resultado;
            var chart = new Highcharts.Chart(options);
        });
    }); 

    /*Container 2 */
     $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container2',
                type: 'pie'
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },
            colors: [
                '#0ed145',
                '#0f55ce',
            ],
            title: {
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },
            series: [{
                name: "Agendamentos"
            }]
        };
        
        $.getJSON('../../JSON/json_grafSoliporCurso.php', function(data){
            var itens = data;
            var ano_mes = itens[0];
            //console.log(ano_mes);
            options.title.text = "Agendamentos solicitados por curso no mês " + ano_mes[0] + "/" + ano_mes[1];
            options.series[0].data = itens[1];
            var chart = new Highcharts.Chart(options);
        });
    }); 

    /*Container 3 */
    $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container3',
                type: 'column'
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },
            colors: [
                '#b97a56',
            ],
            title: {
                text: 'Agendamentos solicitados por recurso do campus.',
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },
            xAxis: {
                categories: [
                
                ], 
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade'
                }
            },
            series: [{
                name: "Agendamentos por recurso"
            }]
        };

        $.getJSON('../../JSON/json_grafSoliporRec.php', function(data){
            var itens = data;
           console.log(itens);
            var ano_mes = itens[0];
            var curso = [];
            itens[1].forEach(function(objeto) {
                for ( var chave in objeto )
                    curso += objeto[chave];
            });
            resultado = curso.split(/\d+/);
            //console.log( resultado);

            options.series[0].data = itens[1];
            options.title.text = "Agendamentos solicitados por curso no mês " + ano_mes[0] + "/" + ano_mes[1];
            options.xAxis.categories = resultado;
            var chart = new Highcharts.Chart(options);
        });
    }); 

    /*Container 4 */
    $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container4',
                type: 'column'
            },
            title: {
                text: 'Notificações de Covid por Campus/Institutos.',
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade'
                }
            },
            series: [{
                name: "Notificações de COVID"
            }]
        };
        
        $.getJSON('../../JSON/json_grafNotiCovidCamp.php', function(data){
            options.series[0].data = data;
            var chart = new Highcharts.Chart(options);
        });
    });

     /*Container 5 */
     $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container5',
                type: 'column'
            },
            title: {
                text: 'Notificações de Covid por Curso.',
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade'
                }
            },
            series: [{
                name: "Notificações de COVID"
            }]
        };
        
        $.getJSON('../../JSON/json_grafNotiCovidCurso.php', function(data){
            options.series[0].data = data;
            var chart = new Highcharts.Chart(options);
        });
    });

    /*Container 6 */
    $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container6',
                type: 'bar'
            },
            plotOptions: {
                column: {
                    colorByPoint: true
                }
            },
            colors: [
                '#3c3c86',
            ],
            title: {
                text: 'Agendamentos realizados nos ultimos 6 meses no campus',
                align: 'center',
                // y: 340 //  this to move y-coordinate of title to desired location
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantidade'
                }
            },
            series: [{
                name: "Total de Agendamentos realizados"
            }]
        };
        
        $.getJSON('../../controller/tecnico_controller/cont_graf_solicitaPorCampus.php', function(data){
            options.series[0].data = data;
            var chart = new Highcharts.Chart(options);
        });
    });


</script>

       

</html>