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
                <h2>Adicionar Recursos<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área você pode add um novo espaço do campus para ser reservado.</p>
                        </div>
                    </div>
                <hr>
                
                <form  method="POST" action="../../controller/tecnico_controller/cont_addrecursos.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <<h5>Dados do recurso</h5>
                    <div class="row">
                        <!--
                        <div class="col-md-6 input-group py-3">
                                
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">campus</label>
                            </div>

                            <?php
                            
                                $token = implode(",",json_decode( $_SESSION['token'],true));
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

                            <select name="campus" class="custom-select" id="campus">
                                <option disabled selected>Escolha...</option>
                                <?php
                                   foreach ($resultado as $value) { ?>
                                   <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                    }
                                ?>
                            </select>
                        </div>-->

                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Nome do recurso do campus (ex: biblioteca, laboratorio)"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40">
                        </div>

                        <!--descrição-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Descrição</span>
                            </div>
                            <input name="descricao" id="descricao" type="text" class="form-control" placeholder="Ex: vinculado ao curso XXXX"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100" >
                        </div>

                    </div>
                    <div class="row">
                        
                        <!--Capacidade de pessoas -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Capacidade</span>
                            </div>
                            <input name="capacidade" id="capacidade" type="text" class="form-control" placeholder="Nº total de pessoas nesse recurso." aria-label="capacidade" aria-describedby="basic-addon5" maxlength="3" onkeypress="$(this).mask('009')">
                        </div>

                        <!-- Periodo de horas para o recurso -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Periodo de horas</span>
                            </div>
                            <input name="periodo_horas" id="periodo_horas" type="text" class="form-control" placeholder="Ex: 1 hora p/ cada aluno nesse recurso"  aria-label="periodo_horas" aria-describedby="basic-addon1" maxlength="2" onkeypress="$(this).mask('09')">
                        </div>
                        
                         
                    </div>
                    <div class="row">
                        <!--Hora inicial-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora inical</span>
                            </div>
                            <input name="hora_inicial" id="hora_inicial" type="text" class="form-control" placeholder="Ex: 17:00:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="10" onkeypress="$(this).mask('00:00:09')">
                        </div>
                       <!--Hora final-->
                       <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora Final</span>
                            </div>
                            <input name="hora_final" id="hora_final" type="text" class="form-control" placeholder="Ex: 19:00:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="10" onkeypress="$(this).mask('00:00:09')">
                        </div>
                            
                    </div>

                    <div class="row">
                      
                        <!-- Botão enviar -->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="addrecurso" class="btn btn-primary" type="submit">Adicionar</button>
                                </div> 
                                <!--<div class="col-md-6">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Verificar Disponibilidade e Finalizar Reserva</button>
                                </div>-->
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