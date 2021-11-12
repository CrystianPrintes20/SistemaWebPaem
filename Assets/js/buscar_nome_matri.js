$(document).ready(function () { 
    $("input[name='matricula']").blur(function () {
        var $nome = $("input[name='nome']"); 
        var $id_disc = $("input[name='id_disc']") ;             
        $.getJSON('../../controller/tecnico_controller/buscar_dados_discen.php',
           {
               matricula: $ (this).val(),
               id_disc: $ (this).val()
           }, function(json){
               $nome.val(json.nome)
               $id_disc.val(json.id_disc)
           }
        );        
    });
});

$(document).ready(function () { 
    $("input[name='nome']").blur(function () {
        var $matricula = $("input[name='matricula']"); 
        var $id_disc = $("input[name='id_disc']") ;      
        $.getJSON('../../controller/tecnico_controller/buscar_dados_discen.php',
           {
               nome: $ (this).val(),
               id_disc: $ (this).val()
           }, function(json){
               $matricula.val(json.matricula)
               $id_disc.val(json.id_disc)
           }
        );        
    });
});
