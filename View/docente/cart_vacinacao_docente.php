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
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdf.js/1.8.349/pdf.min.js"></script>
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
                
                <!-- Checkbox -->
                <div class="col-md-12 input-group py-3 mb-3 alert alert-primary">
                    <div class="form-check mb-2 mr-sm-2">
                        <input class="form-check-input" type="checkbox" data-toggle="modal" data-target="#ExemploModalCentralizado" id="check">
                        <label class="form-check-label" for="inlineFormCheck">
                            Termo de responsabilidade - Reconheço que ao enviar o comprovante de vacinação - Conecte SUS, afirmo que estou dando veracidade
                            nas informações preenchidas durante o cadastro no Sistema Minha Vida Acadêmica.
                        </label>
                    </div>
                </div>
                <form method="POST" action="../../controller/docente_controller/cont_add_cartVacinacao.php" enctype="multipart/form-data" class="alert alert-secondary">
                    <div class="container">

                        <div class="input-group py-3 mb-3" >

                            <div class="custom-file">
                                <input class="custom-file-input" disabled type="file" id="pdf-upload" aria-describedby="inputGroupFileAddon04" name="comprovante_card_vac" accept=".pdf" />
                                <label class="custom-file-label" for="inputGroupFile04">Carterinha de vacinação</label>
                            </div>
                           
                        </div>

                        <div class="row  py-3 mb-5">
                            <div class="col-lg-6">
                                <section>
                                    <canvas class="page img-fluid" size="A4" layout="landscape"></canvas>
                                </section>
                                
                            </div>
                            <?php
                               $carteinha_vac = $dados_docuser['carteirinha_vacinacao'];
  
                            ?>
                            <div class="col-lg-6">
                                <section>
                                    <div class="input-group  py-3 mb-5">

                                        <object height="500" data="data:application/pdf;base64,<?php echo $carteinha_vac;?>" type="application/pdf"></object>
                                    </div>
                                </section>
                            </div>
         
                        </div>
                        <button type="submit" name="enviar" class="btn btn-success">Enviar/Atualizar</button>
                    </div>
                </form>	
            </div>
        </main>
    </div>
</body>
<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script>
/*     $(document).ready(function() {
	$("#enable").click(function (){
                // habilita o campo 
		$("input").prop("disabled", false);
		
	});
    
    $("#disable").click(function (){
                // desabilita o campo 
		$("input").prop("disabled", true);
		
	});
});    */
</script>

<script>

//deixando obrigatorio o campo

    $('#check').on('click', function(){
    var checkbox = $('#check:checked').length;

    let pdf = document.getElementById('pdf-upload');

    if(checkbox === 1)
    {
        pdf.disabled = false;
    
    }
    else if(checkbox === 0)
    {
        pdf.disabled  = true;
    }
    });

</script>

<script>
    
    // imgInp.onchange = evt => {
    //     const [file] = imgInp.files
    //     if (file) {
    //         blah.src = URL.createObjectURL(file)
    //     }
    // }
    document.querySelector("#pdf-upload").addEventListener("change", function(e) {
    var canvasElement = document.querySelector("canvas")
    var file = e.target.files[0]
    if (file.type != "application/pdf") {
        console.error(file.name, "is not a pdf file.")
        return
    }

    var fileReader = new FileReader();

    fileReader.onload = function() {
        var typedarray = new Uint8Array(this.result);

        PDFJS.getDocument(typedarray).then(function(pdf) {
        // you can now use *pdf* here
        console.log("the pdf has ", pdf.numPages, "page(s).")
        pdf.getPage(pdf.numPages).then(function(page) {
            // you can now use *page* here
            var viewport = page.getViewport(2.0);
            var canvas = document.querySelector("canvas")
            canvas.height = viewport.height;
            canvas.width = viewport.width;


            page.render({
            canvasContext: canvas.getContext('2d'),
            viewport: viewport
            });
        });

        });
    };

    fileReader.readAsArrayBuffer(file);
    })
</script>

</html>