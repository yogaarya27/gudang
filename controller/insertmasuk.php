<?php

    session_start();
    $id = $_SESSION['id_gudang'];
    $nama = $_SESSION['nama'];
    $kapas = $_SESSION['kapasitas'];
    $stok = $_SESSION['stok'];
    
    include 'function.php';
    $idbarang = $_POST['id_barang'];
    $jumlahbarang = +$_POST['jumlah_barang'];
    $barangkeluar = -$jumlahbarang;
    $asalbarang = $_POST['asal_barang'];
    $tanggalmasuk = $_POST['tanggal_masuk'];

    $jumlah = $stok + $jumlahbarang;

    $sejumlah = $jumlah - $kapas;

    $setotal =

    $transaksi = getTransaksi();

    $detail = getDetail();

    $gudang = getGudang();

    $auto_increment_id = autoincrementtransaksi();

    $auto_increment_iddet = autoincrementdetail();

    $auto_increment_iddeta = autoincrementdetaila();

    $namabarang = getnamabarang($idbarang);

    $namagudang = getnamagudang($asalbarang);

    $namagudanga = getnamagudang($id);

    if ($jumlah < $kapas) {
        $transaksi [] = array(
            'id_transaksi'  => $auto_increment_id,
            'id_gudang'     => $id,
            'asal_barang'   => $asalbarang,
            'tujuan_barang' => $id,
            'tanggal'       => $tanggalmasuk
        );
    
        $detail [] = array(
            'id_detail'      => $auto_increment_iddet,
            'id_transaksi'   => $auto_increment_id,
            'id_gudang'      => $id,
            'nama_gudang'    => $namagudanga,
            'id_barang'      => $idbarang,
            'nama_barang'    => $namabarang,
            'jumlah_barang'  => $jumlahbarang
        );
    
        foreach ($gudang as $key => $g) {
            if($g['nama_gudang'] == $namagudanga) {
            $gudang[$key]['stok'] = $jumlah;
            $gudang[$key]['tanggal'] = $tanggalmasuk;
            }
        }
    
        if ($asalbarang != 'Produsen') {
            $detail [] = array(
                'id_detail'      => $auto_increment_iddeta,
                'id_transaksi'   => $auto_increment_id,
                'id_gudang'      => $asalbarang,
                'nama_gudang'    => $namagudang,
                'id_barang'      => $idbarang,
                'nama_barang'    => $namabarang,
                'jumlah_barang'  => $barangkeluar
            );
            
            foreach ($gudang as $key => $g) {
                if($g['nama_gudang'] == $namagudang) {
                    $stok = $g['stok'];
                    $total = $stok - $jumlahbarang;
                    $gudang[$key]['stok'] = $total;
                    $gudang[$key]['tanggal'] = $tanggalmasuk;
                }
            }        
        }
        
        $jsontransaksi = file_put_contents('../Data/transaksi.json', json_encode($transaksi, JSON_PRETTY_PRINT));
        $jsongudang = file_put_contents('../Data/gudang.json', json_encode($gudang, JSON_PRETTY_PRINT));
        $jsondetail = file_put_contents('../Data/detailtransaksi.json', json_encode($detail, JSON_PRETTY_PRINT));
    
        session_start();
        $_SESSION['stok'] = $jumlah;
    
        header("location: ".$_SERVER['HTTP_REFERER']);
    } else {
        $message = "Stok gudang ini sudah penuh, silahkan transfer barang ke gudang lain";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header('refresh:0 ; ../barang_masuk.php');
    }
    

?>