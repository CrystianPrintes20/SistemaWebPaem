<?php
 $url = "../../JSON/cursos.json";
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
$cursos = $_POST['Unidade'];

foreach ($resultado->data as $value) {
    if($cursos == $value->campus_instituto_id_campus_instituto){
        echo "<option value='$value->id_curso'>".$value->nome."</option>";
    }
  
    // if($cursos == 'PARFOR'){
    //     $cidade = $value->Cidade;
    //     $curso = $value->Curso;
    //     echo '<option>'.$cidade.'-'. $curso.'</option>';
    // }
    // elseif($cursos == $value->Unidade){
    //     echo '<option>'.$value->Curso.'</option>';
    // }
}

?>