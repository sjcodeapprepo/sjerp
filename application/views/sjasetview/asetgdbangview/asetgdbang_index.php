<!DOCTYPE html>
<html>
<head>
	<title>Aset Gedung dan Bangunan - list</title>
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csstable/tablegrid2.css" media="screen" rel="stylesheet" />
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csspaging/paging.css" media="screen" rel="stylesheet" />
<?php $this->load->view('js/jqueryui')?>
<style>
.ui-dialog-title, .ui-dialog-titlebar, .ui-dialog-titlebar-close{
	font-size:small;
}
.ui-icon {
	 cursor: pointer; cursor: hand;
}
.ratakanan{
	text-align:right;
}
.rtengah{
	text-align:center;
}
.lebariconkecil{
	width:17px;
}
.lebariconsedang{
	width:35px;
}
.lebariconbesar{
	width:68px;
}
.lebardropdown{
	width:200px;
}
</style>
</head>
<body>
<?php menulist()?>

<br />
<br />
<br />

<form action=<?=site_url().'/sjaset/asetgdbang/index'?> method='post'>
<table align=center border="0" cellpadding="0" cellspacing="3" width="600" class='gridtable'>
	<thead>
	  <tr><th colspan='2'>Aset Gedung dan Bangunan</th></tr>
  	</thead>
      <tr>
        <td noWrap align=center>
		<select name="option">
			<option value='mk.KatName'>Kategori</option>
			<option value='mb.JenisGdgBangunanName'>Jenis Bangunan</option>
			<option value='d.LokasiPs'>Lokasi</option>
			<option value='d.MitraKerjasamaSi'>Mitra Kerjasama</option>
			<option value='d.PenanggungJawabSi'>Penanggung Jawab</option>
		</select>
		&nbsp;&nbsp;<input type=text size='40' name='optionValue' />&nbsp;&nbsp;<input type=submit value='Cari' name='submit' />
		</td>
	  </tr>
</table>

<br><br>

<table align=center border="0" cellpadding="0" cellspacing="3" width="800" class='gridua'>
	<thead>
	  <tr>
		<th>NO ASET</th>
	  	<th>KATEGORI</th>
		<th>JENIS BANGUNAN</th>
        <th>NO DOKUMEN</th>
		<th>MITRA KERJASAMA</th>
		<th>LOKASI</th>
        <th colspan='6'>
			<table align="center">
				<tr>
					<td>
						<a href="<?=site_url()?>/sjaset/asetgdbang/input">
							<div class='ui-state-default ui-corner-all lebariconkecil' title='TAMBAH DATA ASET GEDUNG BANGUNAN'>
								<span class='ui-icon ui-icon-plusthick' />
							</div
						</a>
					</td>
				</tr>
			</table>
		</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {
	
	$id			= $view_data[$a]['ItemID'];
	$asno		= $view_data[$a]['AssetNo'];
    $katname	= $view_data[$a]['KatName'];
    $jgdb		= $view_data[$a]['JenisGdgBangunanName'];
	$lok		= $view_data[$a]['LokasiPs'];
	$nodok		= $view_data[$a]['NoDokumenSi'];
	$mtrkj		= $view_data[$a]['MitraKerjasamaSi'];
?>
	  <tr>
	  	<td align='center'><?=$asno?></td>
		<td align='center'><?=$katname?></td>
	  	<td align='center'><?=$jgdb?></td>
		<td align='center'><?=$nodok?></td>
		<td align='center'><?=$mtrkj?></td>
		<td align='center'><?=$lok?></td>
		<td width=40 align='center'>
			<?php 
				$url	=$this->uri->uri_string();
			?>
			<a href="<?=site_url()?>/sjaset/asetgdbang/edit/<?=$id?>/<?=$url?>">
				<div class='ui-state-default ui-corner-all lebariconkecil' title='EDIT DATA ASET GEDUNG BANGUNAN'>
					<span class='ui-icon ui-icon-pencil' />
				</div>
			</a>
		</td>
		<td width=40 align='center'>
			<a href="<?=site_url()?>/sjaset/asetgdbang/pdf/<?=$id?>/<?=$url?>">
				<div class='ui-state-default ui-corner-all lebariconkecil' title='PDF'>
					<span class='ui-icon ui-icon-document' />
				</div>
			</a>
		</td>
	  </tr>
<?php } ?>
	</tbody>
</table>
<br><br>
<?=$this->pagination->create_links()?>
<br><br>
</form>
</body>
</html>