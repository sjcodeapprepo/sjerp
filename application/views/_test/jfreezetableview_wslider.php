<html>
<head>
	<title>FTJQ</title>
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<style>
	#tablearea{
		position:relative;
	}
	#horslider{
		position:absolute;
		top:30px;
		left : 750px;
		width:200px;
	}
	#horslider, #vertslider {
		font-size:x-small;
	}
	#vertslider{
		position:absolute;
		top:100px;
		left:980px;
		height:200px;
	}
	#tablecoa{
		position:absolute;
		top:50px;
		left:20px;
		/*layout the width of the table */
		table-layout:fixed;
		width:940px;		
	}
	#tablecoa tbody td {
		overflow:hidden;
	}
</style>
</head>
<body>
<?=$this->load->view('menu')?>
<script type="text/javascript" src="<?php echo base_url(); ?>publicfolder/jquery-ui-1.7.2.custom/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>publicfolder/jslib/jqfreez.js"></script>
<script>
$(document).ready(function(){
	$('#tablecoa').jqfreez({
		verticalsliderid:'vertslider',
		horizontalsliderid:'horslider',
		kolom:  ['coltiga','colempat','collima','colenam','coltujuh','coldelapan','colsembilan'],
		coltodisplay: 4,
		rowtodisplay: 12,
		totalrows : <?=count($coamst)?>
	});
});
</script>
<br /><br /><br />
<div id="tablearea">
<div id="horslider"></div>
<div id="vertslider"></div>
<table class="gridtable" id="tablecoa">
	<thead>
		<tr>			
			<th class='colsatu'>AcctID</th>
			<th class='coldua'>AcctName</th>
			<th class='coltiga'>HEaderKolomTiga</th>
			<th class='colempat'>Empat</th>
			<th class='collima'>Liiimaaa</th>
			<th class='colenam'>KolomEnam</th>
			<th class='coltujuh'>KolTujuh</th>
			<th nowrap class='coldelapan'>Delapan Kolom</th>
			<th class='colsembilan'>NinthColRow</th>
		</tr>
	</thead>
	<tbody>
		<?php
for($i=0; $i<count($coamst); $i++) {
	echo"<tr>";
		echo"<td class='colsatu'>".$coamst[$i]['AcctID']."</td>";
		echo"<td nowrap class='coldua'>".$coamst[$i]['AcctName']."</td>";
		echo"<td class='coltiga'>BarisIndex$i</td>";
		echo"<td class='colempat'>UrutanIndex$i</td>";
		echo"<td class='collima'>IndexBariske $i</td>";
		echo"<td class='colenam'>KolEnambaris$i</td>";
		echo"<td class='coltujuh'>KolTujuhBaris$i</td>";
		echo"<td class='coldelapan'>DelapanBaris$i</td>";
		echo"<td class='colsembilan'>NinthColRow$i</td>";
	echo"</tr>";
}
		?>
	</tbody>
</table>
</div>
</body>
</html>