<div class="col-lg-3">
    <nav class="navbar navbar-expand-lg bg-light rounded border mt-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel" style="width:230px">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">SmartBook</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav nav-pills flex-column justify-content-end flex-grow-1">
                    <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo ((isset($_GET['x']) && ($_GET['x']) == 'home') || !isset($_GET['x'])) ?
                                'active link-light' : 'link-dark'; ?>" 
                                aria-current="page" href="home"><i class= "bi bi-house-door-fill"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'pustaka') ?
                                'active link-light' : 'link-dark'; ?>" href="pustaka"><i class="bi bi-journal-text"></i>
                                Pustaka</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'keranjang') ?
                                'active link-light' : 'link-dark'; ?>" href="keranjang"><i class="bi bi-cart4"></i> Keranjang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'peminjaman') ?
                                'active link-light' : 'link-dark'; ?>" href="peminjaman"><i class="bi bi-handbag-fill"></i>
                                Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'keterlambatan') ?
                                'active link-light' : 'link-dark'; ?>" href="keterlambatan"><i class="bi bi-exclamation-square-fill"></i>
                                Keterlambatan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'denda') ?
                                'active link-light' : 'link-dark'; ?>" href="denda"><i class="bi bi-currency-dollar"></i>
                                Denda</a>
                        </li>
                        <?php if($hasil['level']==1){?>
                        <li class="nav-item">
                            <a class="nav-link ps-2 <?php echo (isset($_GET['x']) && $_GET['x'] == 'user') ?
                                'active link-light' : 'link-dark'; ?>" href="user"><i class="bi bi-person-vcard"></i>
                                user</a>
                        </li>
                        
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>