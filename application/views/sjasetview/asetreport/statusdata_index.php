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
.fontkecil {
    font-size: 80%;
}
.miring {
    font-style: italic;
}
</style>
</head>
<body>
<?php menulist()?>

<br />
<br />
<br />
<table align="center" width="850">
    <tr>
        <td>

            <table border="0" cellpadding="0" cellspacing="3" class='gridtable'>
                <thead>
                    <tr><th>&nbsp;</th><th colspan='6'>STATUS PENGINPUTAN DATA</th></tr>
                </thead>
                <tbody>
                <tr>
                    <th width="120">&nbsp;</th>
                    <th width="120">TANAH</th>
                    <th width="120">GEDUNG DAN BANGUNAN</th>
                    <th width="120">PERLENGKAPAN DAN PERALATAN</th>
                    <th width="120">ELEKTRONIKA DAN MESIN</th>
                    <th width="120">KENDARAAN</th>
                    <th width="120">TOTAL</th>
                </tr>
                <tr>
                    <th align="center">Target*</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(120, 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(30, 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(3540, 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(2280, 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(30, 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format(6000, 0, ',','.')?><br />&nbsp;</th>
                </tr>
                <tr>
                    <th align="center">Terinput</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Tanah'], 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Gdbang'], 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Lenglat'], 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Elmes'], 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Kendaraan'], 0, ',','.')?><br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($astdata['Total'], 0, ',','.')?><br />&nbsp;</th>
                </tr>
            <?php
            $d6 = 4720; // total asusmsi
            $c6 = 2674; // 59% elmes
            $b6 = 1918; // 38% perlengkapan dan peralatan

            $a1  = 109; //tanah
            $a2 = 9; //gdbang
            $a3 = 10; //kendaraan

            $elmes  = ($astdata['Elmes']/$b6) * 100;
            $lenglat  = ($astdata['Lenglat']/$c6) * 100;
            $tanah  = ($astdata['Tanah']/$a1) * 100;
            $gdbang  = ($astdata['Gdbang']/$a2) * 100;
            $kendaraan  = ($astdata['Kendaraan']/$a3) * 100;
            $total  = ($astdata['Total']/$d6) * 100;
            ?>
                <tr>
                    <th align="center">Progress</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($tanah, 1, ',','')?> %<br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($gdbang, 1, ',','')?> %<br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($lenglat, 1, ',','')?> %<br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($elmes, 1, ',','')?> %<br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($kendaraan, 1, ',','')?> %<br />&nbsp;</th>
                    <th align="center" class="tinggitd fontbesar"><br /><?=number_format($total, 1, ',','')?> %<br />&nbsp;</th>
                </tr>
                </tbody>
            </table>
    </td>
</tr>
<tr>
    <td class="fontkecil miring">
*Catatan :
Progress target tercapai dihitung berdasarkan asumsi total data sebanyak 4720. 
Dengan komposisi data Tanah (109), Gedung dan Bangunan (9) dan Kendaraan (10), 
Elektronika dan Mesin (2676) dan Perlengkapan dan Peralatan (1918).
Jumlah Data Asumsi Gedung Bangunan, Perlengkapan dan Peralatan, dan Elektronika dan Mesin 
berdasarkan BAST Laporan hasil sensus aset tahun 2019. Untuk Golongan Tanah, jumlah asumsi data 
berdasarkan soft copy inventarisasi aset tanah yg dibuat tahun 2021. 
    </td>
</tr>
</table>

<br />
<br />
</body>
</html>