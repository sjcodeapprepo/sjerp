<html>

<head>
    <title>Jenis Dokumen Tanah</title>
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
    <table class='gridtable' width='600'>
    <thead>
        <tr>
            <th colspan="2">JENIS DOKUMEN TANAH</th>
	  </tr>
    </thead>
    </table>
    <form action="<?= site_url() ?>/sjaset/asetjenisdoktanahmaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
	<thead>
	  <tr>
		<th>NO KODE</th>
		<th>JENIS DOKUMEN TANAH</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id		    = $view_data[$a]['JenisDokumenTanahID'];
	$jenisdokname	= $view_data[$a]['JenisDokumenTanahName'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$jenisdokname?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='JenisDokumenTanahID' size='4' id='JenisDokumenTanahID' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='JenisDokumenTanahName' size='20' id='JenisDokumenTanahName' />
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
        new Spry.Widget.ValidationTextField("JenisDokumenTanahName", "none");
        new Spry.Widget.ValidationTextField("JenisDokumenTanahID", "integer");
    </script>
</body>

</html>