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
    
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
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
                <h2>Area de Rastreamento</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form  method="POST" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h4>Rastreamento</h4>
              

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
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Rastrear</button>
                                </div> 
                                
                            </div>
                        </div>
                            
                    </div>
    
                </form>

                <!-- Buscando os dados conforme solicatado pelo usuario -->

                <form>
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <?php
                        
                        if(isset($_POST['nome']))
                        {
                            $rastreio = [];
                        
                            $rastreio['nome'] = addslashes($_POST['nome']);
                            $rastreio['data_inicial'] = addslashes($_POST['data_inicial']);
                            $rastreio['data_final'] = addslashes($_POST['data_final']);
                        

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

                            //print_r($resultado);

                           

                          /*   $ordenado= [] ;

                            $sort = array();
                            foreach($resultado as $k => $v) {
                                $sort['data'][$k] = $v['data'];
                            
                            }

                            //aqui é realizado a ordenação do array
                            array_multisort($sort['data'], SORT_ASC,$resultado);

                            //abaixo é listado o resultado ordenado  
                            foreach($resultado as $k => $v) {
                                
                            $ordenado[] = $sort['data'][$k] = $v['data'] . '<br>';
                            }

                            print_r($ordenado); */

                            $dados = array();

                            foreach($resultado as &$value) { 

                                if($rastreio['nome'] == $value['nome']){

                                    // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
                                    $data = explode('-', $value['data']);
                                    $newdata = strtotime($data[2].'-'.$data[1].'-'.$data[0]);
                                    
                                    
                                    $data_inicial = strtotime($rastreio['data_inicial']);
                                    $data_final = strtotime($rastreio['data_final']);

                                    if($newdata >= $data_inicial && $newdata <= $data_final){
                                        $dados[] = array(
                                            'data' => $value['data'],
                                            'recurso_campus' => $value['recurso_campus'],
                                            'hora_inicio' => $value['hora_inicio'],
                                            'hora_fim' => $value['hora_fim'],
                                            'nome' =>  $value['nome']

                                        );
                                        /* echo $cont;
                                        echo '<br>';
                                        print_r($value['nome']); */
                                        
                                    }
                                
                                }    
                            }
                           /*  echo '<pre>';
                            print_r($dados);
                            echo '<pre>'; */
                        }
                    
                    ?>
                    <?php if(!empty( $dados)) {

                    ?>
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
                                 $cont = 0;

                                // $ordenado= [] ;

                                $sort = array();
                                foreach($dados as $k => $v) {
                                    $sort['data'][$k] = $v['data'];
                                
                                }
    
                                //aqui é realizado a ordenação do array
                                array_multisort($sort['data'], SORT_DESC,$dados);
    
                                //abaixo é listado o d$dados ordenado  
                                foreach($dados as $k => $v) {
                                    
                                $ordenado[] = $sort['data'][$k] = $v['data'] . '<br>';
                                }
    
                                // print_r($ordenado);
                                
                                foreach($dados as &$valores){
    
                            ?>
                                
                                <tr>
                                    <td><?php echo $cont += 1; ?></td>
                                    <td><?php
                                        // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
                                        $data = explode('-', $valores['data']);
                                        $newdata =$data[2].'-'.$data[1].'-'.$data[0];
                                        echo '<b>'. $newdata . '<b>'; ?></td>
                                    <td><?php echo $valores['recurso_campus'] ?></td>
                                    <td><?php echo $valores['hora_inicio']. ' / ' . $valores['hora_fim']; ?></td>
                                    <td><?php echo $valores['nome']; ?></td>
                                    <td>
                                        <!-- Button vizualização modal -->
                                        <button 
                                            type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatevernomerec="<?php echo $valores['recurso_campus'];?>"
                                            data-data_rec="<?php echo $newdata;?>" data-horario_inicial="<?php echo $valores['hora_inicio'];?>" data-horario_final="<?php echo $valores['hora_fim'];?>">
                                            Ver todos
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                }

                                if($cont == 0){
                                ?>
                                    <tr>
                                        <td colspan="3"><?php echo'Sem registros'?></td>
                                    </tr>

                                    <?php
                                }
                                ?>
                        </table>
                    </div>
                    <?php
                    }
                    ?>
                </form>

                 <!-- ALTERAÇÃO DO STATUS DE ACESSO-->

                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Deseja baixar a lista de todos os discentes que estavam presentes em:</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <div class="modal-body">
                                    
                                    <form method="POST" action="../../controller/tecnico_controller/cont_rastreardiscente.php">
                                        <!-- Nome do recurso -->
                                        <div class="form-group">
                                            <label for="recipient_namerec" class="control-label">Nome do recurso:</label>
                                            <input name="nome_rec"   type="text" class="form-control" id="recipient_namerec">
                                        </div>

                                        <!-- Data do recurso -->
                                        <div class="form-group">
                                            <label for="data_rec" class="control-label">Data</label>
                                            <input name="data_rec"  type="text"  class="form-control"  id="data_rec">
                                        </div>

                                        <!-- Horario_inicial do recurso -->
                                        <div class="form-group">
                                            <label for="horario_inicial" class="control-label">Horario inicial</label>
                                            <input name="horario_inicial"  type="text" class="form-control"  id="horario_inicial">
                                        </div>

                                         <!-- Horario_final do recurso -->
                                         <div class="form-group">
                                            <label for="horario_final" class="control-label">Horario Final</label>
                                            <input name="horario_final"  type="text" class="form-control"  id="horario_final">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Download</button>
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

$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipientnomerec = button.data('whatevernomerec') 
  var recipientsdata_rec = button.data('data_rec') 
  var recipienthorario_inicial = button.data('horario_inicial') 
  var recipienthorario_final = button.data('horario_final') 
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
 // modal.find('.modal-title').text('Alteração em ' + recipient)
  modal.find('#recipient_namerec').val(recipientnomerec)
  modal.find('#data_rec').val(recipientsdata_rec)
  modal.find('#horario_inicial').val(recipienthorario_inicial)
  modal.find('#horario_final').val(recipienthorario_final)
})

</script>

</html>