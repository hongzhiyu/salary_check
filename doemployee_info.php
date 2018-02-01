<?php
$action = $_REQUEST['action'];
switch($action) {
case 'init_table':
	init_table();
	break;
case 'add_employee':
	add_employee();
	break;
case 'del_employee':
	del_employee();
	break;
case 'edit_employee':
	edit_employee();
	break;
}
function init_table(){
	$sql    = "SELECT * FROM employee_info";
	$result = query_sql($sql);
	$data   = array();
	if ($result) {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$data[] = $row;
		}
		//将edate时间戳转为字符串
		for($i=0;$i<sizeof($data);$i++){
			$data[$i]['edate']=date("Y-m-d ",$data[$i]['edate']);
		}
		echo json_encode($data);
	}
 	
}
function del_employee(){
	$id=$_POST['delid'];
	$sql = "DELETE FROM employee_info WHERE eid='$id'";
    if (query_sql($sql)) {
    	echo "ok";
	}else{
		echo "bad";
	}
}
function edit_employee(){
	$oldid    = $_POST['oldid'];
	$eid      = $_POST['eid'];
	$ename    = $_POST['ename'];
	$year     =	$_POST['year'];
	$month    =	$_POST['month'];
	$day      =	$_POST['day'];
	$ework    =	$_POST['ework'];
	$edate    =	date("Y-m-d ",mktime(0,0,0,$month,$day,$year));
	$edateint =	strtotime(date("Y-m-d ",mktime(0,0,0,$month,$day,$year)));

	$sql = "UPDATE employee_info SET ename='$ename',eid='$eid',ework='$ework',edate='$edateint'";
	//处理图片eadvatar
	$picname =$_FILES['eadvatar']['name'];
	$picsize =$_FILES['eadvatar']['size'];
	if(checkpic($picname,$picsize)){
		$pics     =date("YmdHis") . $picname;
		$pic_path ="images/employee/".$pics;
		move_uploaded_file($_FILES['eadvatar']['tmp_name'], $pic_path);
		$sql      .=",eadvatar='$pics'";
	}
		//判断有没有选择简历
	$eresumename=$_FILES['eresume']['name'];
	if(checkresume($eresumename)){
		$eresume_path ="files/resume/".$eresumename;
		move_uploaded_file($_FILES['eresume']['tmp_name'], $eresume_path);
		$sql          .=",eresume='$eresumename'";
	}
	

	$sql .= "WHERE eid='$oldid'";

	if (query_sql($sql)) {
	}else{
		echo "bad";
	}

}
function checkpic($picname,$picsize){
	$type=strstr($picname, '.');
	if($picname!=""){
		if($picsize>5120000){
			//图片太大的处理
			return false;
		}
	if($type!='.jpg'&& $type!='.gif'){
		//格式不对的处理
		return false;
	}
	return true;
	}
	else{
		return false;
	}
}
function checkresume($eresumename){
	if($eresumename!=""){
		$type=strstr($eresumename, '.');
		if($type!='.doc'&& $type!='.docx'){
			//格式不对的处理
			return false;
		}
		return true;
	}
	else{
		return false;
	}
}
function add_employee(){
	
	$eid         = $_POST['eid'];
	$ename       = $_POST['ename'];
	$year        =$_POST['year'];
	$month       =$_POST['month'];
	$day         =$_POST['day'];
	$ework       =$_POST['ework'];
	$edate       =date("Y-m-d ",mktime(0,0,0,$month,$day,$year));
	$edateint    =strtotime($edate);
	$picname     =$_FILES['eadvatar']['name'];
	$picsize     =$_FILES['eadvatar']['size'];
	$eresumename =$_FILES['eresume']['name'];
	$sql         = "INSERT INTO employee_info (eid,ename,ework,edate";
	$val         = "VALUES ('$eid','$ename','$ework','$edateint'";

	if (checkpic($picname,$picsize)) {
		$pics=date("YmdHis") . $picname;
		$pic_path="images/employee/".$pics;
		move_uploaded_file($_FILES['eadvatar']['tmp_name'], $pic_path);
		$sql.=",eadvatar";
		$val.=",'$pics'";
	}

	if(checkresume($eresumename)){
		$eresume_path="files/resume/".$eresumename;
		move_uploaded_file($_FILES['eresume']['tmp_name'], $eresume_path);
		$sql.=",eresume";
		$val.=",'$eresumename'";
	}
	$sql=$sql.")".$val.")";
		if (query_sql($sql)) {
	}else{
		echo "bad";
	}

}
function query_sql($sql){
	$conn=mysqli_connect("localhost","hzy","123456789","erp");
	if(!$conn){
    	 return false;
    }
    mysqli_query($conn,'SET NAMES UTF8');

	$result = mysqli_query($conn,$sql);
	mysqli_close($conn); 
    if(!$result){
    	 return false;
    }
	return $result;
}
