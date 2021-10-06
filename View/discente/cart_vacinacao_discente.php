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
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../../css/areaprivtec.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    

</head>
<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <?php
            include_once "./menu_discente.php";
        ?>
        
         <!-- sidebar-wrapper  -->
         <main class="page-content">
            <div class="container">
                <h2>Carteirinha de Vacinação.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Esta é a area dedicada para a reserva de salas no campus.</p>
                        </div>
                    </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <form method="POST" action="../../controller/discente_controller/cont_add_cartVacinacao.php" enctype="multipart/form-data" class="alert alert-secondary">
                    <div class="container">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input"  id="imgInp" aria-describedby="inputGroupFileAddon04" name="imagem" id="imagem" accept=".jpg">
                                <label class="custom-file-label" for="inputGroupFile04">Carterinha de vacinação</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <section>
                                   
                                    <div class="input-group py-5 mb-5">
                                        <figure style="border: thin silver solid;">
                                            <!-- <img id="carterinha" src="..." class="img-fluid" alt="Esperando imagem.."><br> -->
                                            <img id="blah" src="#" class="img-fluid" alt="Esperando imagem.." />
                                        </figure>    
                                
                                    </div>
                                </section>
                            </div>

                            <div class="col-lg-6">
                                <section>
                                   
                                    <div class="input-group py-5 mb-5">
                                           
                                
                                    </div>
                                </section>
                            </div>            
                            <button type="submit"class="btn btn-success">Enviar/Atualizar</button>
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
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script>
    
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
  /*   function previewImagem(){
        var imagem = document.querySelector('input[name=imagem]').files[0];
        var preview = document.querySelector('img[id=carterinha]');
        
        var reader = new FileReader();
        
        reader.onloadend = function () {
            preview.src = reader.result;
        }
        
        if(imagem){
            reader.readAsDataURL(imagem);
        }else{
            preview.src = "";
        }
    } */
</script>

</html>