<nav class="navbar navbar-expand bg-dark border-bottom border-body sticky-top" data-bs-theme="dark">
    <div class="container-lg">
        <a class="navbar-brand" href="."><img src="img/book.png" width="40" height="40" alt="Logo"> SmartBook</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php echo $hasil['username']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle"></i> Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear-wide-connected"></i>
                                Pengaturan</a></li>
                        <li><a class="dropdown-item" href="logout"><i class="bi bi-box-arrow-right"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>