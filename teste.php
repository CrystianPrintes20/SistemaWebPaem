<?php
$url = "http://localhost:5000/api.paem/solicitacoes_acessos";
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

$resultado1 = json_decode($response,true);

//print_r($resultado1);

// Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
$data = explode('-', $contreservar['data']);
$newdata = $data[2].'-'.$data[1].'-'.$data[0];

//Perrcorrendo o resultado1 que foi feita na rota de solicitações buscando todas as datas de reservas já feitas
foreach($resultado1 as &$value){
  $valores['data'] = $value['data'];
  $valores['hora_inicio'] = $value['hora_inicio'];
  $valores['hora_fim'] = $value['hora_fim'];
    
  print_r($valores);

  $vagas = 0;
  
  echo $vagas;
  
  if($valores['data'] == $newdata && $vagas <= $capacidade_recurso && $valores['hora_inicio'] != $contreservar['hora_inicio'] && $valores['hora_fim'] != $contreservar['hora_fim']){

    // Enviando os dados para a API
    $contreservar['para_si'] = '-1';
    $contreservar['status_acesso'] = '1';

    //transformando array em json
    $solicitacao = json_encode($contreservar);

    $headers = array(
      'content-Type: application/json',
      'Authorization: Bearer '.$token,
    );

    $ch = curl_init('http://127.0.0.1:5000/api.paem/solicitacoes_acessos/solicitacao_acesso');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $solicitacao);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    
    $result = curl_exec($ch);
    $httpcode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    //Resposta para o usuario
    switch ($httpcode1) {

      case 201:
        $vagas += 1;
        $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
        Sala reservado com sucesso!!
        </div>";
        header("Location: ../../View/tecnico/home_tecnico.php"); 
        exit(); 

      case 500:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ESSE DISCENTE JÁ RESERVOU ESSA SALA!!
        </div>";
        header("Location: ../../View/tecnico/home_tecnico.php");
        exit();
        break;

      default:
        $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
        ERRO NO SERVIDOR!!
        </div>";
        header("Location: ../../View/tecnico/home_tecnico.php");
        exit();
    }

  }else{
    $_SESSION['msg'] = "<div class='alert alert-warning' role='alert'>
    Infelizmente estão SEM VAGAS, o recurso solicitado nessa Data escolhida e nesse Horario! Tente outra Data ou Horario diferente
    </div>";
    header("Location: ../../View/tecnico/home_tecnico.php"); 
    exit(); 
  }
}








$a = retornacapacidade($contreservar, $token,$capacidade_recurso);
        var_dump($a);
        die();

     /*   
      
         */
       
function retornacapacidade($contreservar, $token,$capacidade_recurso){

$url = "http://localhost:5000/api.paem/solicitacoes_acessos";
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

$resultado1 = json_decode($response,true);

//print_r($resultado1);

// Trasformando a data escolhida pelo usuario no formato yyyy/mm/dd
$data = explode('-', $contreservar['data']);
$newdata = $data[2].'-'.$data[1].'-'.$data[0];

//Perrcorrendo o resultado1 que foi feita na rota de solicitações buscando todas as datas de reservas já feitas
foreach($resultado1 as &$value){
  $valores['data'] = $value['data'];

  //Verificando se alguma das datas já reservadas são igual a nova data escolhida pelo usuario.
  if($valores['data'] == $newdata){

    // Pegando os seus horarios de agendamento do mesmo dia em questão
    $valores['hora_inicio'] = $value['hora_inicio'];
    $valores['hora_fim'] = $value['hora_fim'];

    if($valores['hora_inicio'] == $contreservar['hora_inicio'] && $valores['hora_fim'] == $contreservar['hora_fim']){
      $vagas = 0;
      $vagas += 1;
      
      
      if($vagas != $capacidade_recurso){

        return true;
    
      }else{
        return false;
      }
    }
  }
}
/*Fim do foreach */
}







































//arquivo buscar recursos
<?php

echo "você enviou os campos:";
$v = $_POST['test'];
print_r($v);

session_start();

if(!isset($_SESSION['token']))
{
    header("location: login_tec.php");
    exit();
};
$token = implode(",",json_decode( $_SESSION['token'],true));


    // Inicia
    $curl = curl_init();
    $headers = array(
        'Authorization: Bearer '.$token,
    );

    // Configura
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost:5000/api.paem/recursos_campus/recurso_campus?id_recurso_campus='.$v,
    ]);

    // Envio e armazenamento da resposta
    $response = curl_exec($curl);

    // Fecha e limpa recursos
    curl_close($curl);
    $resultado = json_decode($response,true);
    print_r($resultado);

    foreach($resultado as &$value){
        echo $value;
        /*$id_recuso_campus = $value->id_recuso_campus;
        $nome = $value->nome;
        $capacidade = $value['capacidade'];
        $descricao = $value['descricao'];
        $inicio_horario_funcionamento = $value['inicio_horario_funcionamento'];
        $fim_horario_funcionamento = $value['fim_horario_funcionamento'];
        $quantidade_horas = $value['quantidade_horas'];*/
    }
  
 ?>


                            // Inicia
                            $curl = curl_init();
                            $headers = array(
                                'Authorization: Bearer '.$token,
                            );

                            // Configura
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                           
                            curl_setopt_array($curl, [
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => 'http://localhost:5000/api.paem/recursos_campus/recurso_campus?id_recurso_campus=4'
                            ]);

                            // Envio e armazenamento da resposta
                            $response = curl_exec($curl);

                            // Fecha e limpa recursos
                            curl_close($curl);
                            $a = json_decode($response);
                            print_r($a);
                            



							<select id="language" onChange="update()">
			<option value="pt">Português</option>
			<option value="en">English</option>
			<option value="es">Español</option>
		</select>
		<input type="text" id="value">
		<input type="text" id="text">

		<script type="text/javascript">
			function update() {
				var select = document.getElementById('language');
				var option = select.options[select.selectedIndex];

				document.getElementById('value').value = option.value;
				document.getElementById('text').value = option.text;
			}

			update();
		</script>
                  






<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Teste</title>
</head>

<body>
	<!--Importando Script Jquery-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<!--Formulário-->
	<form>
		<label for="cep">CEP</label>
		<input id="cep" type="text" required/>
		<label for="logradouro">Logradouro</label>
		<input id="logradouro" type="text" required/>
		<label for="numero">Número</label>
		<input id="numero" type="text" />
		<label for="complemento">Complemento</label>
		<input id="complemento" type="text"/>
		<label for="bairro">Bairro</label>
		<input id="bairro" type="text" required/>
		<label for="uf">Estado</label>
		<select id="uf">
			<option value="AC">Acre</option>
			<option value="AL">Alagoas</option>
			<option value="AP">Amapá</option>
			<option value="AM">Amazonas</option>
			<option value="BA">Bahia</option>
			<option value="CE">Ceará</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espírito Santo</option>
			<option value="GO">Goiás</option>
			<option value="MA">Maranhão</option>
			<option value="MT">Mato Grosso</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MG">Minas Gerais</option>
			<option value="PA">Pará</option>
			<option value="PB">Paraíba</option>
			<option value="PR">Paraná</option>
			<option value="PE">Pernambuco</option>
			<option value="PI">Piauí</option>
			<option value="RJ">Rio de Janeiro</option>
			<option value="RN">Rio Grande do Norte</option>
			<option value="RS">Rio Grande do Sul</option>
			<option value="RO">Rondônia</option>
			<option value="RR">Roraima</option>
			<option value="SC">Santa Catarina</option>
			<option value="SP">São Paulo</option>
			<option value="SE">Sergipe</option>
			<option value="TO">Tocantins</option>
		</select>
	</form>
	
	<script type="text/javascript">
		$("#cep").focusout(function(){
			//Início do Comando AJAX
			$.ajax({
				//O campo URL diz o caminho de onde virá os dados
				//É importante concatenar o valor digitado no CEP
				url: 'https://viacep.com.br/ws/'+$(this).val()+'/json/unicode/',
				//Aqui você deve preencher o tipo de dados que será lido,
				//no caso, estamos lendo JSON.
				dataType: 'json',
				//SUCESS é referente a função que será executada caso
				//ele consiga ler a fonte de dados com sucesso.
				//O parâmetro dentro da função se refere ao nome da variável
				//que você vai dar para ler esse objeto.
				success: function(resposta){
					//Agora basta definir os valores que você deseja preencher
					//automaticamente nos campos acima.
					$("#logradouro").val(resposta.logradouro);
					$("#complemento").val(resposta.complemento);
					$("#bairro").val(resposta.bairro);
					$("#cidade").val(resposta.localidade);
					$("#uf").val(resposta.uf);
					//Vamos incluir para que o Número seja focado automaticamente
					//melhorando a experiência do usuário
					$("#numero").focus();
				}
			});
		});
	</script>
</body>
</html>



/* $curlHandler = curl_init();
        $cookieFile = 'ksdlsldkkslkd';
        curl_setopt_array($curlHandler, [
        CURLOPT_URL => 'https://httpbin.org/cookies',
        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_COOKIEFILE  => $cookieFile,
        CURLOPT_COOKIE => 'foo=bar;baz=foo',

      
        * Or set header
        * CURLOPT_HTTPHEADER => [
            'Cookie: foo=bar;baz=foo',
        ]
        
        ]);

        $response = curl_exec($curlHandler);
        curl_close($curlHandler);

        echo $response;*/


//Tentativa 00: chamada da função CURL

/*$iniciar = curl_init('http://localhost:5000/api.paem/tecnicos/tecnico');

curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);
curl_setopt($iniciar, CURLOPT_POST, true);
curl_setopt($iniciar, CURLOPT_POSTFIELDS, $arquivo_json);

curl_exec($iniciar);

curl_close($iniciar);*/
  


  //Tentativa 01: chamada da função CURL

/* $ConteudoPOST = json_encode($cadastro);
$ConteudoCabecalho = [
    'Cookie: ASP.NET_SessionId=XXXXXXXXXXXXXXXXXXX;',
    'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
  ];

  $curl = curl_init('http://localhost:5000/api.paem/tecnicos/tecnico');

  curl_setopt_array($curl, [

      //-------- Segurança (caso se preocupe com isto):
      // Verifica o SSL (dificultar MITM):        
      CURLOPT_SSL_VERIFYHOST => 1,
      CURLOPT_SSL_VERIFYPEER => 2,

      // Limita o CURL para o protocolo HTTPS (dificultar SSRF e "downgrade"):
      CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,

      // Limita para não seguir redirecionamento (mesmo motivo acima):
      CURLOPT_FOLLOWLOCATION => 0,
      CURLOPT_MAXREDIRS => 0,

      // Define um Tempo limita (dificultar DoS por Slow HTTP):
      CURLOPT_CONNECTTIMEOUT => 1,
      CURLOPT_TIMEOUT => 3,
      CURLOPT_LOW_SPEED_LIMIT => 750,
      CURLOPT_LOW_SPEED_TIME => 1,        
      //--------

      // Define como método POST:
      CURLOPT_POST => 1,

      // Define o JSON (o corpo do POST):
      CURLOPT_POSTFIELDS => $ConteudoPOST,

      // Define o cabeçalho:
      CURLOPT_HTTPHEADER => $ConteudoCabecalho,

      // Define para retornar o conteúdo para a variável:
      CURLOPT_RETURNTRANSFER => 1
  ]);

  $RespostaCURL = curl_exec($curl);
  curl_close($curl);

  print_r($RespostaCURL);*/

//Tentativa 03: CONSUMO FEITO VIA CURL
        /*echo "<h1>CURL</h1>";
        $post = [
            'objetos' => 'DV700025559BR'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www2.correios.com.br/sistemas/rastreamento/resultado_semcontent.cfm');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $result = utf8_encode(curl_exec($ch));
        curl_close($ch);

        echo $result;*/