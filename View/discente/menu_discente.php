<?php
include_once "../../controller/discente_controller/buscardados_discuser.php";


if(!isset($dados_discuser['message'])){
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>

    </head>

    <body>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
            <div class="sidebar-brand">
            <a href="#"><img src="../../img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA<br> <?php print_r($dados_discuser['campus']); ?></a>
                <div id="close-sidebar">
                <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-info">
                <span> <img src="../../img/important-person_318-10744.jpg" class="img-user" /></span>
                <span class="user-role"></i>Discente</span>
                <span class="user-name"><?php print_r($dados_discuser['nome']); ?></span>
                </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Agendamentos</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./home_discente.php">
                        <i class="far fa-list-alt"></i>
                        <span>Reservar salas</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    
                    </li>
                    <!--<li class="sidebar-dropdown">
                        <a href="salas_reser.php">
                        <i class="fas fa-tasks"></i>
                        <span>Salas reservadas</span>
                        </a>
                        
                    </li>-->
                    
                </ul>
                <!-- GERENCIAR RECUROS 
                <ul>
                    <li class="header-menu">
                        <span>Gerenciar Recursos</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./quem_esta_campus.php">
                        <i class="fas fa-globe"></i>
                        <span>Presentes no campus</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./add_recursos.php">
                        <i class="fas fa-plus"></i>
                        <span>Adicionar Recursos</span>
                        </a>
                    </li>
                
                    <li class="sidebar-dropdown">
                        <a href="./editar_recursos.php">
                        <i class="far fa-edit"></i>
                        <span>Editar Recursos</span>
                        <span class="badge badge-pill badge-warning">New</span>
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./delete_recursos.php">
                        <i class="far fa-trash-alt"></i>
                        <span>Excluir Recursos</span>
                        </a>
                    </li>-->
                </ul>
                <ul>
                    <li class="header-menu">
                        <span>Configurações</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./update_discente.php">
                        <i class="fa fa-cog"></i>
                        <span>Atualizar perfil</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    </li>
                    <!-- <li class="sidebar-dropdown">
                        <a href="#"> ./delete.php
                        <i class="fa fa-cog"></i>
                        <span>Excluir Perfil</span>
                        </a>
                    </li> -->
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
            <a href="#" onclick="ConfirmarSaida()">
                <i class="fa fa-power-off"></i>
            </a>

            </div>
        </nav>
    </body>
    </html>

    <script>
    function ConfirmarSaida() {
    var option = confirm("Você realmente deseja sair?\nPara sair clique em OK");
    
    if(option) {
        /* Redireciona para a página index */
        window.location = '../logout.php'
    }
    }
    </script>
 <?php
}else{
    $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
    Sua sessão inspirou/Sem sessão!
    </div>";
    header("location: ./login_discente.php");
    exit(); 
}
?>


