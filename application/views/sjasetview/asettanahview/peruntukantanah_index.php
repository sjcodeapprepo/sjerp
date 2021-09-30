<html>

<head>
    <title>Peruntukan Tanah</title>
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
            <th colspan="2">PERUNTUKAN TANAH</th>
	  </tr>
    </thead>
    </table>
    <form action="<?= site_url() ?>/sjaset/asetperuntukantanahmaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
	<thead>
	  <tr>
		<th>NO KODE</th>
		<th>PERUNTUKAN TANAH</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id		    = $view_data[$a]['PeruntukanID'];
	$peruntukanname	= $view_data[$a]['PeruntukanName'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$peruntukanname?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='PeruntukanID' size='4' id='PeruntukanID' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='PeruntukanName' size='20' id='PeruntukanName' />
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
        new Spry.Widget.ValidationTextField("PeruntukanName", "none");
        new Spry.Widget.ValidationTextField("PeruntukanID", "integer");
    </script>
</body>

</html>