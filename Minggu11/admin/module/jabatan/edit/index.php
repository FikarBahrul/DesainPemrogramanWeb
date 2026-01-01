<div class="container-fluid">
    <div class="row">
        <?php
        require 'admin/template/menu.php';
        $id = $_GET['id'];

        $query = "SELECT * FROM anggota a, jabatan j, user u WHERE a.jabatan_id = j.id AND a.user_id = u.id AND a.user_id = '$id'";
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_assoc($result);
        ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Anggota</h1>
            </div>
            
            <form action="fungsi/edit.php?anggota=edit" method="POST">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">Form Edit Data Anggota</div>
                            <div class="card-body">
                                
                                <input type="hidden" value="<?php echo $row['user_id']; ?>" name="id">
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jabatan" class="col-form-label">Jabatan:</label>
                                    <select class="form-select" name="jabatan" required>
                                        <option value="">Pilih Jabatan</option>
                                        <?php
                                        $query2 = "SELECT * FROM jabatan order by jabatan asc";
                                        $result2 = mysqli_query($koneksi, $query2);
                                        while ($row2 = mysqli_fetch_assoc($result2)) {
                                        ?>
                                            <option value="<?= $row2['id']; ?>" <?= ($row['jabatan_id'] == $row2['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($row2['jabatan']); ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin:</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" <?= ($row['jenis_kelamin'] === "L") ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" <?= ($row['jenis_kelamin'] === "P") ? 'checked' : '' ?> required>
                                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" required><?= htmlspecialchars($row['alamat']); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No Telepon</label>
                                    <input type="number" class="form-control" name="no_telp" value="<?= htmlspecialchars($row['no_telp']); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">Form Edit Login Anggota</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['username']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <div class="form-text">Kosongi password, jika tidak ingin menggantinya.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body" style="text-align: center;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Ubah</button>
                                <a href="index.php?page=anggota" class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true"></i> Batal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>