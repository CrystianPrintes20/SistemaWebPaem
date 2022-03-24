<?php
include_once "../../controller/tecnico_controller/buscardados_tecuser.php";

if(!isset($dados_tecuser['message'])){

?>    

    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="#"><img src="../../Assets/img/ufopa-icon-semfundo.png" class="img-icon"/>UFOPA<br> <?php print_r($dados_tecuser['campus']); ?></a>
            <div id="close-sidebar">
            <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="sidebar-header">
            <div class="user-info">
            <span> <img src="../../Assets/img/important-person_318-10744.jpg" class="img-user" /></span>
            <span class="user-role">Servidor Técnico</span>
            <span class="user-name"><?php print_r($dados_tecuser['nome']); ?></span>
            </div>
        </div>
        <!-- sidebar-header  -->
        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>Agendamentos</span>
                </li>
                <li class="sidebar-dropdown">
                    <a href="./home_tecnico.php">
                    <i class="far fa-list-alt"></i>
                    <span>Reservar salas p/ Discentes</span>
                    <!--<span class="badge badge-pill badge-warning">New</span> -->
                    </a>
                
                </li>
                
            </ul>
                <!-- Monitoramento -->
            <ul>
                <li class="header-menu">
                    <span>Monitaramento</span>
                </li>
                
                <li class="sidebar-dropdown">
                    <a href="./rastreamento_tecnico.php">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Rastreamento</span>
                    </a>
                </li>

                <li class="sidebar-dropdown">
                    <a href="./presentes_no_campus.php">
                    <i class="fas fa-globe"></i>
                    <span>Presentes no campus</span>
                    </a>
                </li>

                <li class="sidebar-dropdown">
                    <a href="./salas_reservadas.php">
                    <i class="fas fa-tasks"></i>
                    <span>Recursos Reservados</span>
                    </a>
                    
                </li>

                <li class="sidebar-dropdown">
                    <a href="./cart_vacinacao_tecnico.php">
                    <i class="fas fa-file-medical"></i>
                    <span>Carterinha de Vacinação</span>
                    </a>
                </li>

               <li class="sidebar-dropdown">
                    <a href="./estatistica_e_diag.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Estatisticas e Diag.</span>
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
                    <a href="./editar_recursos.php">
                    <i class="far fa-edit"></i>
                    <span>Editar Recursos</span>
                    <!--<span class="badge badge-pill badge-warning">New</span> -->
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="./delete_recursos.php"> <!--./delete.php -->
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
                    <a href="#"> <!--./delete.php -->
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
        <a href="#" onclick="ConfirmarSaida()">
            <i class="fa fa-power-off"></i>
        </a>

        </div>
    </nav>
 

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
    header("location: ./login_tec.php");
    exit(); 
}
?>




