<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
</head>
<body>
   <div class="navbar navbar-dark bg-primary" style="display: flex !important; justify-content: center !important;">
    <a class="navbar-brand" href="index.php" style="color: #fff">
        CRUD Dengan Ajax
    </a>
</div>

<div class="container">
    <h2 class="sign-center" style="margin: 30px;">Data Anggota</h2>
    <form method="post" class="form-data" id="form-data">
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label>Nama</label>
                <input type="hidden" name="id" id="id">
                <input type="text" name="nama" id="nama" class="form-control" required="true">
                <p class="text-danger" id="err_nama"></p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label>Jenis Kelamin</label><br>
                <input type="radio" name="jenis_kelamin" id="jenkeli" value="L" required="true">Laki-Laki
                <input type="radio" name="jenis_kelamin" id="jenkel2" value="P">Perempuan
            </div>
            <p class="text-danger" id="err_jenis_kelamin"></p>
        </div>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" id="alamat" class="form-control" required="true"></textarea>
        <p class="text-danger" id="err_alamat"></p>
    </div>

    <div class="form-group">
        <label>No Telepon</label>
        <input type="number" name="no_telp" id="no_telp" class="form-control" required="true">
        <p class="text-danger" id="err_no_telp"></p>
    </div>

    <div class="form-group">
        <button type="button" name="simpan" id="simpan" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</form>

    <div id="data">
        
    </div>
</div>

<div class="text-center">&copy; <?php echo date('Y'); ?> Copyright: <a href="https://google.com/">Dengan Dan Pemrograman Web</a></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#data').load('data.php');
    });

    $("#simpan").click(function() {
    var data = $(".form-data").serialize();
    var jenkeli = document.getElementById("jenkeli").checked;
    var jenkel2 = document.getElementById("jenkel2").checked;  
    var nama = document.getElementById("nama").value;
    var alamat = document.getElementById("alamat").value;
    var no_telp = document.getElementById("no_telp").value;

    if (nama == "") {
        document.getElementById("err_nama").innerHTML = "Nama Harus Diisi";
    } else {
        document.getElementById("err_nama").innerHTML = "";
    }

    if (alamat == "") {
        document.getElementById("err_alamat").innerHTML = "Alamat Harus Diisi";
    } else {
        document.getElementById("err_alamat").innerHTML = "";
    }

    if (jenkeli == false && jenkel2 == false) {
        document.getElementById("err_jenis_kelamin").innerHTML = "Jenis Kelamin Harus Dipilih";
    } else {
        document.getElementById("err_jenis_kelamin").innerHTML = "";
    }

    if (no_telp == "") {
        document.getElementById("err_no_telp").innerHTML = "No Telepon Harus Diisi";
    } else {
        document.getElementById("err_no_telp").innerHTML = "";
    }

    if (nama !== "" && alamat !== "" && (jenkeli === true || jenkel2 === true) && no_telp !== "") {
        $.ajax({
            type: 'POST',
            url: "form_action.php",
            data: data,
            success: function(response) {
                $('#data').load("data.php");
                document.getElementById("id").value = "";
                document.getElementById("form-data").reset();
            },
            error: function(response) {
                console.log(response.responseText);
            }
        });
    }
});
</script>
</body>
</html>