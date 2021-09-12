<html>

<head>
    <title>Data Master Karyawan - input</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
    <?php
    $this->load->view('js/jqueryui');
    $this->load->view('js/TextValidation');
    ?>
    <script type="text/javascript">
        $(function() {
            $("#tgllahir").datepicker({
                onSelect: function(value, ui) {
                    
                    var today = new Date();
                    var birthDate = new Date(value);
                    var age = today.getFullYear() - birthDate.getFullYear();
                    var m = today.getMonth() - birthDate.getMonth();
                    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
                    {
                        age--;
                    }

                    $('#umur').val(age);
                },                
                changeMonth: true,
                changeYear: true,
                yearRange: "1960:2010"
            });
            
        });
    </script>

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

</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/hr/karyawanmaster/inputeditproc/<?= $data['ID'] ?>" method='post' id='formin'>
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
                                <th colspan='4'>Data Master Karyawan</th>
                            </tr>
                        </thead>
                        <tr>
                            <td align="right">
                                NIK/No Identitas&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nik' size='20' id='nik' value="<?= $data['NIK'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Nama&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nama' size='60' id='nama' value="<?= $data['Nama'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                JK&nbsp;
                            </td>
                            <td>
                                <input type='text' name='jk' size='4' id='jk' value="<?= $data['JK'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Tgl Lahir/Umur&nbsp;
                            </td>
                            <td>
                                <input type='text' name='tgllahir' size='9' id='tgllahir' value="<?= $data['TglLahir'] ?>" readonly />
                                <input type="text" name="umur" id="umur" size='3' readonly/> Tahun
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Aktif&nbsp;
                            </td>
                            <td>
                                <input type='text' name='isactive' size='2' id='isactive' value="<?= $data['IsActive'] ?>" />
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
        new Spry.Widget.ValidationTextField("nik", "none");
        new Spry.Widget.ValidationTextField("umur", "integer", {
            minValue: "18"
        });
    </script>
</body>

</html>