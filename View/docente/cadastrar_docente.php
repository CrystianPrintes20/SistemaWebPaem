<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/login.css">

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
  
    <main class="tm-section-pad-top">
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >
                    <form  method="POST" action="../../controller/docente_controller/cont_cadastrar_docente.php">
                        <div class="corpo card2 border-0 px-5">
                            <div class="form-group">
                                
                                <h2 class="card-title">Então Docente, vamos começar o cadastro?</h2><br><br>
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
                                    <input required name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome completo" aria-label="Nome" maxlength="40">
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
                                    <select required  name="campus" class="custom-select" id="campus">
                                        <option disabled selected>Escolha...</option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div> 

                                
                                <!--Data de nascimento -->
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Data de nascimento</span>
                                    </div>
                                    <input type="text" name="data_nascimento" class="form-control" placeholder="XX-XX-XXXX" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" onkeypress="$(this).mask('00-00-0009')" >
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
                                    <input required name="cpf" id="cpf" type="text" class="form-control" placeholder="Digite seu numero do CPF SEM OS PONTOS" aria-label="cpf" aria-describedby="basic-addon5" maxlength="14" onkeypress="$(this).mask('000.000.000-09')"  onkeyup="cpfCheck(this)" onkeydown="javascript: fMasc( this, mCPF );">
                                    <div class="input-group-prepend">
                                        <span id="cpfResponse" class="input-group-text" >Validação</span>
                                    </div>
                                </div>

                                <!--Nivel de escolaridade-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Nivel de escolaridade</span>
                                    </div>
                                    <select required  name="situacao" class="custom-select" id="situacao">
                                        <option disabled selected>Escolha...</option>
                                        <option value="Doutorado">Doutorado</option>
                                        <option value="Mestrado">Mestrado</option>
                                        <option value="Especialista">Especialista</option>
    
                                    </select>
                                </div>

                                <!--Situação Atual-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Situação Atual</span>
                                    </div>
                                    <select required  name="escolaridade" class="custom-select" id="escolaridade">
                                        <option disabled selected>Escolha...</option>
                                        <option value="Ativo Permanente">Ativo Permanente</option>
                                        <option value="Professor Substituto">Professor Substituto</option>
                                    </select>
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
                                    <input required name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40">
                                </div>

                                <!--Password -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input  name="senha" id="senha" type="password" class="form-control" placeholder="Crie uma senha de acesso" aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
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
<script>

function isValidCPF(cpf) {
    if (typeof cpf !== "string") return false
    cpf = cpf.replace(/[\s.-]*/igm, '')
    if (
        !cpf ||
        cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999" 
    ) {
        return false
    }
    var soma = 0
    var resto
    for (var i = 1; i <= 9; i++) 
        soma = soma + parseInt(cpf.substring(i-1, i)) * (11 - i)
    resto = (soma * 10) % 11
    if ((resto == 10) || (resto == 11))  resto = 0
    if (resto != parseInt(cpf.substring(9, 10)) ) return false
    soma = 0
    for (var i = 1; i <= 10; i++) 
        soma = soma + parseInt(cpf.substring(i-1, i)) * (12 - i)
    resto = (soma * 10) % 11
    if ((resto == 10) || (resto == 11))  resto = 0
    if (resto != parseInt(cpf.substring(10, 11) ) ) return false
    return true
}
</script>

</body>
</html>