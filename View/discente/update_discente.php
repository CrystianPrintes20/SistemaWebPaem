<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ./login_discente.php");
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
            include "menu_discente.php";
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
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <!-- Alterar informações pessoais -->
                <form  method="POST" action="../../controller/discente_controller/cont_update_discente.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                        <h5 class="card-title">INFORMAÇÕES PESSOAIS</h5><br>
                        
                        <?php
                            include_once "../../controller/discente_controller/buscardados_discuser.php";
                            //print_r($dados_discuser);
                            //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                            $endereco = explode(',', $dados_discuser['endereco']);
                            $rua_travessa = $endereco[0];
                            $numero = $endereco[1];
                            $bairro = $endereco[2];  
                        ?>

                        
                        <!--Nome-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40" value="<?php echo $dados_discuser['nome']; ?>" >
                        </div>

                        <!-- CPF -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >CPF</span>
                            </div>
                            <input name="cpf" id="cpf" type="text" class="form-control" placeholder="Digite seu numero do CPF SEM OS PONTOS" aria-label="cpf" aria-describedby="basic-addon5" maxlength="13" onkeypress="$(this).mask('000.000.000-09')" value="<?php echo $dados_discuser['usuario']['cpf']; ?>" >
                        </div>

                        <!--Matricula -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Matricula</span>
                            </div>
                            <input name="matricula" id="matricula" type="text" class="form-control" placeholder="Digite seu numero do matricula" aria-label="matricula" aria-describedby="basic-addon5" maxlength="8" value="<?php echo $dados_discuser['matricula']; ?>">
                        </div>

                        <!--Endereço-->
                            <!--Rua/Travessa-->

                            <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Rua/Travessa</span>
                                </div>
                                <input name="rua_travessa" id="rua_travessa" type="text" class="form-control" aria-label="rua_travessa" maxlength="100" value="<?php echo $rua_travessa; ?>">
                            </div>
                            <!--Numero-->
                            <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Nº</span>
                                </div>
                                <input name="numero_end" id="numero_end" type="text" class="form-control" aria-label="numero_end" maxlength="5" onkeypress="$(this).mask('00009')" value="<?php echo $numero; ?>">
                            </div>
                            <!--Bairro-->
                                <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Bairro</span>
                                </div>
                                <input name="bairro" id="bairro" type="text" class="form-control"  aria-label="bairro" maxlength="40" value="<?php echo $bairro; ?>">
                            </div>
                        <!--Fim Endereço-->

                        <!--Email-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >@</span>
                            </div>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40" value="<?php echo $dados_discuser['usuario']['email']; ?>">
                        </div>

                        <!--Username-->
                          <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Username</span>
                            </div>
                            <input name="username" id="username" type="text" class="form-control" placeholder="Digite seu username" aria-label="username" maxlength="40" value="<?php echo $dados_discuser['usuario']['login']; ?>" >
                        </div>
                     
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
                                <!--confirmação Matricula -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Matricula</span>
                                    </div>
                                    <input name="confirma_matricula" id="confirma_matricula" type="text" class="form-control" placeholder="Confirme com seu matricula" aria-label="confirma_matricula" aria-describedby="basic-addon5" maxlength="10" value="">
                                </div>
                                <!--Password
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input name="senha" id="senha" type="text" class="form-control"  aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                </div>-->
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
                <form  method="POST" action="../../controller/discente_controller/update_password_disc.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                    <h5 class="card-title">Alterar Senha</h5><br>
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                  

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
                        
                        <div><input name="user_id" type="hidden" value="<?php echo $dados_discuser['usuario']['id_usuario'] ?>"> </div>
                    </div>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">Atualizar senha</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModal1Label">ATENÇÃO</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <p>Após realizar a confirmação de alteração de senha, você deverá fazer novamente o login.
                                Deseja continuar?
                            </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="bntcadastrar" type="submit" name="submit" class="btn btn-blue text-center">Sim, enviar</button> 

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