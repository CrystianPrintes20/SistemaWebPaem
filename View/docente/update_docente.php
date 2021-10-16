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
    <link rel="shortcut icon" href="../../img/Minhavidaacademica.ico">
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
            include_once "./menu_docente.php";
        ?>

        <!-- sidebar-wrapper  -->
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Atualizar Perfil.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <!-- <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p> -->
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
                <form  method="POST" action="../../controller/docente_controller/cont_update_doc.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                        <h5 class="card-title">INFORMAÇÕES PESSOAIS</h5><br>
                        
                        <?php
                            include_once "../../controller/docente_controller/buscardados_docuser.php";
                            //print_r($dados_docuser);
                            // trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                            $data = explode('-', $dados_docuser['data_nascimento']);
                            $newdata = $data[2].'-'.$data[1].'-'.$data[0];
                        ?>

                        
                        <!--Nome-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40" value="<?php echo $dados_docuser['nome']; ?>" >
                        </div>

                        <!-- CPF -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >CPF</span>
                            </div>
                            <input name="cpf" id="cpf" type="text" class="form-control" placeholder="Digite seu numero do CPF SEM OS PONTOS" aria-label="cpf" aria-describedby="basic-addon5" maxlength="13" onkeypress="$(this).mask('000.000.000-09')" value="<?php echo $dados_docuser['usuario']['cpf']; ?>" >
                        </div>

                        <!--Data de nascimento  -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de nascimento</span>
                            </div>
                            <input type="date" name="data_nascimento"  class="form-control" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" value="<?php echo $dados_docuser['data_nascimento']; ?>" >
                        </div>


                        <!--Cod Siape -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Siape</span>
                            </div>
                            <input name="siape" id="siape" type="text" class="form-control" placeholder="Digite seu numero do Siape" aria-label="siape" aria-describedby="basic-addon5" maxlength="8" value="<?php echo $dados_docuser['siape']; ?>">
                        </div>

                        <!-- Função para deixar selecionado os comboboxs -->
                         <?php
                            function selected( $value, $selected ){
                                return $value==$selected ? ' selected="selected"' : '';
                            }
                        ?>

                       <!--Situação de Afastamento-->
                       <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Situação de Afastamento</span>
                            </div>
                            <select name="afastamento_status" class="custom-select" id="afastamento_status">
                                <option selected disabled>Atualmente você está afastado da sua função?</option>
                                <option value="1" <?php print_r( selected('1',$dados_docuser['status_afastamento'])) ?>>Estou afastado(a)</option>
                                <option value="-1"  <?php print_r( selected('-1',$dados_docuser['status_afastamento'])) ?>>Não estou afastado(a)</option>
                            </select>
                        </div>

                        <!--Username-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Username</span>
                            </div>
                            <input name="username" id="username" type="text" class="form-control" placeholder="Digite seu username" aria-label="username" maxlength="40" value="<?php echo $dados_docuser['usuario']['login']; ?>" >
                        </div>

                        <!--Email-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >@</span>
                            </div>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40" value="<?php echo $dados_docuser['usuario']['email']; ?>">
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
                                <!--confirmação Siape -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Siape</span>
                                    </div>
                                    <input name="confirma_siape" id="confirma_siape" type="text" class="form-control" placeholder="Confirme com seu SIAPE ATUAL" aria-label="confirma_siape" aria-describedby="basic-addon5" maxlength="8" value="">
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
                                <button id="bntcadastrar" type="submit" name="submit"  class="btn btn-primary">Enviar</button> 
                    
                            </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Alterar senha -->
                <form  method="POST" action="../../controller/docente_controller/update_password.php" class="alert alert-secondary"> 
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
                        
                        <div><input name="user_id" type="hidden" value="<?php echo $dados_docuser['usuario']['id_usuario'] ?>"> </div>
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
                                <button id="bntcadastrar" type="submit" name="submit"  class="btn btn-primary">Sim, enviar</button> 

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
<script type="text/javascript" src="../../js/personalizado.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</html>