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
    $nomeresul = implode($nomeresul);
*/

   /* try {
        $user_user = "SELECT nome,inicio_horario_funcionamento,fim_horario_funcionamento FROM recurso_campus";
      
        $statement = $pdo->prepare($user_user);
        $statement->execute();
      
        $result_user = $statement->fetchall(PDO::FETCH_ASSOC);
        print_r($result_user[1]);

        
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
                <h2>Area administrativa<!-- <?php echo $_SESSION["nome_tec"]; ?> -->.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form  method="POST" action="../../controller/cont_reservar.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h4>Faça sua reseva.</h4>
                    <div class="input-group  py-3">
                            
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="reserva">Reservar</label>
                        </div>
                        
                        <?php
                            $url = "../../JSON/recurso_campus.json";
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
                        <select name="reserva" class="custom-select" id="reserva" required>
                            <option disabled selected>Escolha...</option>
                            <?php
                               foreach ($resultado->data as &$value) { ?>
                               <option value="<?php echo $value->id_recurso_campus; ?>"><?php echo $value->nome; ?></option> <?php
                                }
                            ?>
                        </select>
                      
                    </div>
                    <h5>Buscar Discente:</h5>
                    <div class="row">
                        
                        <!--Matricula-->
                        <div class=" col-md-5 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Matricula</span>
                            </div>
                            <input type="text" name="matricula" id="matricula" value="" class="form-control"  aria-label="matricula" maxlength="10" required>
                        </div>

                        <span class="py-3">ou</span>

                        <!--nome-->
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" value="" class="form-control"  aria-label="nome" aria-describedby="basic-addon1" maxlength="40" required>
                        </div>
                        
                    </div>
                    <!-- Data da reversa -->
                    <div class="row">
                  
                        <div class=" col-md-6 input-group py-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Data de Reserva</span>
                            </div>
                            <input name="data_reserva" class="form-control date form_date" data-date="" data-date-format="yyyy/mm/dd" data-link-field="dtp_input2" data-link-format="yyyy/mm/dd"  type="text" value="" maxlength="10" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                            <input type="hidden" id="dtp_input2" value="" /><br/>
                        </div>
                            

                        <div class=" col-md-6 input-group py-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="reserva">Periodo</label>
                            </div>
                            <select name="SelectOptions" class="custom-select" id="SelectOptions" required>
                                <option value="">Selecione</option>
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>

                        <div class="DivPai col">
                            
                            <div class="manha" style="display: none;">
                                <div class=" manha row">
                                    <div class="manha col-md-12 input-group py-3">
                                        <div class="manha input-group-prepend">
                                            <label class="input-group-text" for="manha">Manhã</label>
                                        </div>
                                        <select name="hi_hf[]" class="custom-select" id="manha">
                                            <option disabled selected>Escolha...</option>
                                            <option value="08:0010:00">08:00 as 10:00</option>
                                            <option value="10:0012:00">10:00 as 12:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="tarde" style="display: none;">
                                <div class="tarde row">
                                    <div class="tarde col-md-12 input-group py-3">
                                        <div class="tarde input-group-prepend">
                                            <label class="input-group-text" for="tarde">Tarde</label>
                                        </div>
                                        <select name="hi_hf[]" class="custom-select" id="tarde">
                                            <option disabled selected>Escolha...</option>
                                            <option value="14:0016:00">14:00 as 16:00</option>
                                            <option value="16:0018:00">16:00 as 18:00</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="noite" style="display: none;">
                                <div class="noite row">
                                        <div class="noite col-md-12 input-group py-3">
                                            <div class="noite input-group-prepend">
                                                <label class="input-group-text" for="noite">noite</label>
                                            </div>
                                            <select name="hi_hf[]" class="custom-select" id="noite">
                                                <option disabled selected>Escolha...</option>
                                                <option value="18:0020:00">18:00 as 20:00</option>
                                                <option value="20:0022:00">20:00 as 22:00</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="pesqdispo" class="btn btn-primary" type="submit">Verificar Disponibilidade e Reservar</button>
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
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>

<script type="text/javascript">

    $('.form_date').datetimepicker({
        language:  'pt-BR',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0,
        startDate: new Date(),
        
    });
</script>


<script>
    //Funções após a leitura do documento
    $(document).ready(function() {
    //Select para mostrar e esconder divs
    $('#SelectOptions').on('change',function(){
        var SelectValue='.'+$(this).val();
        $('.DivPai div').hide();
        $(SelectValue).toggle();
    });
    });
</script>
</html>