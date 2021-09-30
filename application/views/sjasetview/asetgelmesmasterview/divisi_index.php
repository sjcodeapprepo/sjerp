<html>

<head>
    <title>Master Divisi</title>
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
            <th colspan="2">MASTER DIVISI</th>
	  </tr>
    </thead>
    </table>
    <form action="<?= site_url() ?>/sjaset/asetdivisimaster/index" method='post' id='formin' enctype="multipart/form-data">
    <table border="0" cellpadding="0" cellspacing="3" width="600" class='gridua'>
	<thead>
	  <tr>
		<th>NO KODE</th>
		<th>NAMA DIVISI</th>
        <th>DIVISI</th>
	  </tr>
	</thead>
	<tbody>
<?php 
for($a=0; $a<count($view_data); $a++) {	
	$id		    = $view_data[$a]['DivisionID'];
	$divname	= $view_data[$a]['DivisionName'];
    $divabbr	= $view_data[$a]['DivisionAbbr'];
?>
	  <tr>
	  	<td align='center'><?=$id?></td>
		<td align='left'><?=$divname?></td>
        <td align='left'><?=$divabbr?></td>
	  </tr>
<?php } ?>
        <tr>
            <td align='center'>
                <input type='text' name='divisionid' size='4' id='divisionid' class='ratakanan' /> 
            </td>
            <td align='left'>
                <input type='text' name='divisionname' size='20' id='divisionname' />
            </td>
            <td align='left'>
                <input type='text' name='divisionabbr' size='20' id='divisionabbr' />
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
        new Spry.Widget.ValidationTextField("divisionname", "none");
        new Spry.Widget.ValidationTextField("divisionabbr", "none");
        new Spry.Widget.ValidationTextField("divisionid", "integer");
    </script>
</body>

</html>