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
    <link rel="shortcut icon" href="../../img/icon-icons.svg">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/areaprivtec.css" />
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
                <h2>Seja bem-vindo</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                    <h4>Lista de Espaços reservado no campus</h4>
                <hr>
                <?php
                
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

                    $resultado = json_decode($response);
                   // print_r($response);
                  
                ?>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <div id="table_reservas">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr class="centralizar">
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Para_si</th>
                                <th scope="col">Data</th>
                                <th scope="col">Hora_inicio</th>
                                <th scope="col">Hora_fim</th>
                                <th scope="col">Status_acesso</th>
                                <th scope="col">Recurso campus</th>
                                <th scope="col">Fone</th>
                                <th colspan="2">Editar e Excluir solicitação</th>
                            </tr>
                        </thead>
                        <?php 
                            date_default_timezone_set('America/Sao_Paulo');
                            $hoje = date('d-m-Y');

                        
                        foreach($resultado as &$value) { 
                            $data = $value->data;
                            // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                            $datas = explode('-', $data);
                            $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];


                            if($newdata == $hoje){

                            
                                ?>

                                <tr>
                                    <td><?php echo $value->id ?></td>
                                    <td><?php echo $value->nome; ?></td>
                                    <td><?php echo $value->para_si;?></td>
                                    <td><?php echo $newdata;?></td>
                                    <td><?php echo $value->hora_inicio;?></td>
                                    <td><?php echo $value->hora_fim;?></td>
                                    <td><?php echo $value->status_acesso;?></td>
                                    <td><?php echo $value->recurso_campus;?></td>
                                    <td><?php echo $value->fone;?></td>
                                    <td>
                                        <!-- Button update modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value->id;?>" data-whatevernome="<?php echo $value->nome;?>" data-whateverstatus="<?php echo $value->status_acesso;?>">Editar</button>
                                    </td>
                                    <td>
                                        <!-- Button delete modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"data-target="#exampleModal1" data-whatever1="<?php echo $value->id;?>" data-whatevernome1="<?php echo $value->nome;?>">
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            <?php }?>    
                        <?php }?>
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

            </div>
            
        </main>
    </div>

    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
/*$(document).ready(function(){
$('#listar-reservas').DataTable({
        "ajax" : "../../JSON/solicitacao_acesso.json",
        "columns" : [
            { "data" : "id_recurso_campus"},
            { "data" : "para_si"},
            { "data" : "data"},
            { "data" : "hora_inicio"},
            { "data" : "hora_fim"},
            { "data" : "status_acesso"},
            { "data" : "usuario_id_usuario"},
            { "data" : "discente_id_discente"},
            { "data" : "fone"},
        ]
    });
})*/
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