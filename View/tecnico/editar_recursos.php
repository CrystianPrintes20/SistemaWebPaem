<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: login_tec.php");
    exit();
}

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
                <h2>Editar Recurso<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>

                    </div>
                <hr>
                <form method="POST" class="alert alert-secondary">
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Escolha o recurso deseja editar:</h5>
                    <div class="row">
                        <div class="col-md-12 input-group py-3">
                                
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="recurso">Recurso</label>
                            </div>
                            <?php

                                 $url = 'http://localhost:5000/api.paem/recursos_campus';
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

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="buscardados" class="btn btn-primary" type="submit">Buscar dados</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>





                <?php 
                    
                    //Busca as informções do recurso
                    if(isset($_POST['recurso'])){
                        $id_recurso = addslashes($_POST['recurso']);

                        $url = 'http://localhost:5000/api.paem/recursos_campus/recurso_campus?id_recurso_campus='.$id_recurso;
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

                       print_r($resultado);
                                 
                        $nome_rec = $resultado['nome'];
                        $capacidade_rec = $resultado['capacidade'];
                        $descricao_rec = $resultado['descricao'];
                        $hora_inicio = $resultado['inicio_horario_funcionamento'];
                        $hora_fim = $resultado['fim_horario_funcionamento'];
                        $qtde_horas = $resultado['quantidade_horas'];
                        $campus_rec = $resultado['campus_id_campus'];

                    }
                ?>
            
    
                <form  method="POST" action="../../controller/tecnico_controller/cont_editar_rec.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Informações do recurso</h5>
                    <div class="row">
                       
                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40" required="" value="<?php if(isset($id_recurso)){ echo $nome_rec; }?>">
                        </div>

                        <!--Campus-->
                          <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">Campus</label>
                            </div>
                            <?php
                                $url = 'http://localhost:5000/api.paem/campus';
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

                            ?>
                            
                            <select name="campus" class="custom-select" id="campus" required="">
                                <?php
                                    // Buscando o campus de acordo com os dados do recurso
                                    foreach ($resultado as $value) { 
                                        if($value['id'] == $campus_rec){
                                            ?>
                                            <option selected value="<?php echo $value['id'] ?>"><?php echo $value['nome']; ?></option>

                                            <!-- fechamento do if -->
                                            <?php 
                                        }
                                        ?> 
                                        <!-- fechamento do foreach -->
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        
                        <!--Capacidade de pessoas -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Capacidade</span>
                            </div>
                            <input name="capacidade" id="capacidade" type="text" class="form-control" aria-label="capacidade" aria-describedby="basic-addon5" required="" maxlength="3" onkeypress="$(this).mask('009')" value="<?php if(isset($id_recurso)){ echo $capacidade_rec; } ?>">
                        </div>
                        
                         <!--descrição-->
                         <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Descrição</span>
                            </div>
                            <input name="descricao" id="descricao" type="text" class="form-control"  aria-label="nome" aria-describedby="basic-addon1" required="" maxlength="100" value="<?php if(isset($id_recurso)){ echo $descricao_rec; }  ?>" >
                        </div>
                    </div>
                    <div class="row">
                        <!--Hora inicial-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora inical</span>
                            </div>
                            <input name="hora_inicial" id="hora_inicial" type="text" class="form-control" aria-label="nome" aria-describedby="basic-addon1" required="" maxlength="100" value="<?php if(isset($id_recurso)){echo $hora_inicio; } ?>">
                        </div>
                       <!--Hora final-->
                       <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora Final</span>
                            </div>
                            <input name="hora_final" id="hora_final" type="text" class="form-control"   aria-label="nome" aria-describedby="basic-addon1" required="" maxlength="100" value="<?php if(isset($id_recurso)){echo $hora_fim; } ?>">
                        </div>

                        <!-- Periodo de horas para o recurso -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Periodo de horas</span>
                            </div>
                            <input name="periodo_horas" id="periodo_horas" type="text" class="form-control"  aria-label="periodo_horas" aria-describedby="basic-addon1" required="" maxlength="2" onkeypress="$(this).mask('09')" value="<?php if(isset($id_recurso)){echo $qtde_horas;} ?>">
                        </div> 
                        <div> <input type="hidden" name="valor_id" value="<?php echo $id_recurso; ?>"> </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Editar</button>
                                </div> 
                            </div>
                        </div>
                            
                    </div>
    
                </form>
                

            </div>
        </main>
    </div>

</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


</html>