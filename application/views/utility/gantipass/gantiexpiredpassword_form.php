<html>
<head>
	<title>Ganti Expired Password</title>
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
	<link href="<?php echo base_url();?>public/adobespry/widgets/textfieldvalidation/SpryValidationTextField.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>/public/adobespry/widgets/textfieldvalidation/SpryValidationTextField.js" type="text/javascript"></script>
</head>
<body>
<?php 
$this->load->view('js/jqueryui');
menulist(); ?>
	<br />
	<br />
<form id="loginform" method="post" action="<?=base_url().'index.php/utility/gantiexpiredpass/updatePass'?>">
	<input type="hidden" name="oldmd5pass" id="oldmd5pass" value="<?=$md5oldpass?>" />
<div align='center'>Password telah expired(+30 hari)<br/>Harus di ganti dengan yg baru<br/>(tidak boleh sama dengan password yg lama)</div>

<table align=center style="width:300" class="gridtable">
<!--
<table align=center style="width:300">
-->
<thead>
	<tr><th colspan='2' height='30'>Ganti Expired Password</th></tr>
</thead>
      <tr>
        <td align=right>Username &nbsp;&nbsp;</td>
        <td noWrap><input type="text" name="username" tabindex="1" id="username" value="<?=$username?>" readonly/></td>
	  </tr>
	  <tr>
	  	<td align=right>Password Baru&nbsp;&nbsp;</td>
        <td noWrap>
			<span id="minsixchar">
				<input type="password" name="passwordbaru" tabindex="2" id="passwordbaru" />
			<span class="textfieldMinCharsMsg"><br />Minimum 6 char</span>
		</td>
	  </tr>
	  <tr align=center height=40>
        <td align=center colspan=2>
        <input type=hidden name="userid" value="<?=$userid?>">
			<input name="Submit" type="submit" id="submit" tabindex="4" value="Ganti Password">
		</td>
		</td>
	 </tr>
</table>
</form>
</div>
<script type="text/javascript">
	new Spry.Widget.ValidationTextField("minsixchar","none",{minChars:6,useCharacterMasking:true});
</script>
</body>
</html>