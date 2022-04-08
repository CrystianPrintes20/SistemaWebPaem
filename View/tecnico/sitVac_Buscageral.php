<?php
session_start();

 if(!isset($_SESSION['token']))
 {
     header("location: ./login_tec.php");
     exit();
 }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Minha Vida Academica</title>
    <link rel="shortcut icon" href="../../Assets/img/Minhavidaacademica.ico">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../../Assets/css/areaprivtec.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />


    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
 

</head>
<body>

    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <?php
            include_once "./menu_tecnico.php";
        ?>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Busca geral sobre a situação vacinal dos discentes.</h2>
                <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Nesta área poderá ser feita a filtragem por campus/instituto, curso, turma  e quantidade de doses de cada discente.
                                Alem de poder vizualizar a Carterinha de Vacinação enviada pelos mesmos.<br>
                            </p>
                        </div>
                        <div class="col-md-12 input-group py-3 mb-3 alert alert-primary">
                            <p>
                                OBS: Para realizar a buscar corretamente deve-se preencher no minino um dos campos o que possibilita a filtragem por: nome e matricula, campus e curso, turma e quantidade de doses e etc.
                            </p>
                        </div>
                    </div>
                    <!-- <h4>Vacinação dos discentes.</h4> -->
                <hr>

                <form  method="POST" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h4>Realizar busca por:</h4>
              
                    <div class="row">
                        <div class="col-md-12 input-group py-3">
                    
                            <!--Campus -->
                            <?php
                                /*Bucando o nome do campus intituto  */
                                $url = $rotaApi.'/api.paem/campus_institutos';
                                $ch = curl_init($url);

                                $headers = array(
                                    'Authorization: Bearer '.$token,
                                );

                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                $response = curl_exec($ch);

                                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                if(curl_errno($ch)){
                                    // throw the an Exception.
                                    throw new Exception(curl_error($ch));
                                }

                                curl_close($ch);
                                //print_r($response);

                                $campus = json_decode($response, true);
                               
                            ?>

                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="campus">Campus</label>
                                </div>
                                <select name="campus" class="custom-select" id="campus">
                                <option disabled selected></option>
                                    <?php
                                        foreach ($campus as $value) { ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['nome']; ?></option> <?php
                                            }
                                    ?>

                                </select>
                            </div>

                            <!--Curso -->
                            <div class="col-md-6 input-group my-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="curso">Curso</label>
                                </div>
                                <select name="curso" class="custom-select" id="curso">
                                            
                                </select>
                            </div>

                            <!--Turma -->
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Turma</span>
                                </div>
                                <input name="turma" id="turma"  type="number" min="2009" max="2022" step="1"  class="form-control" placeholder="" aria-label="Nome" aria-describedby="basic-addon2" maxlength="4" onkeypress="$(this).mask('0009')">
                            </div>
                            
                            <!--Numeros de doses -->
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="numeros_doses">Nº de doses</label>
                                </div>
                                <select required name="numeros_doses" class="custom-select" id="numeros_doses">
                                    <option selected disabled>Selecione</option>
                                    <option value="1">Uma dose (ou dose unica).</option>
                                    <option value="2">Duas doses.</option>
                                    <option value="3">Duas doses(ou dose unica) + Reforço.</option>
                                    <option value="0">Nenhuma dose tomada</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 py-4">
                                <button name="pesqdispo" class="btn btn-primary" type="submit">Buscar</button>
                            </div> 
                            
                        </div>
                    </div>
                    
    
                </form>
                <hr>
                <div id="table_reservas">
                  <!--   <div class="card" style="width: 30rem;">
                        <div class="card-body">
                            <h5 class="card-title">Informações Gerais</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Resultado da busca.</h6>
                            <ul>
                                <li>
                                    Total de Discentes:
                                </li>
                                <li>
                                    Quantidade de discentes <b>sem a carterinha:</b>
                                </li>
                                <li>
                                    Quantidade de discentes <b>com a carterinha:</b>
                                </li>
                            </ul>
                            <p class="card-text"></p>
                        </div>
                    </div> -->
                    <hr>
                    <table id="agendamentos_table" class="table table-hover">
                        <thead class="table-dark">
                            <tr class="centralizar">
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Matricula</th>
                                <th scope="col">Turma</th>
                                <th scope="col">Ver Carteirnha</th>
                            <!--  <th colspan="2">Editar e Excluir solicitação</th> -->
                            </tr>
                        </thead>
                        <?php
                            $token = implode(",",json_decode( $_SESSION['token'],true));
                            
                            if(isset($_POST['curso']) || isset($_POST['numeros_doses']) || isset($_POST['turma'])){

                               
                                $n_doses = (isset($_POST['numeros_doses'])) ? addslashes($_POST['numeros_doses']) : '' ; 
                                $turma = addslashes($_POST['turma']);
                                $curso = (isset($_POST['curso'])) ? addslashes($_POST['curso']) : '' ; 

                                if($n_doses == 0){
                                    $n_doses = -1;
                                }

                                $cont = 0;                         
                                $com_cartvac = 0;
                                $sem_cartvac = 0;

                                if(!empty($curso) && !empty($n_doses) && !empty($turma)){

                                    if($n_doses == -1){
                                        $n_doses = 0;
                                    }
    
                                        
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?curso_id_curso=".$curso."&numero_de_doses=".$n_doses."&ano_turma=".$turma;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                    /*echo "Cusos doses e turma";
                                      echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                      
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">

                                                           
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Informações Gerais</h5>
                                            <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                            <ul>
                                                <li>
                                                    Total de Discentes: $cont
                                                </li>
                                                <li>
                                                    Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                </li>
                                                <li>
                                                    Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                </li>
                                            </ul>
                                            <p class='card-text'></p>
                                        </div>
                                    </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    }

                                }elseif(!empty($curso) && !empty($turma)){
                                         
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?curso_id_curso=".$curso."&ano_turma=".$turma;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                    /*echo "Curso e turma";
                                      echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">

                                                           
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informações Gerais</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                                    <ul>
                                                        <li>
                                                            Total de Discentes: $cont
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                        </li>
                                                    </ul>
                                                    <p class='card-text'></p>
                                                </div>
                                            </div><hr>";
                         
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    }
                                }elseif(!empty($curso) && !empty($n_doses)){

                                    if($n_doses == -1){
                                        $n_doses = 0;
                                    }
                                        
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?curso_id_curso=".$curso."&numero_de_doses=".$n_doses;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                     /*echo "Cusos e doses";
                                     echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Informações Gerais</h5>
                                            <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                            <ul>
                                                <li>
                                                    Total de Discentes: $cont
                                                </li>
                                                <li>
                                                    Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                </li>
                                                <li>
                                                    Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                </li>
                                            </ul>
                                            <p class='card-text'></p>
                                        </div>
                                    </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    }
                                }elseif(!empty($n_doses) && !empty($turma)){
                                    
                                    if($n_doses == -1){
                                        $n_doses = 0;
                                    }
                                        
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?ano_turma=".$turma."&numero_de_doses=".$n_doses;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                    /*echo "Turma e doses";
                                      echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">

                                                           
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informações Gerais</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                                    <ul>
                                                        <li>
                                                            Total de Discentes: $cont
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                        </li>
                                                    </ul>
                                                    <p class='card-text'></p>
                                                </div>
                                            </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    } 
                                }elseif(!empty($n_doses)){
                                    if($n_doses == -1){
                                        $n_doses = 0;
                                    }
                                        
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?numero_de_doses=".$n_doses;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                    /* echo "Doses";
                                     echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">
                                                           
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informações Gerais</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                                    <ul>
                                                        <li>
                                                            Total de Discentes: $cont
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                        </li>
                                                    </ul>
                                                    <p class='card-text'></p>
                                                </div>
                                            </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    } 
                                }elseif(!empty($turma)){
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?ano_turma=".$turma;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                    /*echo "Turma";
                                      echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                                <!-- Button update modal -->
                                                                <div align="center">  
                                                                    <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                                </div>
                                                            <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                                <!-- Button update modal -->
                                                                <div class="alert alert-danger" role="alert">
                                                                    <p align="center">Sem carterinha </p>
                                                                </div>
                                                            <?php
                                                        }
                                                    ?>
                                                    
                                                </td>
                                          
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informações Gerais</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                                    <ul>
                                                        <li>
                                                            Total de Discentes: $cont
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                        </li>
                                                    </ul>
                                                    <p class='card-text'></p>
                                                </div>
                                            </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    } 

                                }elseif(!empty($curso)){
                                    $url = $rotaApi."/api.paem/discentes_vacinacoes?curso_id_curso=".$curso;
                                    $ch = curl_init($url);
                                    $headers = array(
                                    'Authorization: Bearer '.$token,
                                    );
                
                
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                                    $response = curl_exec($ch);
                
                                    $resultado = json_decode($response,true);
                                     /*echo "Curso";
                                     echo "<pre>";
                                    echo "Cusos doses e turma";
                                    print_r($resultado);
                                    echo "</pre>"; */
                                    
        
                                    foreach($resultado as $value){
                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $cont += 1;  ?></td>
                                                <td><?php echo $value['nome']; ?></td>
                                                <td><?php echo $value['matricula'];?></td>
                                                <td><?php echo $value['turma'];?></td>
                                            
                                                <td>
                                                    <?php
                                                        if(!empty($value['carteirinha_vacinacao'])){
                                                            $com_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div align="center">
                                                           
                                                                <button  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['id'];?>" data-whatevercart="<?php  echo $value['carteirinha_vacinacao'];?>" >Carteirnha</button>
                                                             </div>
                                                             <?php
                                                        }else{
                                                            $sem_cartvac += 1;
                                                            ?>
                                                            <!-- Button update modal -->
                                                            <div class="alert alert-danger" role="alert">
                                                               <p align="center">Sem carterinha </p>
                                                            </div>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php                                        
                                    }
                                    echo " <div class='card' style='width: 30rem;'>
                                                <div class='card-body'>
                                                    <h5 class='card-title'>Informações Gerais</h5>
                                                    <h6 class='card-subtitle mb-2 text-muted'>Resultado da busca.</h6>
                                                    <ul>
                                                        <li>
                                                            Total de Discentes: $cont
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>sem a carterinha:</b> $sem_cartvac
                                                        </li>
                                                        <li>
                                                            Quantidade de discentes <b>com a carterinha:</b> $com_cartvac
                                                        </li>
                                                    </ul>
                                                    <p class='card-text'></p>
                                                </div>
                                            </div><hr>";
                                    if($cont == 0){
                                        ?>
                                        <tr>
                                            <td align="center" colspan="6"><b> Sem Registros  </b></td>
                                        </tr>
                                    <?php
                                    } 
                                }

                            }
                                    
                        ?>
                        
                        <!-- ALTERAÇÃO DO STATUS DE ACESSO-->

                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                             
                                    <div class="modal-body">
                                        <div class="alert alert-primary" role="alert">
                                            Exibido em outra aba!
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                        </div>
                                        
                                    </div>
                                        
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
             
            </div>
        </main>
    </div>

    
</body>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../../Assets/js/buscar_nome_matri.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script type="text/javascript" src="../../bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../bootstrap/js/locales/bootstrap-datetimepicker.pt-BR.js" charset="UTF-8"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


<!-- Busca os cursos -->
<script language="Javascript">
    //Buscando os cursos
    $("#campus").on("change", function(){
    var unidade = $("#campus").val();
    
    $.ajax({
            url: '../docente/busca_cursos.php',
            type: 'POST',
            data:{Unidade:unidade},
            success: function(data){
                $("#curso").html(data);
            },
            error: function(data){
                $("#curso").html("Houve um erro ao carregar");
            }
    });
    
    });

</script>
<script type="text/javascript">

    $(document).ready(function(){
        $('#data_inicial').datetimepicker({
            language: 'pt-BR',
            format: 'dd-mm-yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0",
            endDate: '+0d'
        
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#data_final').datetimepicker('setStartDate', minDate);
        });

        $('#data_final').datetimepicker({
            language: 'pt-BR',
            format: 'dd-mm-yyyy',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
            daysOfWeekDisabled: "0",
            endDate: '+2d'

        }).on('changeDate', function(selected){
            var minDate = new Date(selected.date.valueOf());
           $('#data_inicial').datetimepicker('setEndDate', minDate);
        }) ;

    });
  
</script>

<script>
    $(document).ready(function() {
        $('#agendamentos_table').DataTable({
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'UFOPA - Minha Vida Academica',
                    messageTop: 'Lista com os dados sobre a vacinação dos discentes.',
                    text:      '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
        
                        $('row c[r^="B"]', sheet).attr( 's', '2' );
                        
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: 'UFOPA - Minha Vida Academica',
                    messageTop: 'Lista com os dados sobre a vacinação dos discentes.',
                    download: 'open',
                    text:      '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'PDF'
                    /* customize: function ( doc ) {
                        doc.content.splice( 1, 0, {
                            margin: [ 0, 0, 0, 12 ],
                            alignment: 'center',
                            image : 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAVAAAAFSCAYAAACkIIfSAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADpwAAA6cAQeUU90AAOLYSURBVHhe7L0HfFRHljXOt7O73/ff/cLuztoGFMmOM2MbCQXAgDNOBOXUSuCAc45kIZEzNiZInZQAg7GNwQnniO2xh3EcZ4JQzlm6/3PqvSe1RGOELaSWePXj8Lpft16/V3Xr1L1Vt+4dYBazmMUsZjGLWTyoHDgg/7L/07L/2PVlzeDtH9f6bX2vYsSGt2ouXfFq9VWr36i6e/WbTfOX7m9YnvZSzfK5e2qffGxP9ZMPPVdle1DHA89V7TCA8wZsjwBz8d20fbVPLt5ft3zl203zV71Ve9+atxsi179TG7Ll/crz7Z9Unv/8961+e76pPOvNI5Vn7f9B/pd+W2Yxi1nM0vslX+QPtr+2/vvWN2p9nn6rImjdqxWTM54vS5n/bNV9s5+pdD6WX/7xQ7kln93jLPrsHsfRz+5wFH52m7Xw76nWoiOp9pLqFGtFbaK9qjbeXlsbZ6+rjXXU18bgGI33v44afL+mNt5WVWsBku0VtSnOspoUe+GxmzMLvrjNdvSzu53HPrsvF8gv/OzRHUWfzdlZ9v6C5yudaXvLH179cnls5ns107cdqB23+4D4vv1l6//RH8ksZjGLWbq3zJkz559ANP9m/6x+1Kq3yq9c/mrpI/OfO7b53h0lu2dtq3jt5pyyb1Md5UUpjtpii62mOM5aVxaTVd8QY22SWCDBWidJ1nKgUhLtlWKx10qCs15inY0Snd0i0TkiUbki0UBsbivQ3BE5zRKT0+SCZvxNC46tEoO/j8tukvjsBlyzDtevlmRbpaTg91KsZWLBb0bb8Tv2htZYax1It7oUpF0801lZfHtuxbF78iv/9vAzFS/Nea5q9+K95ZtXv1oesfXDmoBnvmkdZjva+u96FZjFLGYxy8kLtcqdMLtt71RduOHlY9Pn7z5yz8PbC9bcu6Nw/215hV+kOIuPJkDbi3eUN0Q7qxoicqobwxw1reEgsHAQW2Req4TniYTp4OvIXJCdE6SnIxKIAvFFZbfiM34uEoHvReF70SDIaGfDryIqu1Eis3kd/D2uEeXE3+F6MXgdS0IFucbh8zj+Dl5PxUPdBPA4Pa8F99WE+2zCZ/USaa9uibZXNMbieRKclbWJzvJjeMavb8st/vyBZ4r3zn+2cP3Kl48+suXdsqm5H1ZduOvLIlNbNYtZzKIVEmb2e1XnrNpfOnbpnor5s3cUbL8v+8g7sxyHvr8l60jJDFtBWaKttCreVtEc46gDSYF4QJKR+SDAPBBaXo3EANG5NSCkaonJxXdwPgbkFJ1dB9TjPMgO5BZBwoTWGEHwdTbIE68NUKuMBvHxNzqC51xA7RN/Gw3wSMTqx0gniBiIJvA+CtptRF6zRGwDaQJRRD5IOA/3llcrsfkAnwH3re4LZB5FEnc0SLy9qinFVlJ5s+1o2R22n4vvy/75m9k7ju5d+Ezh4rUvlV+d/Xb56Lx3y/9Lr0qzmMUs/b3s3y//vPrNI2ctf+nny9L2HZ37yLNlu+/ILfsq1V5xNDGrujbeWt0Yb61qjqOZDbJK0LW6WJBLrDKxQUwgJWp/sQ6Y5zDDEw2AdCz2Bkm0NUiSrVFS7U0KFlyDf+MKZX6DCGmeK20RRBnbRpY0zduhftsVIMY4EGSco1XiHSLxfK0jhiCZ4kgCjcV9xjua8R2Y+UCCjnhosfH4PQt+z4IjP6NGHIF7iyDx8jeABDy7BZ8lYyBI5hSEtbwxOau0bEZW6Q+zskq/eiC35K2050uyVr9anLzh9bKLX/6u9P/pVW0Ws5ilPxT7+8X/96l3ascvfa12zSO7il640/nL329xFBQl26FZ2iuaqG2FO1pkOghkOggkDAgnkQDU4DQiAlGBsBIAix2kgu8n2EEwOiw6Em0akoEU/WjB3ygS1olSAwmsAQQF0nXWK/B1nCJr/N6vAfeZAPM8CQSeBHJMBPgbvDeCpGoQKl+73icRT/A7BF6rI8DnIynHcXDA3xKGhtsODAb4PAoDQ7StXmKsFS1JjtIaaOqlt9t/+vqx7UfeTH+x2LnuncqwTe+WD1+955v/qTeDWcxilr5Q5oj80yaY5Rmv11358L6a9Fnbaw6kOqrLkjJrmiyZ1S3QMiXW3ghTtwkk2SLTYMdP2SZy0/ZWuQnHqdAypwMkUprZJFCSEUkzGcSRgr9NAkg01NqIaJ1YCKU1KhLSwO8pDbCNOBtBloRBoBpOhUDjFYHiPkCiFgWSKAFiJ5HiNwlqp7y3tnvka2ixbcCzReKafM4E/L12PWje6t7biZMDCb/DQSUst1XC8pslYnuLRG5rxjXrUZ91kpBVLYlbK5sTt5bWz7BWFtydU/Xp/Gd/yV3+4vd3bnr9yHmZ+38wXanMYhZPLCTNzP1l/7F879GJj20vWH1XXumXifaKsih7TU2kraE5BqRA7UqRgiIVjRTUHGFui5onDM9rAprb5iRJMDH4nARCAk0AOZGgFMGAaLgiHpnrAi7OGEcXRMNM1zRQTQs9HsZnBO4Rv3cyKO3S2eICkiXhek77vai8RtxHI57RODao1xr4zNp9x5LUQfTUbrW/JbTfYx2oOiNQX5G5DTpg+ufqXgGom1ilybZIXBYGjMyG1mRbSe2MrEMFs+y/fPLwtiM5C3YVzFj80peD93zTamqmZjFLb5fl7/78X4+9WDbhvu1HV96Zc/ijGdYjh5Myi2qTMqs005aalA1ECGKIzWlQbkFxgHqPz0k6yiwnlGlO7asBWmK90hY5P0kiMYjUIBGNVEFSIAuSDV8TBhHSvYhQC0MgYg0kH4201RHgoo0BaoK8ritRuoO6D17DBW1zq/rnBjRC7kjYcXh2DXytgffc8V45ePBvoUHjM/V8+FtqvhxIElBXCXa8V88P0uT38VmUE5o96k25WvG5cA/UfmNstZKQWV4/01r0w+3WH/fN2/7LljUvHn0g792Si/Z8U/x/9eY0i1nMcrpL5n75X2v2HQ6ds+3nhTfnlH4Y76g+HGuvrImzVbbEO2BK2mEOKy2RxMh5PxIBOjVXyHNqQSwkRy6caOaumrtsA86BBBLwHZra2uIOV77bSYtERyLtML/I14CaTwShGDDM4M6EZ1zHFTynkd6vw7he579Vf98J/D6nEFzvSZn4ncDvuF7TuJYxIMSTPFEXSkNFfRp1xmfmnKqm3UPbRp1F55BA63GdxrY5ZZr/MRyg7PWtSbbyxpmZxdW3ZR4quCfn2Gezd5a/vvrlqrlb3q8/f+MB+Re9mc1iFrN0VxGR/7ESJvrjuwrvuiv72MupWUVHYKJXx9pqW6n5xHJFm52dWpOuObXPGfLI9/zcQPvnXG12Jai2a3SA9l1CEQvR+e9cYXxufNcNXImu7ZqngN/ztyfCia/nUhedn9WA63f0Oj7+HqnR6lMNdmjBGOziHPXNKVm1FQ846z5b+EJ13urXS2/I/85czTeLWX534Sru4t2HL3ki/6f5d2R9/25q5tGSRGt5czzM7Fh0QK3jmujbAKE6GiQxqwwoqL/V9tNPj2w75Fi2r+CJ7A/LLt4v8s+6OJjFLGbpSln6TtXZi14svfPB3F+em2X96ftU2+HyJHtxU6IDJjhMbJqENDPdd0gTfQstEp2Lds2rwOsqibNVtqZkVlXemll67EFn6dcLd5fmrHqt7PLNb5u7oMxilhMWOrlvfankonnPlGbMyqk8mOIor7RklTZbHDVqUUebx+QOnlYJc4pyqXFvbproS+DiVUR+nYRtr5bwPMYHEJCoSIJVJHlLk8zYWlp3R/aR7x7ZfTh//ksFN5pEahazuBQS56rXqi6f/UzhtrtsR47MsJZXx9jrW6KdLdA2WzX/SpAmV3WpeZJADVcjk0D7PrjiH5nfLNO3Ncl0vI7A4BjlwGf6IpXF1iyJ1qpWWCA1NzsK/nFXbkXe/Ocr7qGjvi5CZjHLmVfmgDiXvlh/3QN5NS+m2ssL4+0VjTFOrpTTORudCOCx3SUHR5Cp5pzegvcdF4NM9F1wOka5c6nXuhuV7gHAFX7NW6BJ4qwNEmOrr0l2Vv50b96x9xe/eHSl9b3i80Tkn3SxMotZ+nchca54seS6h3LK9s7YUl0Uu7WuKSq7ScLyWuUmRjFCR2ojTmgjxrZCbUeP5nfJ/dl0qdFWezt2RhN9D2xvIwCKFrKvDuergRpR/rh0tYI2Go1juJozbWyNtZa2pmQWlD9kL/h08c7idds+qhmTf/Dgv+piZhaz9K9CU33hS4XX3ZP/3d5b7QXHkm2VTfEwz9hx6HtI4mQIOIZ3c92RQ99FOmsnKEATAYFqu2XovmRqoP0CaFvuYtLczxolNhfkyUWl3Cq8B5lyEwC+Q62UO6AilK8p/XgxmG6tabk5s6L8fmfRtytfKtnt/Lj8Urq96WJnFrP07ULiXPZC6fX35FfsS84uK4y1FzfH0aE9p17tWolW8TJBjOg8idQyuRUQ5KhFKeJOGb7v6AxuwG1nNNHHwMFS372Vw00L0EBBktG59S6gnMB8d4JcHQ3q+wzdZywmRlJGbPWSai+puye3+NMFe8qXWQ+U+uoiaBaz9L0yZ//+f163v/ov8/IKtt2dWVSYYK1tpKArgc9DB8hrkKjcWolHB2EwjRRbk8y0t0qSnYTJwBsa1Fynro0a86Ft86IdOqKJvgkuBnJPfSPAINDarqi2baW5TYo8o/O4gwyyAquFO8wY95QRtKbCamFAmGl4zS268Vl1LcnW6mP3ZB/dseD5wykbD4jplG+WvlXox/norsJltzqKjs6wlTclWyn83GutLw7hSJckahyx6DxtWyvRKeIVMdKUO8EiET830PkzE30U1D4JzbOiI3hO0061vfzczYTzgApugu8wrgCngWLU9A9gb5ZIR01tXHbpd3fsKMtNe6Foit3cc28WTy+Zn5b9x+zdR2fdnnfsc4uztJL+m/EgSpX7BwTpvvOYMNG9IPFyLj0qu6k11lZRc4v9yLezdxbkrdlfMMXc2WQWjysMArH8laNRD+f98s4M25GKBEdZayxNMgqyDmqd7oTdhIluB8x5FYHfgQFcj64V7yyvnZlb9N2cfZW2pz9tuEAXXbOYpXfLhrfrRz22/djzt9oOVSXbiloTnLUgy2YJgxCr6O75ALWBzkJuwsRpAqeLkm3VMsNZIwkw/+nhMSWPifWYjK+qclZ+0dtLXix6MO/NI2fpYmwWs/RsWbyr6P/MzS9OmuUo/zIpq7wpyVmn5jKjsiGk3HJJlyRAi3XJeSzT5chEz0ARqKMWJEo/0maJwCB+I3A9F5xy6Zxf1XiL/fDR+TuPvGT7oJxj/B90sTaLWU5vUW5Je0uvf8BZ9NKMreXF8da6Fi78xEFw1VwnXmsO0ZzobwGMhaITLAqZMNHdgPXDzRZEnEOTSWP7L1f2E2AhJUFDTbEWNt2TW/hlxt7i9dmfVplmvVlOb9nwztGzn9hRsGWmrag4PquqOdZKAaXAalCuRRBegiO/CsCr5/7he5NATfQEtMEbVg/ArAPMG5XkqIdWWo8jc1BxIwYGdCDKVtua4KysuG9X6adPvV11h5luxCzdXvLz5Q8Z+wqvvTe/8L0kW3FDrL1eomCmh4MwOborAlXuJYQWwVzLr8M8O1oiNU0D7SjoJkycDpBAlXsTwIGbKadT7LUyw14jyZBdpm7hziYGp+E8fRgHdmu13OYs+CnjxcL1W94qGKqLvlnM8vtK5qfyH3OfrVw+w1r6S7y1upkmeQTIMFwlUGtWREqBVYEf2sAUEO27iZQzvKl9mughUB6Vz7F6DdmD/Bm58ZknXwWjAYGqBINtgHmfVdGaZC8suX/X0bfWvl8+c/fhw/+mdwOzmOXUy7K9h0LuzTn6ckpWeWWMtaE1XAVz4PY5ZnKsEQbCjWZWRm7HJCisBmhCuQiy0lRxNGHi9IODNbeFagM8FzK5Eq9kV7eatFz4ApO+RVJszKEFxQCmfTispcjsqqbUbUVHl7xWlL/94yN+encwi1m6VubkH/zXh16ouG+mveBwQlZJSxzzqEPYVMIxrqpjJI92MmJOvcp0SfKM7UCgmhbAOVESqIHjBd2EidMBzsNzzp2De6tyqqcrnREyTxEotM54KASJ9iZJtjUIs4xyJ1NEnvbdWEctzP6C8se3H31p4xs105k6W+8eZjHLicv6N0p87t1RtjvWWVcZZa1riWEOdN0EV6ToKqRtMM51gq51tv+NCRM9hXbZNOTWFdrCJ4PUcAtxk9oiqraH4jMO9vFQCJJIolsL6+7PLf1m9at1c81o+GY5YVHh5p47PHWW/ZcPLNbShmgIFVcxVWR4RaCuwmnCRD+AWvSE+c7ANZwX1S0mbe6UoRObJNFWBRItljtthT8verbcmvVx1Z/0LmMWs2hl44ED/wLyfGSGo6AoxlHVEkOzXJGn4Xr0K1qmCRN9FScgUK7OR8C8j2a80exGSXHUSXJWRWuKtbLy/vyydza+XznFNOnNokraniNnPZT9w+aZjoLShNwGNf8TrmueUQ4SaYvEcaUdR5KqW0E0YaIvoo1AGxWBGia8it+A14w5GoPzcY5GibU34G+aJd5WUz/LWfr+4hfrUk2f0TO8PL6z5KJbnIXPWOzl5bHOej1hG4RIEaVBltprzZTvJIAmTPRl6AQarzRQzeoyCFTFrYUyQY2U52nSR+ehL6AfJGQ2NNycWf31vF1VG+2fFXvr3cksZ0phXqJHdhWHJeSUfxmWU1czNbellW4eJE7u0OCEuluBM2Giv4E+oiRQzvMronTRQvXXBImUG0Vi7SBSG87ZmlsTs+uL7t1RvmPNR42BetcyS38vq/d88z/n7PxpboqjqHC6s6H1xjwRYjoEhKOrttWNCds6CZoJE/0RIEVt8wfIERaWsUpPVydCueLR8oI5z0j4CXaQJxSMcAbKgUYa5aipvDOv8v0t7zfONLOD9vOy+s0jZ92fd/jZm20FtQm2qtYoCA6di7mdjaOtMk8cjWrHhlthM2GiP4IE2QbNXFfz/a4AgTJPPffWR+U0gUCbJEKtDTRLUmZ18z2O0n88+WblYwdFzMyg/bEsf6XY6+Zt5a/G2isbLNn1GEkbJJEAWTLTpTGJbsz3uBU0Eyb6IdTcvk6e7AecF2VoRroxMfsrQS1V7bZTW5cZ4QkmvwPmv61eZjhrZaa1qHWWveAfafvqFtr+2vrverczS38oi18qGn1H7pH9kfaahun6xDgj1CTb6iQFSIbZzq1sNFWMiXN3gmbCRH+DO8d6EiZX5rVgOCRSjVCj8hoBzd2JW0ETbC2S5GyQJEeFpGRXSEJWuSTba76b+3zlysyDxwbq3c8sfbnMf/XYtGR70XcxWTUNdMlQq4oA53zU6KpG2/YJdCVMJkycyUBf0LLBukLTPJV1Zmis3A6KzzSNlaDvaFNLoqPs2ON7yl7M/br6z3o3NEtfK0yetei5w7ffbD9cFmerlijdRHcrMCZMmOg2xDvrJNF2rP6J54vfyvm0+iq9S5qlrxSSZ9rOkgdv21pckphZI9zPHokRktG43TW4CRMmugu6c769TpK3HKt/fHvRmzkflZsk2lfKxo0H/mXujqMP3ZpVWZK0tUnzW8thnqIGdXTf6CZMmOg2cArA0SpJsPqSt5bUP5h76K1NHxbdoHdRs3hq4Z72J7YffXBGVmFZgrVRou10T2I4L05+NwjjI7ptcBMmTHQb4rgQ69RC5nFxNslaVP/A9sPvbHiv9EYR+R96dzWLJxVqnrO3lT10c2ZFSVxWg9qWGZbXLGH5DRKRWyfR0ECNWJ0mTJg4feBaQxTA/fRctOVCbZK1ov5ee9nba1+qN0nU0wpD0c3LK102c3NVaWJmsxr9wvNBnttrJHxbpUTn1UD7pHO8OQdqwsTpRhuBQhPljiUSaRyswcTN9fUPWKveWf9q2TSTRD2kUPN8NK942cytJSVJWdxFRLNdlPYZnl8L070GjVqvuyq5b3ATJkx0J7juoEfCZ4R7nIsEgXIraEpWVf0dtl/eWvVWYbhJor1cSJ5P5B1blpxVVhrvqJX4XOZzocneotIXRNFkB3EmMK4hGo9zMu4b3IQJE90DWnnNar3BCEqicjExtYhK710tSfZjDbNyC95Z/nqVSaK9VbhgNCfnm4dvth4rjXU2SUwud0pUSWR+hUTm1cOMaFVmQ4INpgOB19ROiTiaFNRG3WiknupIT7OoA9x8RxNeV3DOl0d33zXxu4F2ULKky9Rx8uR6ru210R5GG+mfdwHGRg/OK3YXuiLvbd+hAqKA+yZcvqPBeKYmPCszOuA3AJJoBPpnRF4F+mixxOZWSoytpv727Kp3N79SMMUk0R4uJM/HdxQ9lOgsKY520j2Jcy708wRxcrFI7eFtVZFjSKAWmg9AEkAiJaiRMishhd9o6LbQXXjtSlZ83/lcT6I99SzuD/eswPvGvRIM+BzHfcpqN4ixs4rplBmmjJ4HnRbP8LcnhOv3TLgB61KLnZDgaG2TLQba4PZG1qEhL7F4TxlLwDkmcIuDJRTDIN1qayTA60BTU9/n33VCZzlQ84q4B8bqJKjZKe2u03vXc53R+fu8nnG/rtCSJMIU19/z9+P4DHY8PxCH54jn95Ss8buEpnlGg0CVyyDdmdAPVXhIPG9MNrPYVksU+mgkrh9tr6u/I7/q7dVv1Nykd22znO5CJ/k524seTLaWlkbnNbVyjoUEqoSbjQwYmiaFWkWQ0UFBT+RRf0+B5/eNUV1l3KQLBggpVoeKTENAGChErkLWBhehPx3QOpB2D8zfHQVBJoxOrZ1nplCO+kbHhGCjo0YzKR46ezsB6PWE67pDh++ZcAONMBg3lqSoBmkXeepAoPiMVpAGnUhAPBzgSZxqcFPQZKsDeB03MFa3DTIl+No43/lcB7j5Po9tMu6CaNyXChiC14QyySFPSpb0AZqyRrQRKEkRiMplOmWSKbd5MmldO1h/UfhORB6B33fU19+TV/aO9f0ik0RPd1Hk+WzZgzOspSUWZx0ah65JLqvrEIY2UwrC1hkUTGW68GhACYcmABx1iThcMx6arYZGlTMmAQJkgbAkHAct2ELPwTVKDjuyNlhQI2I4PmVa8fldYAwQrmBddP6eAj4z8StAHSmznXVlyJQOQ87UYERSBTFSa+NmDjqWk0SV9mZH24FIOTdPP0mL0a5KljQwJm1bm/M8wHOJeN8Rruf42oDrdzp/3ixJOtRv69d3hSH3FvQFgsFEInKY8qZRIvOaARJhE0iZGif7jyZnJF+uPZAkVZ/SBxuDQFVUJ/1z9j0LXqdmFtU/kffDO7kfFU7Wu7pZTkdZtPtYUpK9oiTK3qjMVpJoIqCiyFOAgXay0FYCXcGFJRUIlpqm/h2OiEpoKDD2erHYaiUxq0oSNpdJ7MYiid5QIFHrj0rE+iMSsVbHOlcc6hGEA5HrD0vUhqMS89Qx3FuxxG2qFMvWOkmxNkqyDR0EnTMJHVVp2NR6cExgveBZjemJtmkKoF3o23EcYZjoAJIjByzKGutR5VHXZYokSk00ydYqyah/CwkSA5oFbZJI2EBeWQ2SsLVW4p6ulJgnyyBbxWjfAsiVS3ur14f19zxqryNxPnrNYYlVOCQxOMbgqL3XXhvQ3rue6/ja+JtoJc/GbwBrtWMU5D7mqULcZ4kkbS2HfFVDuaiTqPwGiclvFFh/IEEcQaIdCFTVC0iUBKqTqJru0KFlfNCJFSCJpzhqZabtaMMjOw6/u+2bJnPb5+koK54vvO42e2FJvKOx1TBDEjEyJqmwWxjdSRQAiUHbfYRRjiOdAbyneU4znd9h5BiOvonWWol/ulzCVx6S6xd8KVc+9rGMv/sNCbr5RbkkcZdcGLtNzsMfjYpwysjwznAAtp5BhFXOjbTLBZDSi+Lz5C+JOyRgxl4JmbVfJt3/vlw35+8ybfFPErUKQv9kpaRsbZAZthaZgY7LOThN225Hm8B3gjvSMNEOpfHTVEd9ch4xDOQ5PV8jURVcGKR5s7VZbslqQhvUSPzmSolaVyg3Lf5erp7zNxl3/7sSdPvrcmnqXvlT/LNyYcwzaNdcvY07oa39rQqjgPOm2+R8Bb7WoL23tb1v/45x3kDH76trhNlx3Y5yPSoiWy6C3P85/hkZnfycjLv9Zbnigbflyjmfyg3LvpWopwrEkoXB21YDqwzaKohQM/M12YqCcuNKoCTLziRqaKVJGPwTOM2U0whzvqTukefL9lnfKvXVu71ZuqMsebEi+HZ78eFkG0xqCK+a84MAM8IS5480E1YTao5+ETArwkGuNDVoZnCFngsqbLRECHiSrVFinq6QqUt/kokPfiQBqfvkgvB8GXrNFvGauFa8xy4X7+AMGRwEjEmXQUHpMpjvjwPPL5LBIQt7BsFA0AKFQUELZRB/P3SxeF+2Uvyv3CDDr98qF0bkS0DyXrn83g9k+oJ/SMLqQrFsroF2zSkIkimFF5o3jjE4ts95aXBHGibaQZOcAzbnAiNBDJH5dJnTFk7iHfUyI7NGUjaUSkzGj3LtIx9J8G17QZK5MuymLeJ91ToZdNkKGTh2qQwKWYw2XKS1YXCa1rauOFH74+iFI+H6fXfv3X3v+M8gv5Rlynob0sVLP1L+vXGvfugTQyask3MnZ8rFUdtl7M2vyHVPfC5RawokfksVtGxXIiU04uSCGefi1bwv6swgUSLRjkEGWjmVn2kYgKaiv8bZyguf2H54xa63i/6P3v3N8nvK8ldqvGY4Kt6KtTc0kigtnDNygADRACoVh06ehDIfMPpRoCMwokXmNEgcjgnZDWKx10pqZrUkrS+RG+d9KYEzXpaRU7LFZ+KTEOQVMjhgifgEQFACMmRIQJoMC1zYBSwA5vcaho6ZK0MA/6B54jtmvviMWQhhR6eE8A8KXSbDr9kol0Zvl8vufltuXPydWDZVyExHg6RCcC0YjDjyx1PYFXlSWzAJ9GRQuYM4ACly4MDcKIkwZROgkUXBHL5+9mcSggH5/JtsMuSKVTIwZIGcPWYOiG+B+ISgjdBW/kFss7mq/YYRgfOOa1t3GII29g/SETxf/HQY5/y6iLZrAEMwGLuX647nhgcslJEXp8uoS5bK0IuXiG8Ajpc/JedOy5FgaNRTl/8ocZmVkoi+lkhlhTJGQoWMRVHW1KJZR+0zEZ8l2bgQBfKEFn/jNmjy2Y0tt2QVfb94x8/p7/7c+v/pNGCW31I27q/87zvzSl+O2FrTEA6h5ZxlgrNekpzVIMxG5YZBd57OGmikWgVsxHsQp6NOUkiem8skKu0rGT/jRRlx7SZobitkUOBi8QpIhzCkQ0gyZAQB8hwRsEBGQohOjvnAvF7CXBkRNFthODrosKA5MlR1zgXiByL11eENTXXw+OXif/0WDBp7ZOrCLyTpqSKZYa2VZDs0emjjsdBOo6FZua7sm3CPaAzg1Kri0fkT7Y2SnFWj5iWvhrb5l7gd4nvlegxeSzCIpaHuMbAFzEabzJPhoRzw0E5j0F5stzFPyMgxjwM4Bs7p1LbuMXzMPNXGBobocH3dFbheYxhIeYRb2e6IUaMXyIWXLJIL/5Iu512yWEaMhrIRhOcMXiL/jcHa5/rNEnznKxK24h+SvLVCkjnfC3CajHnlo5lbXtdKDZM+HtYgPRloTYbnaloop9kSbTUtd2w59P3KFw7PNXPP/8YyJ//gv97zTInNYi2t58gVgUpWvmO5dRKbW43GqFdmKE165YOnEygntGlOxcFs52iYYq+TxKeK5eoH35eLpmaKbyjMEhCfL0wXEo0fRtehY3SNE8Q5gqPtGIzAENauAdpBL6C9E0CTwXGI0iaopSwQfzyfPzqcH+CP7/rgPE3+gXhm/6s3SPDNL0pYxj8kdWuVpEKLiieB2qBRof5Yh+6IwwTBQRzmKJDgxOAMjf6muV/IX2DSDpm0TrzHwOwF2XhD2/QN5UCG9ghAe1GmYC4PQzsMI2mhzZTmCTIdpki1a3I0lEdcY2g3Qt3PcTJ9PIbjt0dBuRh5KRSM0QCedQgsHe8xsHjQf/4bMjdwbLpcMD1Trrz/A7E8WSmp1iZJsKKe0H+prdOs1/IqAXzN+oS8aa81FzxOK9FjwZJV3XpbVsEPT71Z9pDpaH+KJT9f/nDfsxX3xTqrquNtdcrVg35nkfnNMm1bg4Tl16PCqV3CBLDDHLBDuF0INAYaaDxM9yRbrcSuLZBxd74lvlc9JV4U7OC54gsBJvyCQTK6CewPIVGEAw3OH9/zC8H7rkCZUfh+D8NXIQ2vdUDjIXxBoAQ7r+rA6LiKYPGcPni+wSTScTDvp9pl0sMfS8xTpdCkoCWgHuNJEiaB/gpIoPS3rZNpGwqgcb2l5s19gpaK/+hFsAZgyaBdfIKeEN+Quah7vA9aDOJLR/1j8ApaBNJJw5FthcGb1gLR1p7t7euKts/wXZrc3Qma8b6dZJrvO5/zC5kPssRgDHnyC8H9A774e8LfuE/KGPqR94S1EnjzW+h7JZIKLZTmvPJTVgqQC2gtol5Jnpbsakl01mBggvWIvhwBpSjZWdN8T87hj9a/dOQynRrM0pUyf3fZFIuz4lCYo7FFSzWMDs4GUOHpmgBoTNAw6RdnYcfnKMaRCw1C7SA+G6YVzPaEtUdk/K2viv+kDTIQ5jnnCYeAQP0BRZ4gFmIICJPg/BC/o4QBAnNSKMGGqdwrgABDo2wH32tk6k8YHZTPTI0HJr42V0qzPl3OCV4q3lc9LQE3vyLhKw5LKl24nDCzIMCcE1V1mUvCwICktAQNandJP1tsoibEaR9ql5yfoxsYrRoOJjEwKZXLG14n4LmTrSDPJd/Inyw7ZfCENRiQlmDwzYD1QisGlguJSckWZAya2RB8xs/9dQIl1ECnt5cGd+3rHmzXId0ETUZwXXey3Qk+6B9UQLxCIT+Qe2/2FRz9cU+KjEGcBLVkb2imA8euk0sSX5SY1Uckhf7UUGjU4KOIk2a8NvdOVzAqRxZnrSQBrH/WdRjd8KC5JtpKqx7IO/bM5g9LLtTpwSy/Vua9UjkuMbfmhyh7YwtXhVVnVnBR+wG+Vk65/AxCzqPaheNokGRHvSQ/WSQTZ70mfuNXwZzNkOEBGP2hmR0/Aru+p1DxnHE00Pm96/nehKbNaGg/79pBeJ9KS4YWwdc8PxSdeciYxTIYGDh2uXJXCQcppNprIMAQdtYjyRP1S2HnvHI7gbLeacb2HxLlM4bn00Gc/sAtkmyjLyeeFyQama+5KkWrubkmmT7/KwmYbtVIEHVJAmL9D8HApOTLRcb8eY6fdULn9jpVGO3bHdCu2Vmu3QHPCrIk2v/G9VrGc+MzPLcvV/DHLpOA1Ock9smjkpxTB9lpUFuO1UKSjbu42K/ZBnRD1Pqz1s/Zn3EeoKzFOyrLHnn26KbdBw7/m04TZnFXlu8t/69bso9+GO2oaOZWMnfC3hmsaOV+gw7PeRaa/MmZlXLNYx+L75VPgiQyxG90mgwPTIMp69rgZwYo5Gr1F9BMwIUyjHO+rBcSKI5nhS6TP8Vtk+lL/gFznhsTNE00ilMnHLQ4QLGuWef9kEANDZS7ariwwVgJ1ED5vOHKq4OdvlFuSPteLpyeAy1ek6Wh1PQVYbqv+zMV/gGsE8396azLlkvA7S9LwtZSDE4gUUejWEiYtmbUse6/3ak9joOzoTXFfuzr+S8cvmvjAfkXnS7M4lo2HjjwL/fllKxLspXVxedUQivgqp2byuwEap6REHqa8FwZTYH2OW3pdzIi3AliWCq+IIdhnJtSi0XuG7w/QyNQutAYc2h0S8GAQo0cmrl/yDK1knoONNELYnfI1JU/Q9Pi/DK3+Gkav0Ge7QQKTaFfESi1UD6n5lOs+Rpri5Ykz4TcRpmy/Ec5L2I76mqZMs0N8vQN4Py5SaKu4AA9NAD1g/73R/S9gVdvkElPfIyBqVriMEBbMFgxLkAMCbRTW7gH2sVW3Xir7ciBDW8VJpuLSm7KI89W3WfJqilNgAken42KVgR68k6qTE2YBIwOk4TRLWlzuQTe9rL892Ur5OxgbZWQJqtqVJNA1TkS6IjARdDKM6BJLZEhIAXvkKVyzrhV8qfkFyR6bYHMhDZPPz1tTrR/EyihntEFdKcJgyzGwawPhwn656TdMnjcSvEJ4nymVo8k0WEhXBhyX/dnLEbPh2yxXjIw4MDCGb9M/MPsErb6J0mBGZ/AFXfIj9oI46Yt3IHfj80qb7hv28/v2d8/PE6nDbOwPLGreEyco/LnCHsjyJC+njDFAXcV6Rbo0HQKT7HVytT0r8X3+s3yxxA23iK1aDKEq5/QQLU5qTMLJFBfkKea8G8z4QE6RgemQ9DTUTcYZKCFDg5aLGdPWCPBs16TlKdLoc1D2EGgbfNSqq61+ap+RaAgTOUGB0RB/kiekRiYY3ObJC6rXILueFW8JqwUP5ABB2ND+yT4unOdn+mgfNHxnkqLH/rewOB0+eP45aoeU6xV6KsNwvCT1PCVTJ0E3B7KNuEickLWseonnjnksH5Q8UedPs7s8uQrNV63Zle/Ge5oaJyOCuWKJ+dG1H5jl0o8ISD8sZy3oksTtM/gWa+qEW8wNAOucBoT3WcieRpod4PR3isBp28iTXmAGimJwR+CPjBkifhfu0mun/NXSbXStaRRn/PU6lrb9QVyYb13bou+Cj6THnwlQidQrhYnwgqavOCgDJ38tPhQ20Qd0g+TdWgQqGs9m9AwDNDkiy50XHhKk3M4jXbjVola8SMsRY1AIzAIkxzdtokLSLJhea3K0T7G2dA6I7Ps0OIXKlfmvfvzmb1Ticng7neWb0nIrGuIgGbDSoqCdmNEEupKJ+UkNCf+U+xNErH8Rxk51QbTneSJxoTAE9S8tNXS4xv7TIC2etqxDjidcRyC0sQbZEoS/VPMNolbe1hzQVHWgEaaJFDOE/YrAuWz2LkIySAY0HZo0WRD+9xQKH+J24nBeLFeb/QZnoOjSZwnA+WJG1K0TSkLxCdwgQwev0Im3PWGpNrr1NQb67prGigX8ppkag60Vp7b2th6h63qu9UvVqbqVHJmlsd2Fc1KtlUVM0aiFmKNnbRFaQOGY7y7Cu0AfIdxFVOy6uXqRw7IQJha3A9OIdd26MzTHX3PXALlcysS1V+3QxtcjHoZhu8MhaAPCpgvgyetlkkPvifJtlphHNT+TqCMrcC5dGqeMSDPZFudXPPgARk24UkZoqY5IEchczAwc2umSaC/BiVnIFDunhqhtjvPV7v8BgcskgvCnJL4dBm0e8007wqBaguZjdBYm9SWzwjK39bqxvvzil/J/awmSKeTM6ukvVg5Ljm74qeY7MYWViQ7Jk13Qsu3QhxfmccBws94iwlPV0jgjL1yNrWFEJimIM7hSluYp7QvaqSGCXumoo1IFTSzXgM3D3Br3zwZqRyiF8o5Y5fIcAz3YdBCE7IbUc/00dNWqNu2zrprjz4LDOLORlhADD7TJDGrC+TP07dDg1op5wUuxsAyT7zHzhavUG5IMAn0RKCM+YZw2ogWDclzrpwXMFfO5fZirsxf+aRMTftWkrmARPdDt23RGa2wSLl1u1Gm4/1NJFFoo0lZheUZu47t2nuw/L90Wjkzyrr9x/73Xdllb8c46lsiaLajgtgxVa4ipj6AAHNHUVdIlB05BQ0RveaInBtmVwtH3P+tBV6Yi0bVdhYRhqZ1pkLTOnXy5MJSB+g7lgJnq33b3qjHwZPWyqSHP5KErBoVqowuY0oDJYH2Iw2UWpCKGcuBAp00FZ118iOfiP/4dTJsdIaMvHShjECdeEH79HbZkGDieCj5IoFCprhNdDgGnlGKQDEwM07AuOUqOlgKA9mcgpIUz8AkNOFhIdzEjQ/b2Pfr5HZbcdGqPeVzuP1bp5f+X+bsKp09c0tRNVfjtN0uUNFRSSoNAsxxjUC7ttLL2JYzcY2w9K9l6NXr1F5c7vvmljKNLDTCoBnvrsHPNLiSaGeoOAHBT8CU10wuP2hel0TuUPEEuM2Tpq1qE1oJ/YhAaQGFUQ4xmKfgGVOfLJIxCTuF8V7p+sUBmQsjDCenhZQ7vl5NuELrb2p6aIy2xXU4yJRbiQeHpslfLNslcUuFFuIO2qS7NukMtdMQsscFTcohw1aqcJZQwm7LKf/b1veqz4x0IKterZ58m7WoPNVWDlOwXqKd3IOsz4eQRKHac9FCc5VxX5muYHDbGbZGuf7xT8R3wlLxgQal4mSi8Yy9xmxMmhPm5P+JQVLwgXblFfK4DAWRjgzE+UvSZPikp+SmuX9XK6d06+EWWvcpbfsuFIFyQSNPZAYGioiFX8qIaxkndr74hGrbYGnJcFWZGzLc1Z+JdlB5MRQYXwxC2oDDqbQ5cg5ka/i0rRK9vkBfnHTfJp3BxSO6lvFvmNeJMsg2mwJE2SrrHt1V8Nyzn1edo9NM/yz294v/7/05JX9NzipDh2TgAJAnRpa2HD06gdIPtKvbBS0wKZMza2XiPW/J4LGLoIGSQLWVUpNAuw4l7DDjvWGmDkH9kUCHBaTDbF0mIbe+KpatlZIAAmXgBxVU2E1b9FW0ESg6aLK1Ribe9SZkaQmefYEiUEYmMgm063BHoP5QavxC5srAoLky+Jp1MmXZD7qPsfs26QyNQGlxNkuig2l8NJdHlY+KOZUcvxxb/eLhFUw8qdNN/yuPbPvl0ZSs0trkHHREB+P/aeTJimgnUMZaPAUCxd9YNldJ0C0vySCYB4y0ZGqgpw5N2DkXOlf8A+eCPOfLiKDF4h20VM6fni2Rqw5JErQzLZ1t/yJQzoEyj1Y8tesNRfKXmB3KdUkthoA8CUaAVxsQAHf1Z6IdbjVQTq2hbw6GJnr25Svl6nkHJZFW5qkQKMBAJMn2RuX3HW3XXKEiyBm28pa7HIf/+tQbpeN1uulf5fE9hRcnOwp/iLPXoNLw4I5WFfNPBUpGxbQRKDpofHbXCZRZJ+OfrpBLU55XBDoEWpRJoL8NDOXnq+oJoOsJ8+EEgkgu3yA3zPmbpEA7Y3oUTrt0xf2kLyEmr1WSIHPTFv9Dhl67WbxDF6tA1G2xMZWXAsnBfd2ZcIUmQ64Eyv7nFzhbBoNIz564Qi576COVkbNre+F1AmVfB29wAYoR15gaWkWzB5i33mIvr3pwe8mWfpdPiRFUbs0/9ly0o6aWi0bcLsesmuEwv0mgHUx4fK4RaNcWkaiBxm4skz8l7JKBISRLRtA2CfS3QO2uMeqIu2zGoP6YVC90mVx226uSsonz1txFwrnQ49ui7wLaZy6TDcJ8v+9d8b5slfhwM0YnAmW9mATaFWgESrfBdgLlKvxs8Ubf/O9xSyX4rrdBgl034ckR5AwSKGNekEA5F0rOYHZUppWOym1qSXGUfbNmX+E9Iv1oVT7thcK7EmylVZHZjW1kSahK4WtUAiuClUniPJW91haQccyTJXJh7A6NQOmKw8YyCfS3AaRJgddAQk0TL5DoX8JyJGHNUZhO9RLJFXk3bdFnAXlLwDPFPQXzPX4XzPelms8wSNOPngkkUcgQ64LpX9zWmwkXaASqBYHWCRSa57DAOcpL5qzQJRI063VJtTOAddf6ucEZ5AguJNErRC1Coe3IIXSw5zx2rKO26cG8o59v+7juco19+nhZ+dKR8263HT3CMFYq8DEelmTZGWokAtQCxSnMsZFAozeUyPkx20Gg6PQQeOacMQn01DGUe+IDGTWdke01Vydqor44PwJm/PR5f1cjfxQji7tpiz4LdMIkZ4NMW/KdDLs+U7yCFuO5F6p97/7BczoQKAcYd3VnwgUYeDhn7EqgKrcSNFBfmvAhS2TMza9Kqo0E6qY93EDjCXIDFS4GIeFcPOfkKYuM5apponSJTLaV1C98rmTn/oPH/rdOQ32zzNkv/3zvtsKtybaKBgZQpf+gFoiC/lyaptkOrXJUhRnHLoBuTJHri+TcqHylgQ6BsJsE+tswDOTJ7KRMO8EFFJqtTFHBYCN+QctkErQGS1aVxORTYLs+yHk64iF7jDx1+cMfyqBJa2FmpmMg4bMz/YtOoMoxnFuEzfB1J4ORctmVQLkzcBgzlI6ZL+cEL5bRqS/LjCxmAHDfJp3BNRFC2xfP1XcGfYEJn9uAz+vVZ+SVGFwvzt4gs2zHfly3tzBZp6K+WZ54vmyixVpSFOdobGUI/3grw85xlV1baafZZKy4K7NdjTK6RuqmEt2BBBqxrkhGoVZJoENDuPhhEuhvgSuBqvihII7hqDNGbKJT/V8it0vUk4U6gXKaxX2beBpcpxvcvWauI8uWSrk4+Xk5myl6xyxSz63ySJkEesroTKA8pxHoEzDl58tAEOglyXslhQTapb6u+X8yK0BUbotKsTI9HxpnHgg1rx4DYB0s0XrFKwzSHEkFbWtJ3cN5P+927q/8b52O+laZk/nD/7otp/z5KFt9IxeNVDJ9ByuBjvJcKOJquwZtn7VOoKgwVyE/GbiIpAg0Mg8NQ/MKDQUCHQrT08hUSeI0CfTkIIGqIMsMbYe6UgtySvC5gorPrt0sN6V9DWFtQBtpppMypRSZsv10K6Iz3LRbT4ByxKkGDsjcgkqogCE0+fJa1G4W7m5Jouwt+17Ov3GLDA5KVxHnufOIvovcjqh2arE+VD2ZJvzJoO1q4/QPdyFRA+WUENclmMZ5nngHQQNN2SeJNoZK7Iolo+1ActVAtUUjBn+hAqbFDyaoiNG3PNJZ35roLPllySvlc0Tkn3Ra6jvlse1HIxPtNQWR1BBRCUz4Fp8NdZvCqldKOzpXWNdBAo0CgZ6rCBQNOGYOSEAjUNVwwFBqE/RNMwn0V0ECHQECHQYCVYONmk/W6tMfWqjvZatlIldPt1Ypp/oogAJMMlWxCzyMQNVCJRcWcA8MgMJANZRDJo8Lz2+CBsPO1izJtgaZ8uD7MnLCMgwU3MIK2eEADDPeXT2ZODE4yKi8+MCIgEUycjRDAS4SL6XFz1ay5AtSDZixV+K5u63L/b+dKzoqWcZ5DYzZwAy+jLERkV3XfM/2ko93vFMeoNNS3yhPvfjjoNvtv3wRb6tuVi4GfFA8GB/uVBaIugKTQLsPWqqP9I4EChOWgVkYnoy5k/4c+4zEbyhEvTe6kKdOoLqAK3gsgbYo0296Lu4fBMqUJdyIMTZpt+r8BnESZsDkU4crgY50IdDBoTqBBugEmnqqBNo1xMESoqbKjRHROfWSmHW4cunzhzYd6EvJ6GbnHk1LySqsjcEDTM9nYi6a8JoAd3cUH5NAuw9GriSmYtBM+Lkg0Tk4D/ML5waNgXl/3VaZnv6tcmfSiNNzCdQw4fm6PVkcTUASaIPEgEgT0eGiVh2VC2/aKr4B7RqnSZ6/Db1NoJp2imtyutBRIxZ7ccvt2Yf//vS75RE6PXl2eeqFqovuzCw7ZkEHC9/WINO212PEb1IagIWBkk0C9Vhwn7dK/wxt05gD1ULcQRsLQMcAgQ6eADP+nrcxsldLPEhTi5zleQRqmHmGqacIFOB8qJZtk0kLGyXZ2SDXPv5X8Zu4SvxImjpxmub7b0NvE6ia88Y1LfY6SXYw/1KNxNgq6h/bU7X3mS9aPTuPEtXk2dmVOSmba5v5ENO2Ncr07dUQ2AaVRN9iozuC+wf/rTAJtPtAzZMEytfavnj683FRDvUG7cwXpj3TfVwcv0PtGdeCOjSqOSfm5GebG4RF4lRBl3udQNlBNQuI92MQaDQG9XhnnSRtrZCQW18Wr9DF6rkN090k0N8GTyDQaFgVDFY001ktMfYGmY4BPimn8qen366boVOVZ5Y1L1RNuj2ruiw2q0VFTpmW3wQtFA8BU54EmgAC7e4OZRJo94ErzyRRviaB0pWJLmAk0OGB1M5oxoNkr98oUxZ9q/JQWewgUBBpNAiUvqEqz41OngZp9QaJGuQZA7LsTKCaC1ajJDlrJW7NYbkwIke8dXcbE78PnkGg3O5ZJ6nQPrn2Mi27VcIdtdUP7yzcsfdgq2dGr+d+9wcch19MyqxpjoK5HgZBjVR+WnXQOhtQWa1arqNu7kwmgXYfNALVOoFPiNYRuCOpLcsi6tIHmtngcUtl0r3vyoysBkkyCDS7GeR5PIESvaeFnohA0WkhkzNAoDfN+1z8r9ogXuYe926Bp8yBJuLa3DOv4obiXGR2kyRbDx/ZsL/kAZ2yPKukP19y3czMYxWxtgalfarET7h5OspbACW8p6EzmQTafTDCtZE0vUGgXqF4DQwPXiQjAhbICKWFgkCD0+QvCbsl4ckKSbHBjIeg0h+UBKpSArNt0NZctFEE2qnNegr0T43J5fwsXVs0Ao0GlAbqrJfkrAqZcOerakDwMQm0W9DbBEo/UPqZM65wHJQ2yqHancRB1FrW9ODOgrd2fFbjrdOWZxRqn3fnle6xOCpaItGRIvIhpLhpmu3JNo4GEFg18msjhLsH/60wCbT7QPLkAhIJlORJcEvncBDmSJDnyID50EIZdBnfv8EqU9J/klTmqlHzn55IoHTyB4GiU5E8eU8MXBNNr5Dseoled0guiszGgLAIcnJ8fZg4dfQ2gaqAy05N8yQHsd3JP3F2yAEjONmPFa97p/Rhnbo8oyzeUz05yVpVHuusQyfS5j9pKnHVPYmJ4ug+gopSuY/cPPTvgUmg3QfWGUECpQlP+PIznBuB40gcuTPJh1rohLVyxQMfg0DrVRZL7u6JRrtzoDS0PUVaeO+u3XoCJFD6qiofZNwLCV2ly4YcMq7p9YsOiv8168XbXDDqNngCgVr0YO2MIaoI1NYCLuI2TxCrtbTpwWcOv5F/oNRXp6/eLdQ+79le9Xycrb6ZlaHNQWgPwxX3eHYgwPV8d8Ik0NMDdgQD2lZYxnTUXtPFyStkiQQlPy+JW0okLrcRwkqiotWhZVel2xqFmIOmu3brCTDHuwo4AXOO95Rk00kUJny8vVrG3/+6yqM1LGCeDDdN+G7BrxJo6OknUG7UUSHyyDk6OGgyaEm8swFyUCkzbccKl71W+ahOYb1bMp4ruTrVVlGmgoG4e6DTDJNAex6qk6BTjLpxi0Su/lEsee0Ealgd3DRBd5JeJVD8fmQuNA90KldriKk7ojYXywUJ+eIdukiGj54LmTFlozvwqwTaAxooCbRzYCLOezMSHF3ukh01kpxV1PjArtL92Z8X9G4Suv375Z/v21boSMiqbOruLZpdhUmgPQ/Wq09Qugy6bKVc88QBSc6pl1gQFS0OY8METWa1iKNbJe7a7nSD5E2fT8omiZMEmoT7YuqOG5d9J943bBQvyMxImPDcLODuWU2cGnqfQI3NHdrAqUjUIFAHE9LVSYqtQmbaj/2w9uVDFp3Keqcs21d0abKj5BAqotUk0DMLvqjXs4PREWY8LwlbyiQJZEkC1XL7o23wWpvS6T0NlL/NOXnKJok9EZ0oGeZdKjru+Afek3MuZ+oOECieh7nL3T2niVND7xMo5VDbZcbXSg4VgUIu7c2Qg0YMpCDRrJKqR3O/3bz7wOF/0+ms58t9zxxzRlormnszuK5JoL0DX9TlIK7OT82SqJU/SypGfs49tc07GXDTZj0H3A8IVMtlr8WhTXY2SfKWCvmzZZecM05L3cEFMm1+18TvRa8TKDTPWAZZVoGWqYnqJKpW4mGJgFSpiSbbqlruyv7xy6yPSlJ1OuvZsmF/1YUzHaVl0+z1Kjp0b5lpJoH2Dpiage5M/lesk+sf/0RuxsgeDyGlC5PhhcGRv7dX4rX0Dy0SxeDduc2S6qyX6OU/yogbs2TgmAzIC2Ogaotk7p7TxKnhRATqBQL164FFJOW65kqg1Egph7plxEVtvrZgME3NPNyYvqdw77s/98LupLnPlC61WKsbwjDCM6GTSaBnElCPjDiOo8/4ZRI6c6+kbK5UIztdRygPKoMiBLc3/UAJrsDHQkajlTZSL8n2arn2kY/Ef9I68WHw6MA0tQJvEmj3oLc1UG3O3cX/N1vbhcZVeDWYEyRRTuvYKuXO7MJ/2N6vnKLTWs+U5XvL/+sue+m3sZnQPtFZwF1uH6YnYBJobwAaW8g81C86Q/AiueAmu8StPCqJICvKA9MtkEh7lUAhF0wXEQdSj8lm8GdqJXVi2VomY5KfF68xi0GeINAAbfMA4526f1YTp4LeJ1AuHmoLiIYFRPI0CFStyvNzyCljhyZZyyoWvVi8ESL7B53eTn+Zs7tgyi2Z1aVxWYz6DMaHCe/uYXoCJoH2BkCgwajjoDniF7hQhk3aIDc8flAs9iaVWnYaCRRHmkxcvHHXbqcdkAuaa9zWFwVzLYIEml8vYWt+lHOn2MT7Um5PzUCHpnyQQE3Z6A54DoHivQuBar6hml8yZVMlpsN34uw1LQ/mHfl824dlF+v0dnrLnP37//nenMO7k7bWNhpOyVHKbaDjg/QUTALteTBP0BCm+giaJ0NGL4QWulLGznxN4rbWqFQKU/O1vDW9SqAAOw+D2HAeNIKuVjk1MukJmO9XrJchIM+Ro9NkpMr/xGcyZaM70OsECj5oW8jUCZTkyYGUJj03VzDgTXhuq0wDOE96u72g+MlXji2Y0xO5kxbuLw6akVtyNBLaBm+STskx3Ovu5mF6AiaB9jwU2aikYfNlGEhoyOil8uepeRKzpkDi85g1kRofLBMILQXYXbv1CEDe8XbNVIvOrpc4K8z3W/eI79gl6NxpMmo0ZALPoTo8ZcfNs5o4NZyIQHtqEUktWHaCcq+D9snf0raUgzNApBGwSKJzGiUlq7b+kbzK53ok4PL9zxzdFOOsaKCpxuAgbbneXR+iB2ESaM+DGSr9Qvg6DR0iXYZdukRGTHxKbppzUJKyGyUqr0kiVcI2jvq9JxuKQKkBg8iZEjdi/SG5INymZILkOTJwnjAF7+CxjH16/HOaOHX0tgbaVXChKTKvUiI5sGY2y8ytNT8+/V7D6Q24vOGt8qE324/8HO2oVSZaBP3+6F/FjuLmJnsCJoH2PDhf6I+6HhGSLsNHL0KnWCreQSsk9LbXxGKtklgQaLTaQkkCdd9uPYEYkidhb1EReiYvPCg+V61TqTtGgTy5A4kBoweHgkBNDbRb0FcIlFOPEfm1Ep5Tp2QkaUt1TdoLxbaDx+R/63TX/WXBrqNJKdaSyjiqv7iJcDsJtFmZSO5v8vTDJNCeh8qXhOPwYGifJNDAJSDQ5XJhxDaJWHNYEqCFaq4kkI9e1EC5hS8GMhpnbxZLVo0E371fBl62TBHoCBDoCJ1AvUGgpgnfPeg7BNoq4XkNMg0mPMPeJVqrm++x/fih9b0j5+l0172F+97vzS3ak2itaebcZyShdp7Q38pcRDrTQC1U5VAak466XgwNbpn4Xr1Rrp8HM97GLAQkUS7gcN7JfduddlD7dTCQCDTiDYUyCqP+OaEZepoS5nqar6YjaL6b8UC7B33HhOdKfIuE5YNIISeM1HRz1i+HV7106D4R+R867XVfmf/s0QtuySr+Kd7WpBibBMrgtDHcd2oS6JkHOp8rB3SuYqeLT1CGDBq3Qibc+YakbKkSi4pSrxGou3brEeC34xwtIPQGuXHhVzDfn1TbT0maQ4PmAdBA8ZrxT00C7R6ciEB7bBGpiyCBKnemfFGud2oxyV5c88T2Xxz7D54GM/7BbccWWLIqaziqkzy500S5CnDvqcLxN9kTMAm0d0Dt08if5AtS8g5eBHJaLJdEbZfEtcck2dms/C/VQmNvAQQan90iiZnVMv6ONxTBe5NAg7Vso1xAUj6tphN9t6HPaKDgDYa5o7dIeH6zROY3SIKzovVuZ8Hfre9UX6/TXvcU5+fl/3mbveCbGEet8qHiLhPlqKoWj4je0zJMAu0dMP0x88hTc/PhIgw6jBc6yoirNkrE/K9kJjQ/TvFQXty1W8+gRSwY3BM2lspFEdvU3ndfkj63oYagQysC5bMsgmy4f04Tp4Y+MwcK3uCeeCZDVItJ2+pwvllmZpZVLtldshZmfPf5hC7Zd+yqJHthcSTU3DCovMrHT62w9u4qK2ESaO9gRICWQ57mMBdhSKAMcecbslyuuv1tSc2sV+Z7bxMog+hOW/q9DJu8RbxwzyrnO7RPH9WhQaCcx8VzmFpo96AvESizJ3CuPmJbpYRtr1a7lBK31jY+mlvyyidHWs/S6e/3l8fyflqS4ChtCMuj9z7nDmCyq8WjFqUKa6Z878Ak0F4AyGY4OscwgDmTvEM1jY5+ob6Bi2V01E6JXV+i5kAjgNOxiMRrGjjuc8qjAkPs1cn4Bz4Q74nrxJf3rGugJFAfRaB8FpNAuwt9hUDpXM80LxZnvUTll0nYtipY1q2SZG2Wu7KKvst+vyRap7/fV5xvlf/nXZk/fp3oqG7hfJba+w5NNC4bKi8IVFtIcn+TPQGTQHsBinTSZSg6gpaAbp74hczFZyBSmMMjr90sUzK+lXgMskwhTCLVOsrJ4L6NO0PtJNGhppIMKNLUOge38TE6lGVLmVwUv0sGha4AgabLcHRmygHnQKmJ8p6HQjb4TG6ftQdA0umMts95X65w/cwDwXs/4SKSp2mgjFKf3SDReZUSDjOegz23faZmlpcv3Ve0plvM+CV7Dl81a8ux0uSsJk3ltTO3SB1+uAaC2qQItIMQ9zBMAu0ljElH/WoEqogoeI4MIymh3n0mrJTL7ntHLLZqtBGjgxtz5SfDyTuTWj0FwvMwmAOui1QqeAgB8uQOpFQQaOzy72XI9ZtkUPASPXwd/VYZgZ7znxrx+4bOVVMRbp+zB6DklKmVVXplejUswnkdY0D4Ojjd4O7vPQknIlCPM+H5uyr9B+UTWmhukxZZDp/FWWuaHt5e9t6LX9aP0mnwt5fHnzm0+JbM0gZLlpZXhsEZEqB9mgR6hsMNgQ5XGt0CGRSyGFrfDoneWKhGeM1Lwx1hdkbXCJSkSRcUwiDQOEAFywV5qgg8eJ3qaJJrH/5ABk9cJWfjfn3GZIjfaMgCCFRLIgcCBXl6EoF2IE8dJoGeDrgSaKPaOUcC5QahWHuj3OEoLrK9V/aQToO/rWyA+X5n9qEvZzhrJNaGC0MwmbCeE/Mk0TYCBdzf5OmHSaC9g6HuNNAgmvELZSA6jO91m2TKsm8lkXuNu5FACZKou4GbJGqY8Al4nbClSkYn7ZZzQpfIQNyvXzAINIAEukCGQz5ovvtxNZ7mZa/KRpoiGXfk2REmgXYr6CfMtRxFoE2aSxOtF2eL3JxZULPi+UNWbiDS6fDUS9orpeNSHIXFFs5l4cKRAOc7mbw+wdmgfOzMRaQzE/QDZac2CNSfjumBIFKQ02CcP2fCKpnw8LuSYKvSt/p2BV3oTGhvRtZhABsV6Ynyh/MG4qBFqNgMziaZuuqQDL9pqwwMXSxewSBQEP4Qul+N0TYBMKKUH0B3pl51pEddGlqmpmm2k2abaa/Me5NAuxXkLchKHKwkpgGJhAxSA6Ulk7q1sGlO/o+v7fhr1dk6HZ56eWBb8aPxjop6uiypve8GgTpaVE4RMrUiUNeb6mH0RwJVwTpc4O47vQ2NQGl6agSkCBR1PCRgPkzlNGh9i+WS5J0S83QhBFTTQGPU0UBn8iS6RqCUuwSDQCmTOE+NVBEorhFP08xRJ1fM/qv4XL5GvEIyxAcE6st7hvmudlAB3IXkq+6fsuL+OXsEbgjU36hfQLmH6a/d/r0Hoc8QKOUF0OQO95HL0Hb6xg+cT8qqkHvtP31j/6AwQqfDUytUXWdll74SY69rYuQlbndiBGcGaFC5vx1arhElvMZN9QL6G4F2Jk/PJlBqnwYBaXU8nIszICev0HRof0/LlOXfSrzKR9Qs0dAKtUyJjCXrjkS7QqBacFxm2FRhFHXiVIN4Lq6B8xZ6iVgrZfSt+8Rr3FJFnlycIZRmp0hK6+zUPHt7G+dQ1CWd+Ye7kCgJlPDBfSoCbdNC3V/DU9BXCNQYdFXqj1zIS24tzjVKFL2McD7R3iC3ZR46svKlgsd+0974NfuODknNLv8JQt/K1U5uuieRau4hJFBqohp5mgTafSBh+jFKkAt5Dg32PM2DZjCPNOEZyYgdm3U+EueZpM03JE0GT1wqlz0CM16txGN0dzRBULuDQGn9aARKYW+bD83lZ42SDJMsfN0hGRHuUNrncSvbCpx3bEfn5+tJcDAaobwD6Keqa6G4R9apD+5NkefYDPEP5bO4v4anoO8RKN+TQGuUGa/FbwDH2ZslJbO4+tEdx+z5B4+d+t74ec8evT3RWlnJcGSRGNnD85iYi4FpW5UDKsGtUMoXj8Sq31hPoz9roHxP8uwrBMrV7XOpTcGMZ9qPgehEf0p9VqIYI1TXQEmcxvE3Eaj6jqbR8rVakScgB3yfiGvPcNTKtfM/k0FXrxNv3E/HbZqdidSA63d6FopAQTaKRF01UNwXtU4v1PWoK1fLqMtXmgTaTSCBKu5S7xtgJUFGc+tAoszginOM4pVV2XyH89hHuZ9U/1mnxa6XB/IKtiVl1TRxlI+GihuZj4vjhxJgPiXZQKAACZTC25vb9frfHGhHsnQlUwqn62e9iWG4JxITCVSFg8NxON6PClgoI0ZrC0pewXPFb3qWTF5zVBHmr5PnqREo0xRHQeNUgb0ByiGFnkFMkreUSdAdL8s54xn7UyN73qtGpNTsNGhaabo65+4ZewrDAnUCBYaT8EmeGIz8OfUAAvUJXSShULX/fMNTaueXu2t4ClwJlM/TRqD0diCBom+SQANneAaBEnHkNRAotVDOg6pIc7C0LdZ6mWktPrr+9dLbdFrsWtn0bvl/3Wor/gYXaOWKJ1Xb6DxutieBNouFW6BcNVDA3U32BPoTgSqCDIEZN36pDAtdjHPsSDTnqdFpn3sKiZJAeVQaKAiU9zUMoPY5MhDkSgJFW5wFzemyuQclzo7Oorw5GkGgBlkC6vWpEShzfkdhUKdFRPkjgXIQZw6mFIbRW/OLnB/hlEEhIMdOBGrIhB+0ek8hUJruI9TOLtyHIlDcK+qR7e/Nz69aIzfct1/+dOMm8dXr3VNBOVBxEYIX6M+lEag3CNQfBDoMfdNnDAgUGmgCZaKXCZTcFQcTPj6nBsc6mO8tGoHifAIG+2R7Zc3SF4vtBw8e/FedHk9eFr5UEWSx1xbEtiWL45Fmky7kYOfOLiSdb7Cn0J8IlLt4fEGcF92UKeddtQH3z2DFvH8SFYUSRzyPtjvFM8x6dhialQaxs941TQ/3SzN+7GIZc8s+SdpaDoHEQMy5ULSbWgGFDHFBSFulN+Tr+DZ2hZqjAnlGq/kqzoNq1+I16YbCvc1T0/4uI65c1+E+T4zerUfW1UiVXnkJSCYDpi7PzZdzocVzMBqEAfXcSLuEL/ibnH+TTXk4uLuOJ0HLWEBwKkIjUG5aGB40G8e5Mgia9WhooMk2ukL2DoES7dwFuVP+oNq0EMlTned8u72u5fGdVR/s/6bGW6fHk5dHni27L8ZWX8sVd3c/7EnoXwSK0XvsEglO2CljovJx74uh1YFE8RmjqNMsUnNgSkvx/I7Ee/XC/Y+akgmt8GdJBLmRQKPzNNIj+XFO/VQJNIoWERAHa0ilTcZ1DAKNt9fIhHvfkCEYiLTtmu7vzVOgCHR0hgwLWAbyXCwDx1Fe58n5ARqBnjM2XcbcvldiV/wk505xqEUld9fxLLCfUVYZbEYj0GFMoTJmNl7PlbNhGZBAU6y9S6BdAgb4u3Iqvt3x16pJOj2evNyV+0teTFZtEzVMtxf1IPQ3AvUeu1Qm3fKSXHP7fvEfvwKaZ7o6ryKnA0rTI3n2CU0EzxO8SG2lnDznU0ly0lUERNmBQHHk/OhvIFC6LPHvDV9Q/n3UphL5U/w2mL5pIKW+QaAjoIEOC1yqEehYDo4L5LwAtPXo+eJ1xSq5fsFfxbLuiJx7kx0aaO9ON3QN/YdAOd0001r089OvlNyi0+OvF27fvNV+6JtoW12rSaA9C6WxhS6VK0Ge0fMOyrnXbVZBir3xLPzMcADndw2T2ZPBe/RFZzkHWnXQrfskIbNc4kCUiux08lQE2EagXelM2hwoFzQV4eoESjLmnNUNi78Rv+ueVnOHfUEDJYYrAl0MAk2XQWPZxgtkFAjUO3CBjIywSdyGXyRhDQj0xr5DoNqA3/cJlNuDkzKLKhY9e2TdfunCts7Ve38MSbUfKY501OujumejPxLo5Xe8ISkrf5YAy061o4dpKLgYQv9KugoZ3+38954IOoEPDM6Q88IcaKfDysmdZtHxBKrNP7lr447gdwyTH685yAOcS0201smE+9+TgRNW4HfR1n2EQIcFck47HW3PsG/aIMmA1YNDMiTg9hcl1VEuMat+kfNvdJoE2gtIzCxvfDT/8Av7v6r8b50mT1zm7jp8V6K9qDoSI3xML7ondRX9jUAHhyyTiXe8JbdsLJFJ978l50xaiXPaotFIuggB/K7he9n5Gp4ILnz4XLlerp37mVgcdWrust18p0ZJ3zstDbK7Nj4O7HQwrdSCEt5zOoBbiy1Pl8kllt1yDp3nQzjokEA9u80JegnQ79ML7exDslGLhOniPWm1XDH/E0nNq5XYNUf7PoEG9U0CTbDVNN+ZU/S688Dhc3WaPHF5IL9we5y1vDmSk/1uLuZp6H8EulzG3w4CzaySKYu/FJ+bnpaBMO3obH3epQtl1GgmQes7qXhVO4AgBo1fKgGz9kl8ZgWIs6mNQDVPDjrEG4GXj2/jDsD3+bc8qoUjui/h75IdjRKx5HsZeWOWDA4GyaB+hqicR55PoNq+fPpPcs87ySZd/GHSjwqzy5R1P0oSfbDXFMgF14NA6erU6e89D/1LA42xN7SmOsu/WPF60Q06Tbovzs/lP2+3l34TDS0hPK9Z7Qt1d0FPQr8z4ceukrGz3pGbrdA6NhbIuUnb5eyxi/FMi+SCSxaCRPkMC5SzMn0w3V3Hk8COMxz3O4h748PtErnhKLTFRmFAGoNAuR+ZPp1dJVBNc9UINDyXf9MsybZauebBD8V3whp02jQVcX6Iik/q/r48C2jLkPlqUCTZcE7Ud8wyGXPrSxJlK5WEbfUStfqo/OmmXJzvGwSqnqmfEGi0sxX3WVU0d++hOXN+LUr9hrfrR83MqjgWnd0kEdvor2cSaE9CEei41RI6611JBYEmOiol5ME3ZOCE5TJsdJpcdPFCuQAEyufwCtX8Qt1dx5MwMnC+jFL3u0gGXgUzPu1LmPENkuBCoCRObhc+JQIFSKCM0RCDwT5uU6kEp7wo3kFL1O/6oaP6BWvxST0felxSDIrMsz/80iUy4rINcs3sT/Fs1RIDAo1eVSB/uSlP/GDau7+GJ0HrZ/2FQNVuS2dN1cO7f87c9faX/0eny+NLxotl01Kyquq4/z0Cgtmbe9y7iv6ogYaAQBMzayQxp0auX/GVDL1howwFgf5JJ1AKaJ8hULTDSHQen+A0+eOEFRJ0z5sSn1UDLZSBP7T5Sw7UGoG6b+MOwPfp+8m/VQSahw6Y1yTTV/0k591oE+/RjPlJ7YcE2jc0UGrLvkwtEszpmXQZdskSufimbIla+7NEb6uVqPx6mPBF8ucboIH2EROeRxInfZl55M40Yw70HINAe9mRviugTHKaKMJW3XTvjkNvbP/wp6E6XR5fnni2+NEEW2UjTaoITuybJnyPgv6enAMdO+tNSQTJxOfWS/iWY3JB4g7h9rcLLk2T80GknA/1YYQeN9fwNDC83YiAeeIPUhsUskQuiNkmMRsKJVE5zzN3PBeQuBgETbIr8kYNlATKdsf3OVeflNMg1zx2QIZctkaGXIrOGgCNDtonM4V6ursX788vFOZ7MHfpzBd/tK9v4DIJmfmKxNsqYAk2QAttlLjVxXIRCNTT50A11zVteolbU+meRQL1xSAxFM84FH2TmysCQKAMGcf4rW7b2YPAtaBwW73Myiv9yv5h6Y06XR5f7ttWaI21VzYxSAPVVoZ1cndBT0J/I1Cv0CUy7vbXJNFWpWIQRGXXStD978jgccuF6XfPQwcbPiYDWguAZ3N3HU/CUBAozfhhAdCYqV1d+7TctPALaJG1EMxGDNQMMoJOBI1Ura67aeMOoExy9xHjMHAlPrtBkqyVMnbmi6iPJTJyNMPC0SSeq2UL9fA21wgU9xr8uAynKY9B0m/Cerlqzudqs0BYPsgzp0niQaAX9hECVXvhQ+gx0h5M5LisnCDQhF4MJtJlUN7IMdYmmWGv+mHt/ooknS47Fvv7xf93luPoZ7GO6lYVHgww/UB7FsZOpNBZrzKUlgr0Gr+tWa5b/C2IZ6NKiDYSJDo8EOTZtsfY/bU8BcNQ5yNAaEzi5h+UIV7jV8r4u16HGV8B+WqU6DxooCDPGDvak8Lqpo07Iwbfj7JRY22RhOxGtP9huTA8G3WSobl6oe1pvjPve1/QQH1D5gDQQCGjfgEZcv4Up4StPoy6aVKLuczbQw30ghtz+gSBatGYuMffc8PZdRmUSU41Qd4SMytK016oyHCb7njre4UjbrYdPmLBqMdoJFp8Rc9Hv9NAxy4Bgb6iCFQLPgwtbUOBXJLwjKbBQSiHgUCHBDFaU18gUG4AAIGiPYbCdDsHJHpR7DaJ3VSsAi2rvfHUPh0ABNVdGx8HfD/a3iLxOS2S7KiXyXP+Kv5XbVALLCOYcZNtHzxfzSn2BQKltuwXChJFPflAiw5O2SeWLZUg0GZFoMyvTwI9/8Zsj/cD7a8ESq+PeGtl4+xnSp75/Cf5T50228ua146FptoKiuPyMKLjD5lEjhP8bi/qQehvi0iDxy2RsXe8JpZMECjNWyfMt61VMvG+t8TvshXK4XoI55b6CIEOVW0yT+2iGhqYJoNAAP7Xb5KbFn+tMnbGMK0sTXc9KIi7Nj4OulAnOpslaWulhN76MjTb5SBQ1At+h1Bh9gBPJ1AFTjVAC/XhPU9YK5Mf+0yS7A3KtSsylwkcMZCuKZLzbjIJtMcBWdO2CXPuvbbpgbxjL73xY/UgnTbbS9oLh+9KshVVRdMkwkNxd0iXJvV7Gf2NQAeNWyyhd8GEB4EybQW3PSY5GmXKoi9k6LVPqsUjBhLhPChdXtxdx5PgjzbxC5qvTPmhMOPpKD5oIsz4+9+SRHs1tKsGsUDW4uxd00A5raTm5iGbySCWhPUFclFEtkrdwYhVzLSpfhe/0xemOBSCSaDzZHBwmgy7fqtErPhFktAHIwFuMEhE+8euKZBzp9g9PhrTiQhUzYGG9kECBRj3OB7ymWCva53lLPqr/aOyS3TabC9zdx3dYbGXNEWh07LR6JxsEmjPgtHGzwGBhtz1iiRlVonFAWIBqSRloz02HJULY/O0IMEQyOEwV4d6eGciGMeUYHsM5z5+kP+g0Az5U/x2idtYqJzqE7KbIaRdJ9AonUBn2BslfMGXMvzqJ1W8ABKoIlH126ynvuAzSdKZJ0NCFyj3nkuSn5e4TeUSTwLFc3KelwMot3KeO5XBRPomgfZlDVT5Hds4ldIoMxylRzM/qLhTp8328uC2X96OsZe2aqMeJ+iZesEk0J6ERqAZEgwCTYbZnoRRjy47FrQH50RD731NBo5fgudKlxEkUJiq7q7jKWBnohnNzsS652ISI9l7kfiv2yRTl3wrKRiw4+3AqRAo6oO531Mza+TKO94Q/3FM3UHyhJajcryjzQMXK/R2wOSugPE/fcfME6+JK+Tqxz+VBBvnhkUiWR+wQJJJNGsPy8hpVhWmz901PAX9kUAtaId4ewsG7max2MpKnn6/Jr1Dps78A6X/7/bsHz+PcpS3Mv8750A592YSaM+CBHp2G4FWtxEonY2Tsuvl+sV/F79r1ykzeHggOhKe0d11PAXsTJzX80ZnonM13ZlIomqqYsJKmfjQ+5ICLTLeRhMe7dlFAqWHSBysJMtTJTI6ahs6JOoCbe4fzNXsdgKlD2LfIND54gViGXb9Rglf9bMk0I2QztuQ7TgSqL1BYkwC7R2g73HTR5IDlnku5bS6ZOnrZSTQP+j0OWDA6jePnDXT+tPfIp1Vrcz9TufmOBAoR3m3F/Ug9DcCPWt8ugTd9bKkgECTbZx3wXOiPRKYxmLjYflzfC6+x8yXeK4+oIGSPBmijQQ6KmCewlCcZ6qPi5J2S8zT5dC40IlOgUAjVKdrlimLvpVzr90sfpfSTWquDEEH9WFHZZsHLgGBclun5xMo54d9MLAEJO2UhC1lEgMCDc/TCJQxA1IxyMSsPSQjpmepOKfuruEpOCmBop1IoMyJ1GcIFOTJBUu2S3R2TemcF4qX5LvmSFr+eslFqfbCH2IctRJFFxF0WMZoZDBRtxf1IPQ/Ez5dgu98SRJhsifAbOAEdgz3jec0gWjKZdw9r4nv2CV4RrozkUQ1tKX56IxeJhDmh/cBGJ2HO5JGBs4BYcyXgehUfjdslSlLfpBEmvAkT7SlO9AbhMRpgLuW4qGVTbjnPfEbv0qGjMZ1YQIPhQbaZsIHgECB3nx+DnDtgxxljzLpAkaL4hwxZNVn3GK58tH3tLQnUFyULzafH30xCUQTve6QjJyeKT6dfsMT4YNn4tQN45yO0AmUSeU4wA0fMxeDgJaVkzERGM7QXb/2JMSx/6EvqrCLjqqqB54pstr2Hf13nT4HDJj/as20REd1hcXepNiWjaZ2InW6kCeiPxGotpVzsYTe8YrE2SpgMjSpFWeSKNNJJzjr5JpFX8iQq59SJupwjPAkUuYSZwxJLY5kR/S+qxO9BtIBvube9DkguvnKFPWeuFouf+ADSbLVK5NcTRnxeUGmBqiVGgRKeSQsIJj4J0vk0oTncB0QJa49IghtDgJVIezwnhGNiN4kUMOlihq3IlCSZRtA9NxqiuNgyuqNm+WGld9BpmFpQIlRcQIAxghgNtzodYflvCkgUFWPng1tgODRfVK5gX1oLzwRQyUGbRHFdrCXNd+zrfzdvQfrhuv0OWDAvFdr749z1jSonO8Omu7NKlWsSaA9C+VIDwIdCwKNBYGG5zWp/d4MnpHA+VC0S9j6I3JRdL74By7FCJ+uyNNAZ/I04O63egrqHnCf1IZJGirMHDoT24bR9xkAOW5zOYhSn3NHe7qDQaJ8nYLvTs/4h4y8IUu8xoAoca0Raq+1RqDU+pgmeDh/18099SQ08nQByNMVJNNBIJiLk5+ViK3FEpXPnVlctMCz4hgBAuWWThLo+TdlefwqvAatn/WLaEyUOw5muM+o3Dq0TXnr3XnlXzz/ZW2ITp8DBjzyQtncOGdtg0qLYBJor+F4AuVeeBAoGtACAuWcdLy1Usbd8TpMpOV4Vq7Eu9c8XeHut3oK6h46Eahy20G7DAqChnhDpkxf+TPasQnCemICJUig3BGSCs3lygc/lMGXrYFJC6LEtYbxmq4EysGllwmUWhgXzDRtzDhPGWwHtTWfccvliofeA5nUSGSeTqA2PLNOoIyJEGMSaO+AckcCzaFfbi2ItKL19tyyL7Z/Xj9Zp88BA+7eUbAhxlnXQJMpUcVpNE343kBnAo1Qu8JoutOE11zLaMbfOP8LGXnFRnyfxEQT+Xh4DoGi/nEPJBC1tZIkSg0U5wfj/gdOXCuXP3IAlk+d2prp2rZK4yR0AiV5WtDhLJvKJSBlD0zBZWhfTQMdOobmMEPYaXmQ1NQG0Pl+egrqeUO0zAGcDzSIlNMLrnOjbPPzJm+SsCXfSTyIMpyEyWcEgXLqRoX50zXQ86ZY+wyB8ln7C4FqgzcJlHniqltvtpd+ueXdyqkae6Lcur0gPyK7roEjnua83aJcmUwC7Vm0EejtryoCjQSBckHBiH8ZyT3RORC69YVyccR28QZ5UEjVXBOgzXd6MIGCUJRTPc1XtAsXE84JXSZ/Sdot8ZtK0JbNusByJ5xGoIbZzsGddZCEgSRy5S8yaqpVBgcvxrOmywhci+2r4mqCQElWXGBTrl4u99KT4D14hy4A+NztBKrqA/flT+C+SYhB8bskeVOZxOU2yvRcLTYACZQubAaBRq3vBwTaF3Mi6QRKb4EImPCxsBJSbSU/rn2rcqYizzn5B/811Xnk+TBHXSPnmTgPahJo70ARaOhSGXfna2oRKRImfDRIJYFO5hjY2JmicholOatGLrvtDfHBd7m1zw8C6cf4oNzm6XEEqi2kaASqaWNDVZZREkgG2myJDJ2aKRGrfpRkhm3jSqcTJIKBI4q74VTKDkZdAqnYmyXV0STXPfGp+F25VrxBQsPwvEMDOCWgBQ9hKDWSFYmKcVPd3VNPgPfAoNckUQ4cfH71zAGQQdy3bwAQnKHacPJ978tMW71Egzyn56PfQaY1AuW8W7Oo+BTrjoBAbSaB9gK4iMRBnQQak1svSdbSytWvVa9QvqCb3y76PzOyCz8NdzS0aKt/JoH2FtoJ9HV9FZ7BNmi2QyNDm4SBQMPzWiQF5DJ17lcy4sr1agWX0d59QZ4qF5ALgRor8+5+q6dgECgJxTBnmWROkVtgugyGFup7xRqZ/MQBSbRjhHcyAhUINLcJJhM0cBBIjLNRmHUzFXWQsrVOxszYIz7j6KK0CGYh2jdAM9t5fWp8Kpiv/rud76en0K6B0qUHcmc8M4kzkNk3M8QLg8eIqzdK9KIfJNXeotYdSKBUZBJBoFw4pCdGXD4IdP1RbS98XybQPprSg4FuGEKRBBpNAs0qa1z5avX2A4fl3wZs/bDEJym36JfpEFruMTYJtPegmfAg0Ds6EqgF7UHf3Gkg0LBtrZKA505YDTM+MkcG4pm88Nw+KiUun1cjUBKn4d7k7rd6ChqRaVph23xgINuDnUpL4ztobIYEznxOErYyY2ejxII0omDOEgy6HONsEIujUW6GNh6z+picOxWaGK6jVt8Zvk7tsdfmG5XJ7CEEynik3BnFhSLeD6cUmLLDNzBDvEGeZwGXxGyX1PWlkmQX5Tw/rROBciBpJ1BHnyFQHvsFgaItlCsdrIFI9MeonHpJsFY0pu+r2PlpWdl/DNjy/rE/xzmPFkyFZsNtnDQbSKIkz7ZJfA9G/9NAl0EDfQMEWqkRKDQyJmBTBJrfKtN3aB0sdWOVXHH7y+I9PkMGkTjwnNRCFYFSYHUCVe5Nbn6rp8B26Eig2vwfyUTbjpomA9E2I6dvlbB1R2Gq052pEdpng5oD5pRFLEg1yd4IM7dJrnr8oIr9SRcgRp4fCe1zpCJKZipl/Wm/Q0Ll77q7p54B53s5Lwu5w32Q5EdA+2QsV78xS9XUxVnjVsiku9+UW7fWSyK0nDAQ6NRtmgmfaOOUBdqdBJoHbXz9MRllEmjPA23BxUvGn+WUWgTkMs5W1Tj72eKdHxw69McBK9/8ZUyM/UjBtDyuMpkE2ptoI1BooHRXiqL7ik6gnIOZDu1z2nY8L555ZlaTTJ/9qQy9arUMhvbpTc0ORz8QlHpmg0Ch5XkigQ4DmYzA/Q3DvXoFzROfK1fLFXM+V9v7orNBniDOSF0D5S6sJNRD8pYaGXPzfhk8bhnambuPtHxLw0CijDtK7dOTCJTzsoQrgQ4dzUFuqZwTvFS8YL5Pz/hWbrZxnlsj0OmANgeqEWgM54X7KIGSODskldMJ1Egql9wXHOnRFsy/FW2HhY4BPQKyGWerbnxo25Gdbx6pPGvAklePXRXpLCuYDgJV7hMwlRjA1TThex4kmcGhekDlrCo8H9tBI0/OC3I+jIsKHNgScS5m7RE5NyIbf7NUkRLNRMbe5JwbiYqaKH0he3MxxRV8PoKvlYmt2gakCviEZsj4mXslcXOpSqIWxtXo7Bbl+xqXC2Dkj1p3SP48PVv5fvqDQFWMUZKkTpRGEOW239CPvYVhIE0lh8rrQIvKTxL1H50OWV0m58Y+I5EqMj93/0GO0a6qz+E1XZi4IzAGnyVyGmMdCHSq5xOotlhI7ZvPjwEyQCNQH26gCJ6Nc9pWzr6UVI4aKLMgRKL/MdlmrLWu8f68ozuf+7rYa8Cil4pujHZUKgLl/vckZy0IFMKKPzQJtGfBjj9o7GIJvVOLB0ryUO3AlWi0TRxMW25yIIHG5QJZNRJ8+36VCpnO6iOUSazlAqI5SxOK2xl7ex60K+AAMPomq8Su/BEmq+YPSdcl+sCq7LA4N3nBX+XcK9fJEM55urmGJ4HkrTRODmogUOZoorP/KA50o9OgLa+U0HvehtJSK5H5GCwoz3hWui7xyPfsrNRAuRc+dm1BnyHQfhWNCSCBcs9+JCwBBrKJsdY33pdTvHP3wcO+A+buKY2NdlYVqvzaikDrILScezIJtKfRkUArT0qgiXh/w8KvxP+Kp8QvMAPPrREoFy5oxmpzT32EQEEMIyaskeuf+Bgmex00bY1ASShKE82plzGoF7+xS0Cgnt2OBAlUTZ+AQKmBKgJF26gFLxDI0KuekhsyvpEELhDlUduGPLsQKNvdJFDPQGcCjQWB3pNTsnP3ARLo88X3xNgrq8L5AQQ1yVFvmvC9hFMhUAqeyq2+/phcGJEv3mMWK2LhLh8VqAJ1oc09adso3f2eZyENpjme/Za90KwrJBYEyi10FF76htLUPT8uTy2WKbPd7TU8C5w60WSOc6EM4zdP/AMwuI3JkL/E7pC4p4okAeRJ/97OGqhJoJ4DjUDRTjqBxlkbmu7JLn4l69WfLhgwd1fx+hh7dVM4NBqNQBtMAu0lnAqBcr46wdmsIteHznpNvMatUP6gdJnROiyuCc2TbjO9GZGo60iTwTB5L5hmk6i1h5UVpFZAQSaJOc1yXcZXMvSGTcrXta8QKLVPyhwDJmuRqOaBABfIoNClcvl970qKtVZFoYpC+5oE6rloI1A1B0oCbZL7sku/2vVRyXUD5u0syom1VbWE8ctORl5ulARGX8YfmQTas2gn0Fe7QKAiCehgyfZ6uWbu38T7qg0ySBEoNZ8FasFCLR4p893zCdQf9+vNe71yvUyZd1CSbfVqhTYez5qEZxx3z5viPXFl24KMu2t4IiiHlL3hMN+Z930wznlfsVamLPpaRZpnG0cbgXv6MYH25aRy5EVu8CCB0lKPs7bKPfaSguc/L71zwNydxc/H2mpMAvUAnCqBxrO9oIWGrTksIyJz5BxmpoTWMxym/EjlrM5ravvQ3f2eJ8EPbaN2VEGTvuL2NyRla40y3el9wCRrf4l9RrxDmXmTq7l9g0A5jTIEcsg0JiMDqYEukHNwbmSkU6LXH1WRz7hFl22ppmVMDdQz0UagzSBQaKOZrXJXVknhro8LHx8w55mi52M6ECj9Dk0C7Q2cignPRQfujohDW8XhuwEg3YETmFwtDYLL9Bma7yH3x9NNyNNJlGTjDS3Ne0y6BEZsF8v6IomHwHJX0pRlP8rIyVtAnOnAXIBk5P46ngLWt7YjSiPQESBQTq+cPS5dQu5+VeIzKyC7rRJj4zZdk0A9Gm4I9M6tikAfG/DEtqNvRFtdTXg69ZoE2hs4JQJlp0N7xeB9QnaDXLUQZvzVayGcC+S80Rq4zVHbI983CNQHmiWDbJx/+dMyfcE3EgfyiM1vlomPfCx+41bDDGZbztZI1M01PAlsS/pDUg65W2oUCRSvva5cJdcu+hzWQ52aomAyPVMD7dinPQ7HEajI7VvLCnd+WLRgwKP5JNBqk0A9AF0lULaLah8SKJ2wc+olbMMhGRVpF190sPNBnudf2k6gzKPj+QS6QPzQ8RhsY1jwSpl4xzswb+slwlErf56xD3WzXEYEcFFmNsz4vkGgjAzF+Vom0jt3NDXQhXJepE3CN/yk3LIYIEYRpkmgno1OBBoLAp21tbRw24fHFgx4eNvhN6L0RSSu7NKEZ14kmogmgfYs2gmUc6C/7kivtBaY8DFqZbBOYuzlEjBrr/iFLpXzLkmTCy6BAAemiXcw0QcIFG1DTXlIULp4B2TIxTE7JP7pYzJt7U8yLMyBZ1iqyJWE5N8HFpH8UefUQLlwNAoD2UiQv2/oYglCG8VaSyUuv0miSKDQQLnK298JtM8uIqFt4kCgcU5m6eAOOdyvtVVu21oMAj1KAv3ljSh7Vcv0XINAG00C7SWcCoGqhmWQkdwWmZpbJ1H5dXL5/M9k6BVPysiL0+WCiyG8Y0BGEGTNqd79b3oOGOaNmmiGDATxj7juKYnN+Fyuf/Qd8blqjQwKydC3cC5SC2Xur+E5UARKrRpyxz3/QwMzxHfSWrlm3ufoZ7Vor1aJYJoWRp4ngQL9XgPtswSKI5SV8NwGCctDm9ib5bbMAkMDdSVQ+oGaBNpb6GjCn2QrJ8Cc4ZEYGafmNUjUDpjx63+RC6c5ZeglGdBCM2DCpyvy7BMECmLwD1ykOpcPyXLCMrnqjr0SnLRdzhmbIYPUXC59WvuGXyvbkotinPccyrB9INDzQIBR6w6ryPPhIMdwEqihgZ4JBNoXTfjjCLRVBRa5Neto4bYDJoF6FDoS6K8vIrFhY+34PLtJwrc1SeS2eonPLJOxM1/Cc66A8C5GHYB0QhjmzvMJlERDn1V/dC5GavcKzZDzb3haRl6zDu3KaFPQPoMy1DMN7QMEyhV3XxIoXnNhzDtkmYTO3CfJWysw+DFcn7b7iJ3TXETS+rJHwiTQ/kmgSmNhvEi8j8jnNrMGSbTXyI1PfC6jLmfe+CWKbPxBoLyu52ug1NTSZDjzPJH4QZg+qAtvIgSkinPDoH1Sm+sTBKrkD0SCe/XCPftfsUFumPO5pNhqJA59LAbkqGTYJNAO/dnjcHICPWQSqIfg1AiUE9voYCRQaDTReehoOMatPiwXTnGi4y5R8UUZJ1Npd51+y9PA4BsM/zZiTDqIEgTKTQDKgwAaNOATMB9tyPB8bM++QaBD1bTDIhkYslhGTrVLLNqGO8finU3KBS1aBcrWtnGqvmYSqOeBBMo2MQgUfVERqLWgMI8E+sgzh9+INAnUI+BKoMmZVRKvEyj3SpMo4ztpoCRQxi9g8jXGCU1AZ+Pe+DEw473GLhcfENIwxgXtCwTKHVQKTAZnaHDa1lSlPeM9z3NzAL/r7hoeB9wnY1+ePW6FXArzPQVtmmTXclwp053Q+1l/J9A+vQpPX107cyI1tmmgt9mOFW77pGjBgMeeLXg+0l5pEqgHoAOBZoFAIVwnI1Bqqeo9wNfcN37NnM/E96oNyoWJ++KHBvahveNuzrniZJ97EhiLwAsEOviK9XIl2oR73xNBnhaQJCPQc/Bj0jwzmEh7f/Y4nIBAZ9kLC7d/Vvz4gLnPF+VE2ipbppkE2us4NQLVTHjGKWQjaySKzok2jFh7WEZMs4oXCTRgXp8gUM4XMlCIChbiBlpMTf1zD29HQmnJAQtl8JgMGTrNLuHrjqJtYCWAHBPRIZkDSU3R5GoO2iaBeijcEGgU+HGWo7jg2YNVdwxY8GJFTpRJoB6BUyZQvCaB0g2GnY7n4/Hd+MwKCbz5BbUIQwIdrgJZuP9NTwEJVIvc3k6kruB55VfJ932FQC8FmYQuk4Bb9kmctUqFrmPOMUWgAAdARvgxCbS9P3scjiNQDHq2Brkzt/QL50cVkwek7S1fHmWvbNQIVHOkZ5xJNqBJoD2LUyJQfEYNhhGZjPk0the/Z3HUwoz/WIZduUbVg5E33ZOhCJIdTydJd1C5nvAdvnZ3jZ4GycKA63lOM2gaaJr4T1gj187+BKZ7HeQVZAECtbQRqBZj0iTQjn3a0xDDNkG7MdFhOPpipK2++c68in3294vPH7BkT+HdMfbysun4YhQehuQZbxJor0AR6LjFMvYuYycSG01rl84EqpEl015oBMpOR6uB32Vu9YjVv8h5023izQ7n4Z2OYMdjQBHWgSsxuYKfGd9xd42eAetSA2VLZUHlQh3lDPVMqDis3EYblCEjb8iUyBU/SVJ2k2ojthXnPzkPSgI1EgX2dwLty/FAlcsgp8ocLcJ4oNHZjY135FfsfOajY8MGrHzh8JR4W3nBNDBrBLRQuliQQLUOevzFPA39m0Bh4umk6EqgbBt2MOVLSBMeHY6dTmmh+H4c2jBhc5kE3bwPgrtU+VW6+z0TvxWsz0WKGAyoc6xnQPnfAqz7gJTnJenpUkl0YOCDFmOQJOdCtbY8Mwi0L2ugjFnAwC8c+CLR3yLsDY135JXvfPHLMv8Bq18tvirOXqrnhaf20qSNjPhD1agejv5NoDDxfoVAo10IlL5qmksMO2mjpNhrZfLjn4jvpDXiFagJtrvfNPFboBPmCUAC9SGBTlgtVz/ykcy014EsNN9PQwPVCJS7kUwCddevPQlR6GMkUQvbBa/DrPWNd+aX73zu02KvAU+9UXxVoqO0QDmImgTaqzh1AoXwoUHZ6ToQKL6X4qiXqOU/yHlT7TKYGlGn3zLxe+CeOA2QMOi+NOJGq0Qu/UFmML8TCVRNuegEyjZrI1AeIc8mgXokVF9Dm9Bzgjv/wq11jfc9U7Xz3Z9BoFnvlI5PdRQXRDALIh6GybxMAu0dnDqBog7wuSuBRmKkjM5plARooElPl0nIzJfEZ+wyk0C7CWwj7pAilOmOwYkaJ48q+j93TwWnyaCQxTI6eY8kbyqTZPQpkmc02oYEykUkNQeKwS9abYIw/UA9Fe3rDYJ2wJHcaKttfOz52p0Hj1UPHJD7SfWfZzqOFUSqwLyw800C7TUoAlWr8C5zoHjGUyJQdtQ8tKWzTlJsdTDj/yZDr1ivtnX6qTrBsQ851nsa2EYkSYNAVXATnUDVllOcHxySphLgTXrwI0mx1kFGm9BWHNg0E96VQKNwPvIMINC+uojUkUDRfhzwbDWNC/c17vziUMUfB7zwRf3IW7OLj0TrndPibFBmPDuuSaA9i3YC/XU3JncEqjoeXkeQdPPQ8XKbJBnfjVhxSC64yQqhXaCIk1skfQM83y/UE0FyYGQrg0BJmtyfPyzQINBFII9FcnYw5O2Gp2Xa0h8lSS1AUMsEgaIdOdDRhUkjULZj6xlBoH3dhGcGiEQ7LHQQaExWdcPiV5q3f1cq/2/Azk/L/uOOvMIvYx11koCRMtGpBTswCbTn0S0Eik43HY0cDRJNxN8nbq6SsSkvqLpQ+8sBEulQ5Xrj/j5MuIdBoNQyme20nUBRlwBJdXBomvx36EK5OGmHxG+qEEsu2gQEyikykmgcHenRVu0ECqsB3zEJ1HOh2gJtYgGBsg/G2KorFr/atPzgwYP/OiA/X/5wV37hvlhHdSOTk5FA40CkdGkyCbRncaoEStC0YKfjooQiUHx3Ojoqj1z1TcpqkCkPfyTnTVwB8tQ0UHe/beLk6EygNN2HQ/scRod5ECg103NAHIMvXypXPvyWWKz1yq2MeXQi8kGUIERFoHSkNwm0zxFoPAg0lh4V9uofVr7ZMGMAi4j80/3birbF26obEmC+J+kEamqgPY/fS6DcScZOGp7XKmE40uUi0d4sict+lNE3blJzoL6dtnVS4F3fm/h1dCZQOs0PDcBngDdk7SzI2PCbnpTI5V+LRbfkwvNEwkCg0TjGo706mvD9j0CZTI8EOsJ1DjRknviRQNE3FYHO2AuZ9XwCNeZAI3UCjXLUtFqyq7948oPmCEWgLI/vOpoVb6tq0IK8NgJNauRk53R3UU9C/15EOrkJzzZSfqAACVT5rOH79Onl5xZooTM3lUlo8m4I8RIV4k5tNVR1AXNe/13WleaG4/7eTBjQyJPapq/ahYR6hGwxlikzop6Fz/4C892yuVAS0J9UW4EgSaQxIFAtFYveZuxj+uf8Xn8gUELbestoVJzeAIHi6Bs8T4YGz8a5ucrFiwSaZG9QMu6uX3sOcH/ZaAf0I3LiNGdda3Ju2RfOTyun6PQ5YEDGnsNLLPbK+nA0ZFg+OmhuAxpSWzF0f1HPQX/VQI1VeEWUIETXgMoGgbLzuasTV1BAk231cuUjH4v35RvEOzBDhqOTD0d9DIFQq/3lJIIxGbgHwvM7aG+CC0ZMEKdW20OhdXJ1GfU4gvUWkC6Dx62Syx56XxKctah/Per8ScB2VG3ZTwjUiJbFgcYvSNNAh45BHY2Zjddz5eyQdBkNAk2xgWc8nUDBLwkOxnBtlukYAK/Pbmy9ZVvpF3u/KL5SY0+UFS8XxabYKysj8DDTdQJNMAm0x3FKBKprL+7qxBUkUKaqjlh5CB3QKYPR+Zkag/VhEuipwyBQ1pmXQaAwTxkl3wcm6/DJW2Xasu/FAuIzCZSeCRqBDgvswwTq1AkUCuZNOQ2t9+4q/9u7P1aG6vQ5YMD6V4+FzLCV/BjhbGoNB4FG5TIik2ZmuL2oB6H/EuiJU3qcCoFyp5IFBJq8uULGpL4kg4OXqgWPoagPfxcC9QepDhnTNzJe9ipgjrKeWGdaxlMS6Hyhm9hgDECXWJ4Vy9MlGoGi/dy2SSeYBNqxPjwN3IbL+CDT0efCnHUNs1+o2Lv/YPVAnT4HDNj8Tqnfzfayv0U6G1sj8xs1E94k0B7H6SLQeEezcui+9rFPZcik9eILAlDuTMHo+Gq+SiNQ5RDe6Z5MdAbrSBto/CBPjFXqi3r0gux5T1gplz/wHuq6RrkEnskaKBeT+osGGof+w/Q6YeQaR03For1l63YfOPxvOn0OGLDji8JBd9iLP4921oFAG9BhuXcXf2wSaI/itBAowL9hJ4xa9rOcd5NNhVkjaWrap7aQRM3KJNCTg2SgtHXI1RDIGMnCFxgcivOTn5ab0r+WZG5GUdpn18jBJNCO9eFRIIFyCy7akx4u8Y6qkhWvFmcoH1CjHDgg//JgTvHncY7q1qi8eonJ12IXmgTas1AE2tW98F0kUH6HWwgTc1sk6elyGZP0Isz4JcoENQiUwt4Wx9Llfkx0BOtJqzea8UxwR7nSVpzPDk2X8xO2S8yTxyRJN9+7OsCZBNqxPjwN9JyIBYnG5jVLoq24ZMvbxRl0/9TpUytzdha9FG8ta47KrZXovEZhbEmTQHsWp4tA6dJEbSglq06uf+RT8Z+0TryVGw4JQRN2kqdJoL8Og0AZLIQR50eCQEcAPHf2hOUy/qF3JD5Laze6vXTVDdAk0I714WkggXIxNs7ZKLdkFx9xvF9xPwj0f+jUqZUlL5QtsGSVVEfnVisTXjV+FwWgN2ES6K+D3+GuMgatSOFkOMz482/MkkEgAC6CtBFoYBrqzSTQXwPrySeEi0ccbBbKuaMXyKiABeLNurx2vdy44lu0UYMKeabapov9pz8SKI/9hUBVOwJxttqWe/OLPt72SUWITpvtZc3r1dcmW0uK4vJq0HiMXaj/obsLehBMAv11KALN1zpjsqNZbtlYKmOTn4cZnw5NiuanRqAkT5NAfx2sJ29GWgKogZ4HAj1XJ9CL4nIlalOBxMF642AVg0HLJND+MQca7dCsiRhHTdMjO0v2fVggQ3XabC/LXyq56GZn6bfxufVoPHRSmCAmgfYsThuB5jFdCyNqwwTJqpXJD34gPhNXqrzxXElmXXEnDeHuvkxo0AhU00KpgZ43mvu9cY4Lf/e8KrGOcjX9pbVX1/tPfyNQlaKaxzGLAI1AhwTNk2FBs9E/56KfgkBn7pXkPqKBRoILucMvwVbVtODZ4j2fFtd46bTZXjI/LfuP2/NKXou11zczdmGkcsNwf0FPQr8j0G52pOd32KGjQaIxuc2S6KiX6ct+kOFTmTc+Q4aANIcD/gHzIOxmnNCTwQd15A8CHQlyGDka8jUmQ3yveUquTPtcYvLrJAwKSKSzWWIZeAJE6K5NOqM/Eag2zbFA7YUfHrBIRuh74b1DIF/6XngffS+8hc8F2XRXJ56EiDyRcBBoalZN3fp95baff/75/9Nps70wKtO9+SW7ExwNjbHosAzKywj17i7oSTAJ9NehOif+nvvjmXsnNrtB4jaVwoTiavxSECe3dZoE2lX4kkBxVFMeARkyKCBdLozdJuFPHZbobQ0yPbcBBErHa7aZ+zbpjP5GoP0tGhPXEMJgld+aVV3geKP6keMWkIzyxLOV1iRrTQNXnGK4Eq982dxf1FPQfwm0+/xA+T1mE+R12CET7TVy1SMHxOey1RDmDNQNw7ExSpMZaPlkMOKpDhkNWQpcLIOClsqEu9+QBGu5ROXVSSRNeNVWXScGk0A71oengYFgIpyNrXc4yr5+5kBVexSmziVtT/mtKdbKcuY/5nbOaJNAexSnjUDRIdUkOMx45uCxOOokfMl3MuoGKzrkYtQZgy1TszIJ9GQwCNQ/YKF4MX7A1RtlStqXYrFVoU3qQKJsH7aXSaD9Jx4o7tFW3XRvXvEb2R9UXaDT5fFl7cslwTOzSn+ItzW0tqVa9XCYBHpyqNBpOHInBaOiJ6BTWp4ulUstzykznmHY/INIoHNxH55dR70ODjQgUB+QwlljFsmFMdskbkOBCkQek9Oo1g5Ue50CMZgE2rE+PA1UOuLtZVVzny3Ysv/TH/5Dp8vjS96nxV53WQu/TLTWtEZBGNRI6uaCngSTQE8CfI+dkrENuJLISPWxINFke51Muu898ZmwBoKdjt+G9hlMDdQk0F/DMKZDQR15BafJH8cukaA7XpOkrCoVPFlrGxIo8x+R/Ny0hxucMQTaB5PKEXHOBkm2FRct3P3znIPisoWzc5mzf/8/P55X9E5SVnVzpEmgPY7TRaBGHnL+HaOjR5JAMapOX/K9jLwhU+1KIoGaGmgXAAIdhjoaDIIYdM16uXrB30Fw9WJxtOgLR1ysY6ZNk0D7iwYa76xrudV57O9rXjoyTafKE5f0Z0uXJmWVV0fkcEeFSaA9idNBoIx6rnLwAPw7BoUNy2uVBCBpU5kEJD4rg0CgPiBQP5NAT4qhIADK0jnBkKkop4Q/CfMdg5ExSFHTZ3tF5JkE2l8INNFW03Rn9pH9u/5RM1qnyROXJ1+tikixlpVGkUBNDbRHcboINAnkSRgEOi2ff9sqqQxx9+B74nvZUvEJniP+gEmgv45hAfOUGX9OaJqMvuMlkECVxKN9SJ7M966mSqB9hqvFJPdt0hkmgXasD09DgrWq8eHtx57/uLTWT6fJE5fsjxtH3+ooK4hCZyWBtjWuAh9Wf2B0zA5o+07Pov8SaPf4gWoECm0TnZvfD9MJVO2Nt9dL7LLv5dzrnhLvMXNRX6YGejIMD5gv/qNBAleslGvTPpeEnDrUK8OcaVq+RqDN0ECbcL5r5NDWx/oJgfalpHJG3WvQ+Q39TvOi0HaUWawVFQtfKFvzTWvr/9Rp8sRl44ED/3JfftFfY+0NLfR/YsIrOmGrSXEIRgzMFf6AWtlFYxsN7u7megL9k0CNrZzdMAcKIWA07XiG4+L8HM6pjKsgUks2OuemErnEskMGB6Njos7oIM7AIgxvx5iX/tzuyc/wmu5O/Exloux0730dbc/F5wb4zFqgae2cEWyFR2+8P2+6TSLXHVZtwsU59gFlxjvZ6ZrQRmduQGUVaJqvGWM2cDHOMYYqNPfg2ajLuSoOA/fC9/ZWTg58dFFiVlSVxh0cF5fbhHuqF6Z4Z5/jrswZ9uKfMt8svuOEDvSdy+xnS6wWW3296mxtBAryxMXZoIpAKSwkUIy6fO3uBnsCpgZ6MmjO87EY+OK4yIHOSb9QXoODocVWLRMffEftjaegjxy9SGkOzP2jMlCqsHfsAFrAZeZBJ/obgbY9F56RHV/LuqmnL8Z51sko1A3zIQ0KWSbBt7ws8VsqVF9QbYE6pVJBAmVa8Fi1FfrMJFDDijlRMJFzPCSYiCJQ9C21VRNQeftzSJ7V4JU6vIaymNMod+QWfrb7vcJrdXo8eVn2WnlkorW6MNahaSxaZ2NjUgOlcGidUREo0JupP8w50JMBBKpbDmwzthWd6qk1cVBMwkgbtuxbGXnjZvEFcYwgWQBMSUvBJ4ESJNMziUCN51YEqj83SdQfGpX3hDVyw5zPJclWr0w81T9QrxqB4og2Mgn0xATqMdGY0L9otrOuNZ5DWzKbQE4D2rIOR3Jdff2DO8uffeNvJT46PZ685H1cN/w2R/k3cQ6aIu0EqgQCgkEBYZh7jra9nTvJJNBfBwVEI1Bt2oXtZRBoTB40UAhL4tNFMOOfkcFjMpS2ZRBJBwLF+zOZQDmg8HOmhR5xo01iVx2SJGejqtdoWGkmgbqi7xComutEfyDYL6LBa/FQNqLtqHO2r62masHe2vXH5Nj/1unx5GX/fvnnR7eVvR1vrW1uXyiiaYJOqMDOTCLVyFTdiLsb7AGYBPrrUJ1T+SR2JFDV6fOokdbLDHu1XH7fu+I1fqX46QRCoXcFScQgEqK/EWjbcwF8fm3ezgX6ee7cCrn5FUmB+c5V5OjcJrQR2gf1quZAaZG1EWjXyKE/EijnQD2fQKkA0n9X8+Fl/4hm/VPpcGhbnlMcFYfXvtN4V5fnP42yZE/hsqTMiuo4BhO16z+Aix5PoI2qc7u9wR5A/11E6kYCVR1RExASKDsoz6vr5jRKKsz46Yu/kyGTN4t3cDpMedwLtC/Wn0qBjA5gEKgBd/ffl9H5+bRn1OpgCDq8D+qE2zd9Jq6VybP/LqkkT2goESA4zp1RA20nUNZr1/uEOwJlG/cnAh1OAg3yNAJlf2hRab8TmXkTdU8CjVJ9pFWSHVVNd+QUfmj7a9UknRa7XjJfK7luhq2khEnlY22NuDgEwsYVquM1UZNAuwenTQPVYRAoXZs43xNJ0x5mfAKuG/90qVyStFu8xi5ROX981P1Q80L9uSUX98/QV+H2GfHsahAhgaJOGIB65BS7RK4qQKejm1+zhEO7j2T7oF4NAqVmo015Hd8e7mC0T2cC5XVNDfT0QesTLSBP1jG4DcpiNOo+HG1AZXGGtaj6iR0FNusHX/xRp8Wulx3v13jflVfydYK9uiXB2QDBQOe1N6k5Hq0Tkkg1MlXzCJ1urqdgEuivg9/h9zVh0Too243XDAN5RubT3GyEqdIo1z7+qfhcvlK8QtJkUOB8GRKagfsCkdCFB4RCE9cwb93df9+G9mwkTj4rj9S+KT/e+NwndBHaJl2tvidm1kksOlhkXouKE0mi46BkQd0Saj5Nr/+ugN9V3zfaB8e+TqA8ejKBsr7pzqf8PKEkJkP+E7hojraLQP0nOOvltswfjjz1SsGjjJWs02LXS77IHx7eVbo3zlrakOishWCQRJvxYzqB6tAmYU0C7Q6cLgKlLy//hu1lmJj0eVMEug2vYUUkYiSOXVcgF0XY1DZFrxAQCMx5RSpnIIFq87ww2QNRF/j8HMiW/9WrZNrCL6GxaFMirLupINAoziW7EijquSttY4DfVd/H35kE2jNgfYehX5BEFYHaG9F27AvoL+pcldxn/+brbR8eidMp8dRL2quVtyY6ikss9goVrsvCeQJ7a5uZoYAfVNBvrKdhEuivg985nkBxXZjvEfk6idKBmCYLfvOqe18V7wlLxCuU837orDp5nmkESnDg8A1cKF7Bi+RsDCpBifmSurFQmXpslzBoGdPzORUCAkXdmgRqwPMJlPU7LU8jUU5TJisFEe2KumfbJjpKG+fu/OHV5z8+cp5Oh6deNr5Tee7tOce+igMb048wHpoKt1/FYwTmXAHZ2iTQ7kNHAu3GnEguBKqZ8Fq4tSgSKDooF0HoSZGCQTJyxTcyYtpWEAYDjKDuQCAjdDCRmlGn7u6/L4OdneCuI+44GhGQJsNGQ4ZApNw5M/iK1XLD7I/kZkeNssAiATpgR5JAVf1pdauUC7bNKfSJ/kagrjuRGLWfBKp2IgVpO5EGecBOJNZvWB5jFmhrOdoiEtqSdY/3Kc6CimV7flh7WOTfdDo89ULb/4ltR1+McFQ2Tt2GH85DYzorwdh16NiMLUlB0eZC3d1kT8Ak0JOjrYMSesc2zrV/BsuCA6StUoLvfUPOumyFWpEfytS9o+fLuXoQDaZB9g5dIL6s607331fBeteybeI95GZkwAKVslgljQtMl7OCl8hFic9K1FPHxJJDrxMSW+f60+v2FIjTQNs1OhFoX1yFJ3GeaC+8kVTOE/bCcwomOpduaA2qn7He6Umhtq/bqltvzzn87ZZ3C1N0KvztZcVLpY9GOSoqpigtpkWSnTVicTaojh1OAlWjr7kK3x04XQTaNeA3oJVycAxb84sMD3PKwKAMZcqSUM6FCTZszDwQ6DwQKI+eXZenAkWgalDQUjyPDOSgsRBHzXF+8OUbZPKCv0uCvQ7tAHnv5k7f3wi0K9GYAkGgvRmNSW0wyWlQ9cv6jkW9G1Z1jK2s6eGdBa++8GXVRToN/vay9aOqi2bkln4zzdHYSoZOcjL2odaxlQaKG4hVOP4mewLmHGg3Qv1OgyRaa+Tyhz8Sr0nrxFvtiyeZzAOZzlUh7/xC5qBu+08GT+Yx92O0IAwOQyEnI0CgNOGHgDwHBi2TwNR9krCxHNon6p6Lbe7q7nfAJNDj6+T0Q5seUcGRUOeEtpusWZLsRUULXy5Y3KXoSycrXI1/ZFfZvjh7bSPnCBLxQ0rdJXGxgXMxKkMN7q2KMAm0+6B2J+G3LPiN2A3FcrFlN+p0mfhybhB1NzRorgwJnq2hHxGoWvQIZii/OXhGkijOjUmXwUFLZNRNDglb/JMk2VD3kHHWfXfXu0mgx9dJT0BpoZyO0QmUdW+xVTXPyi34YOmrR0/def5EZem+4sdn2stK4610NkUDAyRQJtGKyatGp6vHDZkE+nvR2wTKa/La8fhdunVMTf9ORqLTDgyhcz3dmkAuDLoc/ATut38R6FAQ6DAMEP5j0NGD02RQ8BLxvmKjXPvoXyVla53E29EWTm313STQE6NvESjqGXVNzZMEaoF1kWwtrH14xw95+4tbvXX6+/1ly5tHzr/PeeTbRGuDRDMwL35QRfbJqQeB1qCDmxpod8Ag0LF3vSrJWVVqhVJNaquRkl4Qp5lA0aYaWbdowpRZI1c8/LH4TN4k54RmiHcwnevnyTCY8P2PQDk4cJFsIcz2dBk4cZ2MufkViX+yTFJQL7GQe67Q9iSB9sVV+BMRqBfkxs8lqZwnECh/OwIDo/ImQr0nOhrllqxDZctf/HFFq7T+fzr9/f6Sn5//h7nbfnk21VFVp/yk8IMM0ktvfU7EMqCC+xs8/eiXBHonCNQKAkUD9ySBcn6PZo2aC8VrNd+9pUJC735Tzpq0Ws4JWSQ+IfPFP4Rk4/4Z+io4p+sNGfEZu0T+GLpM/mTZLTHriyTFoeU74uo6tZVIBweY4+vu9+BMIFCP00BpukO++ftqYMQAmWSrar0/96dvHO93w+p757Jiz9EbZjhKfqLPGzt1gqMJWgoJlB2690YRk0C7GRQsIBrCFW1rVNk7454qltG37JNBl6+BacuI7DR1+5MGulCGhnLOM03ODl0qF8XtlPAVP0sK6xyEGUPSRCfjXJkWrad7YRLo8XVy2gErK8bZIHF50EJZ3+hPiZmlTfN3HX5l/89VF+q0133F/lHhoFn5hW9HZDe0sGHpypSICqDWQrPG7U32AEwC7T5wykAFjSGUYGsuauzAcRuOSdDMF2Xw+OUyGHXLe3X3DH0RlBGm6fAet0IuidshUct/gubZoKws5eecq01ZxdpaFLmZGuiJ0XfmQEGg2fWo5xYJp9KQ26Jyvy9/rTi9W1bfO5c5c+b806MvVKyJdtTWMAqNxVknKiKNPrHu/iZPP0igkSDQUYpAGT1oLgh0DggUpiYaU+vo9O+jxqR1fE+FLzCwA4Fq2n47gWrxVxWBAt1NoFqQbPyOIg6QRR7OoxMn4HdT7HWS9OQxGXfry+I9cY14g3T8uVqNex6iH4fyNeqYbkHqGHzy+nbteEZ7/V4Y1zLuQ4PW/sbvaQAZMUwdSMn3spUSkvyCJKz4RW6x1YvFzihjnB/TOjgJlDvwKG+nhUB5TRCnSo/zKwRKonf3zJ4Eg0AZgHpEQDraIU28QuaqpHLc0ukzJkM50ve2BhrrqMPrJonA+xhHbfNd28o+3PRR3QSd8rq/bHq97srbbeW/JNprJC6nGj9epzraqWxb624wpez0DUUyPHq7nBWyWHzYSaCFDlH+ihjt6N+Hc+xQ3D3jqxrXM8FFmoFjM2TcHS9LcmaZSmzFEVKRJbVDdGKuzHMAUy5kneri90PbVUbw93iOv0H3nQT8bjJDGz5dLqH3vy/DGTt0zCLxRYceGpyOjpEmw6ntY6Dyg5YxBM/iHzpffAB2KO5OMdD2zCRYF/C9a32cCK7X6nA9osP10GmDZ4u/WvSao6yQ4dCehzCzJjq3X2CGeAdkyMirNkroHW9K5PoiScUzcnqKc8Dq+VVdoG4A1kt8W111I3TNk0f+ljFARuEeOJhRG45dd1RGTLPJYA+XYcInJE2B/U21BcmTCeWC56lB95zgJXLJzS9Jor1e1anbOjnN4O+q34e1pYLBOEpq0l44avu8oPUcne66v9j2Hf33edlFb6VmlTbF5dZJlHJfQoe295YaDoFmVCGdQM8OWSJ+aKChINChDN6KRqODNLUN7nFWGo5LB/M0+IJ0Bo9dJOPveElSMktBWjAxuGcdz0rPByOMIDM+RqkEf93v1N0Zyl2NozW1IRwTIGzxzgaZuvBL+QtubPD4FSBI1nu6+IKYhgYuAJFyEENnCWLHgcbRqYMZz0sNsU1bJVzqontAx/8nZNjYuTIMcjAMvzEUJM+o+17QgrzGrpQLpzllyuzPJT6zWg3GHCy05+Y88OmvX4LtqhaqcFSaJ8A25zy0BZihE+hwRaDuntPDwDpmLAVoob4gT7q9DQ98QkbSKkTdnx2yTC6dCRm31amB2V2dnG6oOKBWBhBpkYjsRrk5t/CnzR8c63rmzd9alu0uuPdW65FjCY5a1ZHpfB3Fxndzk6cfGEWoka0tlPMjtinH56EBnHuZKyNAosMMrYPBMBgcAkfOjXoquA97cCg10FeggZaDLBtAlG4INBejZg8RKEmEHTkexKnl+IFWxGR0TlgfTx6Wyx58R4ZNtco5INLBQRnoPNBG0Um4b37o6LkgVMN0bscwPKcBaoQGXM8bdXKi927/RhFkRwxTjvHzxRemoy86tu/YJeI1YZWMwD1PvP8diVl3WBJtVejIjSDNZvWsmlmpa55u6qS7YRCoMfeptE9qoqh7EmgqBqzo9RqBekNBaHteHZ3fdz7X+XPjvbtzxvsTfe9kn6lzzC0VyFCInK+l1j9HRgXMlvNG43UAB69lEpSyV2Zm1fYagXKxNM7GabFWibSWN9y3u+TZvIPlw3WaO31ly5tHzrrb8ePriZkVzWxwNVJ2vrmeAh6erjZxa47JhWHbxCdgqQwfzfSz3M/MhtNMthEwL0eCQHkcjkY9VTBfuCvcfec48Ld0dP57V7j+DSMfDQpdIiF3vCZJWRXQhhqEoeYYTUmZkMcR6OnX/LXdGpym0cmTRIp7UpHst1EAa2Xaqp8k9K43ZORUu/hctkoG0zwevRCmMgYsPJOaI9WfVz0z6oRtYbRLW9sQel24qx/C+JtRozVwYDT+lt/XLA0DnBNPV9qxD7Rk/8vXyblTbTL2zv0ybeX3EmevxLPUSlR+PeQY9ameUdM8tdfu66S7wakZwjDhXQmUJnyys1Ei1x+TodNRvxicjLo4UR25hUvdusK4RpevY0C/nuvfG9fgvOfwwMVoC20H2wj0xXNHz5PzGV9gNMMkLpXQ5Bfl1q2Mq9FLBAoo6wr1m5Jd/tO8vcW3Q/v8g05zp69QxU3fU7A6NausPN6OETtPa3B3N3jaoRNo7JoCOT88XwYFLhO/gAx0XC5wQNuAyc6QbOxE/oHQjmC2+UBL8lR44z7PGrtCxtz5uliy0Llz0HEMAiV5UtPvYQIl4kiYOomyU0fhyAWOCJBpuIrk3SAp1hqJWf2LXP/oxzImcbeMvPZp8R3P6PaLxQtaKZ/NG0cfkhngC5DY2CZsG38cu9I+vvjOEGg3w0dnQJvJgMWBttWv5YPr87cYLm1gSIYMDF0qPhPXy/lT7BI6Y6/cOPuvMIUPS5KVGme9hDtrZFpuvYTtwHPlawOFRqCaJsrVd3f10d0wEptxkHRHoEnZTRK+oVD8pjPAC+f53deNp8B3DKd0lqjXWo4tDGwYTIejrYYELJbB0ECDQaC3ZPYegXJun/Ucaa2ouzu/ZOe6t6ou0Cnu9JeN+0vH3uso+S4hs14RKOds3N3k6QdM+JxmCV97REbF7pI/jl0tXuNWKXeUQZetkHMmLAf4eqUMHr8Kx1UyEOabp+Ic3N8fL18vAXe/K/FWmMhcLAJRqQEKBKqZ8OhYIDQSa09p/oY2ZhCK6uS4FxU7kdoTSD0RnTzZzgyfdZK8uVQiVnwvk+d+IhPu2S8Blp1yQZhd/CdvFJ+r1ovPFevEe9IalV99MJ7bC8/thfYZ3IX2YRv64Lu+Y1eK7zhg/GrxnbRW/HBdv2uelOE3bZELY3IlYMZuGX/P63L9gi8katUhsWwp1zwJYA4rc12tvjaqeJAcCLgDyxgktIWjnhmcFPCb9K6gdaG0IpxTUYHwnsEtEqH5TyWBxmyX/56w2m29eBIGXbYabcn7XC1nT8T7CSvRJ5eLH9rLZ9xqyPlaufSWlyXFBgLtISWgM1jHkYwBaiv7ZfazJfftl/3/rNPb6S9qZ1LesWdStpbXc9JdaUidbrBnQHOyWSK2lstVaV/LxAcPyNWPfCJXPPyBTHr0A5nwGPG+XI7XVzz8oVz+SDsm6ej83vVcV9Gd15mA+79pxRGJdzSBoDjHjE6F+qX5rnwEe4FAjwPuId4ukgAYfovMYshUvnG5jWLJbxJLHoPl1kqirUJStpRIwpNHJWLlDzIl4yu5fv7f5OonPpWrH/9Ernr0I7nyEQDtc0Wn+jgRrnrkgFzz0EdyNXANXk9+4hO5YeHfZfqyf0jEmh8lduNRSdxaLBb8dgLuJx7gfdFlxciRr4Vh1OpT0+xdnq9HwXoz4hy0a6HRxo4nnGOe8ojMapmU9oVMeLS9HjrLmfH+ROc6f+b6ubvvu/veyT7j+yse/khhEtqV9zsRxyse+hBtdkCufeRj9MePZfLS71DvtWiX3iHQWPSpGEdN66y8wg+eeqP4Kp3aeq6seOGXSbfbjv0Qh1GdC0lub7IHEAXhis7jXFyTJNkb5GaQDifd6acan6MhEa+THDjC1FTgJoATwfjOyeDub13h7m/codPfMDtgol2b3CZ5Kl9A1G/bQgM6FQcsxmLtTQK1qK1vOOoEyk7PXWoRIKhwpglR4BZfPFc2nksHn5NaYArILJX+pQ4mtGtQKRXo73hcvbi+BtTfAqlo6xRbvdJ6+V77W7zPhSaM307E78bBTOdUh3YvWuoSzbdSu2fWZyKegWD9un3W0w4SCOtJI3iNUFGfGJCo3fN9lJP+1hyQMDixDk9SR27R+fvuruH6/mRwdw39PNuSbcr3dMUj2D4z0F4zbHxN7x22DS2B3jHhYzlF4yitfGz30Y157/78Xzqt9VzZeODwvz2Uf2hnnLW8rvdGby1iDVPLcjspV9US7S1oMHYSrdNEqU7chHNMycyR3pOBe+f929iJ0IHy8HwcoVG/7OwkK3Z0TyBQ5o8x7keZQ+qeWmU62iIMbcL3JH614ITnYpoETtjH4bMEtBU3CXAFlo77Bjjf575eOoLRotS8oQOdT+2cogmM9icoBzgqP041r6jVH+uK9cYjyZ5TIqxTDgIEs826fdbTDpKkK4HqWijb2U6THp+jDqNAQjEYDOIg1+7qxFPAPkbPAYKvaS2RJNm2ibYWkKvW5uyXUdvxGWXEbb2cRqBOY+x1rTNyCr9c8tqx6SIDTq/r0onK/D2/xCXZyn+MsTe3ur3RHkAEOtN01UFBMBC6RGhGNMn4niRDAuJii9ap8De9BHYIV7j7DkGT2OjM3CGhiAj3rrQlgJpTrxMogTqP5RwtOodaTALZM0FXOD7jAojxLNxHzgAcauupehbcNz4zYjB2AM93BbyWfh88KkI0wM/xe9w5pAgS8kCZUBqm/nfG31BOqEkrLZp/q1+zZ9GJQFmv+r2qjq4TaHQ+BiUoAXx+9bkHg+1O8LVaDOOz6HWdjHOU70jIThisle6XYdYn8SvncD8x9prGR56v3J3zt+LfnjTu95aV+3/4j/tzD+1IspbUUyNQZgc6ibb1kFoBtx5qQsGKUqO/8RDdAF4rUu+4kfhN7uNOyILpYK1XJgNTMVtg4tG0T7bWqSRWyQyQcVLADOwikghrO5KJTt9JpmYMWGCaEzTRk/C+/e/afzse31fzcng2mvBqxxHrkoIJsPFZj1xY6s66PFVQq9B2RGnTDCR6LiaqDoF7NDqRMu/5fd43BdcAn0XvZB2Az06GtmvwvX5t9ZowrsPf18lTBQF3ub66H/0+VV3zPN/3Guh7ShLFkYSJe+KOJzr2cyU+Ehqb0uRgyjN/eTLkOwVIttL7oUlHo0IyoMmTOznsKKu/Bnd/27GPnByJCjDZgRS+zqqX+EzuPoJGTeuKi3fH1cXvAxcHVXhN1Bvn6C2w6OIwOEXn0Kca9cj2tjfKzY6yog3vVMw7ePDgv+p01jtl3Qvfzphl/e6IxVavHOqpNUWgU0WjkuLV/AcrTBtp2MG6s9PzWvy96RC08OxGCdtUJuOf+FRC739TLn/wLbnigbfk8nvelKvuf0euAC6//y2Z1AFvd3pv4B3gvS7hcuI+F3T6nJgIjH/gPRn34AcyHrjsgQ9w/gOZiO9PvO9dmXDfWzIR9zrhgTcl6OEP5erVBarjcNTU5oj00RON34EAehW8t/Z76XBP+n3+Krr6vd8JRZCu54x79CgYGpKLluRynlpoBPrXxLRv5bIH34WMvSmT7nlDrrj3bbny3nflKsjQlfdCxu97GzIIKLl+t4MMangX8vaOkjlXXI7z7TKsvXf/9yfqL654G7L8NmQZryHPk9gXgSsefEfG4revmP+lREGZCcdz0WrpbgKNzm2EUlUD66JFkrMEgwp5qFYi82tlOgYoDrSWrPKmR58peGffl0WX6jTWeyX77Z8GP5T740fxmRUtHD3DcYNhGNGpPVH75AQyj8rniiZcpwf+vYiCucb94pxfi95ULn++5SX5L7p6TFwp3hNXic/Y5eIzboXySeS2Q7o00cVJA193hvFZ1zHYBe4+HziBLlUA7umcCSvxHveC3yIGXrZMBk1YJmdPWCL/dVm6DJxulwmLv8ezQbvDM3GVkhqou2c30X/BAVRZHmh/kmg0NM8xj3wqZ1+xQc5RsrNKuex5jVst3jj6jMdxvOYSNhjy5U4OB122XAaNh7yN51EHzg2GbLrKMN+7/3tXuOsz2vuBeE1ov4fr4zXv+azLn5Tge96TmK216K+ckgAfdPOgxrWPGGig3KLJuW2uicTk1Enk9nqZDl6y2FpklqPo2Oo3Sxbs+eab7o+69FvKkpcqFiVmFVdylZBzYGGoFOW7qLRQpoGFWg0hOB1mp4rViEpKwvFmmArT074Rv2s2ydlB6eIbnCHMbUPHekLt1w5aDGTo4GsDxjmCTvgLugSfoPmd4OY7wQtUQA2vkIV4rQU1YdQaX3zfe8w88QllgIW5clboArn0tr0SyXQenPcCgbITqXkwN89uov+CPrfcWqppoTRDoYU+WSIXQG374+h0yBOIKQByG7BE/HH0Z/51wG/MYmG0Ix8lX8fLojscL8Pz3X7Pl33quL7j2m+09z6Bi3AP+P1ARrpaKF7od2cFZsjIKU6JWXFIUq1NmmkNQlNTOW6e/zcDfYVTBJw+4kInuScyr1Ei8qCEgJdSt1Q3z91e/Naz/ygJ1emr94v1QK3vvdvK/2axVbRSa+K8pGauo5LUHCjnJbQdNd1NoCqGJUaVJGCmtVFu3Vwh4299WQZzF0rAAhkJMjw/cIGcF8A98dwu2Q5GEHKLMfNl6BjGFD0Z5uA6c2QIw+e5Ap8N6/zdIA08PyJQA+OW8m/9Q+aLV/A8+dPUTTJ98Vd4JmjsqEd2HGrWJoGeeSCBGjEISKSRDs3la8pjfxW/ievFK2gZiGqJDFE7srgzKw1YKMO4fRZg2DjKmisMWex4rqP8Gq9dv6MB10M/Yv/o3Hc696nh6HcjmMWV8RDwN9x1xg0P19z3vtyeVSepWbBMaVpzDrybNVAuDGr+yZxiInHWSVh+s5rq47rDvfbqws2vV8z3GO3TKAv3VcybaS0oi7VVSUw+tM22+Q0yPx2YoVEpc+T4h/494PwWFwgS7K2SYm+WW211ErvsOzl/aqYK/EtBOnf0HDkPGB4wDw3aRSjhOjmOFzQNx30P1xxG4gyYIyOBUQFzZaQKwLBQvKktwGy6+q7XJHVruSSgrhR5YiTVthSaBHpmgu2urydAg0qFeTrjqRIJsOyWs4KXim/oMhWWj8Q2gqQFkLz4figIr7MMKjnUB/E2dH6vw93fMjCM277SCaPw3XNBzCP4N1BgBodkyMVR+ZK87pjcYm+UFMo0TOxowP1z/3YozworjpwiyK+R6durZXo+lDeQ6owtdU3p26rf2vNJTYDGWh5U8g9WD7w395d9Fuuxeq4WkjwVgSrtieSpwd1D/x5wDoVTA1xdo99ZorNeUjLLZOIDb8qgScthMrPRGQl7ttIA/YPmqeyS6nhCMLyaFpBCBd09CYzvtQex6IQxxCIIoZZjfTgEnOB7b5g8DO91UcwzErPykMyAlsFI9G3Pp3ci12c2cWbBsEDoP3mzs0GmLPpaBl2zUc4Zu1S8gylb1DZBXgCjHzGknBZQ2kUGO8FVdl3fd5bj9ve8HoOUd+wrQ9y8V1HQ0OcYl3dwCEz4q9bKjfM+kxncugluICeoNRHIdbdbpCDQRJ1Aw7dVy7TtNWq7bkJWs9yTVVFoe7Vmnsdpn0aZv+v7hFtth3602KtVJbFylIuJTqAMzdbti0gAF6cigEhUFFfhLNl1EvXkETkfdtDZYxcpEvUNeAKCpQVYPikglNp8z6+AQRLcnXeLDDUf6xfE9AZamC8KpQ/OnRW8RAZfs0WueuKgck9J4Op7N5s1JvoHaNZbcmHWZ1ZJwB2vyX+MXyoDQxm8mKQ5R4Hyq+KvBi9yI4cnAGUZsqjNY7p+5noO11PxXN30l84AcZJMvfD9s8cvlktmPCcWWlZ0J1I71VqhFYpahT8dBGqxaZwzfVsd0KC4aOaWyuaM7WVvvvR5+WidrjyvZO7/4T8eyftlV5KtqIHaoCJPRaDQEGGGng4C5fVIoiRQNoiaLM5tEoujRq6e+4kMvGK1DMLoOSQEAkAiddfgHYDvqIUefv9UwSjcBlzPp4MsNTDQrBbYGSMzTJuzL1spf07ZI9EbS0Xzpe1+Ld1E/wAtOkapZwCOsNWHxG9KppwVCgUhdIEW9V3PwKAi9SsZ7iyP7mSz8znjvZvvdZFA/fA9v5B0OYua6w2b5abF30gSyJPTePT9DEM/PV0EasyBctE6PL9J+ShbrA1yj7WoKPutioX79/dg0JDfUpa/UJxws73wR+6RpyZFAmXD80FOB4GqKQJA+w0NrDyGWEsEKY1OfE4GQcvzhbms5d7Ro5//KmCqMCXFKQNmTBvaz/sBKl2Fes3PGKl9rgzG+5E3Pi03LPybWOy1Eu3gXLFprptwD+7q4doCA7ekZNXJpHvfFq/LlirZoumsmdOMCE8vD3fy6PraQOdzxnvjnMvr4/qJewyBtuoVmA7teLlMvOstSc2sRX/UPHGUogNwh6ARl8Dds/5WcGWfJMoNHtR0o/F+RmZt87LdFW/v/0eR52qfRlm3/9j/fnBbsTPZWl0eb+ceXo04uaOGFejuoX8PWGF0V+CR86BqvzMaJgEa8EwrTPlF/5AR126VwaMzhMF22yNpM7J3RwyF4GmYB+gR7QG+NtD5nPG+8/dcwXw8viFAKF/PxndnQ9CgLYxfJONufV6SNxdJItN30FsB9eTuOU2YINlQUeCOv1Qgad0x+VMYE81x1Z3z6vMhb1paDZKpO1kkjpNZmP7DCOO9jg7fgbxqGQWYjE/vJ6rfGH0JR3zOqPSMzzoocIlccJNTElcekZvtsAh1JYf9U61ZgAu0TSLun/U4oG+3QZ0jl/AaBnRtFr/DFXiVSwy/FWdvlrvstce2fdAw98CBA/+i05RnlxUvlI++LbPs3ThbfdP07EaJhCodBUKLI9G1VUA3gSMOYCwmaVooK7dZbeGcsblKxt72pgwcuwpaKCfaIQwBc4XR6kfAxNBWLDWB0CbKKSAUFKaiOB5D3Zw7GTh6e42bL95joSXgd0cyeHDgUjnvRoeELf1eEpwgTycj03DF3SRQEyeALuuM0qSRaJNMfuwzGTLxScjwYhlO96WQ+TDpmQvMvSwaoBy7yvLJ5ZoWFKcFNB9mrZ8w04BG2kMC54KEYWGNmY3fB4FOWifXPfqpzNxaI8nQPhmLgv2TINFpwV9OQdbx3IQxJUjyZWhCzqmqBWqQKK9N33MLrN84kDanxBIzq4oX76l0/vVQ/Uidnjy/MAXyY/mlGYm2iqKofDrXQ7NCg8fZ9YpwrZjfC5eKbSNQ+s7hN+Ps9ZJqa5DwZb/IyOlOoUP7MJjOzJMzROVN0vLquBJoB+HoJjBZmtfY+TI4hO4gi6ApLIeAr5NJd38giQycrAuCFq3INOFNuAfJk4FP+JrbpekjmggFIciyR4YEr4BcpYl/IC2dJ8RXaYzu5fG3gH2CqYo7E6hf4DwZjvP83SFqamqOnIXv/MmySyxPFclMKAYpeSA7EJtBntQiVbCXU1gwVcTZRqDs31wwpn85EyxS29QIlD6zFigksVl16Fu19ffmVL6Q90nlZaCl3om49FvLsr1F586yF7wfY6tojsRow21b3Cvf3TsPON+hHHJxXZrwJFDNYZ8jEGNNNsqMzBrhHnXfCUth7qCh0eBsePq1DSd56gRqCEq3EyhGaL9QmDahaTCXMqAJL5e/ROyQmDUFEKImtY+fMU0VgaKu3D2nCRMJkO8k9h8cGcYx0tkgKSCMqPTv5NyrN2s+oUpb1FbB3cnibwX7BBc+Cb7WprrwOoAECuKmJjqWC02wtK5aLdct+JvMdNSqmKAMwUcL1JVAmQPqlAmU4GtFoOgvIE9CmyLUFSj0H2qjFltt623W0p+XvlDFXEd9izxZeNPznz2SnrK1uJjxGrkTIJwkh6O7CvqtUG4L0GwZukyRKM5pDvvNkgCtjg2YZINKv/6oXIwPB4LM6Dvny7kaEKgxh3M6CZTg3NBwuoPA1BpyxUZleiXD1IgEyUfkQ7houqOeuLPK3XOaMMENI4wuxUhTkfmax4lysLdWyfhbXoZVsxSyjEH6Us5Zts9XdjfUnKfyZ14IKy4NpM3+xG3KaTIY5nvgjOclIbNMzetzKzeJXoXjg2Kj+r8iUL3PdpVA28CFaM1816AtTCvgWiq4EPpQsr287oncw89l7i86V6ekvlfoXP9YbuX7lq11TXxALTan+wr6rVBxMnUCbQ/3BhKiRofGi0Pj0Xk3FWQ1Zc6n4nPlOjk7eJF4hyyCKaJNepNEeaRwtDsQuxee3wIK2MjAdBk6Gtpn6AoJTH5B4jaV4P4bZToQvo3mB/cGA9yd0UWhMnGGwQGtzQbSxGtqoGEgzyjIeSLDt605JBdNtYvv6EUyMoCbNrqfQNVGEBAmN4GM0MEpMK66+4cuVfEnzr1xq4Qv/YdYchrQ10GceXQl4vZujUBV/4d8a4u/2mu3z9oBhsbZrnWq16gDtdOR32HfB6iFTkN/n+Eo/OHp14pm5Uv+H3Q66ptl06vVD8/Kqiikqcogqt29Eq92HnQgUG1+RFUwt5CCRLm3XKUb2FgsATP2yH+PXSbnUBvEiKlyh59uAoXQjQpYLEMDl8nI6zLlprSvYL7UQqiaZBpGULpb0O2C80JabqHjn9OECTVvaGc0f81UDVOywz5VLymOGrn24Q/FL3QVSG0J5Ll7ZZhwJdCRLgRKF0GvscvlrHGr5Mr73pXkzCr0QUZgaydPpnphSpUOBKr6a8dndA/2aZrq9CU1yBPPraa8tAGFWQpibWrarjXWXlH02PMlW/YfrfPXaajvlpe/k/83f1fFvqStJbXxGJGU3+ZxFfTboeZSMDLzqAhIrewZar4OVHY8GmCGvV6mpn8jQ26yylnBi8VLN90pBCRRCsnpIFDuPBoyOl38Q1bLhFmvS8KWcuXszy1myvmf87Z4FmWGuDybCRMdgL6j5JykA9AcjgCBRnL3HUg0fn2BXBy1XXzGLFNz7W5l8ffAIFD0FS7AkkBJ1NyO/MfgpTIKvx295ogkZ5PUNUtQcyfiFJW+UEoFCsRJAiXcPqcbsA8zv5VxDQVYbEwNw3QhVNDoe56QWVI1K69wx5NvVob2WqqO7i7292uC7sk+/G6ivbTxlFwXugBeT5m+BK+tE6giUYNAAb5PcsDc2VItY+9+SwZOXC2DIBA9QaC8nk/QMrlwao5ELP9RrRKqnDD5mm+cMTnO1yRSd89pwgRJQ/kJg0iVxQVE4zXJKQYkmprdIDfM+7t4X75R5eF3J4u/B4znQGXAIFAe/YMXycCQxXLOFU/KlU98Lsz6wPvquOADrVGH6ptK2dEJtEsaKK9DItZgKBqKQEGe8Y5GScLzJzqqWm+xH/0ybdcPUX1y4ehEhQ+z4LmCGbfain7hyri7CvqtUJqmCwzy1NBR26WGmmQHca38Rc4Nc8qgYE3Iho+ZB8zHaEpB6X4C9YXQ+V62Vq64/31JyoJ5k10PrRPaOAiUwsatZ/ROUPv5Add7NmHCAP0dqXEyDXISo4/ZNLcmyn0EyCkOGlr81iq5OPUlGRSyBHLsXh5/C3gtbun0U32Dmud8kOkCGYzjWSDQv3A78tPlYsE9RuPejHQt7HPMbW+k99GUHFqK+NyAm2ftDKVcuFpq+Dv6lXMlnwpJUnaNWOyllY88W7L1uU9/9tKpp/8U+zet//exHVV74h11DawQQw1XFdTFSnQHLr50NBHYQJo2qjnrUkvVKpy/Y0GF063pmgfeF78JK8VXuTKRQOlkbwjLqRIotVcDnT7DNX1D0uXimB0SvfYIRsoGiVHxCbWoNCrpGToChY17hCNOw/5gE/0D1L4Y25IEmgySmmkVaHyU71YJh+yHY2BOBMFOXf6zjLxus/I0OU4eO8iqu8/dQwUAV/vjdQLVHezPAYH6Xvuk3JT+FUgM9wb55fZJpRgYQJ+jiR1PM1snUEND7WrfVy5KJFD+HTVXIAHnmG2Xq/2J9jK5Obf44NoPm6N0yul/JfP9+im351VBC60B2dVJWE6dEgpWomGSqMpV5NqxAk8EtQOB5Ani1LRQkjJHuE6jHMDrMxUuE87FPlUgf47ZBlNniYwYnSEjL4EmOnoOSHS2+AfMkSGjIVyjITgBEBzAO1ADo2z7BczXEDhX7bzwG/O4DAl8DHhchgY+IUMCZuM1dx1Bmw1eLCOueVImz/lc5cOOgwbOKQUSP00Z5YIF8P4oIKYGauJEoKxzIYaybYH2ZSyeUnbouhcJAqNbExMpjrttv/iMXSleMLu9oRBwbzzDyw2FjA6jrAY8gteP6vK+APIMWdUzNwwZ7QJ8pmEe5HyO+KOPjLhkgYy8eKEMDeB+9yUy+rYXJN5aIgkwo2MhvyRQwz+bC7uct1Upq0GkRr9UBAqovunmWTuiFc/XoECNVvEErqs0Ujw3lLLWW+3HCpa9Vrb2mUOtf9Tppv+VfJE/LH+1etcMZ0FNbF6lTGe06ByMWqiMRIyoNEs4L8IVaars7ivzt4HXtdi0BSe6DyWAvK+Zd1CGXLFFRgWslKDxK2X8NYslZPJcYJ6EXLNIgq7JkMDJi2U0cMl1GkZfx3PpMmbyIgm8Lk0CblgogdcvkODr5kvo5AUSes1CCbk2Q0ZftUyGMtTY2CUyJuk5iYF5w9VCbVqB0O/NRYiUaWKcN2Hi13BC8gG58rj6mFwwPU/ODl4qwyctk0snL5cx16XLWMjruBvmy9jr5kJe50jw5PkSNDkDWNKG4GuXQIYJ9ocMIB1Ik+DrF8pY9IXLrlwjfx69BES8VIbdsEVuWPGlJGyvRb+l0zyUH53U3d/fbwGuCYUrNpfxRJu1aQtcezoIVHmwZJWWPrbjmP2NLxou0amm/5bnvq7xevzZI/sT7SW1MXh4Zuej1piQzTieNGupnXG0dVeRvx0cCRmp2oIRjCvgsWjs+K3lEpi8ByNrhsTfmif5e76UPW9/KXvf/rvse/Og7H3r73j/hbwA7H7nSwW+fhGf87MX3vpSnn3na9n99tey562vZO+bX8m+N76VXa98J/ekvSTDJqbJ0OvWS1j6F5LMuV+Ovm7uzYSJ7gQ3Y9wCornm4QNy1mXQEKevl1XZf5Xn3/5eXnjjK9kD7H37K3kR8vvCm5TnLztgn8IXAPrB2wd1QN5x/vk3v5O1Wz6RcZPXih+Ugwn3vQ6lpFxittVLBGQ8HsRG7bP7yFMHTX9OewEMMK12NvI3bJXNtzkPvf3kW8VX6hTT/8vWt8qvvNtR9kVsJgNoaGo4TXqOMMpdARXDbZluK/I3Qm2D43wRoCbjmXLZWS9hi7+RUdetlUmRy+Wl9/8hdSLSDIi0KrRKi4L2v3bWKPxeLVCvv+Zn/M6XP5ZJ8sNO8Z00T8bdtVeSMstgZjTgPkwCNdEDAMHQ4yRhY7FcBEbzv2KOrHS+J+VNIvinQHk1ju4LJZnfaNSPLer/0qZWWW19Q86d8IRcGL5FItb/LHH5dRIO8z0SJMd+xnz83UqguJYiZWeLMEHcdLr/4XycvbH1lqyC71ftP/rwX4+2/rtOL/2/zBH5p9Uv1y27Nau+MDYLGicqKBJaYVQedy80qxFGzY90rsjfATrtcrGGIfao+UZsA2nnQcgyK+Tye18Wv3H3y62PbZKfi6pBhKDC1gbIDNAKejTA9y0QqBaIXQtItbVZGiBWjTi2tELg8K+mplm2Zr8uf7r6QTl3+loJW/WdJOHZ4jjn6ea+TJg4HaC8WTBoX7/wU/Ga+IRMiJwv7332izRTtFuhDLQ0SVNroy63OKlAuW7E5w1AHQD1AEcNDYps3/v8O7k8Zo54T5gtk+d/JJacWgnLbYA5rfl+qoRup4FA1TXRh5nf6KZt3IklMtNWWZHxTGHm8x8f8dOp5cwpz38u/zl3V7UzOaumjGmJWfnMkUKn4Gg63HNutBs1Nk4+W+x0uIWGC+FSK965OJ/dKOGrfpI/h2+U0ZMfk7zdB6SuARQKSWvFaKuOFK5mCBqlj8B5Dsetzc14WwdhhLA14wS+8tnn30tUSoYMn/iIXP0wzBtbrRogojh14Oa+TJjobtCqo4bGqbH4TaUSMjNHhoTOkjlLcqSsnGQIe4oy21IDkoTcGuqoQaQg2FZ8hwpCCxUFpSyIFFfUyeyleTJk/D1yaXKexG4ulTiQWVh+qwIXshiLU1sMPv6+fg9UzF8oVmHos1PUSn91w0Pbjr6+80DZFNx5//H5PJWy6bWiSx/KLfoAJNpMv7FwZV7DrM+rhDlPEnVfmb8NdKXgHA2nDZpBnmgMnI/CqJZsa5RrHvxQhk9Il/hZW+Xv/yiVRghVPYi0ibyoSBTNBMFSlg0FDmhtAoE2VklzQ4204HVJcb0sX/ucXHDZvRIQvUUFMGGCOLomcc7GXCAy0ROgnFG2GbwnBaQTveRLueC6DBl7w0Oy77W/Ccf65gZomc3QMJtpVZE8dfE2RByk2YQT9ZD9Opyohbw///LXahFqyJXL5IZF36rVdSohJDUtzkWz6l9M59O901WtkkAnfGeTFnHNVie35h77afX+X+4+eFD+VaeTM6+gnf7Hk/tLZtxlr/jRktXYGmNFZcEUiMuvREXVuqnI3wM2KBu2ESOZth1MaYZAIhC3rlxGxzwr509YKiu3vCUlNU1SA2mqB5pg7rTShOcMqTLnYcZj5G7FsbmpVpoaGqUBQvni69/IlZFLZMSV6TJlzieSbAVZQ4jD2OgQMpNATfQEKGc0cSMgd3RzutXWINfev1+8Qx6SGQ9slcNFkNnGFgz+JE8ILrUDapxQQ7VJqQaph8leBxmvwUeU/H8cLpfUe3LEJ3ChjL1lvyRCtsNttBg1S47rCjFK6SG4SNudBNoi8XlNEmNvhEXXKDOtZQVLXilZv+enumE6lZy5ZeOBA/+ydF+Z4xZbeWWCgy5NVNUbQDxcceu+RqBQRfKYbeyd1WJvGtG9UxwtctO8b2TY1etlsmWZvPnJN1KN0bgOBNrIuSKpgRhV6agGahWpNjfVS0NDi3x/tFJmzc0TnwlzJTD1OUnYWC5J/397XwIeZXnt39rrte3tte2/7f/2Xmv13qpd7O1qF6uPe60trazZM5OZJKzK5sYqiLK6AeKCAsmsSWaSsAQSlrAomxAjQUBAEFlClslMZiazL5k59/ze7xsIGG2sQAm853l+zzf5Zs33nff3nnPe854DgsYsLchauvASFw7QdxgHSCkq5KPmVQf9OG0J/fD+KWSs2k0BWKExNgJggTJhgiaTrOMJ1u14MsDkGWbyjIlF1QCT7eLSjfSTO6fSjX8ppsx5DpEWOIgBolY2rjBpMpQNLcjH/vhv+jwQmTrMCQVFbYGnl7XZV+4K/FylEClrDoeunVDlqNUaXUF0HBQxlHMcR0FqFOJCcNnzmCzzzVG12Cu7BbZOyrMzqS7x0O+HVtGP7n6Mpj5npiZXmJgb2Z2PUwKLR2Iuxro71ApKxxYoK6CfzU9TVT39vO90uu7B16jfs0dJb0WhA/5uVqgc/mxlm+nHf5eExLkHjyHWaSTVi9Q51nk9H+9/ajd96+6nqc/QBbT3WLvIGknGU4uisESh3xF249kK5b9j7MLH+EW7952kTP1M+v4fJtN9j22jPEOQ0tjYGcQ6ncVeHYgtD2OJPTu48ufa2xLGD7ZtmgOdEyqbGszbWrNU6pCSkuL3gr8fu8yxji9SEK0/4PoqqUwgHhAdYisoGqIk20Mputvv/kkAgWK2VAgUBVeZQC0hyi2LMMFFKKMkRLrSIA188RD95MF5dFf/6VS9cT9FWLfg7iQYSSwkJfgo3B0cEQhN0r4PHZQ19jW65o/T6NZHNlGuISRin1n8e7ORt1YaVpS5y++RkDhfgJeVzV4cwlVZFsWTE9uZl/jop/pyuubOJ2j262vIH4A+I76PRSV48akgaFLE/TtZvb3+Tnpubg399A+P0y8yjZS7sJnHCYrhoEydUi4S5CmMEaQZMXkqHSG6/21nAL+JgfGMLZ6In8KKFTuu+Hl8jsgHZ4NHa/THh5e27Xl1i+fR2nr31xXWkNJVvrhgneNPw82OHdmGYByLLnAR0PMkt8xDeaVeyucLrMNuIuRz8nMi5ekzxFvETcUNEzcNbgdbh3zjQMRZ/BipHxpzjO589F269o75VDjRRkeaOwRRYpU9ydMxFIu5lKLJOHXy+YAvTi8XvSlco5uyDdR3fiNpREAdvwkECiug50QvIfF5AT1PbW0WRoZKUvC8Hpz9IU/0z9NdA+fQzrpGZk3YnCHW506RXMJcKgwFrM5jIXXDtqN0V795dMM9C+mBaR8QigFhnGRaUZdT0XHFhVe+B9/dI/JkgDxT++bzLVGGjw2PAGWwx9bXpqy2I46rYYNkZPHRIwvWfDRu08Gmb6t8IeVsmTqVrphW1TY53+Q9ieZQyo4kEGiQtGwdord0npndE7ZQld0On41AewKQ68B5Xro5fTn9b59ZVFSxjaJxlUD5CAKN8wzNTr1Ypayrb6S+eS/SdffPpLuf3MG/CxsCuhAnXCj+TIFuvk9C4lxDIVAF+Bs6DY8NRKUrCtFtw1fT/9w+mSZMW0Yut1gyoggT5ikCZYBZ29pD9Og0G11/61P0+7xayl0SIY0dxMcEivWKzznu8DvhESJch/oUemuQz0dokC1JAyqI+jOB5rAFPdTo9s1cccxYs+O976lUIeWTZO3u5L89vdr7Rp7Z3SYWk9CQn2e7HJ7tUPsQbn2qCAFyzpQCBadvyucFlE1nSFCfKfvouvvm0KBhC2j3wWZlVo5HWbkAJlJWMYc7RNNeqKKb7p5Iv8izUtrCFv5tcGugHPhdWKjiIz77HP5GCYlPw5kEquRPQv9ghRZg0XTucfrx3xbQL++dTFW1H7D1idRm9qhYtxHrZ6dehK4qV++lW/7yFN34wHzKmHWESY49NR5vIFDxuexid/f9PQb/JvxGLOIqHmFC5IL35fMgz6ySCOkNrb7Jy1yryuva/4xuvypNSPk0KW3wXD9haWNVgbE1jN0UuNBIBRrANwyzE1b64H4jlnk+knZRlkvzupN+paukG++ZRnNeqyUPu+qUCFMizi59IkIxdudXbzxIt/WfQTf0eYH+OuM90lrDrBDYWQUX/iwClZC4QEi50QBc7JR7DStUy2SlLwrSA+O20Hd/N4n0Y4vpRLNPWJzJZJB1O0Dsb9Gh4wHKfthI197+DN0zegMNN/gIvcVSlid2C+Ixjt39hp4Coa4U4WONAjmlAuYoaYyO8BO2ExsWb3U/uGnTpn9R6UFKT8S6p+MvE5eefC+/uC2ObZgDWQH68YXtX95J6fYIK0VMVHBKlYLr7ub8Y8B+3igVWEL01+kf0PV/Xkh3Zs6n2m1HKJHk2TnhY8SosdFPY5600/X3PEO/f2g1aYo6xHsxg2JvP+KzSO0QScXnmOAlJD4NXQkU5KmBl8ZjCGlNiDnq+Fzuwjb6SaaJfnT3k2Qq3SHymLF1M9HpI38kSS8Zd9KNd82hHw0qpZyXmmiwJUB5WHNgwoTlCfIUPYn4cXe/oWeAccGkzEdBnirwOzVGL42xHj/88obWwfNrDl2l0oKUngpPiV80vBPQPl7q3KsrDsWz2NLsxxe2f3mc0uxhVgw273k2PR8EmsOWpA4JwYtC9Jvhm+maO2bQuDnL2GUPsIsTpWAkTrYVDfSbPjPpBwOWUN/nj5FWkCdRGpRLBNfjosLUKQI9p79RQuKTkbLoUgQq+gXxWME5LM7iNfmo1jTtPbrmzpk0SP8SHfywnV14duM7Y1S3t5Ee0L1G373zFbrrib2Ubwqztxcg9BU79R3q53weAhX1IdhYSeffh3EDIymbjzpzMDnS3HTytQ3O+ZdkdfkLJYh5vLrOP2asuf1AnsmfQOwFldzTrCFx4fMwG55zFz5B2UygsHChdA8+30w39DfQ7wZMp2XrGigYI9pz2MHuzRt0/b2z6PbHtlJucVAEw9OYOAcxUJUGaVfIjxO7nqAY5/Q3Skh8MkCcWICFzsH6zGOCQgogzos0Iz6Pau457DX9umAZ/fetE+jZl9eRN9BJHYwpzy+ja25/km7WrKKMhQE2JpL8/giPs9MEem6AeCpboEjAR597PqcxBpLDDM0nXqxxzt98yPcTlQqk/KNSX09Xzl/X/uIYc4uz0NSh1AzlmVA0qUIqBdwTvsHd36B/AIKUQZ74XChgjO6csJ2uu+8pGjzeQO8edNNc4za64d6pdDObxekLHILIM5hAhQvCiprFCoEwQB4DFgBmfuBj3yUhcR6QIlAQJfoR6USiO5MfdBF1Gfi5DDYOCuwJ6v/ch/T9P86lP/R7lja+3Uwbth6lW/82jb53/wv0wIzDiuXKup0rtkErY+JcIpXyB6NDVx6hocbm5unLm1/acKDjhyoFSPm8Uu+mr7+0tmX1yKLGQEExuxN8Q5G3iR4wovjIuSRQhljdZ8sW7k4uK1n66030S42Jfv6nGTRyajXdk/c6/ef9z9Ifp7xDeSb+frOyrx47ndJY4TCravm3gUChtEo6VvffJSFxriEsTQb0Dh4QUoREojt0kS1QkCh2EmnL2L0v9tHtozfRf/1hOg1+tIaGjmWL9LYn6baHVlKuySeIDd4VGriJdCj1O84FchlYgRc9jrBeYGrzTa5qsVTudcttmudaNh1O3vBCtWftQ0W+QJ5BWQkcZEN3y4hCoLi5YkWwO5x54/4eUIAhl0kxC83fbLAkfdRnyk666b759D+3z6L/umMO/VRfQZkLW0nPCpbDyoUZPYMVE+1I0PcozxpmF14SqMSFBwgU7jBIFKSpR9dKJlHE4zPYs8qyIR6K1flOymdPLnNBK/2or5l+8IcX6YbfzqSb+7xGac/vpzx7iMcXCpyzjvN4UHb//T1gvMFSZWA8inHZBeqYxG8Uuw1Fnc8kE7wv+tjy9jrje8G+6pCXcq7lrcPRXz27yrluuMERgIWHfkrpcC0sykqjsrMoxi4HE1ep4ur/I3VFoXTZ7Prk2NDtMyqsydyFLvp14Vq6+rb5dE0fIz34zAeUb2SS5O/ETIqiIdiCppA5fgs6EKpuEyuOJFCJCwWQkwgbsd4h9xPdMEVTN9bFTBCo+jos4hQwhhmjdN9ju+jbdyykb96+gO5B+22jn7DNOROV5vm9PS9yzgZEWYhdc7/4Tmx60RgZKGYOwwRjsizOnqPitSFEoDf7Yo9WNDfY3o+Mrif6qjrcpZwPWbUn+Otpy0+szTe0+cW+WbgXolkc9tJi1mMCZdc5W7j2KomK893d7O6BrpnYQprNEK4FQ2eJ0wOzj9J/DqygXz+8nQoXBanQxArCCtDdZ0hI9AZoTXEaZoiTfqGfbtCspmuzV9KAV1wiZoqFVKw1YCxkYjz0yBBJkqY0RHmlfh4zCdGHTGtgMJFqeRxml4R5fLLXyASKkEBecSD6iK39XdMu/6gDTue/q8NcyvmUsvdjd4xf2rI+3+gMIECO4iOIWeKG4MZki5Ja2OYJwBpkgOh6SKJ4jyBQYcGqJMouUG5xgO6dfogGveSgoeY45Vswq3f/GRISFz3YqkQJyQJjjIaygfDnOcfo/tkfMvHFhNUKvReLtTwWMB565MnxeEDrcJ05IUgT41LEOfm9ilHD3hwyVPg1emMk9kiJt6H4ncgoB9HX1OEt5UJI2XuxOyZXnFg3pJjdeb4ZIj4jCJRdF8QimUiFS81KAvJEV064M93e9LMAAhWK05VAmag1CMSbI6wYALqIgpy7/wwJiYsfTKCs61omTK2JdRpGAnQbRgnrPPT+VMbLZyFQJk5YnjhmshGTZo/QIHtYrFdobZ2iQ62+2Bt7oszXYNocHHWESFZX+mdIxbu+OyYvc6wrtAYCiEVi6yT2y4s0DYaI2TBpYieTWBjqIYEqioLY6dlQ9uWj2LMG20mZpHukVBISFy3Y0EDaHut2Lrw2dttzBVl2p//dvf8sgEBNituOxVWQZ//KAA2oiFC6IOtOGlzsjo0ra2swbPOP3nPc+011OEu54EL0RfO7/nsfXeqpzTe5gvrSEJMkuwnC+lQIVPSDFwQKS/Ssm/2JACmyVasCFmkGKxncGBH8ZmXKsiEYD9eku/dLSPQSsMeWwZYmtlNmsAGCY7aoXdsdunn/2VAJFAtHyNEGgQ6oiIoaFlh11y8JxB63tu5avMU9ut4t63r+84VJdPG74XvHLWteN9R8MlhY6mPSjIjUCGz/REsDpGDkmtU4aHc3/WzAcgXUv0XKBUMkJ2MnB5ROPcrVdYneitRqPdLvUvqcQkrnU6/9LKEqLKwiDppdgsLLUQaPPz6vK4pEH7X4dxVtCT685zhJy/OiESbRsjr/fVMqj20cYTgWLLB2KOlFfNNBoFlMoGK1vKdKcBaBArBmuxIpFA/HrkomIdHbAP1N6XLKa+suXannBMrjTIS3IpRrQ8wzzh4gFqqC8SfKgg3Fm2OjjrhlzPOiExQfKXnH9ccpS4/VDmZLVGv2KYFwvqlwHT5T2S0oy9mA+58C/31K0YDuPkNCojegqx4DZ+n5Geju/R8DVtvjTMZR0jKR6kwhKjC4YhPtzt3F2/yjGjyeb6hDVsrFKGJ1fqVrfYG1PZBtRs4ZUpl4hrXCpQCJ9oBIz1YcVibET5WkZGVBChAr+z1WLAmJiw/Q3zN0OqXXjI+RaDfvPz2eTo8rZMCgJq5o3mgIxCYt7dhV8o5/5Jbjx6Xb3huk4v3YHdOrO2oHm5xBrSVMWjsWftBeOMaIKqSKOI2qPCKHFMpySikYXRVHVagUgaaU7JSidX2fhERvAev2GTrdhTyFXgNdx4H6ntNAbBObVcLsskdJU6ak9WWK8ZSkQmuIyTO4y7wzPPKQy3W1Ojyl9AZZ80Hwt89Xu2sfMrZ3aE2hZAbPioPUfDS0Mc7m2VFjTpLOTOxm8OzLR6EwcEE+zUo9Q4FUdPc6CYnegh7qcypsJUJiAHYWlQUp1+7hMdMhQmY6GCaGKBUaO4JTV3p3Ve72jpRJ8r1UNh2lHz1b4140wuI8orX4O7NtyBFVCn9oyni2LcUeevS17uQZM8HKoxLnpyiRhMTlCFiWipuPdECEw7BbD2lPqCiPVh/oEsFjyRwmvcHpmFDZWlG+x5/bQsl/U4ejlN4o1j3ebz63vnXK6JLmA3pjNA5LM5stTnT9zLJFKNMepExbiJUB28yYQEGewhKVkJBIAQQKb01vQa3bEFueAcqwgTyJ0ng8weVH1frBpc7GqdUtr1p3OH+NhV11GErpzVJzKHnVqxt8Tz5mDB0oXBSJ5ZtQGzFKaawEg8qDlFYepnRbXLgnqXhnd0okIXG5AgSKJo5oLJfD4ybTHhBjBrVCs0GspkjnCKvj5PRa18vLj7lkJflLTeqJrly0MTbqCavzraFLWjx5FjdbnUyi9oTYJYF2HKnyX1CW7pRIQuJyBnbkYRceiDPd1imS77HwlG/wB8dYHbte2uSeveFw9GZ1yEm51AQuxeLak7dOrThWMtzU1KZDG2ImTFSex9550XPe2slufA/3/UpIXCbIKmNDo6JTdMUdwMaG6NZg7qTBBq//ibLGta+ta8qS5eguE6msa//pzKo248PG9mZdUTiugxvCM2mWJcEkGmVSRWpG94okIXE5IpMJtH9FjPra2fK0seVpjtPgIrf/SXvj2tIdzr5snMi+7ZeT1OwIfu+5Ve4pY03tdYOLvCE9kyaIM8MaFa5Kd0okIXG5AgV60is7aWBplN32YGyE0dP4QrW7cuPBeN/6+vor1WEl5XIS3PhXNnoKxpQc3ZZvag1py4JqZZpPyQOVkLgMIepAiN1FgfjDpS3vz1vjeGbDYf/NbHleoQ4nKZej2Im+ZNztGTBu+cnV+Za21myLP4mGW6KwQhcFUhpkIVcUwN9dnwNSzwGSgCX+uUBKHvRYVIJPnU/pbVeorz21eaTb1yQpF3U8DcHIJLt37+K3feO2tbT8f3UISbnshb7wxdKdHTfNXnnyxbGmY0fyLL4EWhSjsyEq3CNxGL3itda4CrWJnZUViwlTNM/i8+idJIDEfEG4igKK2RvKKSFxAQAyzLChEjxWyxNitVwskAJI0VOBx6hpmylW1FEzAhXqSRQgFylLloTouoCaEoUmt/PZpU3Vq+rcI04mk99SR44UKadlU8PRbxg3ts0cV+46nGv1x7JMISZApQhJlrr7AmQK8kSJLuxgUsgz0eWxQqKnejBJApW4wBAEWpagNCbPdD4i2V3oYhfyVPa6w+pk69OOXUX8WibNDDOJGhGCPE0B0hscnaPL3c0vvBlZtOmA9xaaOlW67FI+WfYR/WvZO4HC6SvbNw43NHp0Rpdw6QewovXnmTyNgZkcBJpnAVGyyy7IMgXFjT9lgaaUN/VYQuJ8A7rGBHm6QAhblpj4hYcUE9DiaI2RjvVYj9cy0GY4nfUbVelzTP7OoZZW55TlLduLdnie3nwk+jN1iEiR8vdly2H/za+tazE8UtJ4RGNqj6exm9PPToJEkTOqYYKEUorK9/z32RC7mhggUpGYD/B5CYnzDbFryIQEd4aRSG+Gx4QmiCEmzgBpSoOUiwpK1ijp2dIs5NegCRx0Ob20kwaZfJ35Ja4PplQ75pbubL23vqn+q+qwkCKl57Jpn+Nr5jr/6EnLXVu1FpcnwxpiBcOuJYVEMWMjtgQXCRDnVIBEUwQK115YpjgnIXGeAQLVMyEWqAQqWgyjo2xpiJ8HogzoJOumKSlek29iC7U4kNAb2wNjVrga5m11T7R94LpGHQpSpPxjgt1Llfs9v3puneP1R8qaj2qLXdHM0jilsTU6kJUVZImYE8gUBIqAvQjaQ5kFgbLyIiYqCVTiQoH1DhYoyjTmmVkHhZfUSZnYgonOsqyvOTbWW3bbs5g8NYY4FVh84RFWx/5nqpuLi+tb+8nK8VLOqTQc9XzDtLl17OSlrRsLLZ6ONAv6XPMMjniRJSYWmECagkQZCoHCfcdikyRQiQsITNyIy6vhJegj6j1k2Nl7wmNUJLPw64ywQCOks7iDo+zNm19Y31ZQsv7If9AXviCrKEk59zJ16tQrVr0f+93z632GETbnIZ3JFcw3dVCBNUwatD22dAqFPdOFh/skCVTiQgJ5nayLZdh2qYScBjFAnhlYMGKXXlccovzF/vCIUu/xKbXOSsv7/oyqehnrlHIBpOaQ6+qi7a68qSta7CNNrc1DDO2d+dYQ5bHSIuUJO5lOEaia4iQJVOLCAQQap8yyOKETA/KZYYXCZdeao5RvcEWHmxqPT1rqqFrwlvOh5QecP7ST/UuqekuRcmGkYlvourkbwjMeK/fWDzN6AnpziLLMccpiEj1NoMoikiRQiQsHdt+ZQGGFppLnc7GQZAgnBhc5Ox63N2+dXX38kZKd7TdvkkVApPwzpb6errTsjvx1To13+SMW98nBxkBMb1FyQDPhOrEyD4IrxdZADuKlUG4otJqjJxKamXCxKqpUxefXgWwFUFYPO0ROb8kDQM4yMf8SAutKt4BuMAQJMrD4k4WWwWXQDeU50RCxC8SmD0bK8sT7tBa2Oos9/pEmx76nlznfWLS9429bkyRLz0m5eGTnyeS3rFtDj8+o9K0ZZfQ16wzBaBaT4YAKor6VaGiHUnnKriakmeSa2TIV6SX8N/JJhcWASlAxfh4WKwDSxXlAIdFUjFUS6CUEkKEKUdBbRYo8kSoHiH5eqAIvCBR6o+iQSEXiz9ExslivUCV+IE/eyOnMLQnEh1qaWyaXNy6dt/pk2qZ9ge+qKitFysUlSHlafYCuX7AhMOEJu6N2qKm1WVfii2WXRMU2uTS2EABR5KEMZBnmAYRmXEyaTKK5sFyxegqLFBAWawr4WyHOlEXysYEo0TuBe3kGlEUgZSEoFctElTA+B/0AuQrvJMIIk6aMj6xDOdAfpC2BVM2hmM7sdIyxtW2ZWeN8Zume2K2yZqeUXiEgUts7/v+dt6Zt5mRb096Hl7QFtUXBJFbpYT2msUWZZmNSLY9QJh8xGODOI3dPgxQTHkTCwvzYwDoLXQehRO8F7mXK6uS/hbdRFmPyjFCGPch6EqA0RiZ6r2OvOusKdCa7DC26A5Rt81FuWZAt0Bh6E8ULikPOUaaWrdNrmmcsedt9++4W2RlTSi+U7cnkV6p2+Pq9UtVuGWNp213AFoHW5OkUFim7YaleTKL+KA8KLbtfcMtOWZgYUF2guHbKa4CPDUSJ3gnVHceuNZAnYpyK1RljAg1TGpOoIFBbSOxnh7eihHOQe4wUuRDpzN54YXFzcGxJS8MzVcGZr2/23bn1gGyxIeUSkB07XFdX7Gr/y5y1J+Y+Unpsb6HRFdBYoolMuPVMisjPyyrDYEJnUMVNE4nOKfLkx7A6UGYMMVNR+UnER+Ha430SvRdJcS9R4CO1cp7JkyoWgRDzTOd7nMEAoWbbImx1MpGy6y4WlDCJmmJxvTHsGGNp3zl9eZPZstOl29TU9G1V9aRIuXRE2VvvzJ1V02YdY+toKLAEHTmmSCzLEqdMJk4kPucAWFQS1igPMAZWV7UqUFlHA5dfEuglAtzPCCPI954JEgTK58WWYD6i6SHuv5KxwbphQ9w8RFmWIHssgfYRpZGtEyr901/f5L/vrcOhaxE+UtVNipRLU2oOJa8u2uHrO2WFY9qYirb1w6yeZr0lFNWgPJ45SnmWCCPGhAlrUyVOMYAYYnFJWZ2XBHopAGXmmEBLmUDZsoQLDwIVhWowgZpQTYmowJQk3ZIY5Zn8iQJrR3iUrf2jKTXeRXNr/Xdtld0wpVyOwtbClxa/2fbLmataJ423uTY8bHK35hvbY/kWLw0uC1MBW5o6kKiwPHkwMUTsi61UxL4kgV4K6OrCY+VdSVVDDBzV4Qv470JjkIYsdsdHGtzOJ0o9e2fVeJcZ64Ijao57f6CqkhQpl6+ASEs2u3/20tq2yVOWu9aPKHU2643OqN7kTejMbHWo1icGlYiP2RAnQ7xMLiRdCkgtDirpS0hzw72GN+Ilvak1NsJyvG1yZeuWF9Z6ZizfFRm07f3kdXa73HopRcoZwkR6xdL9kZsW1MUmTF7lrRljcx0canZ5dMaOmNaMfFFYn0TptqRYxc8GYLVg4elsaxSr+Ayxmt8VXV/DUAo+o4I+oL7mY6+/1Ika/x+uX1fA2u8OuO6p6w2o1wbXShBhF/DzAgi78POp7Ap8Dkjy1KYIPofXKwuGbIma/TG92eUdbm36cPzypvUvb3XOrDgYuu3o0aNfVlVFihQpnyRYCNh+InmNbZc3+7nq48+Ns320eoS19aN8kzeUY4kkMHixQpvJbn62LSjyATPZBcxEegsGMgYnHzPYcsWulFMDV0WKHDGw0c9Jw+QpFqaQiM3vEQMZEK9jq0gQNb+3C06Tz6UAnkSwA0wUGj7tSotYJAMLOtgWiXYXGbYEZdrCPJFhRRxbb5HQrhImQi0MrZmE16Dje6KzRigP1xb3gc8hrpnB1zWNgQpJqCmbhm27PEHmGYKRISbnifG25vXPVp2cZ9rcoq99P/DLqqamr6qqIUWKlM8ihw4lr7LVOX/4fG3zkCdXuMtGWNt35RvaHVpDRyjX7E9orFFBgtjBhPQnDFCQZxo/Hsjn0VxMw4Mc/ZvyLJ2kZQh3EQOaXycq6jNAyGLRgp9T8kxhOanbSfkodkiJ51Xwez5ORL0VmCTiCiGK0AhIETmWiEfyc5hE+P8XRwauCa6NqFeAa8/nUrULsFKuXLM4X09ManExsWUxeeK65eL78Fkm/h4mzRyLP6k1ecIPWd2NTy73Vc9d5xlT9pbnV9tPeP+fqgJSpEj5vAKrtKre9+3F29r6zFjVNH68vck2whzcU1gc6cgvinTmG7HgxBYQExtaMafblf33aXakPKH3TYTBFhETqSBcvA7kyQMa1hWsIZAoBr+2JKIiLN4rOo3yoBepVGxdAcLlPEVAvRvC2sSGBoYgTAYIEWEN5NyinxCunZ6vnR6r4Wqld1Htna8JJhyQblZZlD8Du4eQ/B6lfvx5A+w8mdmUSQo9tHSmAOUXOxPDik8Gx9hamqascH3w0nrPStO2jlGr9kZ+XF9ff6V6y6VIkXI+ZBNt+hfzjsbvzV3j6zdrZeiVCXb/W6NMnmNDiz0+vTEQ15jYtefBn8UDFwnZ2OmEv4U7LqCQp4LUOZU02I1F7xw0HQOBaplAURBa9AlXSePSI1DVVVePIkTB10NpVx3nSSdG+ZYoFZh5IjIn+BpgMuHnGeI64DqyxZopqm51UrotToNsndSfr/9AdvnTLCHKNHrj+UZXYLS52TXJfuLA89UnDObtzsdXfxDK2n3M898k63FKkXLhZfuJE1+p3uO9ZckW75A5qxxvTKx0bx1T6j9eWBwK6IqjnRoTD2AmA3QTHcgDGpYmLE4sYIAkUgShZ4LI48cg0VOLUoJ0GWxhIbaXAqyuS8uFV0IZKYg4L/4/kKMAwhdKaEMkurOrjxoGKD+IlDKxsCSsVlwbvlbYBGHGKnqgM8/iCRaUOBvHlLe/PXuNx1y83Tt72V5vxqqdR78rV9KlSLlIBC4+9j6X7HTesmhL8OFZq0JvTK4Ibxlj9h/XmQPt6eZAKN0STGAfvqjcgzgdE2Y2k2eucOvxN1utTBhYeELrByx2pCyzdCZblEdDU7IMuKsgDJV8LgWImC+IEsTJELFhPo/JRvQRwgTE6M8Wfb/yThpQASsTWyr5elpDpDX6qcDkTxQaOkJDDX73aGtH48QKx/ZZNc6i17d3jDXWue+sZK+hXi4ISZFycQvIFBV4ag5Gf1byTnjY/Dd9L05d1V4xvqK5YbS10THc1BTWG9piuUZvZ5YlItx80TPnlMXFBAIwiYiGZHwchNfYO2lgeYwGMURNSn7ukgBb2bDE0dcKk0mOla1KhD5greO6oAMrox8/fpBJth9bnKJItiVIOWZPLN/S6h1Z0nx0fHlTw9PLmpfO3+CZb94ZHln7vve+XYeavyPdcylSerEcPUpfXr/H/x/r9rT3KdvWPPmVdSct06qaqkeVO7cXlHhPZFoDgYEl4URmSTSpQ5dGY5S07PqjOlQ2W2ZYAEEHUixIDbRHaYAtLKzQbsmoN4IJVGyjFQQaY2ucj8JCh6WO1KYwu+ghRiSZYwmHtcaQe7Al5Bxl9384cZm79plqx9xFb7cPX76/vY/t3RM3oIMrT2KSNKVIudQE1tBRD33jzQ8jNxre8d/9ytvhEc+u9y+ZtMqz+dEKx57RlsYPRxqa3CNMrvAQozuqNXQk8swgFHbbmWiQwJ9uU1J8uiWjXgjEPNEGAwtpaFOtYbdcY/Ek8k2uyDBLW3iE9aRndGnjkfGVrfXTlrsr564JvVi0Pfp0aV1IU30gdkuNy3U1G6iSMKVIudxEiZ0m//3dI+6fvXXQm2F91zv0pU3Oec9Wt1Y+tcy59jG7d9/o0mDrUEu4XWeIhLJN0US2Oc6WWDyZXcJHkQ+pkKnIcewlQMwT/wNbmfw/xDozLVE/w6kpCTsLbEHHyHLPgfFLHetmr21b9vrm9pfL6n0jVr3v7lvxdtuNR4i+TpS8Sr2EUqRIkXJaDiWTV+1z0HdXf5T8YUl9pL/57cj4hZvjs+auDVtmVfm2PVXpbXik3NswxBZ8b4jV/1GBJeDVm/xhnSkY1pjC4VxTLMokS9lmkFSC3eKoArjETFyw9MRWRnWhBrFGsf8b6VZnQdkqeeY58R4VSgoWfxdcbWx3tUTYeoyQ1hIWj7PMkWSWKRzNNYfDOnMonM+/U2/2hYZYva6Hy/wfjFka2v1opf/NiVX+N6at7pg+763gNGND5yTrns609ceSv3rXkbzB4aCv8URzhXp5pEiRIqXnAiuVceWRI+6v72+J/rT+o8Cfqg8G+xXvjgx8bVt4xNy3Aq/MqfXZpq7qsI9b5i9/fGmwdmy5/9DIso7m4VZvyzCLR2AIo9DibdGZPY5cU0e7xuiLaizBhMYaSmhKQokcSyCRLeA/hSwT4EtkmX3KOey+4qOWkWcJdGpM3mCeub0t3+xsKWQMYzxkcbWMsra3PFzW3jKy0n145HLv+sdXdFRMru6wz1jjts/fFCh7dUtwjnFHOH/F/siAqoOx36ApIP+PXyU6+mU+yt5BUqRIOf8Ccm1qavrqyWTyW3vbQ9fW7gt9f+2+6C9W7fNnLd/jHm/d6Z60aKtv0mtveifNXeeaNLumbdIzVa2Tp690PfdMtXfF09XeHVNXeOomL3fXTVzRUTdhpY+Bo4LHl3fUjRPn/XUTV/nrJjGmVnvqZlS762au9mydubrdOmu1c/qc1W0T561vm/jyRtfExVu9E0vrAhPte3wT7Hvd2qX7vL/dfDJyU4MnfP2JYPIaXzL5HVjZ6r8gRYoUKRefqJbrFYwvwapjXKniX+vZ2tv2kfu6rUfbb9162HP3hkOu+zfsb7p/w96m+9ftaeyzbj+Dj6vVxxv3t/TZsN/Br3Hcv/Vwy93bjnnu2Xnce8uu5uR3TiSTX8FnqsD3APhe6XZLOY/yhS/8H5viNb1elubxAAAAAElFTkSuQmCC' } );
                        )};
                    } */

                }
            ]
            //'copy''csv', , 'print'
        });
    } );
</script>

</script>

<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    var carterinha = button.data('whatevercart') 

    let pdfWindow = window.open("")
    pdfWindow.document.write(
        "<iframe width='100%' height='100%' src='data:application/pdf;base64, " +
        encodeURI(carterinha) + "'></iframe>"
    )

    })

</script>

</html>