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
                <h2>Minhas Disciplinas</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área mostra todas as disciplinas criada e/ou vinculadas com você docente! /p>
                        </div>
                    </div>
                    <h4>Lista de todas as Disciplinas</h4>
                <hr>

                <?php
                    
                    include_once('../../JSON/rota_api.php');

                    $url = $rotaApi.'/api.paem/disciplinas?docente_id_docente='.$id_docente;
                    $ch = curl_init($url);
                    
                    $headers = array(
                        //'content-Type: application/json',
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
                    /*  echo "<pre>";
                    print_r($resultado);
                    echo "</pre>"; */
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
                    
                    ?>
                    <div id="table_reservas">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Cod.SIGAA</th>
                                    <th scope="col">Editar Disciplina</th>
                                    <th scope="col">Excluir Disciplina</th>
                                </tr>
                            </thead>
                            <?php 

                                foreach($resultado as &$value) { 

                                    ?>

                                    <tr>
                                        <td class="centralizar"><?php echo $cont += 1;  ?></td>
                                        <td class="centralizar"><?php echo $value['nome']; ?></td>
                                        <td class="centralizar"><?php echo $value['semestre']; ?></td>
                                        <td class="centralizar"><?php echo $value['codigo_sigaa']; ?></td>
                                        <td class="centralizar">
                                            <!-- Button update modal -->
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id_disciplina'];?>" data-whatevernome="<?php echo $value['nome'];?>" data-whateversemestre="<?php echo $value['semestre'];?>" 
                                            data-whateversigaa="<?php echo $value['codigo_sigaa'];?>">Editar</button>
                                        </td>
                                        <td class="centralizar">
                                            <!-- Button delete modal -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"data-target="#exampleModal1" data-whatever1="<?php echo $value['id_disciplina'];?>" data-whatevernome1="<?php echo $value['nome'];?>">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                    <?php 
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
                                    <form method="POST" action="../../controller/docente_controller/cont_editar_disciplina.php" >
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Nome:</label>
                                            <input name="nome" type="text" class="form-control" id="recipient-name">
                                        </div>
                                        <div class="form-group">
                                            <label for="semestre" class="control-label">Semestre</label>
                                            <input name="semestre" type="text"   class="form-control"  id="semestre" >
                                        </div>
                                        <div class="form-group">
                                            <label for="cod_sigaa" class="control-label">Codigo Sigaa</label>
                                            <input name="cod_sigaa" type="text" class="form-control"  id="cod_sigaa">
                                        </div>
                                        <input name="id_disciplina_edit" type='hidden' id="id_disciplina_edit" value="">

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
                                    <form method="POST" action="../../controller/docente_controller/cont_excluir_disciplina.php" >
                                        <div class="form-group">
                                            <label for="recipient-name1" class="control-label">Nome:</label>
                                            <input name="nome1"  disabled type="text" class="form-control" id="recipient-name1">
                                        </div>

                                        <input name="id_disciplina" type='hidden' id="id_disciplina" value="">

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
                                    <th scope="col">Nome</th>
                                    <th scope="col">Semestre</th>
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
  var recipient = button.data('whatever') // Extract info from data-* attributes
  var recipientnome = button.data('whatevernome') 
  var recipientsemestre = button.data('whateversemestre') 
  var recipientsigaa = button.data('whateversigaa') 
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
 // modal.find('.modal-title').text('Alteração em ' + recipient)
  modal.find('#id_disciplina_edit').val(recipient)
  modal.find('#recipient-name').val(recipientnome)
  modal.find('#semestre').val(recipientsemestre)
  modal.find('#cod_sigaa').val(recipientsigaa)
})

$('#exampleModal1').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient1 = button.data('whatever1') // Extract info from data-* attributes
  var recipientnome1 = button.data('whatevernome1') 
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('#id_disciplina').val(recipient1)
  modal.find('#recipient-name1').val(recipientnome1)
})
</script>

</html>