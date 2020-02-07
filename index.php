<?php

# Abraham Tishelman-Charny 
# 5 February 2020
#
# The purpose of this php file is to display results from GetCondorInfo.sh in graph format

$page = $_SERVER['PHP_SELF'];
$sec = "5";
$userName = "Abe";

$dataPoints4 = array();
$dataPoints5 = array();
$dataPoints6 = array();
$dataPoints7 = array();

$file_handle = fopen("CondorElements_tmp.txt", "rb");

#if ( filesize("CondorElements_tmp.txt") == 0 )
#{
#	echo "No condor jobs running!"
#
#}

while (!feof($file_handle) ) {

$line_of_text = fgets($file_handle);
$parts = explode(',', $line_of_text);

$thisArray = array("label"=> $parts[0], "y"=> (float)$parts[1]);
$thisArray2 = array("label"=> $parts[0], "y"=> (float)$parts[2]);
$thisArray3 = array("label"=> $parts[0], "y"=> (float)$parts[3]);
$thisArray4 = array("label"=> $parts[0], "y"=> (float)$parts[4]);

$dataPoints4[] = $thisArray;
$dataPoints5[] = $thisArray2;
$dataPoints6[] = $thisArray3;
$dataPoints7[] = $thisArray4;
}

fclose($file_handle);

$dataPoints1 = array(
	array("label"=> "Node 666", "y"=> 36.12),
	array("label"=> "Node 888", "y"=> 74.70)
);
$dataPoints2 = array(
	array("label"=> "Node 666", "y"=> 64.61),
	array("label"=> "Node 888", "y"=> 98.70)
);
$dataPoints3 = array(
	array("label"=> "Node 666", "y"=> 24.61),
	array("label"=> "Node 888", "y"=> 48.70)
);
?>
<!DOCTYPE HTML>
<html>
<head>  
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "<?php echo $userName ?>'s Condor Jobs"
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "TOTAL",
		color: "black",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "DONE",
		color: "green",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "RUNNING",
		color: "blue",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "IDLE",
		color: "gray",
		indexLabel: "{y}",
		yValueFormatString: "#0.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
	}
	]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
}
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>  
