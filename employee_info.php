<!DOCTYPE html>
<html>
<head>
	<title>员工信息处理</title>
	<meta charset="utf-8">
	<script src="./js/jquery.min.js" ></script>
	<script type="text/javascript">
	</script>
</head>
<body>
<h2>员工信息</h2>
<form id="form"  enctype="multipart/form-data">
	<table id="employee_info" border="1" width="1000px" cellpadding="10">
		<tr>
			<th>编号</th>
			<th>头像</th>
			<th>姓名</th>
			<th>职务</th>
			<th>入职时间</th>
			<th>简历</th>
			<th>操作</th>
		</tr>
	</table>
</form>
<button type="button" id="addButton">新增</button>
<script src="./js/employee_info.js"></script>
</body>
</html>