<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet"href="../../css/style.css">
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

    <section class="tm-section-pad-top">
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >

                
                    <form method="POST" action="../../controller/docente_controller/cont_login_docente.php" class="px-5">

                        <div class="card2 card border-0 px-5">
                            <?php
                                if(isset($_SESSION['msg'])){
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                            <div id="titulo">
                                <h3 class="card-title text-lg">Olá Docente, conecte-se!</h3><br>
                            </div>
                            
                            <!--Login e senha -->
                            <div class="row px-5  mb-2">
                                <label class="mb-2">
                                    <h6 class="mb-0 text-sm">Username ou Email</h6>
                                </label>
                                <input class="mb-4" type="login" name="login" placeholder="Digite seu login de usuario ou seu Email">
                            </div>
                            <div class="row px-5 mb-3">
                                <label class="mb-2">
                                    <h6 class="mb-0 text-sm">Senha</h6>
                                </label>
                                <input type="password" name="senha" placeholder="Digite sua senha">
                            </div>
                            <!----------------- -->

                            <div class="row px-5 mb-5">
                                <div class="custom-control custom-checkbox custom-control-inline"> <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> <label for="chk1" class="custom-control-label text-sm">lembre de mim</label> </div> <a href="#" class="ml-auto mb-0 text-sm">Esqueceu a senha?</a>
                            </div>
                            <div class="row mb-5 px-5"> 
                                <button type="submit" class="btn btn-blue text-center">Login</button> 
                            </div>
                            <div class="row mb-5 px-5"> 
                                <small class="font-weight-bold">Ainda não possui uma conta? <a href="../quem_cadastrar.php" class="text-danger ">Registre-se</a></small> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer  class="tm-footer">
        <div class="container ">
            <small>Copyright &copy; 2021. All rights reserved.</small>
        </div>
    </footer>
<script src="../../js/jquery-3.5.1.js"></script>

</body>
</html>