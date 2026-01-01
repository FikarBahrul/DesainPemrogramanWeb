<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Aplikasi Kantor Devon Grade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="index.php">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </a>
                </li>
                <?php if ($_SESSION['level'] == 'admin') { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2" href="index.php?page=jabatan">
                            <i class="fa fa-address-card"></i>
                            Jabatan
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="index.php?page=anggota">
                        <i class="fa fa-users"></i>
                        Anggota
                    </a>
                </li>
            </ul>

            <hr class="my-3">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <i class="fa fa-cog"></i>
                        Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="logout.php">
                        <i class="fa fa-sign-out"></i>
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>