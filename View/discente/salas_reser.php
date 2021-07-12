<?php
    /*session_start();
    if(!isset($_SESSION['id_usuario']))
    {
        header("location: login_tec.php");
        exit();
    }

    require_once '../../controller/conn.php';
    $id = $_SESSION['id_usuario'];

    $nomeuser = "SELECT nome FROM tecnico WHERE usuario_id_usuario = $id";
    $stmt = $pdo->prepare($nomeuser);
    $stmt->execute();

    $nomeresul = $stmt->fetch(PDO::FETCH_ASSOC);
    $nomeresul = implode($nomeresul);*/
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

</head>
<body>

    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="../index.php"><img src="../../img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA</a>
                <div id="close-sidebar">
                <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-info">
                <span> <img src="../../img/important-person_318-10744.jpg" class="img-user" /></span>
                <span class="user-role"></i>Servidor Técnico</span>
                <span class="user-name"><?php print_r($nomeresul); ?></span>
                </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Agendamentos</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="areaprivtec.php">
                        <i class="far fa-list-alt"></i>
                        <span>Resevar salas</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="salas_reser.php">
                        <i class="fas fa-tasks"></i>
                        <span>Salas reservadas</span>
                        </a>
                        
                    </li>
                    
                </ul>
                <!-- GERENCIAR RECUROS -->
                <ul>
                    <li class="header-menu">
                        <span>Gerenciar Recursos</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./add_recursos.php">
                        <i class="fas fa-plus"></i>
                        <span>Adicionar Recursos</span>
                        </a>
                    </li>
                
                    <li class="sidebar-dropdown">
                        <a href="./editar_rec.php">
                        <i class="far fa-edit"></i>
                        <span>Editar Recursos</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./delete.php">
                        <i class="far fa-trash-alt"></i>
                        <span>Excluir Recursos</span>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li class="header-menu">
                        <span>Configurações</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./update.php">
                        <i class="fa fa-cog"></i>
                        <span>Atualizar perfil</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./delete.php">
                        <i class="fa fa-cog"></i>
                        <span>Excluir Perfil</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- sidebar-menu  -->
            </div>
            <!-- sidebar-content  -->
            <div class="sidebar-footer">
            <!--<a href="#">
                <i class="fa fa-bell"></i>
                <span class="badge badge-pill badge-warning notification">3</span>
            </a>
            <a href="#">
                <i class="fa fa-envelope"></i>
                <span class="badge badge-pill badge-success notification">7</span>
            </a>
            <a href="#">
                <i class="fa fa-cog"></i>
                <span class="badge-sonar"></span>
            </a>-->
            <a href="../logout.php">
                <i class="fa fa-power-off"></i>
            </a>
            </div>
        </nav>
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
               <!-- <?php
                    $url = "../../JSON/solicitacao_acesso.json";
                    //var_dump($url);
                    //$url = "https://swapi.dev/api/people/?page=1";
                    $resultado = json_decode(file_get_contents($url));

                    if (!$resultado) {
                        switch (json_last_error()) {
                            case JSON_ERROR_DEPTH:
                                echo 'A profundidade máxima da pilha foi excedida';
                            break;
                            case JSON_ERROR_STATE_MISMATCH:
                                echo 'JSON malformado ou inválido';
                            break;
                            case JSON_ERROR_CTRL_CHAR:
                                echo 'Erro de caractere de controle, possivelmente codificado incorretamente';
                            break;
                            case JSON_ERROR_SYNTAX:
                                echo 'Erro de sintaxe';
                            break;
                            case JSON_ERROR_UTF8:
                                echo 'Caractere UTF-8 malformado, codificação possivelmente incorreta';
                            break;
                            default:
                                echo 'Erro desconhecido';
                            break;
                        }
                        exit;
                    }
                    foreach ($resultado->data as $value) {
                        $id_recurso_campus = $value->id_recurso_campus;
                        print_r($id_recurso_campus);
                           
                            
                    }
                ?>-->
    
                <table id="listar-usuario" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>id_recurso_campus</th>
                        <th>para_si</th>
                        <th>data</th>
                        <th>hora_inicio</th>
                        <th>hora_fim</th>
                        <th>status_acesso</th>
                        <th>usuario_id_usuario</th>
                        <th>discente_id_discente</th>
                        <th>fone</th>
                    </tr>
                </thead>
               <!-- <tbody>
                    <?php foreach($resultado->data as $value) { ?>
                        <tr>
                            <td><?php echo $value->id_recurso_campus ?></td>
                        </tr>
                    <?php } ?>
                </tbody> -->
                </table>
                <input type="submit">
            </div>
        </main>
    </div>
    
</body>

<script src="../../js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../js/areaprivtec.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#listar-usuario').DataTable({
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
})
</script>

</html>