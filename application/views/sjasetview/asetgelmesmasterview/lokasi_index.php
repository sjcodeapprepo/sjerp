<html>

<head>
    <title>Master Aset Lokasi </title>
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
    <table align="center">
    <tr><td>
    <form action="<?= site_url() ?>/sjaset/asetlokasimaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table class='gridtable' width='600'>
        <thead>
            <tr>
                <th>MASTER LOKASI</th>
            </tr>
        </thead>
    </table>
    <table border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
    <thead>
	  <tr>
		<th>NO KODE</th>
		<th>LOKASI</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id		= $view_data[$a]['LokasiID'];
	$lokasi	= $view_data[$a]['LokasiName'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$lokasi?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='lokasiid' size='4' id='lokasiid' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='lokasiname' size='20' id='lokasiname' />
            </td>
	    </tr>
        <tr>
            <td align='right' colspan="3">
                <input type='submit' name='submit' value='TAMBAH' />
            </td>
        </tr>
	</tbody>
</table>
    </form>


</td></tr>
</table>
    <script>
        new Spry.Widget.ValidationTextField("katname", "none");
        new Spry.Widget.ValidationTextField("katid", "integer");
    </script>
</body>

</html>