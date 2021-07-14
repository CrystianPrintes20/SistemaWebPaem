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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>

    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/areaprivtec.css" />
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

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
                <h2>Seja bem-vindo<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                    <h4>Lista de Espaços reservado no campus</h4>
                <hr>
                <?php
                
                    $token = implode(",",json_decode( $_SESSION['token'],true));
                    $url = "http://localhost:5000/api.paem/solicitacoes_acessos";
                    $ch = curl_init($url);
                    $headers = array(
                    'content-Type: application/json',
                    'Authorization: Bearer '.$token,
                    );


                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    $response = curl_exec($ch);

                    $resultado = json_decode($response);
                    print_r($response);
                  
                ?>
                <table class="table table-hover" style="width:100%">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">para_si</th>
                            <th scope="col">data</th>
                            <th scope="col">hora_inicio</th>
                            <th scope="col">hora_fim</th>
                            <th scope="col">status_acesso</th>
                            <th scope="col">Recurso campus</th>
                            <th scope="col">fone</th>
                        </tr>
                    </thead>
                    <?php foreach($resultado as &$value) { ?>
                        <tr>
                            <td><?php echo $value->nome; ?></td>
                            <td><?php echo $value->para_si;?></td>
                            <td><?php echo $value->data;?></td>
                            <td><?php echo $value->hora_inicio;?></td>
                            <td><?php echo $value->hora_fim;?></td>
                            <td><?php echo $value->status_acesso;?></td>
                            <td><?php echo $value->recurso_campus;?></td>
                            <td><?php echo $value->fone;?></td>
                        </tr>
                    <?php }?>
               <!-- <tbody>
                    <?php foreach($resultado->data as $value) { ?>
                        <tr>
                            <td><?php echo $value->id_recurso_campus ?></td>
                        </tr>
                    <?php } ?>
                </tbody> -->
                </table>
            </div>
        </main>
    </div>
    
</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
/*$(document).ready(function(){
$('#listar-reservas').DataTable({
        "ajax" : "../../JSON/solicitacao_acesso.json",
        "columns" : [
            { "data" : "id_recurso_campus"},
            { "data" : "para_si"},
            { "data" : "data"},
            { "data" : "hora_inicio"},
            { "data" : "hora_fim"},
            { "data" : "status_acesso"},
            { "data" : "usuario_id_usuario"},
            { "data" : "discente_id_discente"},
            { "data" : "fone"},
        ]
    });
})*/
</script>

</html>