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
            include_once "./menu_docente.php";
        ?>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Area administrativa<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form  method="POST" action="../../controller/cont_reservar.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h4>Faça sua reseva.</h4>
                    <div class="input-group py-3">
                        
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="reserva">Reservar</label>
                        </div>
                            
                        <?php
                            include_once('../../JSON/rota_api.php');
                            $url = $rotaApi.'/api.paem/recursos_campus';
                            $ch = curl_init($url);
                            
                            $headers = array(
                                'content-Type: application/json; charset = utf-8',
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
                        <select name="reserva" class="custom-select" id="reserva" required>
                            <option disabled selected>Escolha...</option>
                            <?php
                                foreach ($resultado as $value) { ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                }
                            ?>
                        </select>    
                    </div>

                    <div class="row">
                        
                        <!--Disciplinas-->
                        <div class=" col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reserva">Disciplinas</label>
                            </div>
                            <?php
                                
                                $url = $rotaApi.'/api.paem/recursos_campus';
                                $ch = curl_init($url);
                                
                                $headers = array(
                                    'content-Type: application/json; charset = utf-8',
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
                            <select name="reserva" class="custom-select" id="reserva" required>
                                <option disabled selected>Escolha...</option>
                                <?php
                                    foreach ($resultado as $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                    }
                                ?>
                            </select> 
                        </div>

                        <!--Turma-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Turma</span>
                            </div>
                            <input name="turma" id="turma" type="text" value="" class="form-control"  aria-label="turma" aria-describedby="basic-addon1" maxlength="40" required>
                        </div>
                        
                    </div>
                    <!-- Data da reversa -->
                    <div class="row">
                  
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data de Reserva</span>
                            </div>
                            <input name="data_reserva" class="form-control date form_date" data-date="" data-date-format="dd-mm-yyyy" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" id="dtp_input2" value="" /><br/>
                        </div>
                            

                        <div class=" col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reserva">Periodo</label>
                            </div>
                            <select name="SelectOptions" class="custom-select" id="SelectOptions" required>
                                <option value="">Selecione</option>
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>

                        <div class="DivPai col">
                            
                            <div class="manha" style="display: none;">
                                <div class=" manha row">
                                    <div class="manha col-md-12 input-group py-3">
                                        <div class="manha input-group-prepend">
                                            <label class="input-group-text" for="manha">Manhã</label>
                                        </div>
                                        <select name="hi_hf[]" class="custom-select" id="manha">
                                            <option disabled selected>Escolha...</option>
                                            <option value="08:0010:00">08:00 as 10:00</option>
                                            <option value="10:0012:00">10:00 as 12:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="tarde" style="display: none;">
                                <div class="tarde row">
                                    <div class="tarde col-md-12 input-group py-3">
                                        <div class="tarde input-group-prepend">
                                            <label class="input-group-text" for="tarde">Tarde</label>
                                        </div>
                                        <select name="hi_hf[]" class="custom-select" id="tarde">
                                            <option disabled selected>Escolha...</option>
                                            <option value="14:0016:00">14:00 as 16:00</option>
                                            <option value="16:0018:00">16:00 as 18:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="noite" style="display: none;">
                                <div class="noite row">
                                    <div class="noite col-md-12 input-group py-3">
                                        <div class="noite input-group-prepend">
                                            <label class="input-group-text" for="noite">noite</label>
                                        </div>
                                        <select name="hi_hf[]" class="custom-select" id="noite">
                                            <option disabled selected>Escolha...</option>
                                            <option value="18:0020:00">18:00 as 20:00</option>
                                            <option value="20:0022:00">20:00 as 22:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Observação -->
                        <div id="observacao" class="col-md-12 input-group py-3">
                            <!-- <label for="exampleFormControlTextarea1"></label> -->
                            <div class=" input-group-prepend">
                                <span class="input-group-text">Oberservação</span>
                            </div>
                            <textarea id="observacao" class="form-control" name="observacao" minlength="10" rows="4" cols="20" placeholder="Escreva Aqui."></textarea>
                        </div>
                        
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Verif. dispo/reservar</button>
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

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script type="text/javascript">

    $('.form_date').datetimepicker({
      
        language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        daysOfWeekDisabled: "0",
        startView: 2,
        minView: 2,
        forceParse: 0,
        startDate: new Date(),
        //endDate: '+2d',
        
    });
</script>


<script>
    //Funções após a leitura do documento
    $(document).ready(function() {
    //Select para mostrar e esconder divs
    $('#SelectOptions').on('change',function(){
        var SelectValue='.'+$(this).val();
        $('.DivPai div').hide();
        $(SelectValue).toggle();
    });
    });
</script>
</html>