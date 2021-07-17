<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: login_tec.php");
    exit();
};
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>
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
            include "menu.php";
        ?>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Quem está presente no campus?</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área você consegue ver quem está ainda no campus e acompanhar o horarios de reservas.</p>
                        </div>
                    </div>
                <hr>
                <?php

                    $token = implode(",",json_decode( $_SESSION['token'],true));
                    $url = "http://localhost:5000/api.paem/solicitacoes_acessos";
                    
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

                    $resultado = json_decode($response, true);
                    
                   // print_r($resultado);
                    
                ?>
                
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nome do Discente</th>
                            <th scope="col">Data de entrada</th>
                            <th scope="col">Projeção de saida</th>
                            <th scope="col">Sala</th>
                            <th scope='co'>Status</th>
                        </tr>
                    </thead>
                    <?php
                    
                        date_default_timezone_set('America/Sao_Paulo');
                        $hagora = new DateTime(); // Pega o momento atual
                        $hagora->format('d-m-y H:i:s'); // Exibe no formato desejado

                       

                        foreach($resultado as &$value){ ?> 
                        <?php
                            
                            $valores_id = $value['acesso_permitido'];

                            /*Shift + Alt + A cometado tudo 
                            PHPSESSID=k7qh50oan5218hm2m3fevlurpl
                            */

                            if($valores_id !== 'null'){
                                
                        ?>
                            <tr>
                                <th><?php echo $value['nome'] ?></th>
                                <td><?php echo $value['data'],' / ',$value['hora_inicio'];  ?></td>
                                <td><?php echo $value['hora_fim'] ?></td>
                                <td><?php echo $value['recurso_campus'] ?></td>

                                <?php

                                    
                                    $entrada = $value['data'].' '.$value['hora_inicio'];
                                    $saida = $value['data'].' '.$value['hora_fim'];
                                    

                                    $datatime1 = new DateTime($entrada);
                                    $datatime2 = new DateTime();
                                    $datatime3 = new DateTime($saida);

                                    $data1  = $datatime1->format('d-m-y H:i:s');
                                    $data2  = $datatime2->format('d-m-y H:i:s');
                                    $hsaida = $datatime3->format('d-m-y H:i:s');
                                    
                                    $diff = $datatime2->diff($datatime3);
                                    $horas = $diff->h + ($diff->days * 24);
                                    $minutos = $horas * 60;
                                    
                                    //echo "A diferença de horas entre {$data1} e {$data2} é {$horas} horas \n";
                                    //echo "A diferença de minutos entre {$data1} e {$data2} é {$minutos} minutos \n";
                                    
                                
                                    if($datatime2 > $datatime3){
                                        ?>
                                            <td class='btn-danger'><?php echo 'Tempo esgotado!'; ?></td>
                                        <?php
                                    }
                                    elseif($minutos < 30){
                                        ?>
                                            <td class='btn-warning'><?php echo 'Faltam menos de 30 minutos!'; ?></td>
                                        <?php
                                    }
                                    else{
                                        ?>
                                            <td class='btn-success'><?php echo 'Aluno no Campus!'; ?></td>
                                        <?php
                                    }
                                
                                
                                ?>
                                
                            </tr>
                            <!-- Fechamento do if -->
                            <?php }?>
                        <!-- Fechamento do foreach -->
                        <?php }?>
                </table>

            </div>
        </main>
    </div>
                        
</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../../js/personalizado.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</html>