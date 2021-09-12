<html>
<head>
	<title>Tambah Menu</title>
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid2.css" media="screen" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<style>
	#tablearea{
		position:relative;
	}
	#horslider{
		position:absolute;
		top:20px;
		left : 70%;
		width:200px;
	}
	#horslider, #vertslider {
		font-size:small;
	}
	#vertslider{
		position:absolute;
		top:70px;
		left:96%;
		height:200px;
	}
	#tablemenu{
		position:absolute;
		top:50px;
		left:5%;
		/*layout the width of the table */
		table-layout:fixed;
		width:90%;		
	}
	#tablemenu tbody td {
		overflow:hidden;
	}
</style>
</head>
<body>
<?php 
	$this->load->view('js/jqueryui');
	menulist();
	?>
<script type="text/javascript" src="<?php echo base_url(); ?>publicfolder/jslib/jqfreez.js"></script>
<script>
$(document).ready(function(){
	var jumlkol	= $('#jumlkol').val();
	$('#tablemenu').jqfreez({
		verticalsliderid:'vertslider',
		horizontalsliderid:'horslider',
		kolom:  ['coldua'],
		coltodisplay: 2,
		rowtodisplay: 10,
		totalrows : <?=count($menumstarr)?>
	});
});
</script>
<br />

<form action='<?php echo base_url();?>index.php/utility/menuadd' method='post'>
	<table class="gridtable" align="center" style="width: 400px;">
		<thead>
			<tr>
				<th colspan='2'>TAMBAH MENU</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Nama Menu</td>
				<td>
					<input type="text" name="menuname" id="menuname">
				</td>
			</tr>
			<tr>
				<td>Parent Menu</td>
				<td>
					<input type="text" name="parentmenu" id="parentmenu">
				</td>
			</tr>
			<tr>
				<td>Group Menu</td>
				<td>
					<select name="grupmenu" id="grupmenu">
						<option value="Master">Master</option>
						<option value="Transaksi">Transaksi</option>
						<option value="Laporan">Laporan</option>
						<option value="Utility">Utility</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>UrlSite</td>
				<td>
					<input type="text" name="urlsite" id="urlsite">
				</td>
			</tr>
		<tr>
			<td colspan ='2' align="center">
				<input type="submit" name="submit" value="TAMBAH" id="submit">
			</td>
		</tr>
	</tbody>
	</table>
</form>

<table align="center" style="width: 800px;">
	<tr>
		<td>

<div id="tablearea">
<div id="horslider"></div>
<div id="vertslider"></div>
<table class="gridua" id="tablemenu">
	<thead>
		<tr>			
			<th class='colsatu' width="20px">Menu ID</th>
			<th class='coldua' width="80px">Parent Menu</th>
			<th class='coltiga' width="80px">Group Menu</th>
			<th class='colempat' width="80px">Nama Menu</th>
			<th class='collima' width="80px">UrlSite</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach ($menumstarr as $menumst) { ?>
		<tr>
			<td class="colsatu" align="right"><?=$menumst['MenuID']?></td>
			<td class="coldua"><?=$menumst['ParentGroupName']?></td>
			<td class="coltiga"><?=$menumst['GroupName']?></td>
			<td class="colempat"><?=$menumst['MenuName']?></td>
			<td class="collima"><?=$menumst['UrlSiteUrl']?></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
			
		</td>
	</tr>
</table>
<br /><br />
</body>
</html>