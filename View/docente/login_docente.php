<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Assets/css/style.css" />
    <link rel="stylesheet" href="../../Assets/css/icon.css">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    
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
                                <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                                <i class="fa fa-eye" id="text"></i>
                                <i class="fa fa-eye-slash" id="pass"></i>
                            </div>
                            <!----------------- -->

                            <!-- <div class="row px-5 mb-5">
                                <div class="custom-control custom-checkbox custom-control-inline"> <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> <label for="chk1" class="custom-control-label text-sm">lembre de mim</label> </div> <a href="#" class="ml-auto mb-0 text-sm">Esqueceu a senha?</a>
                            </div> -->
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script> 

    <script>
        /* function viewSenha(){
            var tipo = document.getElementById("senha")
            if (tipo.type == "password") {
                tipo.type = "text";
            }else{
                tipo.type = "password";
            }
        } */

        var tipo = document.getElementById('senha')

        document.getElementById('pass').addEventListener('click', () => {
        if(tipo.value) {
            tipo.type == 'password' ? tipo.type = 'text' : tipo.type = 'password';
            tipo.focus()
            document.getElementById('pass').style.display = 'none';
            document.getElementById('text').style.display = 'inline-block';
        }
        })

        document.getElementById('text').addEventListener('click', () => {
        if(tipo.value) {
            tipo.type == 'text' ? tipo.type = 'password' : tipo.type = 'text';
            tipo.focus()
            document.getElementById('text').style.display = 'none';
            document.getElementById('pass').style.display = 'inline-block';
        }
    })
        
    </script>

</body>
</html>