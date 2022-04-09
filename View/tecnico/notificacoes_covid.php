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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />


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
                <h2>Lista de todas as notificações de COVID</h2>
                <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Nesta área poderá ser feita a filtragem por campus/instituto, curso, turma  e quantidade de doses de cada discente.
                                Alem de poder vizualizar a Carterinha de Vacinação enviada pelos mesmos.<br>
                            </p>
                        </div>
                    </div>
                    <!-- <h4>Vacinação dos discentes.</h4> -->

                <hr>
      <!--           <div class='card' style='width: 30rem;'>
                    <div class='card-body'>
                        <h5 class='card-title'>Informações Gerais</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                        <ul>
                            <li>
                                Total de Discentes: $cont
                            </li>
                            <li>
                                Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                            </li>
                            <li>
                                Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                            </li>
                        </ul>
                        <p class='card-text'></p>
                    </div>
                </div> -->
                <hr>

                <div id="table_reservas">
      
                    <table id="notificacoes_table" class="table table-hover">
                        <thead class="table-dark">
                            <tr class="centralizar">
                                <th scope="col">#</th>
                                <th scope="col">Inicio dos sintomas</th>
                                <th scope="col">Fez teste?</th>
                                <th scope="col">Data do exame</th>
                                <th scope="col">Nivel dos sintomas</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Matricula do discente</th>
                            </tr>
                        </thead>
                        <?php

                            $token = implode(",",json_decode( $_SESSION['token'],true));

                            $url = $rotaApi."/api.paem/notificacoes_covid";
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

                            $cont = 0; //contador

                            if(isset($resultado)){
                               

                                foreach($resultado as &$value){
                                    ?>
                                    
                                        <tr>
                                            <td><?php echo $cont += 1 ?></td>
                                            <td><?php echo $value['data']; ?></td>
                                            <td><?php if($value['teste'] == 1 ){
                                               echo "<div class='alert alert-success' role='alert'>
                                               Realizou o Exame.
                                             </div>";
                                            }else{
                                                echo "<div class='alert alert-danger' role='alert'>
                                                Não realizou.
                                              </div>";
                                            };?></td>
                                            <td><?php if($value['data_diagnostico'] != 'None'){
                                                echo $value['data_diagnostico'];
                                            }else{
                                                echo "<div class='alert alert-secondary' role='alert'>
                                                Não informado!
                                              </div>";
                                            }?></td>
                                            <td><?php switch($value['nivel_sintomas']){
                                                case -1:
                                                    echo "<div class='alert alert-secondary' role='alert'>
                                                    Não informado!
                                                  </div>";
                                                    break;
                                                case 1:
                                                    echo "<div class='alert alert-primary' role='alert'>
                                                    Leve!
                                                  </div>";
                                                    break;
                                                case 2:
                                                    echo "<div class='alert alert-warning' role='alert'>
                                                    Moderado!
                                                  </div>";
                                                    break;
                                                case 3:
                                                    echo "<div class='alert alert-danger' role='alert'>
                                                    Grave!
                                                  </div>";
                                                    break;
                                                default:
                                                    echo "Ocorreu um erro";
                                                    break;

                                            };?></td>
                                            <td><?php echo $value['observacoes'];?></td>
                                            <td><?php echo $value['matricula_discente'];?></td>
                                        </tr>
                                    <?php
                                }
                                                                  

                            }else{
                                ?>
                                    <tr>
                                        <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                    </tr>
                                <?php
                            }
                            
                                    
                        ?>
                        
                    </table>
                </div>
             
            </div>
        </main>
    </div>

    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../../Assets/js/buscar_nome_matri.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#notificacoes_table').DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'UFOPA - Minha Vida Academica',
                    messageTop: 'Lista com os dados sobre a vacinação dos discentes.',
                    text:      '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        
                        $('row c[r^="B"]', sheet).attr( 's', '2' );
                        
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'UFOPA - Minha Vida Academica',
                    messageTop: 'Lista com os dados sobre a vacinação dos discentes.',
                    download: 'open',
                    text:      '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF'
                    
                }
            ]
            //'copy''csv', , 'print'
        });
    } );
</script>

</html>