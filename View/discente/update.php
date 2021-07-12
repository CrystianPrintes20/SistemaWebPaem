<?php
    /*session_start();
    if(!isset($_SESSION['id_usuario']))
    {
        header("location: login_tec.php");
        exit();
    }
    require_once '../../controller/conn.php';
*/
    //Pega o nome do usuario
    $id = $_SESSION['id_usuario'];

    $nomeuser = "SELECT nome FROM tecnico WHERE usuario_id_usuario = $id";
    $stmt = $pdo->prepare($nomeuser);
    $stmt->execute();

    $nomeresul = $stmt->fetch(PDO::FETCH_ASSOC);
    $nomeresul = implode($nomeresul);
/*
    //Busca os dados do usuario
    try {
        $user_user = "SELECT * FROM usuario WHERE id_usuario = $id";
      
        $statement = $pdo->prepare($user_user);
        $statement->execute();
      
        $result_user = $statement->fetch(PDO::FETCH_ASSOC);
        //print_r($result_user);

        $user_tec = "SELECT * FROM tecnico WHERE usuario_id_usuario = $id";

        $statement = $pdo->prepare($user_tec);
        $statement->execute();

        $result_tec = $statement->fetch(PDO::FETCH_ASSOC);
        //print_r($result_tec);
        
        
      } catch(PDOException $error) {
        echo $user_user . "<br>" . $error->getMessage();
      }*/
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
    
            <a href="../logout.php">
                <i class="fa fa-power-off"></i>
            </a>
            </div>
        </nav>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Atualizar Perfil<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form  method="POST" action="../../controller/update_tec.php" class="alert alert-secondary"> 
                    <div class="input-group  py-3">
                                
                        <h2 class="card-title"></h2><br>
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
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40" value="<?php echo $result_tec['nome']; ?>" >
                        </div>

                        <!--Email-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >@</span>
                            </div>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40" value="<?php echo $result_user['email']; ?>">
                        </div>

                        <!--Campus-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="campus">Campus</label>
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

                        <!--Data de nascimento -->
                        <div class="input-group mb-3">
                        <div class="input-group-prepend">
                                <span class="input-group-text">Data de nascimento</span>
                            </div>
                            <input type="text" name="data_nascimento" class="form-control" placeholder="XXXX/XX/XX" aria-label="data_nascimento" aria-describedby="basic-addon4" maxlength="10" onkeypress="$(this).mask('0000/00/09')" value="<?php echo $result_tec['data_nascimento']; ?>" >
                        </div>


                        <!--Cod Siape -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Siape</span>
                            </div>
                            <input name="siape" id="siape" type="text" class="form-control" placeholder="Digite seu numero do Siape" aria-label="siape" aria-describedby="basic-addon5" maxlength="8" value="<?php echo $result_tec['siape']; ?>">
                        </div>

                        <!--Cargo-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Cargo</span>
                            </div>
                            <input name="cargo" id="cargo" type="text" class="form-control" placeholder="Qual seu Cargo na UFOPA?" aria-label="Nome" aria-describedby="basic-addon2" maxlength="25" value="<?php echo $result_tec['cargo']; ?>">
                        </div>

                        <!--Password-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Senha</span>
                            </div>
                            <input name="senha" id="senha" type="text" class="form-control"  aria-label="Nome" aria-describedby="basic-addon2" maxlength="32" value="<?php echo $result_user['senha']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group row px-3"> 
                        <button id="bntcadastrar" type="submit" name="submit" class="btn btn-blue text-center">Atualizar</button> 
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