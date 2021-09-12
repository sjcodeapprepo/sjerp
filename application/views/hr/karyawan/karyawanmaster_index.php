<!DOCTYPE html>
<html>
<head>
	<title>Data Master Karyawan - list</title>
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
<form action=<?=site_url().'/hr/karyawanmaster'?> method='post'>
<table align=center border="0" cellpadding="0" cellspacing="3" width="600" class='gridtable'>
	<thead>
	  <tr><th colspan='2'>Data Master Karyawan</th></tr>
  	</thead>
      <tr>
        <td noWrap align=center>
		<select name="option">
			<option value='k.Nama'>Nama</option>
			<option value='k.NIK'>NIK</option>
			<option value='k.TglLahir'>Tgl Lahir</option>
		</select>
		&nbsp;&nbsp;<input type=text size='40' name='optionValue' />&nbsp;&nbsp;<input type=submit value='Cari' name='submit' />
		</td>
	  </tr>
</table>

<br><br>

<table align=center border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
	<thead>
	  <tr>
		<th>NIK/NO IDENTITAS</th>	  	
	  	<th>NAMA</th>		
	  	<th>JK</th>
		<th>TANGGAL LAHIR</th>
	  	<th colspan='6'>
			<table align="center">
				<tr>
					<td>
						<a href="<?=site_url()?>/hr/karyawanmaster/input">
							<div class='ui-state-default ui-corner-all lebariconkecil' title='TAMBAH DATA KARYAWAN'>
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
	
	$id			= $view_data[$a]['ID'];
	$nik		= $view_data[$a]['NIK'];
	$nama		= $view_data[$a]['Nama'];
	$jk			= $view_data[$a]['JK'];
	$tgllahir	= $view_data[$a]['TglLahir'];
	$isaktif	= $view_data[$a]['IsActive'];
?>
	  <tr>
	  	<td align='center'><?=$nik?></td>
		<td align='left'><?=$nama?></td>
		<td align='center'><?=$jk?></td>
	  	<td align='center'><?=$tgllahir?></td>
		<td width=40 align='center'>
			<?php 
				$url	=$this->uri->uri_string();
			?>
			<a href="<?=site_url()?>/hr/karyawanmaster/edit/<?=$id?>/<?=$url?>">
				<div class='ui-state-default ui-corner-all lebariconkecil' title='EDIT DATA KARYAWAN'>
					<span class='ui-icon ui-icon-pencil' />
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