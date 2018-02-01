<?php
$action = $_GET['action'];
switch($action) {
case 'init_data_list':
	init_data_list();
	break;
case 'add_row':
	add_row();
	break;
case 'del_row':
	del_row();
	break;
case 'edit_row':
	edit_row();
	break;
}

function init_data_list(){
	$sql = "SELECT * FROM `et_data`";
	$query = query_sql($sql);
	while($row = $query->fetch_assoc()){
		$data[] = $row;
	}
	echo json_encode($data);
}

function del_row(){
	$dataid = $_POST['dataid'];	
	$sql = "DELETE FROM `et_data` WHERE `id` = " . $dataid;
	if(query_sql($sql)){
		echo "ok";	
	} else {
		echo "db error ...";	
	}
}

function add_row(){
	$sql = 'INSERT INTO `et_data` ( `c_a`,`c_b`,`c_c`,`c_d`,`c_e`,`c_f`,`c_g`,`c_h` ) VALUES( ';
	for($i = 0 ; $i < 8 ; $i++){
			$sql .= '\'' . $_POST['col_' . $i] . '\', ';
	}	
	$sql = trim($sql,", ");
	$sql .= ")";
	if($res = query_sql($sql,"SELECT LAST_INSERT_ID() as LD")){
		$d = $res->fetch_assoc();
		echo $d['LD'];
	} else {
		echo "db error ...";	
	}
}

function edit_row(){
	$sql = 'UPDATE `et_data` SET ';
	$id = $_POST['id'];
	unset($_POST['id']);
	for($i = 0 ; $i < 8 ; $i++){
		$sql .= ' `c_' . chr(97+$i) . '` = \'' . $_POST['col_' . $i] . '\' , ';
	}
	$sql = trim($sql,", ");
	$sql .= ' WHERE `id` = ' . $id ;

	if(query_sql($sql)){
		echo "ok";	
	} else {
		echo "db error ...";	
	}
}

function query_sql(){
	$mysqli = new mysqli("127.0.0.1", "shaddow", "123456", "etable");
	$sqls = func_get_args();
	foreach($sqls as $s){
		$query = $mysqli->query($s);
	}
	$mysqli->close();
	return $query;
}

