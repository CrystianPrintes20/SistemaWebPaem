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
    <meta charset="UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>UFOPA - Campus Prof. Dr. Domingos Diniz </title>
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
                <h2>Adicionar Recursos<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Nesta área você pode add um novo espaço do campus para ser reservado.</p>
                        </div>
                    </div>
                <hr>
                
                <form  method="POST" action="../../controller/cont_addrecursos.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Escolha o campus:</h5>
                    <div class="row">
                        <div class="col-md-6 input-group py-3">
                                
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">campus</label>
                            </div>

                            <?php
                                $url = "../../JSON/campus.json";
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
                            ?>
                            <select name="campus" class="custom-select" id="campus">
                                <option disabled selected>Escolha...</option>
                                <?php
                                   foreach ($resultado->data as &$value) { ?>
                                   <option value="<?php echo $value->id_campus; ?>"><?php echo $value->nome; ?></option> <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Nome do recurso do campus (ex: biblioteca, laboratorio)"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40">
                        </div>
                    </div>
                    <div class="row">
                        
                        <!--Capacidade de pessoas -->
                        <div class="col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Capacidade</span>
                            </div>
                            <input name="capacidade" id="capacidade" type="text" class="form-control" placeholder="Nº total de pessoas nesse recurso." aria-label="capacidade" aria-describedby="basic-addon5" maxlength="3" onkeypress="$(this).mask('009')">
                        </div>
                        
                         <!--descrição-->
                         <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Descrição</span>
                            </div>
                            <input name="descricao" id="descricao" type="text" class="form-control" placeholder="Ex: vinculado ao curso XXXX"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100">
                        </div>
                    </div>
                    <div class="row">
                        <!--Hora inicial-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora inical</span>
                            </div>
                            <input name="hora_inicial" id="hora_inicial" type="text" class="form-control" placeholder="Ex: 17:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100">
                        </div>
                       <!--Hora final-->
                       <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Hora Final</span>
                            </div>
                            <input name="hora_final" id="hora_final" type="text" class="form-control" placeholder="Ex: 19:00"  aria-label="nome" aria-describedby="basic-addon1" maxlength="100">
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="addrecurso" class="btn btn-primary" type="submit">Adicionar</button>
                                </div> 
                                <!--<div class="col-md-6">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Verificar Disponibilidade e Finalizar Reserva</button>
                                </div>-->
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