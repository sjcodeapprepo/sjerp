<html>

<head>
    <title>Aset Elektronika dan Mesin - input</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
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
    <form action="<?= site_url() ?>/sjaset/asetgelmes/inputeditproc/<?= $data['ItemID'] ?>" method='post' id='formin' enctype="multipart/form-data">
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
                                <th colspan='4'>Elektronika dan Mesin</th>
                            </tr>
                        </thead>
						<tr>
                            <td align="right">
                                No Aset&nbsp;
                            </td>
                            <td colspan='3'>
								<input type='text' name='assetno' size='60' id='assetno' value="<?= $data['AssetNo'] ?>" />
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Kategori&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('itemkatmaster', $itemkatmaster, 'KatID', 'KatName', $data['KatID'], '00', '-Pilih Kategori-', "id='katid'");?>
                            </td>
                            <td align="right">
                                Jenis&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jeniselkmesinkatid', $itemjeniselkmesinmaster, 'JenisElkmesinKatID', 'JenisElkmesinKatName', $data['JenisElkmesinKatID'], '00', '-Pilih Jenis-', "id='jeniselkmesinkatid'");?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Perolehan&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumenpr' size='60' id='nodokumenpr' value="<?= $data['NoDokumenPr'] ?>" />
                            </td>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('lokasiidpr', $itemlokasimaster, 'LokasiID', 'LokasiName', $data['LokasiIDPr'], '00', '-Pilih Lokasi-', "id='lokasiidpr'");?>
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaipr' size='50' id='nilaipr' value="<?= $data['NilaiPr'] ?>" class='ratakanan' />
                            </td>
                            <td align="right">
                                Penyusutan&nbsp;
                            </td>
                            <td>
								<input type='text' name='penyusutanpr' size='10' id='penyusutanpr' value="<?= $data['PenyusutanPr'] ?>" class='ratakanan' /> %
							</td>
                        </tr>
						<tr>
                            <td colspan='4' class='subdata'>
                                Posisi&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Divisi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('divisionidps', $itemdivisionmaster, 'DivisionID', 'DivisionAbbr', $data['DivisionIDPs'], '00', '-Pilih Divisi-', "id='divisionidps'");?>
                            </td>
                            <td align="right">
                                Penanggung Jawab&nbsp;
                            </td>
                            <td>
								<input type='text' name='penanggungjawabps' size='30' id='penanggungjawabps' value="<?= $data['PenanggungJawabPs'] ?>" class='ratakanan' />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Kondisi&nbsp;
                            </td>
                            <td colspan='3'>
								<select name="kondisikodesi" id="kondisikodesi">
									<option value="">-Pilih Kondisi-</option>
									<option value="B">Baik</option>
									<option value="RR">Rusak Ringan</option>
									<option value="RB">Rusak Berat</option>
								</select>
							</td>
                        </tr>
						<tr> <!-- ////////////////////////////=============================//////////////////////////////////// -->
                            <td colspan='4'  class='subdata'>
                                Kondisi Saat Ini&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Harga&nbsp;
                            </td>
                            <td>
                                <input type='text' name='penanggungjawabps' size='30' id='penanggungjawabps' value="<?= $data['PenanggungJawabPs'] ?>" class='ratakanan' />                            </td>
                            <td align="right">
                                File Foto&nbsp;
                            </td>
                            <td>
								<input type='text' name='penanggungjawabps' size='30' id='penanggungjawabps' value="<?= $data['PenanggungJawabPs'] ?>" class='ratakanan' />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Keterangan&nbsp;
                            </td>
                            <td>
								<textarea name="" id=""></textarea>
							</td>
                            <td colspan="3">
                                Gambar
                                <div id="picaset"></div>
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
        new Spry.Widget.ValidationTextField("certname", "none");
        new Spry.Widget.ValidationTextField("tahun", "integer", {
            minValue: "1970"
        });
    </script>
</body>

</html>