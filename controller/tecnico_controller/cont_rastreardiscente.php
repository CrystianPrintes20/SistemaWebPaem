<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
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
      
            
            // nome do arquivo que vai ser exportado
            $arquivo = 'Listadasreservas.xls';

            //criando a tabela com formato de planilha

            $html = ' ';
            $html .= '<table border="1">';
            $html .= '<tr>';
            $html .= '<td colspan="5"> Todos os presentes nesse periodo</td>';
            $html .= '</tr>';


            $html .= '<tr>';
            $html .= '<td> Recurso do campus</td>';
            $html .= '<td> Nome</td>';
            $html .= '<td> Data</td>';
            $html .= '<td> Hora inicial</td>';
            $html .= '<td> Hora Final</td>';
            $html .= '</tr>';
            
            foreach($dados_rastreio as &$dados){
                  # code...
                  $html .= '<tr>';
                  $html .= '<td>'. $dados['recurso_campus'].'</td>';
                  $html .= '<td>'. $dados['nome'].'</td>';
                  $html .= '<td>'. $dados['data'].'</td>';
                  $html .= '<td>'. $dados['hora_inicio'].'</td>';
                  $html .= '<td>'. $dados['hora_fim'].'</td>';
                  $html .= '</tr>';
            }
              
                
            
            

            // configurações para downloads

            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: ".gmdate("D, d M YH:i:s") . "GMT");
            header("Cache-Control: no-cache, must-revalidate");
            header("Pragma:no-cache");
            header("Content-type: application/x-msexecel");
            header("Content-Disposition: attachment; filename=\"($arquivo)\"");
            header("Content-Description: PHP Generated Data");

            //enviar arquivo
            echo $html;
            exit();
        }
    ?>
    
</body>
</html>