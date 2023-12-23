<?php
session_start();

//membuat koneksi ke database
$conn = pg_connect("host=localhost port=5432 dbname=kosmetik user=postgres password=estergracia04");

//menambahkan stok baru
if(isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    //nambah gambar
    $allow_extention=array('png', 'jpg');
    $nama=$_FILES['file']['name']; //ngambil gambar
    $dot=explode('.', $nama);
    $ekstensi=strtolower(end($dot));//ngambil ekstensinya
    $ukuran=$_FILES['file']['size'];//ngambil sizenya
    $file_tmp=$_FILES['file']['tmp_name'];//ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image=md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file

    //validasi ada atau belum
    $cek=mysqli_query($conn, "select * from stock where namabarang='$namabarang'");
    $hitung=mysqli_num_rows($cek);

    if($hitung<1){
        //proses upload gambar
        if(in_array($ekstensi, $allow_extention) === true) {
            //validasi ukuran
            if($ukuran<95000000) {
                move_uploaded_file($file_tmp, 'image/'.$image);
                $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock, image, harga) VALUES ('$namabarang', '$deskripsi', '$stok','$image','$harga')");
                if($addtotable) {
                    header('location:index.php');
                } else {
                    echo 'Gagal';
                    header('location:index.php');
                }
            } else {
                //kalau file dari 95mb
                echo '<script>
                alert ("ukuran terlalu besar");
                window.location.href="index.php";
                </script>';
            }
        } else {
            //kalau gambar tidak png / jpg
            echo '<script>
            alert ("File harus png/jpg");
            window.location.href="index.php";
            </script>';
        }
    } else {
        echo '<script>
        alert ("Nama Baru sudah Terdaftar");
        window.location.href="index.php";
        </script>';
    }
}

//menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $bayarmasuk = $_POST['bayarmasuk'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];

    $cekstok=mysqli_query($conn, "SELECT * FROM stock where idbarang='$barangnya'");
    $ambildatanya=mysqli_fetch_array($cekstok);

    $stoknow=$ambildatanya['stock'];
    $tambahstok=$stoknow+$qty;

    $addtomasuk=mysqli_query($conn,"INSERT into masuk (idbarang, keterangan, bayarmasuk,qty) values('$barangnya', '$penerima', '$bayarmasuk','$qty')");
    $updatestok = mysqli_query($conn, "update stock set stock='$tambahstok' where idbarang='$barangnya'");
    if($addtomasuk && $updatestok){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $bayarkeluar = $_POST['bayarkeluar'];
    $qty = $_POST['qty'];
    $harga = $_POST['harga'];

    $cekstok=mysqli_query($conn, "SELECT * FROM stock where idbarang='$barangnya'");
    $ambildatanya=mysqli_fetch_array($cekstok);

    $stoknow=$ambildatanya['stock'];
    $tambahstok=$stoknow-$qty;

    $addtokeluar=mysqli_query($conn,"INSERT into keluar (idbarang, penerima, bayarkeluar ,qty) values('$barangnya', '$penerima', '$bayarkeluar','$qty')");
    $updatestok = mysqli_query($conn, "update stock set stock='$tambahstok' where idbarang='$barangnya'");
    if($addtokeluar && $updatestok){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//update barang
if(isset($_POST['updatebarang'])) {
    $idb=$_POST['idb'];
    $namabarang=$_POST['namabarang'];
    $deskripsi=$_POST['deskripsi'];
    $harga = $_POST['harga'];

    //nambah gambar
    $allow_extention=array('png', 'jpg');
    $nama=$_FILES['file']['name']; //ngambil gambar
    $dot=explode('.', $nama);
    $ekstensi=strtolower(end($dot));//ngambil ekstensinya
    $ukuran=$_FILES['file']['size'];//ngambil sizenya
    $file_tmp=$_FILES['file']['tmp_name'];//ngambil lokasi filenya

    //penamaan file -> enkripsi
    $image=md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file

    if ($ukuran == 0) {
        // jika tidak ingin upload
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    } else {
        // jika ingin
        move_uploaded_file($file_tmp, 'image/'.$image);
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi', image='$image' where idbarang='$idb'");
        if ($update) {
            header('location:index.php');
        } else {
            echo 'Gagal';
            header('location:index.php');
        }
    }        
}

//hapus barang
if(isset($_POST['hapusbarang'])){
    $idb=$_POST['idb'];

    $gambar=mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $get=mysqli_fetch_array($gambar);
    $img='image/'.$get['image'];
    unlink($img);

    $hapus=mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus) {
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//mengubah data masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb=$_POST['idb'];
    $idm=$_POST['idm'];
    $deskripsi=$_POST['keterangan'];
    $qty=$_POST['qty'];

    $lihatstok=mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stoknya=mysqli_fetch_array($lihatstok);
    $stoknew=$stoknya['stock'];

    $qtynow=mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya=mysqli_fetch_array($qtynow);
    $qtynow=$qtynya['qty'];

    if($qty>$qtynow) {
        $selisih=$qty-$qtynow;
        $kurangin=$stoknew+$selisih;
        $kurangstok=mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya=mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if($kurangin&&$updatenya){
            header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
            }
    } else {
        $selisih=$qtynow-$qty;
        $kurangin=$stoknew-$selisih;
        $kurangstok=mysqli_query($conn, "update stock set stock='$kurangin'");
        $updatenya=mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if($kurangin&&$updatenya){
            header('location:masuk.php');
            } else {
                echo 'Gagal';
                header('location:masuk.php');
            }
    }
}

//menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])) {
    $idb=$_POST['idb'];
    $idm=$_POST['idm'];
    $qty=$_POST['kty'];

    $getdata=mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data=mysqli_fetch_array($getdata);
    $stok=$data['stock'];

    $selisih=$stok-$qty;

    $update=mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata=mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata) {
        header('location:masuk.php');
    } else {
        header('location:masuk.php');
    }
}

//mengubah data kelaur
if(isset($_POST['updatebarangkeluar'])){
    $idb=$_POST['idb'];
    $idk=$_POST['idk'];
    $penerima=$_POST['penerima'];
    $qty=$_POST['qty'];

    $lihatstok=mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stoknya=mysqli_fetch_array($lihatstok);
    $stoknew=$stoknya['stock'];

    $qtynow=mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya=mysqli_fetch_array($qtynow);
    $qtynow=$qtynya['qty'];

    if($qty>$qtynow) {
        $selisih=$qty-$qtynow;
        $kurakngin=$stoknew-$selisih;
        $kurangstok=mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya=mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if($kurangin&&$updatenya){
            header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            }
    } else {
        $selisih=$qtynow-$qty;
        $kurangin=$stoknew+$selisih;
        $kurangstok=mysqli_query($conn, "update stock set stock='$kurangin'");
        $updatenya=mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
        if($kurangin&&$updatenya){
            header('location:keluar.php');
            } else {
                echo 'Gagal';
                header('location:keluar.php');
            }
    }
}

//menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])) {
    $idb=$_POST['idb'];
    $idk=$_POST['idk'];
    $qty=$_POST['kty'];

    $getdata=mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data=mysqli_fetch_array($getdata);
    $stok=$data['stock'];

    $selisih=$stok+$qty;

    $update=mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata=mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata) {
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}
?>