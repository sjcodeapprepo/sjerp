<html>

<head>
    <title>Aset Kendaraan - input</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
    <?php
		$this->load->view('js/jqueryui');
		$this->load->view('js/TextValidation');
        $this->load->view('js/SelectValidation');
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
    $(function() {
        $("#katid").change(function() {
            var katid   = $(this).val();            
            getJenis(katid);
        });

        $("#tglpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });
        $("#tgldokumenpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });
        $("#tglstnkpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });
        $( "#penyusutanps" ).focusin(function() {
            $(this).val('');
        });

        $( "#penyusutanps" ).focusout(function() {
            if($(this).val()=='') {
                $(this).val(0);
            }
        });
    });

    function getJenis(katid) {
        if(katid != '') {
            $.post('<?=site_url()?>/sjaset/asetkendaraan/getJenis/'+katid, function(data){
                $('#jenisidj').empty();
                $('#jenisidj').append(data);
            });
        } else {
            $('#jenisidj').empty();
            $('#jenisidj').append('<option value="-1">--Pilih Kategori dahulu--</option>');
        }
    }
</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/sjaset/asetkendaraan/inputeditproc/" method='post' id='formin' enctype="multipart/form-data">
        <input type='hidden' name='urlsegment' id='urlsegment' value='<?= $urlsegment ?>' />
        <br />
        <br />
        <br />
        <table width='400' align='center'>
            <tr>
                <td>
                    <table class='gridtable' width='600'>
                        <thead>
                            <tr>
                                <th colspan='4'>Kendaraan</th>
                            </tr>
                        </thead>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Identitas Barang&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                No Aset&nbsp;
                            </td>
                            <td colspan='3'>
								&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Kategori&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('katid', $itemkatmaster, 'KatID', 'KatName', $data['KatID'], '', '-Pilih Kategori-', "id='katid'");?>
                            </td>
                            <td align="right">
                                Jenis&nbsp;
                            </td>
                            <td>
                                <select name="jenisidj" id="jenisidj">
                                    <option value="-1">--Pilih Kategori dahulu--</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Perolehan&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Tgl Perolehan&nbsp;
                            </td>
                            <td>
								<input type='text' name='tglpr' size='9' id='tglpr' value="<?= $data['TglPr'] ?>" readonly />
                            </td>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumenpr' size='30' id='nodokumenpr' value="<?= $data['NoDokumenPr'] ?>" />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaipr' size='20' id='nilaipr' value="<?= $data['NilaiPr'] ?>" class='ratakanan' />
                            </td>
                            <td align="right">
                                Penyusutan&nbsp;
                            </td>
                            <td>
								<input type='text' name='penyusutanpr' size='3' id='penyusutanpr' value="<?= $data['PenyusutanPr'] ?>" class='ratakanan' /> %
							</td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokumen Kendaraan&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                No BPKB&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumenbpkbpr' size='12' id='nodokumenbpkbpr' value="<?= $data['NoDokumenBPKBPr'] ?>" />
							</td>
                            <td align="right">
                                Tgl Dokumen&nbsp;
                            </td>
                            <td>
                                <input type='text' name='tgldokumenpr' size='9' id='tgldokumenpr' value="<?= $data['TglDokumenPr'] ?>" readonly />
							</td>
                        </tr>
                        <tr>
                            <td align="right">
                                No STNK&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nostnkpr' size='12' id='nostnkpr' value="<?= $data['NoSTNKPr'] ?>" />
                            </td>
                            <td align="right">
                                Tgl STNK&nbsp;
                            </td>
                            <td>
                                <input type='text' name='tglstnkpr' size='9' id='tglstnkpr' value="<?= $data['TglSTNKPr'] ?>" readonly />
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detail Kendaraan&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Merk&nbsp;
                            </td>
                            <td>
                                <input type='text' name='merkpr' size='30' id='merkpr' value="<?= $data['MerkPr'] ?>" />
                            </td>
                            <td align="right">
                                No Rangka&nbsp;
                            </td>
                            <td>
                                <input type='text' name='norangkapr' size='12' id='norangkapr' value="<?= $data['NoRangkaPr'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                No Polisi&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nopolpr' size='9' id='nopolpr' value="<?= $data['NoPolPr'] ?>" />
                            </td>
                            <td align="right">
                                Tahun Dibuat&nbsp;
                            </td>
                            <td>
                                <input type='text' name='tahundibuatpr' size='8' id='tahundibuatpr' value="<?= $data['TahunDibuatPr'] ?>" />
                            </td>                            
                        </tr>
                        <tr>
                            <td align="right">
                                No Mesin&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nomesinpr' size='12' id='nomesinpr' value="<?= $data['NoMesinPr'] ?>" />
                            </td>
                            <td align="right">
                                Isi Silinder&nbsp;
                            </td>
                            <td>
                                <input type='text' name='isisilinderpr' size='8' id='isisilinderpr' value="<?= $data['IsiSilinderPr'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Warna&nbsp;
                            </td>
                            <td>
                                <input type='text' name='warnapr' size='12' id='warnapr' value="<?= $data['WarnaPr'] ?>" />
                            </td>
                            <td align="right">
                                Bahan Bakar&nbsp;
                            </td>
                            <td>
                                <input type='text' name='bahanbakarpr' size='12' id='bahanbakarpr' value="<?= $data['BahanBakarPr'] ?>" />
                            </td>
                        </tr>
						<tr>
                            <td colspan='4' class='subdata'>
                                Posisi&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('lokasiidps', $itemlokasimaster, 'LokasiID', 'LokasiName', $data['LokasiIDPs'], '', '-Pilih Lokasi-', "id='lokasiidps'");?>
                            </td>
                            <td align="right">
                                Divisi&nbsp;
                            </td>
                            <td colspan="3">
							    <?=form_dropdownDB_init('divisionidps', $itemdivisionmaster, 'DivisionID', 'DivisionAbbr', $data['DivisionIDPs'], '', '-Pilih Divisi-', "id='divisionidps'");?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Penanggung Jawab&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='penanggungjawabps' size='30' id='penanggungjawabps' value="<?= $data['PenanggungJawabPs'] ?>" />
                            </td>
                        </tr>
						<tr>
                            <td colspan='4' class='subdata'>
                                Kondisi Saat Ini&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Kondisi&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('kondisikodesi', $kondisikodesi, 'KondisiKodeSi', 'KondisiKodeSiName', $data['KondisiKodeSi'], '', '-Pilih Kondisi-', "id='kondisikodesi'");?>
							</td>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nilaisi' size='20' id='nilaisi' value="<?= $data['NilaiSi'] ?>" class='ratakanan' /> 
                            </td>
                        </tr>
						<tr>
                            <td align="right" valign="top">
                                Keterangan&nbsp;
                            </td>
                            <td colspan="3">
								<textarea name="keterangansi" id="keterangansi" rows="4" cols="50"><?= $data['KeteranganSi'] ?></textarea>
							</td>
                        </tr>
                        <tr>
                        <tr>
                            <td align="right">
                                File Foto&nbsp;
                            </td>
                            <td colspan="3">
                                <input name="piclocationsi" type="file" id="piclocationsi" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type='submit' name='submit' value='KEMBALI' />
                    <input type='submit' name='submit' value='SIMPAN' />
                </td>
            </tr>
        </table>
    </form>
    <script>
        // new Spry.Widget.ValidationTextField("nodokumenpr", "none");
        // new Spry.Widget.ValidationTextField("nilaipr", "integer", {minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("nilaisi", "integer", {minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("penyusutanpr", "integer", {minValue: "0",maxValue: "100",useCharacterMasking:true});
        
        // new Spry.Widget.ValidationSelect("katid");
        // new Spry.Widget.ValidationSelect("kondisikodesi");

        // new Spry.Widget.ValidationTextField("nodokumenbpkbpr", "none"); 
        // new Spry.Widget.ValidationTextField("nostnkpr", "none");
        // new Spry.Widget.ValidationTextField("merkpr", "none");
        // new Spry.Widget.ValidationTextField("norangkapr", "none");
        // new Spry.Widget.ValidationTextField("nopolpr", "none");
        // new Spry.Widget.ValidationTextField("nomesinpr", "none");
        // new Spry.Widget.ValidationTextField("warnapr", "none");
        // new Spry.Widget.ValidationTextField("bahanbakarpr", "none");
        // new Spry.Widget.ValidationTextField("penanggungjawabps", "none");

        // new Spry.Widget.ValidationTextField("tahundibuatpr", "integer", {useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("isisilinderpr", "integer", {useCharacterMasking:true});
        
        // new Spry.Widget.ValidationSelect("lokasiidps");
        // new Spry.Widget.ValidationSelect("divisionidps");
        // new Spry.Widget.ValidationSelect("jenisidj");
    </script>
</body>

</html>