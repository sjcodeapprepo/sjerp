<!DOCTYPE html>
<html>
<head>
	<title>Sertifikat / Ijasah Karyawan - list</title>
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
<script>
	function hapus_confirm(url) {
		var r = confirm("Yakin ?");
		if (r == true) 
		{
			window.location.assign(url);
		}
	}

	function newwindowtab(url) {
		var myWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400");
	}
</script>
</head>
<body>
<?php menulist()?>
<form action=<?=site_url().'/hr/sertkarytrns'?> method='post'>
<table align=center border="0" cellpadding="0" cellspacing="3" width="600" class='gridtable'>
	<thead>
	  <tr><th colspan='2'>Sertifikat / Ijasah Karyawan</th></tr>
  	</thead>
      <tr>
        <td noWrap align=center>
		<select name="option">
			<option value='k.Nama'>Nama</option>
			<option value='k.NIK'>NIK</option>
			<option value='c.ValidYear'>Tahun Sertifikat/Ijasah</option>
			<option value='c.CertName'>Nama Sertifikat/Ijasah</option>
			<option value='t.CertTypeName'>Jenis Sertifikat/Ijasah</option>

		</select>
		&nbsp;&nbsp;<input type=text size='40' name='optionValue' />&nbsp;&nbsp;<input type=submit value='Cari' name='submit' />
		</td>
	  </tr>
</table>

<br><br>

<table align=center border="0" cellpadding="0" cellspacing="3" width="800" class='gridua'>
	<thead>
	  <tr>
		<th>NIK/NO IDENTITAS</th>	  	
	  	<th>NAMA KARYAWAN</th>		
	  	<th>JENIS</th>
		<th>TAHUN</th>
		<th>NAMA SERTIFIKAT</th>
		<th colspan='3'>
			<table align="center">
				<tr>
					<td>
						<a href="<?=site_url()?>/hr/sertkarytrns/input">
							<div class='ui-state-default ui-corner-all lebariconkecil' title='TAMBAH DATA SERTIFIKAT/IJASAH'>
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
		$typeser	= $view_data[$a]['CertTypeName'];
		$nosert		= $view_data[$a]['CertNo'];
		$namasert	= $view_data[$a]['CertName'];
		$tahunsert	= $view_data[$a]['ValidYear'];

?>
	  <tr>
	  	<td align='center'><?=$nik?></td>
		<td align='left'><?=$nama?></td>
		<td align='center'><?=$typeser?></td>
	  	<td align='center'><?=$tahunsert?></td>
	  	<td align='left'><?=$namasert?></td>
		
		<td width=20 align='center'>
			<?php 
				$url	= $this->uri->uri_string();
			?>
			<a onclick='hapus_confirm("<?=site_url()?>/hr/sertkarytrns/delete/<?=$id?>/<?=$url?>")'>
				<div class='ui-state-default ui-corner-all lebariconkecil' title='DELETE DATA SERTIFIKAT/IJASAH'>
					<span class='ui-icon ui-icon-minus' />
				</div>
			</a>
		</td>

		<td width=20 align='center'>
			<a href="<?=site_url()?>/hr/sertkarytrns/edit/<?=$id?>/<?=$url?>">
				<div class='ui-state-default ui-corner-all lebariconkecil' title='EDIT DATA SERTIFIKAT/IJASAH'>
					<span class='ui-icon ui-icon-pencil' />
				</div>
			</a>
		</td>

		<td width=20 align='center'>
			<a onclick="newwindowtab('<?=site_url()?>/hr/sertkarytrns/dlview/<?=$id?>')" >
				<div class='ui-state-default ui-corner-all lebariconkecil' title='LIHAT DATA SERTIFIKAT/IJASAH'>
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