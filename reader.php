<?php 
include 'readfunc.php';
header('Content-Type:text/html;charset=utf-8');
/**
 * 读取Excel指定行列内容
 * @param string $excelfilename  1_标准报表.xls [type]
 * @param string $sheetname 选择的工作表
 * @param int $startrow 开始行	
 * @param int $endrow 结束行  [type]
 * @param int $columns 列数  [type]
 * @return array array[行数][改行数据]
 */
function readExcel($excelfilename,$sheetname,$startrow,$endrow,$columns){
	$dir = dirname(__FILE__);
	require $dir.'/PHPExcel/PHPExcel/IOFactory.php';
	class MyReadFilter implements PHPExcel_Reader_IReadFilter  
	{  
	    private $_startRow = 0;     // 开始行  
	    private $_endRow = 0;       // 结束行  
	    private $_columns = 0;    // 列跨度  
	    public function __construct($startRow, $endRow, $columns) {  
	        $this->_startRow 	 = $startRow;  
	        $this->_endRow       = $endRow;  
	        $this->_columns      = $columns;  
	    }  
	    public function readCell($column, $row, $worksheetName = '') {  
	        if ($row >= $this->_startRow && $row <= $this->_endRow) {  
	            if ($column<=$this->_columns) {  
	                return true;  
	            }  
	        }  
	        return false;  
	    }  
	}  
	$filename = $dir.'/'.$excelfilename;
	$fileType=PHPExcel_IOFactory::identify($filename);//获取文件类型
	$objReader = PHPExcel_IOFactory::createReader($fileType);
	$objReader->setLoadSheetsOnly($sheetname);//只读目标工作表
	$objReader->setReadDataOnly(true);//只读取数据忽略样式
	$filterSubset = new MyReadFilter($startrow,$endrow,$columns);
	$objReader->setReadFilter($filterSubset);
	$objPHPExcel=$objReader->load($filename);
	$currentSheet = $objPHPExcel->getActiveSheet();

	$data=array();
	$highestColumn      = $currentSheet->getHighestColumn(); //最后列数所对应的字母，例如第2行就是B
	$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
	for ($row = $startrow; $row <= $endrow; $row++) {
	    for ($col = 0; $col < $columns; $col++) {
	        $data[$row][] = (string) $currentSheet->getCellByColumnAndRow($col, $row)->getValue();
	    }
	}

	return $data;
}

// var_dump(readExcel('1_标准报表.xls','考勤记录',6,6,31));


$row_data    = readExcel('1_标准报表.xls','考勤记录',6,6,31);
$shouldtimes = ['8:00','12:00','13:30','17:30','18:30','21:30'];
foreach ($row_data as $row => $days_data) {
	foreach ($days_data as $day => $value) {
		$data[]=dayRecord($value,$shouldtimes);
	}
}
// var_dump($data);
// echo "<pre>";
// print_r($data); // or var_dump()
// echo "</pre><br>";
echo json_encode($data);
 ?>