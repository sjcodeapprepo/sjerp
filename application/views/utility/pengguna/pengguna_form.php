<html>
<head>
	<title>User Pengguna</title>
<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<link href="<?php echo base_url();?>public/adobespry/widgets/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>/public/adobespry/widgets/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>

</head>
<body>
<?php 
	$this->load->view('js/jqueryui');
	menulist();
	?>
<script type="text/javascript">
$(document).ready(function(){
	$('#UserPwd_confirm_f').blur(function(){
		if($('#UserPwd_confirm_f').val() != $('#UserPwd_f').val()){
			alert('password tidak sama');
			$('#UserPwd_confirm_f').val('');
			$('#UserPwd_f').val('');
		}
	});
});
</script>
	<br />
	<br />
	<br />
	<br />
<form action='<?=site_url()?>/utility/pengguna/insert' method='post'>
<table align='center' style="width:300" class="gridtable">
<thead>
	<tr><th colspan='2' height='30'>PENGGUNA</th></tr>
</thead>
      <tr>
        <td noWrap align=right>Nama : </td>
        <td noWrap>
		
		<span id="UserName">
		<input size='15' name='UserName'>
		</span>
		
		</td>
	  </tr>
      <tr>
        <td noWrap align='right'>Password : </td>
        <td noWrap>
	
		<span id="UserPwd">
		<input size='15' name='UserPwd' type='password' id="UserPwd_f">
		</span>
		
		</td>
	  </tr>
	  <tr>
        <td noWrap align='right'>Konfirmasi : </td>
        <td noWrap>

		<span id="UserPwd_confirm">
		<input size=15 name='UserPwd_confirm' id="UserPwd_confirm_f" type=password>
		</span>
		
		</td>
	  </tr>
	  <tr>
        <td noWrap align='right'>Welcome Page : </td>
        <td noWrap>
			<input size='15' name='defaultpage' value="auth/login/welcome"></td>
	  </tr>
	  <tr>
        <td noWrap align=right>Group : </td>
        <td noWrap><?=form_dropdownDB('UserGroupID', $group, 'UserGroupID', 'UserGroupName');?></td>
	  </tr>
	  <tr>
        <td noWrap align=right>Aktif :</td>
        <td noWrap><input type=checkbox name='ActiveFlg' value=1> Aktif</td>
	  </tr>
      <tr>
        <td align='center' colspan='2'>
        <?php if ($modifyflag){?>
		<input type=submit value=SIMPAN name=submit class='button'>
		<?php }?>
		<input type=hidden name=kirim value=1 class='button'>
		<input type=reset value=BATAL class='button'>
		</td>
	  </tr>
</table>
</form>
<script type="text/javascript">
	var number1 = new Spry.Widget.ValidationTextField("UserID", "none");
	var number2 = new Spry.Widget.ValidationTextField("UserName", "none");
	var number3 = new Spry.Widget.ValidationTextField("UserPwd", "none");
	var number4 = new Spry.Widget.ValidationTextField("UserPwd_confirm", "none");
</script>
</body>
</html>