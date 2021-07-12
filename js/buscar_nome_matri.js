$(document).ready(function () { 
    $("input[name='matricula']").blur(function () {
        var $nome = $("input[name='nome']");        
        $.getJSON('../../controller/tecnico_controller/buscar_dados_discen.php',
           {
               matricula: $ (this).val()
           }, function(json){
               $nome.val(json.nome)
           }
        );        
    });
});

$(document).ready(function () { 
    $("input[name='nome']").blur(function () {
        var $matricula = $("input[name='matricula']");        
        $.getJSON('../../controller/tecnico_controller/buscar_dados_discen.php',
           {
               nome: $ (this).val()
           }, function(json){
               $matricula.val(json.matricula)
           }
        );        
    });
});