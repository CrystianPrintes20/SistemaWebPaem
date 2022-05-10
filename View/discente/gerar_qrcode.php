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
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
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
                <h4 class="tm-text-primary mb-4"><strong>Gerador de QR-code</strong></h4>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p class="mb-4 tm-intro-text">
                            Para ter acesso ao campus ou instituto será necessario o uso da <b>Carteirinha Digital</b> caso
                            você já possou a sua não precisa se preocupar, porém aos que ainda não tiveram acessoa a carteirinha estamos 
                            disponibilizando o seu QR-code abaixo.
                            </p>
                        </div>
                    </div>
                <hr>
                <?php
                    include_once "../../controller/discente_controller/buscardados_discuser.php";
                    //print_r($dados_discuser);
                    //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                    $matricula = $dados_discuser['matricula'];
                    $nome = $dados_discuser['nome'];
                    $curso = $dados_discuser['curso'];

                    $tiraAcentoNome = $nome; // COM O htmlentities ELE CONVERTE ACENTOS EM CODIGOS HTML, sem ele o str_replace funcionará. TESTADO EM UM SCRIPT MEU. BY AKSG.
                    $tiraAcentoCurso = $curso;
                    //$tiraAcentoNome = 'á é í oo â ã'; exemplo retorna a_e_i_oo_a_a
                    $semAcentoNome = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $tiraAcentoNome); 
                    $semAcentoCurso = str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $tiraAcentoCurso); 
                    

                ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <figure>
                            <img class="img-fluid rounded mx-auto d-block" src="https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=<?php print_r($matricula.';'.$semAcentoNome.';'.$semAcentoCurso)?>" >
                            
                        </figure>

                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

</html>
