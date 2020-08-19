<?php
function getTransaksi() {
        return json_decode(file_get_contents('../Data/transaksi.json'), true);
    }

function getTransaksiM() {
    return json_decode(file_get_contents('Data/transaksi.json'), true);
}

function getDetailM() {
    return json_decode(file_get_contents('Data/detailtransaksi.json'),true);
}


function getDetail() {
        return json_decode(file_get_contents('../Data/detailtransaksi.json'),true);
    }

function getGudang() {
        return json_decode(file_get_contents('../Data/gudang.json'), true);
    }

function getGudangM() {
    return json_decode(file_get_contents('Data/gudang.json'), true);
}

function getGudangcek() {
    return json_decode(file_get_contents('Data/gudang.json'), true);
}

function getBarang() {
    return json_decode(file_get_contents('../Data/Barang.json'), true);
}

function getBarangI() {
    return json_decode(file_get_contents('Data/Barang.json'), true);
}

function getnamabarang($id_barang) {
    $barang = getBarang();
    for ($i=0; $i < count($barang); $i++) {
        if ($barang[$i]['id_barang']==$id_barang) {
            $namabarang = $barang[$i]['nama_barang'];
        }
    }return $namabarang;
}

function getnamagudang($id_gudang) {
    $gudang = getGudang();
    for ($i=0; $i < count($gudang); $i++) {
        if ($gudang[$i]['id_gudang']==$id_gudang) {
            $namagudang = $gudang[$i]['nama_gudang'];
            return $namagudang;
        }
    } 
}

function getstokgudang($id_gudang) {
    $gudang = getGudang();
    for ($i=0; $i < count($gudang); $i++) {
        if ($gudang[$i]['id_gudang']==$id_gudang) {
            $stok = $gudang[$i]['stok'];
            return $stok;
        }
    } 
}

function getkapasgudang($id_gudang) {
    $gudang = getGudang();
    for ($i=0; $i < count($gudang); $i++) {
        if ($gudang[$i]['id_gudang']==$id_gudang) {
            $kapas = $gudang[$i]['kapasitas'];
            return $kapas;
        }
    } 
}

function autoincrementtransaksi() {
    $transaksi = getTransaksi();
    $idtrans = array_column($transaksi, 'id_transaksi');
    $auto_increment_id = max($idtrans) + 1;
    return $auto_increment_id;
}

function autoincrementdetail() {
    $detail = getDetail();
    $iddetail = array_column($detail, 'id_detail');
    $auto_increment_iddet = max($iddetail) + 1;
    return $auto_increment_iddet;
}

function autoincrementdetaila() {
    $detail = getDetail();
    $iddetail = array_column($detail, 'id_detail');
    $auto_increment_iddet = max($iddetail) + 2;
    return $auto_increment_iddet;
}

function autoincrementdettransaksi(){
    $t = autoincrementtransaksi();
    return $t;
}
    
?>