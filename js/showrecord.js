$(function(){
	var record_table = $('#record_table');
	//-->reader.php获取数据
	var init_url = './reader.php';
	
	$.post(init_url,function(data){
		var records = $.parseJSON(data);
		for (var i = 0; i < records.length; i++) {
			var row      = $('<tr></tr>');
			var cell     = $('<td></td>');
			cell.append(i+1);
			row.append(cell);
			var cell     = $('<td></td>');
			for (var j = 0; j < 6; j++) {
				cell.append(records[i][j][0]);
				row.append(cell);
				var cell     = $('<td></td>');
			}
			
			record_table.append(row);
		}
	});

});