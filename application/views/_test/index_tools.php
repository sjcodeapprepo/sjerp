<html>
    <body>
        <table border="1">
<?php 
    for($a=0; $a<count($datasrc); $a++) {	
	    $id             = $datasrc[$a]['id'];
        $jenisbarang    = $datasrc[$a]['jenis_barang'];
        $merk           = $datasrc[$a]['merk_model'];
        $ukuran         = $datasrc[$a]['ukuran'];
        $bahan          = $datasrc[$a]['bahan'];
        $tahunpengadaan = $datasrc[$a]['tahunpengadaan'];
        $nomorkode      = $datasrc[$a]['nomor_kode'];
        $jumlah         = $datasrc[$a]['jumlah'];
        $keadaanbarang  = $datasrc[$a]['keadaan_barang'];
        $keterangan     = $datasrc[$a]['keterangan'];
        $lokasi         = $datasrc[$a]['lokasi'];
        $nama           = $datasrc[$a]['nama'];
?>
<tr>
    <td><?=$id?></td>
    <td><?=$jenisbarang?></td>
    <td><?=$merk?></td>
    <td><?=$ukuran?></td>
    <td><?=$bahan?></td>
    <td><?=$tahunpengadaan?></td>
    <td><?=$nomorkode?></td>
    <td><?=$jumlah?></td>
    <td><?=$keadaanbarang?></td>
    <td><?=$keterangan?></td>
    <td><?=$lokasi?></td>
    <td><?=$nama?></td>
</tr>
<?php } ?>
        </table>
    </body>
</html>
