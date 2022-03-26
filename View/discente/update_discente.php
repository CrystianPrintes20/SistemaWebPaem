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
   
    <script src="https://kit.fontawesome.com/b7e150eff5.js" crossorigin="anonymous"></script>
    <link href="../../bootstrap/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    

</head>

<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <?php
            include "menu_discente.php";
        ?>

        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Atualizar Perfil.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <!-- Alterar informações pessoais -->
                <form  method="POST" action="../../controller/discente_controller/cont_update_discente.php" class="needs-validation alert alert-secondary" novalidate > 
                    <div class="input-group  py-3">
                                
                        <h5 class="card-title">INFORMAÇÕES PESSOAIS</h5><br>
                        
                        <?php
                            include_once "../../controller/discente_controller/buscardados_discuser.php";
                            //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
                            $endereco = explode(',', $dados_discuser['endereco']);
                            $rua_travessa = $endereco[0];
                            $numero = $endereco[1];
                            $bairro = $endereco[2];
                        ?>

                        
                        <!--Nome-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Nome</span>
                            </div>
                            <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40" value="<?php echo $dados_discuser['nome']; ?>" >
                        </div>

                        <!--Data de nascimento  -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Data de nascimento</span>
                            </div>
                            <input type="date" name="data_nascimento"  class="form-control" aria-label="data_nascimento" aria-describedby="basic-addon4" required="" maxlength="10" value="<?php echo $dados_discuser['data_nascimento']; ?>" >
                        </div>

                        <!--Endereço-->
                            <!--Rua/Travessa-->

                            <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Rua/Travessa</span>
                                </div>
                                <input name="rua_travessa" id="rua_travessa" type="text" class="form-control" aria-label="rua_travessa" maxlength="100" value="<?php echo $rua_travessa; ?>">
                            </div>
                            <!--Numero-->
                            <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Nº</span>
                                </div>
                                <input name="numero_end" id="numero_end" type="text" class="form-control" aria-label="numero_end" maxlength="5" onkeypress="$(this).mask('00009')" value="<?php echo $numero; ?>">
                            </div>
                            <!--Bairro-->
                                <div class=" input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Bairro</span>
                                </div>
                                <input name="bairro" id="bairro" type="text" class="form-control"  aria-label="bairro" maxlength="60" value="<?php echo $bairro; ?>">
                            </div>

                            <!-- Qtde pessoas  -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Moradores</span>
                                </div>
                                <input required type="text" name="qtde_moradores" class="form-control" placeholder="Atualmente quantas pessoas moram com você?" aria-label="qtde_moradores" aria-describedby="basic-addon4" required="" maxlength="2" onkeypress="$(this).mask('09')" value="<?php echo $dados_discuser['quantidade_pessoas']; ?>">
                            </div>
                        <!--Fim Endereço-->

                        <!--Email-->
                        <div class=" input-group mb-3">
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >@</span>
                            </div>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email" aria-label="Email"  maxlength="40" value="<?php echo $dados_discuser['usuario']['email']; ?>">
                        </div>

                        <!-- Função para deixar selecionado os comboboxs -->
                        <?php
                            function selected( $value, $selected ){
                                return $value==$selected ? ' selected="selected"' : '';
                            }
                        ?>
                         <!--Status Covid-->
                         <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="status_covid">Sobre o Coronavirus</label>
                            </div>
                            <select required name="status_covid" class="custom-select" id="status_covid">
                                <option disabled>Atualmente você apresanta algum sintoma da COVID-19?</option>
                                <option value="1" <?php print_r( selected('1',$dados_discuser['status_covid'])) ?>>Sim</option>
                                <option value="-1" <?php print_r( selected('-1',$dados_discuser['status_covid'])) ?>>Não</option>
                            </select>
                        </div>

                        <!--Grupo de risco-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="grupo_risco">Sobre o Coronavirus</label>
                            </div>
                            <select required name="grupo_risco" class="custom-select" id="grupo_risco">
                                <option disabled>Você pertence ao grupo de risco?</option>
                                <option value="1" <?php print_r( selected('1',$dados_discuser['grupo_risco'])) ?>>Sim</option>
                                <option value="-1" <?php print_r( selected('-1',$dados_discuser['grupo_risco'])) ?>>Não</option>
                            </select>
                        </div>

                        <!--Vacinação-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="quantidade_vacinas">Sobre a vacinação conta a COVID-19</label>
                            </div>
                            <select required name="quantidade_vacinas" class="custom-select" id="quantidade_vacinas">
                                <option selected disabled>Selecione</option>
                                <option value="1">Tomei somente a 1° dose (ou dose unica).</option>
                                <option value="2">Tomei as duas doses.</option>
                                <option value="3">Tomei as duas doses(ou dose unica) + Reforço.</option>
                                <option value="nenhuma">Ainda não tomei nenhuma</option>
                            </select>
                        </div>

                        <!-- Caso o discente TENHA tomado somente a 1º dose da vacina -->
                        <div id='1' class="qual_vacina input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">De Qual fabricante voce tomou?</span>

                            </div>
                            <select required name="fabricante_doses1" class="custom-select">
                                <option value="Butantan_coronavac" <?php print_r( selected('Butantan_coronavac',$dados_discuser['fabricantes'])) ?>>Butantan - Coronavac</option>
                                <option value="Fiocruz_astrazeneca" <?php print_r( selected('Fiocruz_astrazeneca',$dados_discuser['fabricantes'])) ?>>Fiocruz - Astrazeneca</option>
                                <option value="BioNTech_pfizer" <?php print_r( selected('BioNTech_pfizer',$dados_discuser['fabricantes'])) ?>>BioNTech - Pfizer </option>
                                <option value="Janssen_J&J" <?php print_r( selected('Janssen_J&J',$dados_discuser['fabricantes'])) ?>>Janssen - Johnson & Johnson </option>
                            </select>
                        </div>
                            
                        <!--Caso o discente TENHA tomado as 2º doses da vacina -->
                        <div id='2' class="qual_vacina input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">De Qual fabricante voce tomou?</span>

                            </div>
                            <select required name="fabricante_doses2" class="custom-select">
                                <option value="Butantan_coronavac" <?php print_r( selected('Butantan_coronavac',$dados_discuser['fabricantes'])) ?>>Butantan - Coronavac</option>
                                <option value="Fiocruz_astrazeneca" <?php print_r( selected('Fiocruz_astrazeneca',$dados_discuser['fabricantes'])) ?>>Fiocruz - Astrazeneca</option>
                                <option value="BioNTech_pfizer"  <?php print_r( selected('BioNTech_pfizer',$dados_discuser['fabricantes'])) ?>>BioNTech - Pfizer </option>

                            </select>
                        </div>

                        <!--Caso o discente TENHA tomado as 2º doses da vacina + o REFORÇO-->
                        <div id='3' class="qual_vacina input-group">
                            <?php 
                                //Separando os fabricantes entre os da 1ª e 2ª doses e reforço
                                $doses1e2 = $dados_discuser['fabricantes'];
                                $reforco = $dados_discuser['fabricantes'];
                                if($dados_discuser['quantidade_vacinas'] == 3){
                                    $fabricantes_dados = explode('/',$dados_discuser['fabricantes']);
                                    $doses1e2 = $fabricantes_dados[0];
                                    $reforco = $fabricantes_dados[1];
                                }
                                  
                            ?>
                        
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">1ª e 2º doses, qual fabricante?</span>

                                </div>
                                <select required name="fabricante_dose3" class="custom-select">
                                    <option value="Butantan_coronavac" <?php print_r( selected('Butantan_coronavac',$doses1e2)) ?>>Butantan - Coronavac</option>
                                    <option value="Fiocruz_astrazeneca"<?php print_r( selected('Fiocruz_astrazeneca',$doses1e2)) ?>>Fiocruz - Astrazeneca</option>
                                    <option value="BioNTech_pfizer"<?php print_r( selected('BioNTech_pfizer',$doses1e2)) ?>>BioNTech - Pfizer </option>
                                    <option value="Janssen_J&J" <?php print_r( selected('Janssen_J&J',$doses1e2)) ?>>Janssen - Johnson & Johnson </option>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Reforço</span>

                                </div>

                                <select required name="fabricante_reforco" class="custom-select">
                                    <option value="Butantan_coronavac" <?php print_r( selected('Butantan_coronavac',$reforco)) ?>>Butantan - Coronavac</option>
                                    <option value="Fiocruz_astrazeneca" <?php print_r( selected('Fiocruz_astrazeneca',$reforco)) ?>>Fiocruz - Astrazeneca</option>
                                    <option value="BioNTech_pfizer" <?php print_r( selected('BioNTech_pfizer',$reforco)) ?>>BioNTech - Pfizer </option>
                                    <option value="Janssen_J&J" <?php print_r( selected('Janssen_J&J',$reforco)) ?>>Janssen - Johnson & Johnson </option>

                                </select>
                            </div>

                        </div>

                        <!-- Caso o discente NÃO TENHA tomado vacina -->
                        <div id="nenhuma" class="motivo input-group mb-3">
                            <!-- <label for="exampleFormControlTextarea1"></label> -->
                            <div class=" input-group-prepend">
                                <span class="input-group-text" >Justifique o seu motivo.</span>
                            </div>
                            <textarea required  id="justificativa" class="form-control" name="justificativa" minlength="10" rows="4" cols="20" placeholder="<?php echo $dados_discuser['justificativa'] ?>"></textarea>
                        </div>
                     
                    </div>
                    

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Atualizar Dados</button>

                    <!-- Confirmar matricula -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Digite sua MATRICULA para enviar as alterações.</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--confirmação Matricula -->
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Matricula</span>
                                        </div>
                                        <input name="confirma_matricula" id="confirma_matricula" type="text" class="form-control" placeholder="Confirme com seu matricula." aria-label="confirma_matricula" aria-describedby="basic-addon5" maxlength="10" onkeypress="$(this).mask('0000000009')">
                                    </div>
                                    <!--Password
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" >Senha</span>
                                        </div>
                                        <input name="senha" id="senha" type="text" class="form-control"  aria-label="Nome" aria-describedby="basic-addon2" maxlength="32">
                                    </div>-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button id="bntcadastrar" type="submit" name="submit" class="btn btn-primary" >Enviar</button> 
                        
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Alterar senha -->
                <form  method="POST" action="../../controller/discente_controller/update_password_disc.php" class="alert alert-secondary" > 
                    <div class="input-group  py-3">
                                
                    <h5 class="card-title">Alterar Senha</h5><br>
                        <?php
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                  

                         <!--Nova senha-->
                         <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Nova Senha</span>
                            </div>
                            <input name="senha_new" id="senha_new" type="text" class="form-control" aria-label="senha_new" aria-describedby="basic-addon2" maxlength="25" value="" required>
                        </div>

                        <!--Confirmar senha-->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" >Confirmar Senha</span>
                            </div>
                            <input name="confirmar_senha" id="confirmar_senha" type="number" class="form-control" aria-label="confirmar_senha" aria-describedby="basic-addon2" maxlength="25" value="" required>
                        </div>
                        
                        <div><input name="user_id" type="hidden" value="<?php echo $dados_discuser['usuario']['id_usuario'] ?>"> </div>
                    </div>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">Atualizar senha</button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModal1Label">ATENÇÃO</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <p>Após realizar a confirmação de alteração de senha, você deverá fazer novamente o login.
                                Deseja continuar?
                            </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="bntcadastrar" type="submit" name="submit" class="btn btn-primary">Sim, enviar</button> 

                            </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>

</body>

<script src="../../Assets/js/jquery-3.5.1.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<!--  //Validação dos campos -->
<script>

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<!-- Mostrando ou ocultando textarea -->
<script type="text/javascript">
$(document).ready(function () {
  $('.motivo').hide();
  //$('#option1').show();
  $('#quantidade_vacinas').change(function () {
    $('.motivo').hide();
    $('#'+$(this).val()).show();
  })

  $('.qual_vacina').hide();
  //$('#option1').show();
  $('#quantidade_vacinas').change(function () {
    $('.qual_vacina').hide();
    $('#'+$(this).val()).show();
  })
});
</script>

<script>

   let sel = document.getElementById('quantidade_vacinas');

    function verifica() {
        let nao = document.getElementById('justificativa');
        if (sel.value == '1' ||sel.value == '2' || sel.value == 3) {
            nao.required = false;
        } else {
            nao.required = true;
        }
    }

    sel.addEventListener('change', verifica);
</script>

</html>