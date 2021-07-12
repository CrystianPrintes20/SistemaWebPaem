
<?php
include '../../controller/conn.php';
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value


	$sql = "SELECT discente_id_discente FROM solicitacao_acesso";
	$result = $pdo->query( $sql );
	$id_discente = $result->fetchAll(PDO::FETCH_COLUMN,0);

//    print_r($id_discente);

	$comma_separated =implode(",", $id_discente);

    $sql = "SELECT nome FROM discente WHERE id_discente IN($comma_separated)";
	$resultado = $pdo->query( $sql );
	$nomes_dis = $resultado->fetchAll(PDO::FETCH_COLUMN,0);

  //  var_dump($nomes_dis);

	

$searchArray = array();

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " AND (id_recurso_campus LIKE :id_recurso_campus or 
        data LIKE :data OR 
        hora_inicio LIKE :hora_inicio ) ";
    $searchArray = array( 
        'id_recurso_campus'=>"%$searchValue%", 
        'data'=>"%$searchValue%",
        'hora_inicio'=>"%$searchValue%"
    );
}

## Número total de registros sem filtragem
$stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM solicitacao_acesso ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];


## Número total de registros com filtragem
$stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM solicitacao_acesso WHERE 1 ".$searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $pdo->prepare("SELECT * FROM solicitacao_acesso WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");
// Bind values
foreach($searchArray as $key=>$search){
    $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();


$teste = array();

foreach($empRecords as $row){
    $teste[] = array(
        #o lado esquerdo indica o local onde serão add os valores e o direito são os respctivos valores
            "id_recurso_campus"=>$row['id_recurso_campus'],
            "data"=>$row['data'],
            "hora_inicio"=>$row['hora_inicio'],
            "hora_fim"=>$row['hora_fim'],
            "discente_id_discente"=>$row['discente_id_discente'],
        );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $teste
);

echo json_encode($response);
?>