<?php
session_start();
//verifica se clicou no botão
if(isset($_POST['valor_id']))
{   
    $delete_rec = [];

    $delete_rec['campus_instituto_id_campus_instituto'] = addslashes($_POST['valor_id']);

    //vereficar se esta tudo preenchido no array
    $validacao = (false === array_search(false , $delete_rec, false));

    if($validacao == true)
    {

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $headers = array(
        'Authorization: Bearer '.$token,
    );

    $ch = curl_init('http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/campus_institutos/campus_instituto?id_campus_instituto='.$delete_rec['campus_instituto_id_campus_instituto']);
    
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"DELETE");  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if($httpcode1 == 200)
    {
            
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Campus excluido com sucesso!!
        </div>";
        header("Location: ../../View/tecnico/delete_campus.php");             
        exit();
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        Ocorreu um erro ao excluir esse campus!!
        </div>";
        header("Location: ../../View/tecnico/delete_campus.php");
        exit();
    }

    
    }
    else
    {
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>
        Preencha todos os campos!!
    </div>";
        header("Location: ../../View/tecnico/delete_campus.php");
        exit();
    }
}
?>
