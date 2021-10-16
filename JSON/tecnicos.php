<?php
$discente = array(
    'unidade' => array(

        '1' => array(
            //CORI
            '2177569' => "ANDREA NUNES FIGUEIRA",
            "1972586" => "DANIELE PRINTES BARRETO",
            "1695149" => "DILCRIANE DOS SANTOS BATISTA",
            "1825851" => "EDIEGO DE SOUSA BATISTA",
            "1598224" => "JOÃO RAIMUNDO SILVA DE SOUZA",
            '2092625' => "LEANDRO NICOLINO DE SOUZA",
            "1825954" => "LEINA IONE BRAGA CORREA",
            "2112125" => "MELQUIADES DE OLIVEIRA COSTA",
            "3082210" => "MIGUEL ANGELO DE OLIVEIRA CANTO",
            "2114303" => "MISAEL BRITO DE LIMA",
            "1825522" => "ROGERIO ARAUJO DE MIRANDA",
            "2091695" => "SILVANO PRINTES GOMES",
            "2094313" => "STELIO MAURICIO DE ANDRADE MONTEIRO"

            
        ),

        '2' => array(
            //CALE
        
        ),
    
        '3' => array(
            //CITB
            
        ),
    
        '4' => array(
            //CJUR
        
        ),
    
        '5' => array(
            //CMAL
            
        ),
       
    
        '6' => array(
            //COBI
            
        ),
    
        '7' => array(
            //CFI
            
        ),
        '8' => array(
            //CGIFP
            
        ),
    
        '9' => array(
            //PARFOR
        ),

        '10' => array(
            //IBEF
            
        ),

        '11' => array(
            //ICED
        ),

        '12' => array(
            //ICS
            
        ),

        '13' => array(
            //ICTA
            
        ),

        '14' => array(
            //IEG
            
        ),

        '15' => array(
            //ISCO
        )

    )    
  
);

$discente_json = json_encode($discente, JSON_UNESCAPED_UNICODE);

echo $discente_json;