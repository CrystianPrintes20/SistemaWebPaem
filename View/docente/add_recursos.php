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
            include "./menu_docente.php";
        ?>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Adicionar Recursos</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área você pode adicionar um novo espaço do campus para ser reservado.</p>
                        </div>
                    </div>
                <hr>
                
                <form  method="POST" action="../../controller/docente_controller/cont_addrecursos.php" class="needs-validation alert alert-secondary" novalidate> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Dados do Recurso</h5>
                    <div class="row">
                        <!--
                        <div class="col-md-6 input-group py-3">
                                
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">campus</label>
                            </div>

                            <?php
                                include_once('../../JSON/rota_api.php');
                            
                                $token = implode(",",json_decode( $_SESSION['token'],true));
                                $url = $rotaApi.'api.paem/campus';
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
                            <input required name="nome" id="nome" type="text" class="form-control" placeholder="Nome do recurso do campus (ex: biblioteca, laboratorio)"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40">
                        </div>

                        <!--descrição-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Descrição</span>
                            </div>
                            <input required name="descricao" id="descricao" type="text" class="form-control" placeholder="Ex: vinculado ao curso XXXX"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100" >
                        </div>

                    </div>

                    <div class="row">
                        <!--Hora inicial-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora inical</span>
                            </div>
                            <input required name="hora_inicial" id="hora_inicial" type="time"  min="06:00" max="24:00" step="0" class="form-control" placeholder="Ex: 17:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="5" onkeypress="$(this).mask('00:09')">
                        </div>

                       <!--Hora final-->
                       <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora Final</span>
                            </div>
                            <input required name="hora_final" id="hora_final" type="time" min="06:00" max="24:00" step="0" class="form-control" placeholder="Ex: 19:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="10" onkeypress="$(this).mask('00:00:09')">
                        </div>
                            
                    </div>
                    <!-- Tipo de restrição -->
                    <div class="row">

                        <div class=" col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="restricao">Restrição</label>
                            </div>
                            <select name="tipo_de_restricao" class="custom-select" id="tipo_de_restricao" required>
                                <option selected disabled>Qual é o tipo restricao de acesso a esse recurso</option>
                                <option value="0">Livre - 0 doses</option>
                                <option value="1">Parcial - Apenas 1 dose</option>
                                <option value="2">Restrito - 2 doses</option>
                            </select>
                        </div>

                        <!-- Periodo de horas para o recurso -->
                        <div name='ocultar_div' class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> Periodo de horas</span>
                            </div>
                            <input required  name="periodo_horas" id="periodo_horas" type="text" class="form-control" placeholder="Ex: 1 hora p/ cada aluno nesse recurso"  aria-label="periodo_horas" aria-describedby="basic-addon1" maxlength="2" onkeypress="$(this).mask('09')">
                        </div>

                    </div>

                    <div class="row">
                        
                        <!--Capacidade de pessoas -->
                        <div name='ocultar_div' class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Capacidade</span>
                            </div>
                            <input required name="capacidade" id="capacidade" type="number" min='-1' class="form-control" placeholder="Nº total de pessoas nesse recurso." aria-label="capacidade" aria-describedby="basic-addon5" maxlength="3" onkeypress="$(this).mask('009')">
                        </div>

                        <!-- Checkbox -->
                        <div class="col-md-12 input-group ">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox"  id="check" name="check" value="oculta">
                                <label class="form-check-label" for="inlineFormCheck">
                                    Sem limite de capacidade
                                </label>
                            </div>
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

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $('[name="check"]').change(function() {
        $('[name="ocultar_div"]').toggle(200);
    });
</script>

<script>

//deixando obrigatorio o campo

    $('#check').on('click', function(){
    var checkbox = $('#check:checked').length;

    let periodo_horas = document.getElementById('periodo_horas');
    let capacidade = document.getElementById('capacidade');

    if(checkbox === 1)
    {
        periodo_horas.required = false;
        capacidade.required = false;

    }
    else if(checkbox === 0)
    {
        periodo_horas.required = true;
        capacidade.required = true;
    }
    });

</script>

<!--  //Validação dos campos -->
<script>

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

</html>