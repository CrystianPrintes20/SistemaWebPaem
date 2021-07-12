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
                <h2>Atualizar Perfil.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <!-- Alterar informações pessoais -->
                <form  method="POST" action="../../controller/tecnico_controller/update_tec.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                        <h5 class="card-title">INFORMAÇÕES PESSOAIS</h5><br>
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                        <?php
                            include_once "../../controller/tecnico_controller/buscardados_tecuser.php";
                            // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                            $data = explode('-', $dados_tecuser['data_nascimento']);
                            $newdata = $data[2].'-'.$data[1].'-'.$data[0];
                            print_r($dados_tecuser);
                        ?>
                        
                         <!--Username-->
                         <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Username</span>
                            </div>
                            <input name="username" id="username" type="text" class="form-control" placeholder="Digite seu username" aria-label="username" maxlength="40" value="<?php echo $dados_tecuser['usuario']['login']; ?>" >
                        </div>
                        
                        <!--Nome-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40" value="<?php echo $dados_tecuser['nome']; ?>" >
                        </div>

                        <!-- CPF -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >CPF</span>
                            </div>
                            <input name="cpf" id="cpf" type="text" class="form-control" placeholder="Digite seu numero do CPF SEM OS PONTOS" aria-label="cpf" aria-describedby="basic-addon5" maxlength="13" onkeypress="$(this).mask('000.000.000-09')" value="<?php echo $dados_tecuser['usuario']['cpf']; ?>" >
                        </div>

                        <!--Email-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >@</span>
                            </div>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40" value="<?php echo $dados_tecuser['usuario']['email']; ?>">
                        </div>

                        <!--Campus-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">Campus</label>
                            </div>
                  
                            <select name="campus" class="custom-select" id="campus">

                                <option selected value="<?php echo $dados_tecuser['campus_id_campus']; ?>"><?php echo $dados_tecuser['campus']; ?></option> 
                                 
                            </select>
                        </div>

                        <!--Data de nascimento -->
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                                <span class="input-group-text">Data de nascimento</span>
                            </div>
                            <input type="text" name="data_nascimento" class="form-control" placeholder="XX-XX-XXXX" aria-label="data_nascimento" aria-describedby="basic-addon4" maxlength="10" onkeypress="$(this).mask('00-00-0009')" value="<?php echo $newdata;?>" >
                        </div>


                        <!--Cod Siape -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Siape</span>
                            </div>
                            <input name="siape" id="siape" type="text" class="form-control" placeholder="Digite seu numero do Siape" aria-label="siape" aria-describedby="basic-addon5" maxlength="8" value="<?php echo $dados_tecuser['siape']; ?>">
                        </div>

                        <!--Cargo-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Cargo</span>
                            </div>
                            <input name="cargo" id="cargo" type="text" class="form-control" placeholder="Qual seu Cargo na UFOPA?" aria-label="Nome" aria-describedby="basic-addon2" maxlength="25" value="<?php echo $dados_tecuser['cargo']; ?>">
                        </div>

                        

                        <div><input name="tec_id" type="hidden" value="<?php echo $dados_tecuser['id_tecnico'] ?>"> </div>
                        <div><input name="user_id" type="hidden" value="<?php echo $dados_tecuser['usuario']['id_usuario'] ?>"> </div>
                    </div>
                    

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Atualizar Dados</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Digite sua senha para enviar as alterações.</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!--Password-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input name="senha" id="senha" type="text" class="form-control"  aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="bntcadastrar" type="submit" name="submit" class="btn btn-blue text-center">Enviar</button> 
                    
                            </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Alterar senha -->
                <form  method="POST" action="../../controller/tecnico_controller/update_password.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                        <h2 class="card-title"></h2><br>
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                  

                        <!--Senha Atual-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Senha Atual</span>
                            </div>
                            <input name="senha_atual" id="senha_atual" type="text" class="form-control" aria-label="senha_atual" aria-describedby="basic-addon2" maxlength="25" value="">
                        </div>

                         <!--Nova senha-->
                         <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Nova Senha</span>
                            </div>
                            <input name="senha_new" id="senha_new" type="text" class="form-control" aria-label="senha_new" aria-describedby="basic-addon2" maxlength="25" value="">
                        </div>

                         <!--Confirmar senha-->
                         <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Confirmar Senha</span>
                            </div>
                            <input name="confirmar_senha" id="confirmar_senha" type="text" class="form-control" aria-label="confirmar_senha" aria-describedby="basic-addon2" maxlength="25" value="">
                        </div>
                        
                        
                        <div><input name="tec_id" type="hidden" value="<?php echo $dados_tecuser['id_tecnico'] ?>"> </div>
                        <div><input name="user_id" type="hidden" value="<?php echo $dados_tecuser['usuario']['id_usuario'] ?>"> </div>
                    </div>
                    
                    <button id="bntcadastrar" type="submit" name="submit" class="btn btn-primary text-center">Atualizar senha</button> 

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