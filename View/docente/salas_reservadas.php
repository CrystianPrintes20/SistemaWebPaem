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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>

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
                <h2>Filtragem de reservas</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área poderá ser feita a filtragem de todos as reservas em determinado periodo</p>
                        </div>
                    </div>
                    <h4>Lista de todas os recursos já reservados</h4>
                <hr>

                <form  method="POST" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <!-- <h4>Filtragem</h4> -->
              
                    <div class="row">

                        <div class=" col-md-12 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="recurso">Recurso</label>
                            </div>
                            <?php
                                include_once('../../JSON/rota_api.php');

                                $url = $rotaApi.'/api.paem/recursos_campus';
                                $ch = curl_init($url);
                                
                                $headers = array(
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
                            <select name="recurso" class="custom-select" id="recurso" required>
                                <option disabled selected>Escolha...</option>
                                <?php
                                    foreach ($resultado as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                        }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- Data da reversa -->
                    <div class="row">

                        <!-- Data Inicial -->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data Inicial</span>
                            </div>
                            <input  id="data_inicial" name="data_inicial" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" id="dtp_input2" value="" /><br/>
                        </div>
                        
                         <!-- Data Final -->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data Final</span>
                            </div>
                            <input id="data_final" name="data_final"  class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" id="dtp_input2" value="" /><br/>
                        </div>
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Filtrar</button>
                                </div> 
                                
                            </div>
                        </div>
                            
                    </div>
    
                </form>

                <?php

                    $token = implode(",",json_decode( $_SESSION['token'],true));

                    $url = $rotaApi."/api.paem/solicitacoes_acessos";
                    $ch = curl_init($url);
                    $headers = array(

                    'Authorization: Bearer '.$token,
                    );


                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    $response = curl_exec($ch);

                    $resultado = json_decode($response,true);
                    // echo '<pre>';
                    // print_r($resultado);
                    // echo '</pre>';
                ?>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <?php 
                /* Verifica se a variavel resultado não está vazia */
                if(!empty($resultado)){
                    
                    $sort = array();
                    foreach($resultado as $k => $v) {
                        $sort['data'][$k] = $v['data'];
                    
                    }

                    //aqui é realizado a ordenação do array
                    array_multisort($sort['data'], SORT_DESC,$resultado);
                    ?>
                    <div id="table_reservas">
                        <table id="agendamentos_table" class="table table-hover">
                            <thead class="table-dark">
                                <tr class="centralizar">
                                    <th scope="col">#</th>
                                    <th scope="col">Recurso campus</th>
                                    <th scope="col">Data</th>
                                   <!--  <th scope="col">Para_si</th> -->
                                    <th scope="col">Nome</th>
                                    <th scope="col">Hora_inicio</th>
                                    <th scope="col">Hora_fim</th>
                                </tr>
                            </thead>
                            <?php 
                                //contador
                                $cont = 0;

                                /* Verifica se o recurso existe, no caso se foi enviado */
                                if(isset($_POST['recurso'])){

                                    $id_recurso = addslashes($_POST['recurso']);
                                    $data_inicial = addslashes($_POST['data_inicial']);
                                    $data_final = addslashes($_POST['data_final']);

                                    //trasformando formato de data dd/mm/yyyy para yyyy/mm/dd
                                    $datas_in = explode('-', $data_inicial);
                                    $newdata_in = $datas_in[2].'-'.$datas_in[1].'-'.$datas_in[0];

                                    $datas_final = explode('-', $data_final);
                                    $newdata_fim = $datas_final[2].'-'.$datas_final[1].'-'.$datas_final[0];
    
                                    foreach($resultado as $value){
                                        
    
                                        if($id_recurso == $value['recurso_campus_id_recurso_campus'] && $value['data'] >= $newdata_in && $value['data'] <= $newdata_fim ){
                                            $data = $value['data'];
                                            //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                                            $datas = explode('-', $data);
                                            $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];
                                            $cont += 1;
                                            ?>
                                                <tr>
                                                    <td><?php echo $cont;  ?></td>
                                                    <td><?php echo $value['recurso_campus'];?></td>
                                                    <td><?php echo $newdata;?></td>
                                                    <td><?php echo $value['nome']; ?></td>
                                                    <td><?php echo $value['hora_inicio'];?></td>
                                                    <td><?php echo $value['hora_fim'];?></td>
                                             
                                                </tr>
                                            <?php
        
                                        }
                                    }
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    }
                                /* Caso ainda não tenha enviado o formulario, esse trecho de codigo ira mostrar todos as reservar feitas no campus  */
                                }else{
    
                                    foreach($resultado as &$value) { 
    
                                        $data = $value['data'];
                                        // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                                        $datas = explode('-', $data);
                                        $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];
      
                                        ?>
    
                                        <tr>
                                            <td><?php echo $cont += 1;  ?></td>
                                            <td><?php echo $value['recurso_campus'];?></td>
                                            <td><?php echo $newdata;?></td>
                                            <td><?php echo $value['nome']; ?></td>
                                            <td><?php echo $value['hora_inicio'];?></td>
                                            <td><?php echo $value['hora_fim'];?></td>
                                       
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                                      
                        </table>
                    </div>
                    
                <?php
                }else{
                    ?>
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr class="centralizar">
                                    <th scope="col">#</th>
                                    <th scope="col">Recurso campus</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Hora_inicio</th>
                                    <th scope="col">Hora_fim</th>
                                </tr>
                            </thead>
                            <tr>
                                <td align="center" colspan="6"><b> Sem Registros  </b></td>
                            </tr>
                        </table>
                    <?php
                }?>

            </div>
            
        </main>
    </div>

    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">

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
            endDate: '+2d'

        }).on('changeDate', function(selected){
            var minDate = new Date(selected.date.valueOf());
           $('#data_inicial').datetimepicker('setEndDate', minDate);
        }) ;

    });
  
</script>

<script>
$(document).ready(function() {
    $('#agendamentos_table').DataTable({
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    });
} );
</script>
</html>