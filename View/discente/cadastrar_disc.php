<?php 
session_start()
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/icon.css">

</head>
<body>
      <!-- Hero section -->
      <section id="hero" class="text-white tm-font-big">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md tm-navbar" id="tmNav">
            <div class="container">  
                <div class="tm-next">
                    <a href="../../index.php" class="navbar-brand"><img src="../../img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA</a>
                </div>     
            </div>
        </nav>
    </section>
  
    <main>
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >
                    <form  method="POST" action="../../controller/discente_controller/cont_cadastrar_discente.php">
                        <div class="corpo card2 border-0 px-5">
                            <div class="form-group">
                                
                                <h2 class="card-title">Vamos começar o cadastro?</h2><br>
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
                                    <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite nome completo" aria-label="nome" maxlength="40">
                                </div>

                                <!--Matricula -->
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Matricula</span>
                                    </div>
                                    <input name="matricula" id="matricula" type="text" class="form-control" placeholder="Digite seu numero do matricula" aria-label="matricula" aria-describedby="basic-addon5" maxlength="10" onkeypress="$(this).mask('0000000009')" >
                                </div>

                                <!-- CPF -->
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >CPF</span>
                                    </div>
                                    <input name="cpf" id="cpf" type="text" class="form-control" placeholder="Digite seu numero do CPF SEM OS PONTOS" aria-label="cpf" aria-describedby="basic-addon5" maxlength="13" onkeypress="$(this).mask('000.000.000-09')">
                                </div>

                                <!--Campus -->
                               
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
                                    <select name="campus" class="custom-select" id="campus">
                                        <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div>
                                
                                  <!--Curso -->
                               
                                  <?php
                                    $url = "../../JSON/cursos.json";
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
                                        <label class="input-group-text" for="curso">curso</label>
                                    </div>
                                    <select name="curso" class="custom-select" id="curso">
                                        <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_curso; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div> 


                                <!--Data de nascimento 
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Data de nascimento</span>
                                    </div>
                                    <input type="text" name="data_nascimento" class="form-control" placeholder="XX-XX-XXXX" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" onkeypress="$(this).mask('00-00-0009')" >
                                </div>
                                -->


                                <!--Entrada-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Entrada</span>
                                    </div>
                                    <input name="entrada" id="entrada" type="text" class="form-control" placeholder="Qual foi sua forma de entrada na UFOPA? Ex: PSS, KDKD" aria-label="Nome" aria-describedby="basic-addon2" maxlength="25">
                                </div>

                                <!--Semestre-->
                                  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Semestre</span>
                                    </div>
                                    <input name="semestre" id="semestre" type="text" class="form-control" placeholder="Qual seu semestre atual?" aria-label="Nome" aria-describedby="basic-addon2" maxlength="2" onkeypress="$(this).mask('09')">
                                </div>
                                
                                <!--Endereço-->
                                    <!--Rua/Travessa-->

                                    <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Rua/Travessa</span>
                                        </div>
                                        <input name="rua_travessa" id="rua_travessa" type="text" class="form-control" aria-label="rua_travessa" maxlength="40">
                                    </div>
                                    <!--Numero-->
                                    <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Nº</span>
                                        </div>
                                        <input name="numero_end" id="numero_end" type="text" class="form-control" aria-label="numero_end" maxlength="5" onkeypress="$(this).mask('00009')">
                                    </div>
                                    <!--Bairro-->
                                     <div class=" input-group mb-3">
                                        <div class=" input-group-prepend">
                                            <span class="input-group-text" >Bairro</span>
                                        </div>
                                        <input name="bairro" id="bairro" type="text" class="form-control"  aria-label="bairro" maxlength="40">
                                    </div>

                                <!--username-->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Username</span>
                                    </div>
                                    <input name="username" id="username" type="text" class="form-control" placeholder="Digite seu login, ex:joaotec11" aria-label="username" maxlength="40">
                                </div>
                                
                                 <!--Email-->
                                 <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >@</span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40">
                                </div>

                                <!--Password-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input name="senha" id="senha" type="password" class="form-control" placeholder="Crie uma senha de acesso" aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                </div>

                                <!--Status Covid-->
                                   <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="status_covid">Sobre o Coronavirus</label>
                                    </div>
                                    <select name="status_covid" class="custom-select" id="status_covid">
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
                                    <select name="grupo_risco" class="custom-select" id="grupo_risco">
                                        <option selected disabled>Você pertence ao grupo de risco?</option>
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

<script src="../../js/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>
</html>