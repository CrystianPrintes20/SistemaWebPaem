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
            include_once "./menu_tecnico.php";
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

                                $url = $rotaApi.'/api.paem/recursos_campus?campus_instituto_id_campus_instituto='.$dados_tecuser['campus_id_campus'];
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
                   /*  echo '<pre>';
                    print_r($resultado);
                    echo '</pre>'; */
                ?>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <?php 

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
                                    <th scope="col">Nome</th>
                                    <th scope="col">Hora_inicio</th>
                                    <th scope="col">Hora_fim</th>
                                    <th scope="col">Status_acesso</th>
                                    <th scope="col">Fone</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Excluir</th>
                                   <!--  <th colspan="2">Editar e Excluir solicitação</th> -->
                                </tr>
                            </thead>
                            <?php 
                                //contador
                                $cont = 0;
                        
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
                                            ?>
                                                <tr>
                                                    <td><?php echo $cont += 1;  ?></td>
                                                    <td><?php echo $value['recurso_campus'];?></td>
                                                    <td><?php echo $newdata;?></td>
                                                    <td><?php echo $value['nome']; ?></td>
                                                    <td><?php echo $value['hora_inicio'];?></td>
                                                    <td><?php echo $value['hora_fim'];?></td>
                                                    <td><?php echo $value['status_acesso'];?></td>
                                                    <td><?php echo $value['fone'];?></td>
                                                    <td>
                                                        <!-- Button update modal --> 
                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevernome="<?php echo $value['nome'];?>" data-whateverstatus="<?php echo $value['status_acesso'];?>">Editar</button>
                                                    </td>
                                                     <td>
                                                       <!-- Button delete modal -->
                                                        <button type="button" class="btn btn-primary" data-toggle="modal"data-target="#exampleModal1" data-whatever1="<?php echo $value['id'];?>" data-whatevernome1="<?php echo $value['nome'];?>">
                                                            Excluir
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php
        
                                        }
        
                                    }
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="9"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    }
    
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
                                            <td><?php echo $value['status_acesso'];?></td>
                                            <td><?php echo $value['fone'];?></td>
                                            <td>
                                                <!-- Button update modal -->
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevernome="<?php echo $value['nome'];?>" data-whateverstatus="<?php echo $value['status_acesso'];?>">Editar</button>
                                            </td>
                                           <td>
                                               <!-- Button delete modal-->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"data-target="#exampleModal1" data-whatever1="<?php echo $value['id'];?>" data-whatevernome1="<?php echo $value['nome'];?>">
                                                    Excluir
                                                </button>
                                            </td> 
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                                      
                        </table>
                    </div>
                    
                    <!-- ALTERAÇÃO DO STATUS DE ACESSO-->

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!--<div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                                </div>-->
                                <div class="modal-body">
                                    <form method="POST" action="../../controller/tecnico_controller/cont_editar_statusacesso.php" >
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Nome:</label>
                                            <input name="nome"  disabled type="text" class="form-control" id="recipient-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="status_acesso" class="control-label">Status de acesso</label>
                                            <input name="status_acesso" type="text" placeholder="Lembre-se: 1 = acesso permitido; -1 = acesso negado " class="form-control"  id="status_acesso">
                                        </div>

                                        <input name="id_solicitacao" type='hidden' id="id_solicitacao" value="">

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>


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
                }
                ?>
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

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    var recipientnome = button.data('whatevernome') 
    var recipientstatus = button.data('whateverstatus') 
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    // modal.find('.modal-title').text('Alteração em ' + recipient)
    modal.find('#id_solicitacao').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#status_acesso').val(recipientstatus)
    })

    $('#exampleModal1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient1 = button.data('whatever1') // Extract info from data-* attributes
    var recipientnome1 = button.data('whatevernome1') 
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#id_solicitacao1').val(recipient1)
    modal.find('#recipient-name1').val(recipientnome1)
    })
</script>

</html>