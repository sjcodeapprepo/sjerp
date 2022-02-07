<html>

<head>
    <title>Master Jenis Gedung dan Bangunan</title>
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
    <form action="<?= site_url() ?>/sjaset/asetjenisgdbangmaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table align="center">
    <tr><td>
    <table class='gridtable' width='300'>
    <thead>
        <tr>
            <th>JENIS GEDUNG DAN BANGUNAN</th>
	  </tr>
    </thead>
    </table>
    <table border="0" cellpadding="0" cellspacing="3" width="300" class='gridua'>
	<thead>
	  <tr>
		<th>NO KODE</th>
		<th>JENIS GEDUNG DAN BANGUNAN</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id			= $view_data[$a]['JenisGdgBangunanID'];
	$jenis		= $view_data[$a]['JenisGdgBangunanName'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$jenis?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='JenisGdgBangunanID' size='4' id='JenisGdgBangunanID' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='JenisGdgBangunanName' size='16' id='JenisGdgBangunanName' />
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
        new Spry.Widget.ValidationTextField("JenisGdgBangunanName", "none");
        new Spry.Widget.ValidationTextField("JenisGdgBangunanID", "integer");
    </script>
</body>

</html>