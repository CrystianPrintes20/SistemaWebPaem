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
                <form method="POST"  class="alert alert-secondary">
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
                <!-- Buscando os dados conforme solicatado pelo usuario -->
         
                <form method="POST"  class="alert alert-secondary">
                    
                    <h4>Tabelas de informações</h4>
                    
                    <div id="table_reservas">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr class="centralizar">
                                    <th scope="col">#</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Recurso campus</th>
                                    <th scope="col">Horarios</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Lista do periodo</th>
                                </tr>
                            </thead>
                            <?php
               
                                if(isset($_POST['nome']))
                                {
                                    $rastreio = [];
                                
                                    $rastreio['nome'] = addslashes($_POST['nome']);
                                    $rastreio['data_inicial'] = addslashes($_POST['data_inicial']);
                                    $rastreio['data_final'] = addslashes($_POST['data_final']);
                                
                                    //print_r($rastreio);
                                
                                    $token = implode(",",json_decode( $_SESSION['token'],true));
                                    $url = "http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/solicitacoes_acessos";
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
                                    
                                    $resultado = json_decode($response,true);
                                
                                   /*  print_r($resultado);
                                    "<br>"; */
                                    $cont = 0;
                                
                                    foreach($resultado as $value){
                                        if($rastreio['nome'] == $value['nome']){
                                            
                                            // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
                                            $data = explode('-', $value['data']);
                                            $newdata = strtotime($data[2].'-'.$data[1].'-'.$data[0]);
                                            $newdata1 = $data[2].'-'.$data[1].'-'.$data[0];
                                
                                            $data_inicial = strtotime($rastreio['data_inicial']);
                                            $data_final = strtotime($rastreio['data_final']);
                                
                                            if($newdata >= $data_inicial && $newdata <= $data_final){
                                                $cont += 1;
                                                ?>
                                                <tr>
                                                    <td><?php echo $cont; ?></td>
                                                    <td><?php echo $newdata1; ?></td>
                                                    <td><?php echo $value['recurso_campus'] ?></td>
                                                    <td><?php echo $value['hora_inicio']. ' / ' . $value['hora_fim']; ?></td>
                                                    <td><?php echo $value['nome']; ?></td>
                                                    <td>
                                                        <!-- Button delete modal -->
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1" data-whatever1="<?php echo $value['recurso_campus'];?>" data-whatevernome1="<?php echo $newdata1;?>">
                                                            Visualizar todos
                                                        </button>
                                                    </td>
                                                  <!--   <td><?php echo $value['acesso_permitido']['hora_entrada'].' / '. $value['acesso_permitido']['hora_saida']?></td> -->
                                                   
                                                </tr>
                                                
                                            
                                            <?php
                                            }
                                        }
                                       
                                        
                                    }

                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td colspan="3"><?php echo'Sem registros'?></td>
                                            
                                        </tr>
                                    <?php
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </form>

                <!-- EXCLUIR SOLICITAÇÃO-->

                <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                               
                                <h6 class="modal-title" id="exampleModal1Label">Deseja excluir essa solicitação?</h6>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="../../controller/tecnico_controller/cont_excluir_solicitacao.php" >
                                    <div class="form-group">
                                        <label for="recipient-name1" class="control-label">Nome:</label>
                                        <input name="nome1"  disabled type="text" class="form-control" id="recipient-name1">
                                    </div>

                                    <input name="id_solicitacao1" type='hidden' id="id_solicitacao1" value="">

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Excluir</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

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
            format: 'dd-mm-yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0",
            endDate: '+0d'
        
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#data_final').datetimepicker('setStartDate', minDate);
        });

        $('#data_final').datetimepicker({
            language: 'pt-BR',
            format: 'dd-mm-yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0",
            endDate: '+0d'

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