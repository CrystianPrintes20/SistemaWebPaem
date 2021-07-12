<?php
require_once '../../controller/conn.php';
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
                    <a href="../index.php" class="navbar-brand"><img src="../../img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA</a>
                </div>     
            </div>
        </nav>
    </section>
  
    <main>
        <div class="px-5 px-md-5 px-lg-5  py-5 mx-auto">
            <div class="row px-5 corpo">
                <div class="col mx-lg-5 px-5" >
                    <form  method="POST" action="../../controller/processa_tec.php">
                        <div class="corpo card2 border-0 px-5">
                            <div class="form-group">
                                
                                <h2 class="card-title">Então Tecnico, vamos começar o cadastro?</h2><br>
                                <?php
                                    if(isset($_SESSION['msg'])){
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }
                                ?>
                                <!--Nome-->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >Username</span>
                                    </div>
                                    <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40">
                                </div>

                                <!--Email-->
                                <div class=" input-group mb-3">
                                    <div class=" input-group-prepend">
                                        <span class="input-group-text" >@</span>
                                    </div>
                                    <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40">
                                </div>

                                <!--Campus-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select name="campus" class="custom-select" id="campus">
                                        <option disabled selected>Escolha...</option>
                                        <?php
                                            $stmt = $pdo->prepare("SELECT * FROM campus");
                                            $stmt->execute();

                                            if($stmt->rowCount() > 0){
                                                while($dados = $stmt->fetch(PDO::FETCH_ASSOC)){ ?>
                                                    <option value="<?php echo$dados['id_campus'];?>"><?php echo $dados['nome']; ?></option> <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!--Data de nascimento -->
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">Data de nascimento</span>
                                    </div>
                                    <input type="text" name="data_nascimento" class="form-control" placeholder="XXXX/XX/XX" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" onkeypress="$(this).mask('0000/00/09')" >
                                </div>


                                <!--Cod Siape -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Siape</span>
                                    </div>
                                    <input name="siape" id="siape" type="text" class="form-control" placeholder="Digite seu numero do Siape" aria-label="siape" aria-describedby="basic-addon5" maxlength="8">
                                </div>

                                <!--Cargo-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Cargo</span>
                                    </div>
                                    <input name="cargo" id="cargo" type="text" class="form-control" placeholder="Qual seu Cargo na UFOPA?" aria-label="Nome" aria-describedby="basic-addon2" maxlength="25">
                                </div>

                                <!--Password-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" >Senha</span>
                                    </div>
                                    <input name="senha" id="senha" type="password" class="form-control" placeholder="Crie uma senha de acesso" aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
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

    <footer id="sticky-footer" class="py-4 text-white"  style="background-color: #005926; position:relative;">
        <div class="container">
            <small>Copyright &copy; 2021. All rights reserved.</small>
        </div>
    </footer>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

</body>
</html>