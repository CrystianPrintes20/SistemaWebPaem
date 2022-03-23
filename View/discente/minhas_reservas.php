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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />
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
                <h2>Listando Reservas</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área você pode vizualizar todas as suas reversas realizadas</p>
                        </div>
                    </div>
                <hr>

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

                 
                ?>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <?php 

                if(!empty($resultado)){
                    //contador
                    $cont = 0;

                    $sort = array();
                    foreach($resultado as $k => $v) {
                        $sort['data'][$k] = $v['data'];
                    
                    }

                    //aqui é realizado a ordenação do array
                    array_multisort($sort['data'], SORT_DESC,$resultado);
                    ?>
                    <div id="table_reservas">
                        <table id='agendamentos_table' class="table table-hover">
                            <thead class="table-dark">
                                <tr class="centralizar">
                                    <th scope="col">#</th>
                                    <th scope="col">Recurso campus</th>
                                    <th scope="col">Data</th>
                                   <!--  <th scope="col">Para_si</th> -->
                                    <th scope="col">Nome</th>
                                    <th scope="col">Hora_inicio</th>
                                    <th scope="col">Hora_fim</th>
                                    <th scope="col">Fone</th>
                                </tr>
                            </thead>
                            <?php 
                                
                      
                                //Nessa parte é feita a filtragem com os dados vindos do fomulario preenchido pelo usuario
                                if(isset($_POST['recurso'])){
    
                                    $filtro = [];
                                                        
                                    $filtro['id_recurso'] = addslashes($_POST['recurso']);
                                    $filtro['data_inicial'] = addslashes($_POST['data_inicial']);
                                    $filtro['data_final'] = addslashes($_POST['data_final']);
    
                                    foreach($resultado as $value){
    
                                        if($filtro['id_recurso'] == $value['recurso_campus_id_recurso_campus']){
                                            $data = $value['data'];
                                            //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                                            $datas = explode('-', $data);
                                            $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];
                                            ?>
                                                <tr>
                                                    <td><?php echo $cont += 1;  ?></td>
                                                    <td><?php echo $value['recurso_campus'];?></td>
                                                    <td><?php echo $newdata;?></td>
                                                    <!-- <td><?php echo $value['para_si'];?></td> -->
                                                    <td><?php echo $value['nome']; ?></td>
                                                    <td><?php echo $value['hora_inicio'];?></td>
                                                    <td><?php echo $value['hora_fim'];?></td>
                                                    <td><?php echo $value['fone'];?></td>
                                                
                                                </tr>
                                            <?php
        
                                        }
        
                                    }
    
                                }else{
                                    date_default_timezone_set('America/Sao_Paulo');
                                    $hoje = date('d-m-Y');
                                
                                
    
                                    foreach($resultado as &$value) { 
                                        if($value['matricula'] == $dados_discuser['matricula']){

                                            $data = $value['data'];
                                            // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                                            $datas = explode('-', $data);
                                            $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];
                                        
                                            /* if($newdata == $hoje){ */
        
                                        
                                            ?>
        
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['recurso_campus'];?></td>
                                                <td><?php echo $newdata;?></td>
                                                <!-- <td><?php echo $value['para_si'];?></td> -->
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['hora_inicio'];?></td>
                                                <td><?php echo $value['hora_fim'];?></td>
                                                <td><?php echo $value['fone'];?></td>
                                            
                                            </tr>
                                            <?php /* }   */ 
                                            
                                        };
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
                                   <!--  <th scope="col">Para_si</th> -->
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
                }
                ?>
            </div>
            
        </main>
    </div>

    
</body>

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

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
        startDate: new Date(),
        endDate: '+7d',
        
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