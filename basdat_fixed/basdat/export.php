<?php
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" href="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>
<body>
    <div class="container">
        <h2>Stok Kosmetik</h2>
        <h4>Persediaan Produk</h4>
            <div class="data-tables datatable-dark">
                <table class="table table-bordered" id="export" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kosmetik</th>
                            <th>Deskripsi</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>                                
                    <?php
                    $ambildata=mysqli_query($conn,"SELECT * FROM stock");
                    while($data=mysqli_fetch_array($ambildata)){
                    $idbarang=$data['idbarang'];
                    $namabarang=$data['namabarang'];
                    $deskripsi=$data['deskripsi'];
                    $stok=$data['stock'];
                    $idb=$data['idbarang'];
                    ?>
                    <tr>
                        <td><?php echo $idbarang;?></td>
                        <td><?php echo $namabarang;?></td>
                        <td><?php echo $deskripsi;?></td>
                        <td><?php echo $stok;?></td>
                        
                    </tr>                                                                     
                    <?php
                    }
                    ?>
                    </tbody>
            </table>                                       
        </div>
    </div>

<script>
    $($document).ready(function(){
        $('#export').dataTable({
            dom: 'Bfrtip',
            buttons: [
                 'csv', 'excel', 'pdf', 'print', 'word'
            ]
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.com/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.com/buttons/1.6.5/js/buttons.print.min.js"></script>
</body>
</html>