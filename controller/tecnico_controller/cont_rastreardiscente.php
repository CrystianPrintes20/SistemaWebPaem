<?php
session_start();

if(isset($_POST['nome_rec']))
{
    $rastreio = [];

    $rastreio['nome_recurso'] = addslashes($_POST['nome_rec']);
    $rastreio['data_rec'] = addslashes($_POST['data_rec']);
    $rastreio['horario_inicial'] = addslashes($_POST['horario_inicial']);
    $rastreio['horario_final'] = addslashes($_POST['horario_final']);

    /*    print_r($rastreio);
    echo ('<br>');
    echo ('<br>'); */

    $token = implode(",",json_decode( $_SESSION['token'],true));
    $url = "http://webservicepaem-env.eba-mkyswznu.sa-east-1.elasticbeanstalk.com/api.paem/solicitacoes_acessos";
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
    
    $resultado = json_decode($response,true);

    /* print_r($resultado);
    */
    $dados_rastreio = array();

        
    foreach($resultado as $value){
        if($rastreio['nome_recurso'] == $value['recurso_campus']){

            // Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
            $data = explode('-', $value['data']);
            $newdata = $data[2].'-'.$data[1].'-'.$data[0];

            if($rastreio['data_rec'] == $newdata && $rastreio['horario_inicial'] == $value['hora_inicio']){
                
                
                $dados_rastreio[] = 
                    array(
                        'recurso_campus' => $value['recurso_campus'],
                        'nome' => $value['nome'],
                        'data' => $newdata,
                        'hora_inicio' => $value['hora_inicio'],
                        'hora_fim' => $value['hora_fim']
                    );
            }
            
        }
    }

    require_once("../../fpdf/fpdf.php");
    $pdf= new FPDF("P","pt","A4");
    $pdf->AddPage();
    /* $pdf->Image('../../img/ufopa-icon.jpg'); */

    $pdf->SetFont('arial','B',14);
    $pdf->Cell(0,5,"Todos os presentes no campus no dia e hora solicitado",0,1,'C');
    $pdf->Cell(0,5,"","B",1,'C');
    $pdf->Ln(50);

    //cabeçalho da tabela 
    $pdf->SetFont('arial','B',10);
    $pdf->Cell(130,20,'Recurso do campus',1,0,"L");
    $pdf->Cell(170,20,'Nome',1,0,"L");
    $pdf->Cell(80,20,'Data',1,0,"L");
    $pdf->Cell(80,20,'Hora inicial',1,0,"L");
    $pdf->Cell(70,20,'Hora Final',1,1,"L");

    //linhas da tabela
    $pdf->SetFont('arial','',8);

    foreach($dados_rastreio as $dados){
        $pdf->Cell(130,20,$dados['recurso_campus'],1,0,"L");
        $pdf->Cell(170,20,$dados['nome'],1,0,"L");
        $pdf->Cell(80,20,$dados['data'],1,0,"L");
        $pdf->Cell(80,20,$dados['hora_inicio'],1,0,"L");
        $pdf->Cell(70,20,$dados['hora_fim'],1,1,"L");

    }
    $pdf->Output("arquivo.pdf","D");
}
?>