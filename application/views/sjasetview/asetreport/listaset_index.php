<!DOCTYPE html>
<html>
<head>
	<title>Aset Tanah - list</title>
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

<form action=<?=site_url().'/sjaset/listaset/xlslist'?> method='post'>
<table align=center border="0" cellpadding="0" cellspacing="3" width="400" class='gridtable'>
	<thead>
	  <tr><th colspan='2'>LIST ASET</th></tr>
  	</thead>
      <tr>
        <td noWrap align=center>
            Golongan &nbsp;&nbsp;
		<select name="golaset">
			<!-- <option value='01'>Tanah</option> -->
			<!-- <option value='02'>Gedung dan Bangunan</option> -->
			<option value='03'>Perlengkapan dan Peralatan</option>
			<option value='04'>Elektronika dan Mesin</option>
			<!-- <option value='05'>Kendaraan</option> -->
		</select>
            &nbsp;&nbsp;<input type=submit value='.XLS' name='submit' />
		</td>
	  </tr>
</table>

<br />
<br />
</form>
</body>
</html>