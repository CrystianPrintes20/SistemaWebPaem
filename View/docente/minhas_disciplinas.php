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

                    $url = $rotaApi.'/api.paem/disciplinas?id_docente='.$id_docente;
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
                    //print_r($response);

                    $resultado = json_decode($response, true);
                
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
                                </tr>
                            </thead>
                            <?php 

                                foreach($resultado as &$value) { 

                                    ?>

                                    <tr>
                                        <td class="centralizar"><?php echo $cont += 1;  ?></td>
                                        <td class="centralizar"><?php echo $value['nome']; ?></td>
                                        <td class="centralizar"><?php echo $value['id']; ?></td>
                                    </tr>
                                    <?php 
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

</html>