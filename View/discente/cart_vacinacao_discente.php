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
                    include_once "../../controller/discente_controller/buscardados_discuser.php";
                    //print_r($dados_discuser);
                    //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                    $matricula = $dados_discuser['matricula'];

                ?>

                <form method="POST" action="" enctype="multipart/form-data" class="alert alert-secondary">
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
                                        <figure style="border: thin silver solid;">
                                            <?php
                                                $path = "../../img/imagens_vacina/";
                                                $dirPath = "../../img/imagens_vacina/";
                                                
                                                foreach (new DirectoryIterator($path) as $fileInfo) {
                                                    if($fileInfo->getFilename() == $matricula.'.jpg'){
                                                        if ($fileInfo->isDir()) continue;
                                                        echo "<div class='alert alert-info' role='alert'>
                                                       Sua Carteirinha de vacinação
                                                    </div>";
                                                        //echo $fileInfo->getFilename() . "<br />\n";
                                                        echo " <img class='img-fluid' src='$dirPath{$fileInfo->getFilename()}' />";
                                                    }
                                                    
                                                
                                                }
                                            ?>
                                 
                                        </figure>    
                                
                                    </div>
                                </section>
                            </div>

                            
                            <button type="submit"class="btn btn-success">Enviar/Atualizar</button>
                        </div>
                    </div>
                </form>	

                <input type="file" multiple id="addFotoGaleria">
                <div class="galeria"></div>
                
                <?php
           
                    if(isset($_FILES['imagem']))
                    {
                        $ext = strtolower(substr($_FILES['imagem']['name'],-4)); //Pegando extensão do arquivo
                        $new_name = $matricula . $ext; //Definindo um novo nome para o arquivodate("Y.m.d-H.i.s")
                        $dir = '../../img/imagens_vacina/'; //Diretório para uploads
                    
                        $reposta = move_uploaded_file($_FILES['imagem']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo



                        if(!empty($reposta)){
                            echo  "<div class='alert alert-success' role='alert'>
                                        Imagem Enviada com sucesso!
                                    </div>";
                            // $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
                            // Imagem Enviada com sucesso!
                            // </div>";
                            
                        }
                        else{
                            echo  "<div class='alert alert-warning' role='alert'>
                                        Erro ao enviar imagem
                                    </div>";
                            // $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
                            // Erro ao enviar imagem, Tente mais tarde!!
                            // </div>";
                        }
                        
                    } 
                ?>
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
    $(function() {
// Pré-visualização de várias imagens no navegador
var visualizacaoImagens = function(input, lugarParaInserirVisualizacaoDeImagem) {

    if (input.files) {
        var quantImagens = input.files.length;

        for (i = 0; i < quantImagens; i++) {
            var reader = new FileReader();

            reader.onload = function(event) {
                $($.parseHTML('<img class="miniatura">')).attr('src', event.target.result).appendTo(lugarParaInserirVisualizacaoDeImagem);
            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

$('#addFotoGaleria').on('change', function() {
    visualizacaoImagens(this, 'div.galeria');
});
});
</script>

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