<html>
<head>
	<title>BLOK REGISTER</title>
<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<?php 
$this->load->view('js/jqueryui');
$this->load->view('js/select2');
?>
<style>
	.firstwidth{
		width:500px;
	}
	.firstwidthb {
		width:100px;
	}
	.InputAlignRight{
		text-align:right;
	}
</style>
<script type="text/javascript">
$(function() {
	
	$("#daritgl").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
	
	$("#sampaitgl").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
    });
	
	$('#estdivblok').select2({
		ajax: {
			delay: 500,
			url: '<?=site_url()?>/akuntingaus/blokregister/getestdivblok/',
			dataType: 'json',
			type: "POST",
			data: function (params) {
					var tgldari		= $('#daritgl').val();
					var tglsampai	= $('#sampaitgl').val();
					var query = {
									keyword: tgldari+'|'+tglsampai+'|'+params.term
								}
					return query;
			}
		}
	});
});

</script>
</head>
<body>
<?php menulist()?>
<form action='<?=site_url()?>/akuntingaus/blokregister/proses' method='post' id='process1' name='form1'>
	<br /><br /><br /><br /><br /><br />
<table align=center border="0" cellpadding="0" cellspacing="3" width="800" class='gridtable'>
	<thead>
	<tr><th colspan='2'>BLOK REGISTER</th></tr>
		<tr>
    	    <td align=center width=200>Periode</td>
    	    <td noWrap>
				Dari
				<input type="text" name="daritgl" id="daritgl" size="10" readonly>
				Sampai
				<input type="text" name="sampaitgl" id="sampaitgl" size="10" readonly>
			</td>
		</tr>
		<tr>
    	    <td align=center width=300>Divisi ESTATE - Blok - Tahun Tanam</td>
    	    <td noWrap>
				<select name="estdivblok" id="estdivblok" class="firstwidth" data-placeholder="-- cari dengan ESTATE, Divisi atau Blok --"/></select>
			</td>
		</tr>
		<tr>
			<td noWrap align='center' colspan='2'>
				<input type='submit' value='VIEW' name='submit' class='button'>
				<input type='submit' value='XL' name='submit' class='button'>
			</td>
		</tr>
		</thead>
</table>

</form>
</body>
</html>