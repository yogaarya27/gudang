<?php
    session_start();
    $id = $_SESSION['id_gudang'];
    $nama = $_SESSION['nama'];
    $stok = $_SESSION['stok'];

    include 'function.php';
    $idbarang = $_POST['id_barang'];
    $jumlahbarang = +$_POST['jumlah_barang'];
    $barangkeluar = -$jumlahbarang;
    $tujuanbarang = $_POST['tujuan_barang'];
    $tanggalkeluar = $_POST['tanggal_keluar'];

    $jumlah = $stok + $barangkeluar;

    $transaksi = getTransaksi();

    $detail = getDetail();

    $gudang = getGudang();

    $auto_increment_id = autoincrementtransaksi();

    $auto_increment_iddet = autoincrementdetail();

    $auto_increment_iddeta = autoincrementdetaila();

    $namabarang = getnamabarang($idbarang);

    $namagudang = getnamagudang($tujuanbarang);

    $namagudanga = getnamagudang($id);

    $stokt = getstokgudang($tujuanbarang);
    
    $kapast = getkapasgudang($tujuanbarang);

    $total = $stokt + $jumlahbarang;

    if ($jumlah > 0) {
        if ($tujuanbarang != 'Konsumen') {
            if($total < $kapast) {
                $transaksi [] = array(
                    'id_transaksi'  => $auto_increment_id,
                    'id_gudang'     => $id,
                    'asal_barang'   => $id,
                    'tujuan_barang' => $tujuanbarang,
                    'tanggal'       => $tanggalkeluar
                );
            
                $detail [] = array(
                    'id_detail'      => $auto_increment_iddet,
                    'id_transaksi'   => $auto_increment_id,
                    'id_gudang'      => $id,
                    'nama_gudang'    => $namagudanga,
                    'id_barang'      => $idbarang,
                    'nama_barang'    => $namabarang,
                    'jumlah_barang'  => $barangkeluar
                );
        
                foreach ($gudang as $key => $g) {
                    if($g['nama_gudang'] == $namagudanga) {
                        $gudang[$key]['stok'] = $jumlah;
                        $gudang[$key]['tanggal'] = $tanggalkeluar;
                    }
                }
    
                $detail [] = array(
                    'id_detail'      => $auto_increment_iddeta,
                    'id_transaksi'   => $auto_increment_id,
                    'id_gudang'      => $tujuanbarang,
                    'nama_gudang'    => $namagudang,
                    'id_barang'      => $idbarang,
                    'nama_barang'    => $namabarang,
                    'jumlah_barang'  => $jumlahbarang
                );
                
                foreach ($gudang as $key => $g) {
                    if($g['nama_gudang'] == $namagudang) {
                        $gudang[$key]['stok'] = $total;
                        $gudang[$key]['tanggal'] = $tanggalkeluar;
                    }
                }
    
                $jsontransaksi = file_put_contents('../Data/transaksi.json', json_encode($transaksi, JSON_PRETTY_PRINT));
                $jsongudang = file_put_contents('../Data/gudang.json', json_encode($gudang, JSON_PRETTY_PRINT));
                $jsondetail = file_put_contents('../Data/detailtransaksi.json', json_encode($detail, JSON_PRETTY_PRINT));
        
                session_start();
                $_SESSION['stok'] = $jumlah;
    
                header("location: ".$_SERVER['HTTP_REFERER']);
    
            } else {
                $message = "Gudang tujuan sudah penuh, silahkan pilih gudang lain";
                echo "<script type='text/javascript'>alert('$message');</script>";
                header('refresh:0 ; ../barang_keluar.php'); 
            }
        } else {
            $transaksi [] = array(
                'id_transaksi'  => $auto_increment_id,
                'id_gudang'     => $id,
                'asal_barang'   => $id,
                'tujuan_barang' => $tujuanbarang,
                'tanggal'       => $tanggalkeluar
            );
        
            $detail [] = array(
                'id_detail'      => $auto_increment_iddet,
                'id_transaksi'   => $auto_increment_id,
                'id_gudang'      => $id,
                'nama_gudang'    => $namagudanga,
                'id_barang'      => $idbarang,
                'nama_barang'    => $namabarang,
                'jumlah_barang'  => $barangkeluar
            );
    
            foreach ($gudang as $key => $g) {
                if($g['nama_gudang'] == $namagudanga) {
                    $gudang[$key]['stok'] = $jumlah;
                    $gudang[$key]['tanggal'] = $tanggalkeluar;
                }
            }
            
            $jsontransaksi = file_put_contents('../Data/transaksi.json', json_encode($transaksi, JSON_PRETTY_PRINT));
            $jsongudang = file_put_contents('../Data/gudang.json', json_encode($gudang, JSON_PRETTY_PRINT));
            $jsondetail = file_put_contents('../Data/detailtransaksi.json', json_encode($detail, JSON_PRETTY_PRINT));
    
            session_start();
            $_SESSION['stok'] = $jumlah;
    
            header("location: ".$_SERVER['HTTP_REFERER']);
        }
    }else{
        $message = "Jumlah barang tidak mencukupi, silahkan masukkan jumlah yang lain.";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header('refresh:0 ; ../barang_keluar.php');
    }
             
       
?>