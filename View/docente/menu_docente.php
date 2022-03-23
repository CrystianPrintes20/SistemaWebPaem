<?php
include_once "../../controller/docente_controller/buscardados_docuser.php";

if(!isset($dados_docuser['message'])){
    $id_docente = $dados_docuser['id_docente'];
    $id_usuario = $dados_docuser['usuario_id_usuario']; //Usando na pagina de editar e excluir recursos, onde uso o id usuario pra filtar somente os recursos feitos pelo docente.
?>    
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>

    </head>

    <body>
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
            <div class="sidebar-brand">
                <a href="#"><img src="../../Assets/img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA<br><?php print_r($dados_docuser['campus_instituto']); ?></a>
                <div id="close-sidebar">
                <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">
                <div class="user-info">
                <span> <img src="../../Assets/img/important-person_318-10744.jpg" class="img-user" /></span>
                <span class="user-role"></i>Docente</span>
                <span class="user-name"><?php print_r($dados_docuser['nome']); ?></span>
                </div>
            </div>
            <!-- sidebar-header  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Agendamentos</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./home_docente.php">
                        <i class="far fa-list-alt"></i>
                        <span>Reservar recurso p/ Disciplina</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./minhas_reservas_docente.php">
                        <i class="far fa-list-alt"></i>
                        <span>Minhas Reservas</span>
                       <span class="badge badge-pill badge-warning">New</span>
                        </a>
                    
                    </li>
                    <!-- <li class="sidebar-dropdown">
                        <a href="salas_reservadas.php">
                        <i class="fas fa-tasks"></i>
                        <span>Suas Disciplinas</span>
                        </a>
                    </li>  -->
                    
                </ul>

                <!-- MONITORAMENTO 
                <ul>
                    <li class="header-menu">
                        <span>Monitoramento</span>
                    </li>
                   
                </ul>-->
                <!-- GERENCIAR RECUROS -->
                <ul>
                    <li class="header-menu">
                        <span>Gerenciar Recursos</span>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./salas_reservadas.php">
                        <i class="far fa-edit"></i>
                        <span>Recursos Reservados</span>
                    
                        </a>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./add_recursos.php">
                        <i class="fas fa-plus"></i>
                        <span>Adicionar Recursos</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./editar_recursos_docente.php">
                        <i class="far fa-edit"></i>
                        <span>Editar Recursos</span>
                        </a>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./delete_recursos_docente.php"> 
                        <i class="far fa-trash-alt"></i>
                        <span>Excluir Recursos</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./cadastrar_disciplinas_docente.php">
                        <i class="fas fa-plus"></i>
                        <span>Cadastrar Disciplinas</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-dropdown">
                        <a href="./minhas_disciplinas.php">
                        <i class="far fa-list-alt"></i>
                        <span>Minhas Disciplinas</span>
                        </a>
                    </li>

                    <li class="sidebar-dropdown">
                        <a href="./cart_vacinacao_docente.php">
                        <i class="fas fa-file-medical"></i>
                        <span>Carterinha de Vacinação</span>
                        </a>
                    </li>
                    
                </ul>
           
                <ul>
                    <li class="header-menu">
                        <span>Configurações</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="./update_docente.php">
                        <i class="fa fa-cog"></i>
                        <span>Atualizar perfil</span>
                        <!--<span class="badge badge-pill badge-warning">New</span> -->
                        </a>
                    </li>
                    <!--<li class="sidebar-dropdown">
                        <a href="#"> ./delete.php 
                        <i class="fa fa-cog"></i>
                        <span>Excluir Perfil</span>
                        </a>
                    </li>-->
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
    Sua sessão expirou/Sem sessão!
    </div>";
    header("location: ./login_docente.php");
    exit(); 
}
?>
