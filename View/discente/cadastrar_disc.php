<?php 
session_start()
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
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

    <main>
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >
                    
                    <form name="f1" method="POST" action="../../controller/discente_controller/cont_cadastrar_discente.php" class="needs-validation" novalidate>
                        <div class="corpo card2 border-0 px-5">
                            <div class="form-group">
                                
                                <h2 class="card-title">Vamos começar o cadastro?</h2><br>
                                <?php
                                    if(isset($_SESSION['msg'])){
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }
                                ?>

                                <!--Matricula -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Matricula</span>
                                    </div>
                                    <input required name="matricula" id="matricula" type="text" class="form-control" placeholder="Digite seu numero do matricula" aria-label="matricula" aria-describedby="basic-addon5" maxlength="10" onkeypress="$(this).mask('0000000009')" >
                                </div>

                                <!--Nome-->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Nome</span>
                                    </div>
                                    <input required name="nome" id="nome" type="text" class="form-control" placeholder="Digite nome completo" aria-label="nome" maxlength="40">
                                </div>
                       
                                <!--Data de nascimento  -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Data de nascimento</span>
                                    </div>
                                    <input type="date" name="data_nascimento" min="1900-01-01" max="2021-12-31"  class="form-control" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" >
                                </div>

                                <!-- Sexo  -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Sexo</span>
                                    </div>
                                    <select required name="sexo" class="custom-select" id="sexo">
                                        <option disabled selected></option>
                                        <option value='F'>Feminino</option>
                                        <option value="M">Masculino</option>
                                        <option value="IS">Intersexo</option>
                                    </select>
                                </div>

                                <!-- CPF -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >CPF</span>
                                    </div>
                                    <input required name="cpf" id="cpf" type="text" class="form-control" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" placeholder="Digite seu numero do CPF (Ex: 000.000.000-00)" aria-label="cpf" aria-describedby="basic-addon5" maxlength="14" onkeypress="$(this).mask('000.000.000-09')" onblur="validarCPF(this)">
                                </div>

                                <!--Campus-->
                               
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
                                    <select required name="campus" class="custom-select" id="campus">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div>

                              <!--   <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus" class="custom-select" id="campus">
                                        <option disabled selected></option>
                                        <option value="1">CAMPUS UNIVERSITÁRIO DE ORIXIMINÁ - PROF.DR. DOMINGOS DINIZ</option>
                                    </select>
                                </div>
 -->
                                <!--Curso -->

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="curso">Curso</label>
                                    </div>
                                    <select required name="curso" class="custom-select" id="curso">
    
                                    </select>
                                </div>

                        <!--         <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="curso">Curso</label>
                                    </div>
                                    <select required name="curso" class="custom-select" id="curso">
                                        <option disabled selected></option>
                                        <option value="1"> SISTEMAS DE INFORMAÇÃO</option>
                                        <option value="2"> CIÊNCIAS BIOLÓGICAS</option>
    
                                    </select>
                                </div> -->


                                <!--Entrada-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Forma de Ingresso</span>
                                    </div>
                                    <select name="entrada" id="entrada" class="custom-select">
                                        <option selected disabled value="">Qual foi sua forma de entrada na UFOPA?</option>
                                        <option value="PSR">PSR Unificado</option>
                                        <option value="PSEI">PSE Indígena</option>
                                        <option value="PSEQ">PSE Quilombola</option>
                                    </select>
                                </div>

                                <!--Ano_ingresso-->
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Ano de Ingresso</span>
                                    </div>
                                    <input required name="ano_ingresso" id="ano_ingresso" type="number" min='2000' class="form-control" placeholder="Qual ano voce ingressou na UFOPA? Ex: 2021" aria-label="Nome" aria-describedby="basic-addon2" maxlength="4" onkeypress="$(this).mask('0009')">
                                </div>

                                <!--Semestre-->
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Semestre</span>
                                    </div>
                                    <input required name="semestre" id="semestre" type="number" class="form-control" min='1' max='12' placeholder="Qual seu semestre atual?" aria-label="Nome" aria-describedby="basic-addon2" maxlength="2" onkeypress="$(this).mask('09')">
                                </div>
                                
                                <!--Endereço-->

                                    <!--Rua/Travessa-->

                                    <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Rua/Travessa</span>
                                        </div>
                                        <input required name="rua_travessa" id="rua_travessa" type="text"  class="form-control" aria-label="rua_travessa" maxlength="60" onblur="validacaoEmail(f1.email)">
                                    </div>

                                    <!--Numero-->
                                    <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Nº</span>
                                        </div>
                                        <input required name="numero_end" id="numero_end" type="text" class="form-control" aria-label="numero_end" maxlength="5" onkeypress="$(this).mask('00009')">
                                    </div>

                                    <!--Bairro-->
                                     <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Bairro</span>
                                        </div>
                                        <input required name="bairro" id="bairro" type="text" class="form-control"  aria-label="bairro" maxlength="40">
                                    </div>

                                    <!-- Qtde pessoas  -->
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Moradores</span>
                                        </div>
                                        <input required type="text" name="qtde_moradores" class="form-control" placeholder="Atualmente, quantas pessoas moram na sua residencia (incluindo você).?" aria-label="qtde_moradores" aria-describedby="basic-addon4" required="" maxlength="2" onkeypress="$(this).mask('09')" >
                                    </div>
                                
                                <!--username-->
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
                                    <input required name="email" id="email" type="email" pattern=".+@discente\.ufopa\.edu\.br" title="Por Favor digite somente o seu endereço de email institucional, exemple@discente.ufopa.edu.br " class="form-control" placeholder="Digite o seu email institucional" aria-label="Email"  maxlength="40">
                                    
                                    <!-- <div class=" input-group-prepend">
                                        <span id="msgemail" class="input-group-text" ></span>
                                    </div> -->
                                </div>

                                <!--Password-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input required name="senha" id="senha" type="password" class="form-control" placeholder="Crie uma senha de acesso" aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                </div>

                                <!--Status Covid-->
                                   <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="status_covid">Sobre o Coronavirus</label>
                                    </div>
                                    <select required name="status_covid" class="custom-select" id="status_covid">
                                        <option selected disabled>Atualmente você apresanta algum sintoma da COVID-19?</option>
                                        <option value="1">Sim</option>
                                        <option value="-1">Não</option>
                                    </select>
                                </div>

                                <!--Grupo de risco-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="grupo_risco">Sobre o Coronavirus</label>
                                    </div>
                                    <select required name="grupo_risco" class="custom-select" id="grupo_risco">
                                        <option selected disabled>Você pertence ao grupo de risco?</option>
                                        <option value="1">Sim</option>
                                        <option value="-1">Não</option>
                                    </select>
                                </div>

                                <!--Vacinação-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="quantidade_vacinas">Sobre a vacinação conta a COVID-19</label>
                                    </div>
                                    <select required name="quantidade_vacinas" class="custom-select" id="quantidade_vacinas">
                                        <option selected disabled>Selecione</option>
                                        <option value="1">Tomei somente a 1° dose (ou dose unica).</option>
                                        <option value="2">Tomei as duas doses.</option>
                                        <option value="3">Tomei as duas doses(ou dose unica) + Reforço.</option>
                                        <option value="nenhuma">Ainda não tomei nenhuma</option>
                                    </select>
                                </div>

                                <!-- Caso o discente TENHA tomado somente a 1º dose da vacina -->
                                <div id='1' class="qual_vacina input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">De Qual fabricante voce tomou?</span>

                                    </div>
                                    <select required name="fabricante_dose1" class="custom-select" id="fabricante">
                                        <option value="Butantan_coronavac">Butantan - Coronavac</option>
                                        <option value="Fiocruz_astrazeneca">Fiocruz - Astrazeneca</option>
                                        <option value="BioNTech_pfizer">BioNTech - Pfizer </option>
                                        <option value="Janssen_J&J">Janssen - Johnson & Johnson </option>

                                    </select>
                                </div>
                                 <!--Caso o discente TENHA tomado as 2º doses da vacina -->
                                <div id='2' class="qual_vacina input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">De Qual fabricante voce tomou?</span>

                                    </div>
                                    <select required name="fabricante_dose2" class="custom-select" id="fabricante">
                                        <option value="Butantan_coronavac">Butantan - Coronavac</option>
                                        <option value="Fiocruz_astrazeneca">Fiocruz - Astrazeneca</option>
                                        <option value="BioNTech_pfizer">BioNTech - Pfizer </option>

                                    </select>
                                </div>

                                <!--Caso o discente TENHA tomado as 2º doses da vacina + o REFORÇO-->
                                <div id='3' class="qual_vacina">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">1ª e 2º doses, qual fabricante?</span>

                                        </div>
                                        <select required name="fabricante_dose3" class="custom-select">
                                            <option value="Butantan_coronavac">Butantan - Coronavac</option>
                                            <option value="Fiocruz_astrazeneca">Fiocruz - Astrazeneca</option>
                                            <option value="BioNTech_pfizer">BioNTech - Pfizer </option>
                                            <option value="Janssen_J&J">Janssen - Johnson & Johnson </option>

                                        </select>
                                    </div>
                                   
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Reforço</span>

                                        </div>

                                        <select required name="fabricante_reforco" class="custom-select">
                                            <option value="Butantan_coronavac">Butantan - Coronavac</option>
                                            <option value="Fiocruz_astrazeneca">Fiocruz - Astrazeneca</option>
                                            <option value="BioNTech_pfizer">BioNTech - Pfizer </option>
                                            <option value="Janssen_J&J">Janssen - Johnson & Johnson </option>

                                        </select>
                                    </div>

                                </div>
                       
                                <!-- Caso o discente NÃO TENHA tomado vacina -->
                                <div id="nenhuma" class="motivo input-group mb-3">
                                    <!-- <label for="exampleFormControlTextarea1"></label> -->
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Justifique o seu motivo.</span>
                                    </div>
                                    <textarea required  id="justificativa" class="form-control" name="justificativa" minlength="10" rows="4" cols="20" placeholder="Escreva Aqui."></textarea>
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

    <!-- Mostrando ou ocultando textarea -->
    <script type="text/javascript">
    $(document).ready(function () {
    $('.motivo').hide();
    //$('#option1').show();
    $('#quantidade_vacinas').change(function () {
        $('.motivo').hide();
        $('#'+$(this).val()).show();
    })

    $('.qual_vacina').hide();
    //$('#option1').show();
    $('#quantidade_vacinas').change(function () {
        $('.qual_vacina').hide();
        $('#'+$(this).val()).show();
    })
    });
    </script>

    <script>
    //deixando obrigatorio o campo
    let sel = document.getElementById('quantidade_vacinas');

        function verifica() {
            let nao = document.getElementById('justificativa');
            if (sel.value == '1' ||sel.value == '2' || sel.value == '3') {
                nao.required = false;
            } else {
                nao.required = true;
            }
        }

        sel.addEventListener('change', verifica);
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


    <script language="Javascript">
        //Buscando os cursos
        $("#campus").on("change", function(){
        var unidade = $("#campus").val();
        
        $.ajax({
                url: 'busca_cursos.php',
                type: 'POST',
                data:{Unidade:unidade},
                success: function(data){
                    $("#curso").html(data);
                },
                error: function(data){
                    $("#curso").html("Houve um erro ao carregar");
                }
        });
        
        });

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
</body>
</html>