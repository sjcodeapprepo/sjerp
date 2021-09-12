<html>
	<head>
	<title>Sarana Jaya</title>
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
	</head>
<body>
<?php 
	$this->load->view('js/jqueryui');
	menulist();
	?>
	<script>
		$(document).ready(function(){
			$("#msg").fadeOut( 9000, function() {
				
			});
		});
	</script>
<form action='<?=site_url()?>/auth/login/setJtArjunaSessionDB' method='post'>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
<table align=center border="0" cellpadding="0" cellspacing="3" width="300px" class="gridtable">
	<thead>
	<tr><th colspan='2'>Login</th></tr>
	</thead>
      <tr>
        <td align='right'>Username</td>
        <td nowrap><input size='13' name='UserName' id="username"></td>
	  </tr>
      <tr>
        <td nowrap align='right'>Password</td>
        <td nowrap><input size='13' name='UserPwd' type="password"></td>
	  </tr>
      <tr>
        <td align='center'  colspan='2' nowrap>
		<input type='submit' value='LOGIN'>
		</td>
	  </tr>
</table>
</form>
<center>
	<h2 id="msg"><?=$msg?></h2>
</center>
</body>
</html>