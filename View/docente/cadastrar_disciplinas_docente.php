<?php
session_start();

if(!isset($_SESSION['token']))
{
    header("location: ./login_docente.php");
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

    <style>.cookieConsentContainer{z-index:999;width:350px;min-height:20px;box-sizing:border-box;padding:30px 30px 30px 30px;background:#232323;overflow:hidden;position:fixed;bottom:30px;right:30px;display:none}.cookieConsentContainer .cookieTitle a{font-family:OpenSans,arial,sans-serif;color:#fff;font-size:22px;line-height:20px;display:block}.cookieConsentContainer .cookieDesc p{margin:0;padding:0;font-family:OpenSans,arial,sans-serif;color:#fff;font-size:13px;line-height:20px;display:block;margin-top:10px}.cookieConsentContainer .cookieDesc a{font-family:OpenSans,arial,sans-serif;color:#fff;text-decoration:underline}.cookieConsentContainer .cookieButton a{display:inline-block;font-family:OpenSans,arial,sans-serif;color:#fff;font-size:14px;font-weight:700;margin-top:14px;background:#000;box-sizing:border-box;padding:15px 24px;text-align:center;transition:background .3s}.cookieConsentContainer .cookieButton a:hover{cursor:pointer;background:#3e9b67}@media (max-width:980px){.cookieConsentContainer{bottom:0!important;left:0!important;width:100%!important}}</style>

</head>

<body>
    <div class="page-wrapper chiller-theme toggled">
        <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
            <i class="fas fa-bars"></i>
        </a>
        <?php
            include_once "./menu_docente.php";
        ?>
        <!-- sidebar-wrapper  -->
        <main class="page-content">
            <div class="container">
                <h2>Cadastrar Disciplinas.</h2>
                <hr>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <p>Está é a area dedicada pra todas as funções administrativas direcionada a você, servidor técnico.</p>
                        </div>
                    </div>
                <hr>
                <form method="POST"  class="alert alert-secondary">
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    <h5>Primeiro busque uma turma:</h5>
                    <div class="row">
                        <!-- ETAPA 01 -->
                        <div class="col-md-12 input-group py-3">
                    
                            <!--Campus -->
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

                                <div class="col-md-6 input-group py-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="campus">Campus</label>
                                    </div>
                                    <select required name="campus" class="custom-select" id="campus">
                                    <option disabled selected></option>
                                        <?php
                                            foreach ($resultado->data as $value) { ?>
                                            <option value="<?php echo $value->id_campus_instituto; ?>"><?php echo $value->nome; ?></option> <?php
                                                }
                                        ?>
    
                                    </select>
                                </div>

                            <!--Curso -->
                            <div class="col-md-6 input-group my-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="curso">Curso</label>
                                </div>
                                <select required name="curso" class="custom-select" id="curso">

                                </select>
                            </div>

                            <!--Turma -->
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Turma</span>
                                </div>
                                <input required name="turma" id="turma"  type="number" min="2009" max="2022" step="1" value="2016"  class="form-control" placeholder="" aria-label="Nome" aria-describedby="basic-addon2" maxlength="4" onkeypress="$(this).mask('0009')">
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 py-4">
                                    <button name="buscaturma" class="btn btn-success" type="submit">+ Adicionar Turma</button>
                                </div> 
                            </div>
                        </div>
                    </div>
                </form>

                <form  method="POST" action="../../controller/docente_controller/cont_cadastrardisciplina.php" class="alert alert-secondary"> 
                    <?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                    ?>
                    
                    <h5>Siga os proximos passos:</h5>
                    <div class="row">
                        
                        <!-- ETAPA 01 -->
                        <div id="step_1" class="col-md-12 input-group py-3 step">
                           
                            <!--Matricula -->
                            <div class="col-md-6 input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Matricula</span>
                                </div>
                                <input name="matricula" id="matricula" type="text" class="form-control" placeholder="Digite seu numero do matricula" aria-label="matricula" aria-describedby="basic-addon5" maxlength="10">
                            </div>

                            <!--Nome-->
                            <div class="col-md-6 input-group mb-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Nome</span>
                                </div>
                                <input name="nome" id="nome" type="text" class="form-control" placeholder="Digite seu nome" aria-label="Nome" maxlength="40">
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="buscaturma" class="btn btn-success" onclick="adicionaLinha('tbl')">+ Adicionar Discente</button>
                                    </div> 
                                </div>
                            </div>
                            <table id="tbl" class="table table-hover">
                                <thead class="table-dark">
                                    <tr class="centralizar">                    
                                        <th scope="col">Nome</th>
                                        <th scope="col">Matricula</th>
                                        <th scope="col">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- ETAPA 02 -->
                          <div id="step_2" class="col-md-12 step">
                            <?php 
        
                                if(isset($_POST['turma']))
                                {
                                    $turma = addslashes($_POST['turma']);
                                    $curso = addslashes($_POST['curso']);
                                    $campus = addslashes($_POST['campus']);
                               
                                    if(!empty($turma)){

                                        $token = implode(",",json_decode( $_SESSION['token'],true));

                                        $url = $rotaApi."/api.paem/discentes";
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
                                        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        $resultado = json_decode($response,true);
                                        
                                        //contador
                                        $cont = 0;

                                        ?>
                                        <div id="table_reservas">
                                            <table class="table table-hover">
                                                <thead class="table-dark">
                                                    <tr class="centralizar">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Matricula</th>
                                                    </tr>
                                                </thead>
                                                <?php 
                        
                                                    foreach($resultado as $value){
                                                        $matricula = $value['matricula'];  
                                                        $ano = str_split($matricula, 4);
                        
                                                       if($turma == $ano[0] && $curso == $value['curso_id_curso'] && $campus == $value['campus_instituto_id_campus_instituto']){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $cont += 1;  ?></td>
                                                            <td><?php echo $value['nome'];?></td>
                                                            <td><span><?php echo $value['matricula']; ?></span></td>
                                                            
                                                        </tr>
                                                        <?php
                                                       }
                                                       
                                                    }         

                                                ?>
                                            </table>
                                            <h4 align="center">Adicionados Individualmente</h4>
                                            <table class="table table-hover">
                                                <thead class="table-dark">
                                                    <tr class="centralizar">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Nome</th>
                                                        <th scope="col">Matricula</th>
                                                   
                                                    </tr>
                                                </thead>
                                                <tbody id="curso1" >

                                                </tbody>
                                            </table>
                                        </div> 
                                    <?php
                                    
                                    }else{
                                    ?>
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr class="centralizar">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Matricula</th>
                                                    <!-- <th scope="col">Hora_fim</th> -->
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td align="center" colspan="4"><b> Sem Registros  </b></td>
                                            </tr>
                                        </table>
                                    <?php
                                    }
                                }else{
                                    ?>
                                        <table class="table table-hover">
                                            <thead class="table-dark">
                                                <tr class="centralizar">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome</th>
                                                    <th scope="col">Matricula</th>
                                                    <!-- <th scope="col">Hora_fim</th> -->
                                                </tr>
                                            </thead>
                                            <tr>
                                                <td align="center" colspan="4"><b> Adicione uma turma!</b></td>
                                            </tr>
                                        </table>
                                    <?php
                                }
                            ?>
                        </div>

                        <!-- ETAPA 03 -->
                         <div id="step_3" class="col-md-12 input-group py-3 step">
                         
                            <!-- Nome da disciplina -->
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="nome">Nome</label>
                                </div>
                                <input name="nome_disciplina" id="nome_disciplina" type="text" value="" class="form-control" placeholder="Nome da Disciplina"  aria-label="nome_disciplina" aria-describedby="basic-addon1" maxlength="40" required>
                            </div>

                            <!--cod_sigaa-->
                            <div class=" col-md-6 input-group py-3">
                                <div class=" input-group-prepend">
                                    <span class="input-group-text" >Código do SIGAA</span>
                                </div>
                                <input name="cod_sigaa" id="cod_sigaa" type="number"  value="" placeholder="Codigo da disciplina" class="form-control"  aria-label="cod_sigaa" aria-describedby="basic-addon1" maxlength="40" required>
                            </div>
                        

                            <!--Semestre-->
                            <div class="col-md-6 input-group py-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" >Semestre</span>
                                </div>
                                <input name="semestre" id="semestre" type="number" min="0" max="10" class="form-control" placeholder="" aria-label="Nome" aria-describedby="basic-addon2" maxlength="2" required>
                            </div>
                        
            
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 py-4">
                                        <button name="pesqdispo" class="value-plus btn btn-success" type="submit">Criar Disciplina</button>
                                    </div> 
                                </div>
                            </div>
                         </div>
                    </div>
                       
        
                    <div class="row">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 py-1">
                                    <button name="pesqdispo" id="prev" class="btn btn-secondary" type="button">Anterior</button>
                                </div> 
                                <div class="col-md-6 py-1">
                                    <button name="pesqdispo" id="next" onclick="Enviartabela()" class="btn btn-dark" type="button">Confimar e Proximo</button>
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
<script type="text/javascript" src="../../Assets/js/buscar_nome_matri.js"></script>
<script src="../../bootstrap/js/bootstrap.js"></script>
<script src="../../Assets/js/areaprivtec.js"></script>
<script src="../../Assets/js/carhartl-jquery-cookie-v1.4.1-0/jquery.cookie.js"></script>


<!-- Busca os cursos -->
<script language="Javascript">
    //Buscando os cursos
    $("#campus").on("change", function(){
    var unidade = $("#campus").val();
    
    $.ajax({
            url: './busca_cursos.php',
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

<!-- Responsavel pela o formulario em etapa  -->
<script>
 $(document).ready(function(){

    //Esconde todos os passos e exibe o primeiro ao carregar a página 
    $('.step').hide();
    $('.step').first().show();

    //Exibe no topo em qual passo estamos pela ordem da div que esta visivel
    var passoexibido = function(){
        var index = parseInt($(".step:visible").index());
        if(index == 0){
            //Se for o primeiro passo desabilita o botão de voltar
            $("#prev").prop('disabled',true);
        }else if(index == (parseInt($(".step").length)-1)){
            //Se for o ultimo passo desabilita o botão de avançar
            $("#next").prop('disabled',true);
        }else{
            //Em outras situações os dois serão habilitados
            $("#next").prop('disabled',false);            
            $("#prev").prop('disabled',false);
        }
        $("#passo").html(index + 1);

    };
    
    //Executa a função ao carregar a página
    passoexibido();

    //avança para o próximo passo
    $("#next").click(function(){
        $(".step:visible").hide().next().show();
        passoexibido();
    });

    //retrocede para o passo anterior
    $("#prev").click(function(){
        $(".step:visible").hide().prev().show();
        passoexibido();
    });

 });
</script>

<!-- Adicionar os itens da tabela em um array -->
<script>
    //Funcao adiciona uma nova linha na tabela
    var discentes = [];

    function adicionaLinha(idTabela) {

        var tabela = document.getElementById(idTabela);
        var numeroLinhas = tabela.rows.length;
        var linha = tabela.insertRow(numeroLinhas);
        var celula1 = linha.insertCell(0);
        var celula2 = linha.insertCell(1);   
        var celula3 = linha.insertCell(2); 

        //Pegando o nome do discente
        var input_nome = document.querySelector("#nome");
        var nome_discente = input_nome.value;
        celula1.innerHTML = nome_discente;

        //Pegando a matricula do discente
        var input_matricula = document.querySelector("#matricula");
        var matricula_discente = input_matricula.value;
        celula2.innerHTML = matricula_discente;

        //Adicionado o botão de remover
        celula3.innerHTML =  "<button type='button' onclick='removeLinha(this)' class='btn btn-danger'>Remover</button>";

        discentes.push({nome: nome_discente, matricula: matricula_discente});
        var dados = JSON.stringify(discentes);
        
    }

    function Enviartabela() {
        $.ajax({
                url: '../../controller/docente_controller/cont_addTurmas.php',
                type: 'POST',
                data:{Discente:discentes},
                success: function(data){
                    $("#curso1").html(data);
                },
                error: function(data){
                    $("#curso1").html("Houve um erro ao carregar");
                } 
        });
    }
    
    // funcao remove uma linha da tabela
    function removeLinha(linha) {
        var i=linha.parentNode.parentNode.rowIndex;
        document.getElementById('tbl').deleteRow(i);
        var newArray = discentes.splice(1, i);
        discentes = newArray;
    }      
    
</script>

<!-- Pega todos os campos da tabela entre a tag span -->
<script>
    $('.value-plus').on('click', function() {
        var valores = document.querySelectorAll("table tr td span");
        var array_discente = [] 
        for (i = 0; i < valores.length; i++) {
        
            array_discente.push(valores[i].innerHTML.replace(",", "."));
        }

        var date = new Date();
        date.setTime(date.getTime() + (60 * 1000)); // expires after 1 minute

        var myAry = array_discente;
        $.cookie('name', JSON.stringify(myAry), { expires: date, path: '/' });
    })
</script>

<!-- Politica de Cookie -->
<script>
    var purecookieTitle="Cookies.",
    purecookieDesc="Ao usar este site, você aceita automaticamente que usamos cookies.",
    purecookieLink='<a href="https://www.cssscript.com/privacy-policy/" target="_blank">Porque isso?</a>',
    purecookieButton="Aceitar";

    function pureFadeIn(e,o){
        var i=document.getElementById(e);
        i.style.opacity=0,i.style.display=o||"block",

        function e(){
            var o=parseFloat(i.style.opacity);
            (o+=.02)>1||(i.style.opacity=o,requestAnimationFrame(e))}()
            }
            function pureFadeOut(e){
                var o=document.getElementById(e);
                o.style.opacity=1,
                function e(){
                    (o.style.opacity-=.02)<0?o.style.display="none":requestAnimationFrame(e)}()}
                    function setCookie(e,o,i){var t="";if(i){var n=new Date;n.setTime(n.getTime()+24*i*60*1e3),t="; expires="+n.toUTCString()}document.cookie=e+"="+(o||"")+t+"; path=/"}function getCookie(e){for(var o=e+"=",i=document.cookie.split(";"),t=0;t<i.length;t++){for(var n=i[t];" "==n.charAt(0);)n=n.substring(1,n.length);if(0==n.indexOf(o))return n.substring(o.length,n.length)}return null}function eraseCookie(e){document.cookie=e+"=; Max-Age=-99999999;"}function cookieConsent(){getCookie("purecookieDismiss")||(document.body.innerHTML+='<div class="cookieConsentContainer" id="cookieConsentContainer"><div class="cookieTitle"><a>'+purecookieTitle+'</a></div><div class="cookieDesc"><p>'+purecookieDesc+" "+purecookieLink+'</p></div><div class="cookieButton"><a onClick="purecookieDismiss();">'+purecookieButton+"</a></div></div>",pureFadeIn("cookieConsentContainer"))}function purecookieDismiss(){setCookie("purecookieDismiss","1",7),pureFadeOut("cookieConsentContainer")}window.onload=function(){cookieConsent()};
</script>

</html>