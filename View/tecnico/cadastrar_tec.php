<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Assets/css/style.css">
    <link rel="stylesheet" href="../../Assets/css/icon.css">

</head>
<body>
      <!-- Hero section -->
      <section id="hero" class="text-white tm-font-big">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md tm-navbar" id="tmNav">
            <div class="container">  
                <div class="tm-next">
                    <a href="../../index.php" class="navbar-brand"><img src="../../Assets/img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA-MINHA VIDA ACADEMICA</a>
                </div>     
            </div>
        </nav>
    </section>
  
    <main class="tm-section-pad-top">
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >
                    <form  method="POST" action="../../controller/tecnico_controller/cont_cadastrar_tecnico.php" class="needs-validation" novalidate>
                        <div class="corpo card2 border-0 px-5">
                            <div class="form-group">
                                
                                <h2 class="card-title">Então Tecnico, vamos começar o cadastro?</h2><br><br>
                                <?php
                                    if(isset($_SESSION['msg'])){
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }
                                ?>
                               
                                <!--Nome-->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Nome</span>
                                    </div>
                                    <input required name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome completo" aria-label="Nome" maxlength="60" >
                                </div>

                                <!-- Campus -->
                               
                                <?php
                                    $url = "../../JSON/campus.json";
                                    //var_dump($url);
                                    //$url = "https://swapi.dev/api/people/?page=1";
                                    $resultado = json_decode(file_get_contents($url));

                                    if (!$resultado) {
                                        switch (json_last_error()) {
                                            case JSON_ERROR_DEPTH:
                                                echo 'A profundidade máxima da pilha foi excedida';
                                            break;
                                            case JSON_ERROR_STATE_MISMATCH:
                                                echo 'JSON malformado ou inválido';
                                            break;
                                            case JSON_ERROR_CTRL_CHAR:
                                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                                            break;
                                            case JSON_ERROR_SYNTAX:
                                                echo 'Erro de sintaxe';
                                            break;
                                            case JSON_ERROR_UTF8:
                                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                                            break;
                                            default:
                                                echo 'Erro desconhecido';
                                            break;
                                        }
                                        exit;
                                    }
                               
                                ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required  name="campus" class="custom-select" id="campus">
                                        <option disabled selected>Escolha...</option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div> 

                                <!--Campus
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Campus</span>
                                    </div>
                                    <select name="campus" class="custom-select" id="campus">
                                        <option selected disabled></option>
                                        <option value="1">CAMPUS UNIVERSITÁRIO DE ORIXIMINÁ - PROF.DR. DOMINGOS DINIZ</option>
                                        
                                    </select>
                                </div>-->
                                
                                
                                <!--Data de nascimento -->
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Data de nascimento</span>
                                    </div>
                                    <input type="date" name="data_nascimento" min="1900-01-01" max="2021-12-31" class="form-control" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" >
                                </div>


                                <!--Cod Siape -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Siape</span>
                                    </div>
                                    <input required name="siape" id="siape" type="text" class="form-control" placeholder="Digite seu numero do Siape" aria-label="siape" aria-describedby="basic-addon5" maxlength="8" onkeypress="$(this).mask('00000009')">
                                </div>

                                 <!-- CPF -->
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >CPF</span>
                                    </div>
                                    <input required name="cpf" id="cpf" type="text" class="form-control"  pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" placeholder="Digite seu numero do CPF (Ex: 000.000.000-00)" aria-label="cpf" aria-describedby="basic-addon5" maxlength="14" onkeypress="$(this).mask('000.000.000-09')"   onblur="validarCPF(this)">
                                    <!-- <div class="input-group-prepend">
                                        <span id="cpfResponse" class="input-group-text" >Validação</span>
                                    </div> -->
                                </div>

                                <!--Cargo-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Cargo</span>
                                    </div>
                                    <input required name="cargo" id="cargo" type="text" class="form-control" placeholder="Qual seu Cargo na UFOPA?" aria-label="Nome" maxlength="30">
                                </div>

                                <!--Username -->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Username</span>
                                    </div>
                                    <input required name="username" id="username" type="text" class="form-control" placeholder="Digite seu login, ex:joaotec11" aria-label="username" maxlength="40">
                                </div>

                                <!--Email-->
                                 <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >@</span>
                                    </div>
                                    <input required name="email" id="email" type="email" pattern=".+@ufopa\.edu\.br" class="form-control" placeholder="Email institucional" aria-label="Email"  maxlength="40">
                                </div>

                                <!--Password -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input required  name="senha" id="senha" type="password" class="form-control" placeholder="Crie uma senha de acesso" aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                </div>

                                <!--Situação de Afastamento-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Situação de Afastamento</span>
                                    </div>
                                    <select name="afastamento_status" class="custom-select" id="afastamento_status">
                                        <option selected disabled>Atualmente você está afastado da sua função?</option>
                                        <option value="1">Sim</option>
                                        <option value="-1">Não</option>
                                    </select>
                                </div>

                                <!--Status Covid-->
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="status_covid">Sobre o Coronavirus</label>
                                    </div>
                                    <select name="status_covid" class="custom-select" id="status_covid">
                                        <option selected disabled>Atualmente você apresenta algum sintoma da COVID-19?</option>
                                        <option value="1">Sim</option>
                                        <option value="-1">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row px-3"> 
                                <button id="bntcadastrar" type="submit" name="submit" class="btn btn-blue text-center">Cadastrar</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer  class="tm-footer">
        <div class="container ">
        <small>Copyright &copy; 2021. All rights reserved.</small>
        </div>
    </footer>

    <script src="../../Assets/js/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
    //Validação dos campos
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
    <script>
        function validarCPF(el){
            if( !_cpf(el.value) ){
            alert("CPF inválido!" + el.value);
            // apaga o valor
            el.value = "";
            }
        }
    </script>
    <script>
        function _cpf(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf == '') return false;
            if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
            add = 0;
            for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
            rev = 11 - (add % 11);
            if (rev == 10 || rev == 11)
            rev = 0;
            if (rev != parseInt(cpf.charAt(9)))
            return false;
            add = 0;
            for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
            rev = 11 - (add % 11);
            if (rev == 10 || rev == 11)
            rev = 0;
            if (rev != parseInt(cpf.charAt(10)))
            return false;
            return true;
        }
    </script>

    <script>
    $("#nome").on("input", function(){
    var regexp = /[^a-zA-Z ]/g;
    if(this.value.match(regexp)){
        $(this).val(this.value.replace(regexp,''));
    }
    });

    </script>

</body>
</html>