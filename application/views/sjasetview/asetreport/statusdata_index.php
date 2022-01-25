<!DOCTYPE html>
<html>
<head>
	<title>Status Penginputan Data Aset</title>
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csstable/tablegrid2.css" media="screen" rel="stylesheet" />
<link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csspaging/paging.css" media="screen" rel="stylesheet" />
<?php $this->load->view('js/jqueryui')?>
<?php
    // $this->load->view('js/SelectValidation');
?>
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
.tinggitd{
	height:80px;
}
.fontbesar{
	font-size: 180%;
}
.lebardata{
	width:100px;
}
</style>
</head>
<body>
<?php menulist()?>

<br />
<br />
<br />

<table align="center" border="0" cellpadding="0" cellspacing="3" class='gridtable'>
    <thead>
        <tr><th colspan='6'>STATUS PENGINPUTAN DATA</th></tr>
    </thead>
    <tbody>
    <tr>
        <th width="120">TANAH</th>
        <th width="120">GEDUNG DAN BANGUNAN</th>
        <th width="120">PERLENGKAPAN DAN PERALATAN</th>
        <th width="120">ELEKTRONIKA DAN MESIN</th>
        <th width="120">KENDARAAN</th>
        <th width="120">TOTAL</th>
    </tr>
    <tr class="tinggitd fontbesar">
        <th align="center"><br /><?=$astdata['Tanah']?><br />&nbsp;</th>
        <th align="center"><br /><?=$astdata['Gdbang']?><br />&nbsp;</th>
        <th align="center"><br /><?=$astdata['Lenglat']?><br />&nbsp;</th>
        <th align="center"><br /><?=$astdata['Elmes']?><br />&nbsp;</th>
        <th align="center"><br /><?=$astdata['Kendaraan']?><br />&nbsp;</th>
        <th align="center"><br /><?=$astdata['Total']?><br />&nbsp;</th>
    </tr>
    </tbody>
</table>

<br />
<br />
</body>
</html>