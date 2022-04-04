<?php
    include_once('./cont_rastreiodiscente.php');

    function get_post_action($name)
    {
        $params = func_get_args();

        foreach ($params as $name) {
            if (isset($_POST[$name])) {
                return $name;
            }
        }
    }

    switch (get_post_action('Gerarpdf', 'visualizar', 'Gerarexeel')) {

        case 'Gerarpdf':
            //save article and keep editing
            $recurso = $dados_rastreio['0']['recurso_campus'];
            $data = $dados_rastreio['0']['data'];

            require_once("../../fpdf/fpdf.php");
        
            $pdf= new FPDF("P","pt","A4");
            $pdf->AddPage();

            $pdf->Image('../../Assets/img/ufopa.png', 225,10,-210);
            

            $pdf->SetFont('times','B',10);
            $pdf->Cell(0,150,"Todos os Alunos presentes no ". $recurso . " em " . $data,0,1,'C');
            $pdf->Cell(0,25,"","B",1,'C');

            //cabeçalho da tabela 
            $pdf->SetFont('times','B',10);
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
            break;
    
        case 'visualizar':
            //save article and redirect
            ?>
            <!DOCTYPE html>
                <html lang="pt-br">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Lista de discente</title>
                    <link rel="shortcut icon" href="../../img/icon-icons.svg">
                    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" />

                    <link rel="stylesheet" href="../../css/areaprivtec.css" />
                    <style>
                    h5 {
                        text-align:center;
                        margin-bottom: 3rem;
                    } 
                    img.displayed {
                        display: block;
                        margin-left: auto;
                        margin-right: auto;
                        margin-bottom: 3rem;
                        width: 90px;
                    }

                    #table_reservas{
                            display: block;
                            margin-left: auto;
                            margin-right: auto;
                        border: 1px solid black;
                        text-align: left;
                        width: 100%;
                    }
                    th {
                            text-align: initial;
                        }
                        .butao{

                            display: block;
                            margin-left: auto;
                            margin-right: auto;
                            margin-bottom: 1rem;
                        }
                        a {
                            margin-left: 12px;
                        }
                    </style>
                
                </head>
                <body>

                    <div class="page-wrapper chiller-theme ">
                        <main class="page-content">
                                <div class="container">
                                    <div class="row">

                                        <div class="form-group col-md-12">
                                            <img class="displayed" src="../../img/ufopa-icon-semfundo.png" alt="...">
                                            <h5> Lista de todos os discentes presentes no <?php print_r($dados_rastreio['0']['recurso_campus']); ?></h5>
                                        </div>
                                    </div>   
                                   <!--  <div class="row butao">
                                        <div class="pull-right">
                                             form method="POST" action="./cont_gerarpdf.php">
                                            
                                            <input name="dados" id="dados" type="hidden" value="<?php print_r($dados_rastreio) ?>">
                                                <button type='submit' class='btn btn-sm btn-success'>Gerar PDF</button></a>
                                            </form>
                                            <a href="cont_gerarpdf"><button type='submit' class='btn btn-sm btn-success'>Gerar PDF</button></a>
                                            <a href="gerar_planilha.php"><button type='button' class='btn btn-sm btn-success'>Gerar Excel</button></a>

                                        </div>
                                    </div> -->
                                    <div class="row butao">
                                        <div class="pull-right">
                                            
                                            <a href="../../View/tecnico/rastreamento_tecnico.php"><button type='submit' class='btn btn-sm btn-info'>Voltar</button></a>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div id="table_reservas">
                                            
                                            <table class="table" >
                                                <thead >
                                                    <tr>
                                                        <th scope="col">Sala</th>
                                                        <th scope="col">Nome do Discente</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Hora de entrada</th>
                                                        <th scope='col'>Hora de saida</th>
                                                    </tr>
                                                </thead>
                                                    <?php 
                                                        $sort = array();
                                                        foreach($dados_rastreio as $k => $v) {
                                                            $sort['recurso_campus'][$k] = $v['recurso_campus'];
                                                        
                                                        }

                                                        //aqui é realizado a ordenação do array
                                                        array_multisort($sort['recurso_campus'], SORT_ASC,$dados_rastreio);


                                                        foreach($dados_rastreio as $valores){
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $valores['recurso_campus'] ?></td>
                                                                <td><?php echo $valores['nome'] ?></td>
                                                                <td><?php echo $valores['data'] ?></td>
                                                                <td><?php echo $valores['hora_inicio'];  ?></td>
                                                                <td><?php echo $valores['hora_fim'] ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    ?>
                                            
                                                    
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row butao">
                                        <div class="pull-right">
                                            
                                            <a href="../../View/tecnico/rastreamento_tecnico.php"><button type='submit' class='btn btn-sm btn-info'>Voltar</button></a>

                                        </div>
                                    </div>
                                </div>
                        </main>
                    </div>
                </body>
                </html>

                <script src="../../js/jquery-3.5.1.js"></script>

            <?php
            break;
    
        case 'Gerarexeel':
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
                <head>
                    <meta charset="utf-8">
                    <title>Contato</title>
                <head>
                <body>
                    <?php
                    // Definimos o nome do arquivo que será exportado
                    $arquivo = 'listadediscentes.xls';
                    
                    // Criamos uma tabela HTML com o formato da planilha
                    $html = '';
                    $html .= '<table border="1">';
                    $html .= '<tr>';
                    $html .= '<td colspan="5">Lista de todos os discentes presentes</tr>';
                    $html .= '</tr>';
                    
                    
                    $html .= '<tr>';
                    $html .= '<td><b>Recurso campus</b></td>';
                    $html .= '<td><b>Nome</b></td>';
                    $html .= '<td><b>Data</b></td>';
                    $html .= '<td><b>Hora_inicial</b></td>';
                    $html .= '<td><b>Hora_inicial</b></td>';
                    $html .= '</tr>';
                    
                    //Selecionar todos os itens da tabela 
                    foreach($dados_rastreio as $dados){
                        $html .= '<tr>';
                        $html .= '<td>'.$dados["recurso_campus"].'</td>';
                        $html .= '<td>'.$dados["nome"].'</td>';
                        $html .= '<td>'.$dados["data"].'</td>';
                        $html .= '<td>'.$dados["hora_inicio"].'</td>';
                        $html .= '<td>'.$dados["hora_fim"].'</td>';
                        $html .= '</tr>';
                        ;
                    }
               
                    // Configurações header para forçar o download
                    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
                    header ("Cache-Control: no-cache, must-revalidate");
                    header ("Pragma: no-cache");
                    header ("Content-type: application/x-msexcel");
                    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
                    header ("Content-Description: PHP Generated Data" );
                    // Envia o conteúdo do arquivo
                    echo $html;
                    exit; ?>
                </body>
            </html>
            <?php
            break;
    
        default:
            //no action sent
    }

?>
