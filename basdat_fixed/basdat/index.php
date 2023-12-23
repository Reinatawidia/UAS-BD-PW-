<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Home</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .zoomable{
                width: 180px;
            }
        </style>
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <script type="text/javascript" charset="utf8" href="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script> -->
        </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">Beauty Shop</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Option</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"></div>
                                Stok Kosmetik
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"></i></div>
                                Kosmetik Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"></i></div>
                                Kosmetik Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Log Out
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Stok Kosmetik</h1>
                        <div class="card mb-4">
                            <div class="card-header">  
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Gambar</th>
                                                <th>Nama Kosmetik</th>
                                                <th>Deskripsi</th>
                                                <!-- <th>Harga/Pc (Rp.)</th> -->
                                                <th>Stok</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambildata=mysqli_query($conn,"SELECT * FROM stock");
                                            while($data=mysqli_fetch_array($ambildata)){
                                                $idbarang=$data['idbarang'];
                                                $namabarang=$data['namabarang'];
                                                $deskripsi=$data['deskripsi'];
                                                $harga=$data['harga'];
                                                $stok=$data['stock'];
                                                $idb=$data['idbarang'];

                                                //cek gambar
                                                $gambar=$data['image'];
                                                if($gambar==null) {
                                                    //jika tidak ada gambar
                                                    $img='No Photo';
                                                } else {
                                                    //jika ada gambar
                                                    $img='<img src="image/'.$gambar.'"class="zoomable">';
                                                }
                                            ?>
                                            <tr>
                                                <td><?=$idbarang;?></td>
                                                <td><?=$img;?></td>
                                                <td><?=$namabarang;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$stok;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idb;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idb;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>                                             
                                            <!-- Edit Modal -->
                                                <div class="modal fade" id="edit<?=$idb;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Edit Kosmetik</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                    <!-- Modal body -->
                                                <form method="post" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" required>
                                                <br>
                                                <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" required>
                                                <br>
                                                <input type="file" name="file" value="<?=$image;?>" class="form-control">
                                                <br>
                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                </div>
                                                </form>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete<?=$idb;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Hapus Kosmetik</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                    <!-- Modal body -->
                                                <form method="post">
                                                <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus <?=$namabarang;?> ?
                                                <input type="hidden" name="idb" value="<?=$idb;?>">
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-danger" name="hapusbarang">Submit</button>
                                                </div>
                                                </form>
                                                </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Tambah Kosmetik</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
        <input type="text" name="namabarang" placeholder="Nama Kosmetik" class="form-control" required>
        <br>
        <input type="text" name="deskripsi" placeholder="Deskripsi Kosmetik" class="form-control" required>
        <br>
        <input type="num" name="harga" placeholder="Harga" class="form-control" required>
        <br>
        <input type="number" name="stock" placeholder="Stok" class="form-control" required>
        <br>
        <input type="file" name="file" class="form-control">
        <br>
        <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
        </div>
        </form>
      </div>
    </div>
    <script>
    $($document).ready(function(){
        $('#datatable').dataTable({
            "processing": true,
            "serverside": true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    oriented: 'potrait',
                    pageSize: 'Legal',
                    title: 'Persedian Stok Gudang',
                    download: 'open',
                }
                'csv', 'excel', 'pdf', 'print', 'word'
            ]
        });
    });
    </script>
  </div>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.com/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.print.min.js"></script> -->
</html>
