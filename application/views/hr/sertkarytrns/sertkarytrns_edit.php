<html>

<head>
    <title>Data Sertififkat/Ijasah Karyawan - edit</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
    <?php
    $this->load->view('js/jqueryui');
    $this->load->view('js/select2');
    $this->load->view('js/TextValidation');
    ?>
    <style>
        .msg {
            color: red;
            text-align: center;
            font-weight: bold;
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
$(function() {
	

});

</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/hr/sertkarytrns/inputeditproc/<?= $data['ID'] ?>" method='post' id='formin' enctype="multipart/form-data">
        <input type='hidden' name='urlsegment' id='urlsegment' value='<?= $urlsegment ?>' />
        <br />
        <br />
        <br />
        <table width='400' align='center'>
            <tr>
                <td>
                    <table class='gridtable' width='400'>
                        <thead>
                            <tr>
                                <th colspan='4'>Data Sertifikat/Ijasah Karyawan</th>
                            </tr>
                        </thead>
                        <tr>
                            <td align="right">
                                NIK - Nama Karyawan&nbsp;
                            </td>
                            <td>
                                <input type='hidden' name='idkaryawan' id='idkaryawan' value='<?=$data['KaryawanID']?>' />
                                <?=$data['NIK']?> - <?=$data['Nama']?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Jenis Sertifikat/Ijasah&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('certtypeid', $certypemst, 'CertTypeID', 'CertTypeName', $data['CertTypeID'], '', '', "id='certtypeid'");?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Tahun&nbsp;
                            </td>
                            <td>
                                <input type='text' name='validyear' size='4' id='validyear' value="<?= $data['ValidYear'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Nama Sertifikat/Ijasah&nbsp;
                            </td>
                            <td>
                                <input type='text' name='certname' size='60' id='certname' value="<?= $data['CertName'] ?>" />
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td align="right">
                                No Sertifikat/Ijasah&nbsp;
                            </td>
                            <td>
                                <input type='text' name='certno' size='60' id='certno' value="<?= $data['CertNo'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Catatan&nbsp;
                            </td>
                            <td>
                                <input type='text' name='notes' size='60' id='notes' value="<?= $data['Notes'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                File Sertifikat/Ijasah&nbsp;
                            </td>
                            <td>
                                <input type='hidden' name='filelocation' id='filelocation' value='<?=$data['FileLocation']?>' />
                                <input name="sertfile" type="file" id="sertfile" size="80" maxlength="80" />
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type='submit' name='submit' value='BATAL' />
                    <input type='submit' name='submit' value='SIMPAN' />
                </td>
            </tr>
        </table>
    </form>
    <script>
        new Spry.Widget.ValidationTextField("certname", "none");
        new Spry.Widget.ValidationTextField("tahun", "integer", {
            minValue: "1970"
        });
    </script>
</body>

</html>