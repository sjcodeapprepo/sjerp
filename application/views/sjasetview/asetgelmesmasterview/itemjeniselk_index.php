<html>

<head>
    <title>Master Jenis Elektronika dan Mesin</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
    <link type="text/css" href="<?=base_url()?>publicfolder/cssdir/csstable/tablegrid2.css" media="screen" rel="stylesheet" />
    <?php
		$this->load->view('js/jqueryui');
		$this->load->view('js/TextValidation');
    ?>
    <style>
        .msg {
            color: red;
            text-align: center;
            font-weight: bold;
        }
        .subdata {
            font-weight: bold;
            font-style: italic;
            background-color: #F4F4F4;
        }

        .fixwidthkecil {
            width: 80px;
        }

        .fixwidthsedang {
            width: 180px;
        }
        .fixwidthlebar{
            width:500px;
    	}

        .ratakanan {
            text-align: right;
        }

        .fontkecil {
            font-size: 60%;
            vertical-align: top;
            font-style: italic;
        }

        td {
            white-space: nowrap;
        }
    </style>

<script type="text/javascript">

</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <br />
    <br />
    <br />
    <br />
    <form action="<?= site_url() ?>/sjaset/asetitemjeniselkmesinmaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table align="center">
    <tr><td>
    <table class='gridtable' width='600'>
    <thead>
        <tr>
            <th>JENIS ELEKTRONIKA DAN MESIN</th>
	  </tr>
    </thead>
    </table>
    <table border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
	<thead>
	  <tr>
		<th>NO KODE</th>
		<th>JENIS</th>
        <th>KATEGORI</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id			= $view_data[$a]['JenisElkmesinKatID'];
	$jenis		= $view_data[$a]['JenisElkmesinKatName'];
    $kat		= $view_data[$a]['KatName'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$jenis?></td>
        <td align='left'><?=$kat?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='jeniselkmesinkatid' size='4' id='jeniselkmesinkatid' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='jeniselkmesinkatname' size='16' id='jeniselkmesinkatname' />
            </td>
            <td align='left'>
                <?=form_dropdownDB_init('katid', $itemkatmaster, 'KatID', 'KatName', '', '', '-Pilih Kategori-', "id='katid'");?>
            </td>
        </tr>
        <tr>
            <td align='right' colspan="3">
                <input type='submit' name='submit' value='TAMBAH' />
            </td>
        </tr>
	</tbody>
</table>
</td></tr>
</table>
    </form>
    <script>
        new Spry.Widget.ValidationTextField("jeniselkmesinkatname", "none");
        new Spry.Widget.ValidationTextField("jeniselkmesinkatid", "integer");
        new Spry.Widget.ValidationSelect("katid");
    </script>
</body>

</html>