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
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
   
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    
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
                <h2>Presentes no Campus</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>O discente que reservou um espaço no campus e passou a carterinha na portaria será nesta área </p>
                        </div>
                    </div>
                <hr>
                <?php
                    include_once('../../JSON/rota_api.php');

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

                    $resultado = json_decode($response, true);
                
                    date_default_timezone_set('America/Sao_Paulo');
                    /* $hagora = new DateTime(); // Pega o momento atual
                    $hagora->format('d-m-y H:i:s'); // Exibe no formato desejado
                    */

                    $presente_no_campus = array();

                    foreach($resultado as &$value){ 
    
                        $data = $value['data'];

                        // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                        $datas = explode('-', $data);
                        $newdata = $datas[2].'-'.$datas[1].'-'.$datas[0];

                         if(!empty($value['acesso_permitido'])){

                            //print_r($value['acesso_permitido']);

                            //pegando todos os quais tem autorização dada pelo porteiro
                            $valores_id = $value['acesso_permitido'];
                           
                            $hora_saida = $valores_id['hora_saida'];

                            if(($hora_saida == 'null' || $hora_saida == '00:00:00') && $newdata == date('d-m-Y') ){ 
                                
                                $presente_no_campus [] = array(
                                    'nome' => $value['nome'],
                                    'data' => $newdata,
                                    'hora_inicio' => $value['hora_inicio'],
                                    'hora_fim' => $value['hora_fim'],
                                    'recurso_campus' => $value['recurso_campus']

                                );

                                //print_r($presente_no_campus);
                            } 

                        }
                    }
               /*  echo '<pre>';
                print_r($presente_no_campus);
                echo '</pre>'; */
                ?>
                
                <div id="table_reservas">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th scope="col">Sala</th>
                                <th scope="col">Nome do Discente</th> 
                                <th scope="col">Data de entrada</th>
                                <th scope="col">Projeção de saida</th>
                                <th scope='col'>Status</th>
                            </tr>
                        </thead>
                        <?php

                        if(!empty( $presente_no_campus)) {
                
                            $sort = array();
                            foreach($presente_no_campus as $k => $v) {
                                $sort['recurso_campus'][$k] = $v['recurso_campus'];
                            
                            }

                            //aqui é realizado a ordenação do array
                            array_multisort($sort['recurso_campus'], SORT_ASC,$presente_no_campus);

                            $cont = 0;

                            foreach($presente_no_campus as $valores){
                                ?>
                                <tr>
                                    <td><?php echo $cont += 1?></td>
                                    <td><?php echo $valores['recurso_campus'] ?></td>
                                    <td><?php echo $valores['nome'] ?></td>
                                    <td><?php echo $valores['data'],' / ',$valores['hora_inicio'];  ?></td>
                                    <td><?php echo $valores['hora_fim'] ?></td>
                                    
                                    <?php
                            
                                        $entrada = $valores['data'].' '.$valores['hora_inicio'];
                                        $saida = $valores['data'].' '.$valores['hora_fim'];


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
                            <?php
                            //fechamento do foreach
                            }
                        }else{
                            ?>
                            <tr>
                                
                                <td align="center" colspan="5"><b> Sem Registros  </b></td>
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

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../../js/personalizado.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</html>