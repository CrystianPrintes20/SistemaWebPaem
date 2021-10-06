<?php
session_start();

if(isset($_FILES['imagem']))
{    
    include_once "./buscardados_discuser.php";
    //print_r($dados_discuser);
    //trasformando formato de data yyyy/mm/dd para dd/mm/yyyy
    $matricula = $dados_discuser['matricula'];



    $ext = strtolower(substr($_FILES['imagem']['name'],-4)); //Pegando extensão do arquivo
    $new_name = $matricula . $ext; //Definindo um novo nome para o arquivodate("Y.m.d-H.i.s")
    $dir = '../../img/imagens_vacina/'; //Diretório para uploads

    $reposta = move_uploaded_file($_FILES['imagem']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo



    if(!empty($reposta)){
        // echo  "<div class='alert alert-success' role='alert'>
        //             Imagem Enviada com sucesso!
        //         </div>";
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Imagem Enviada com sucesso!
        </div>";
        header("Location: ../../View/discente/cart_vacinacao_discente.php");
        exit(); 
        
    }
    else{
        // echo  "<div class='alert alert-warning' role='alert'>
        //             Erro ao enviar imagem
        //         </div>";
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Erro ao enviar imagem, Tente mais tarde!!
        </div>";
        header("Location: ../../View/discente/cart_vacinacao_discente.php");
        exit(); 
    }

} 
?>