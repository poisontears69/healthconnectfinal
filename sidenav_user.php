<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="index_user.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="index_user.php?page=messages" class="nav-link text-white align-middle px-0">
                            <i class="fs-4 fas fa-envelope"></i> <span class="ms-1 d-none d-sm-inline">Messages</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index_user.php?page=clinics" class="nav-link text-white align-middle px-0">
                            <i class="fs-4 fas fa-hospital"></i> <span class="ms-1 d-none d-sm-inline">Clinics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index_user.php?page=settings" class="nav-link text-white align-middle px-0">
                            <i class="fs-4 fas fa-cog"></i> <span class="ms-1 d-none d-sm-inline">Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-white align-middle px-0">
                            <i class="fs-4 fas fa-sign-out-alt"></i> <span class="ms-1 d-none d-sm-inline">Logout</span>
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="User" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Username</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>